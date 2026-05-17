<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::orderBy('number', 'asc')->get();
        $date = date('Y-m-d');

        // Menggunakan validasi pengecekan fallback agar anti-blank jika folder view berbeda
        if (view()->exists('admin.tables.index')) {
            return view('admin.tables.index', compact('tables', 'date'));
        }
        return view('tables.index', compact('tables', 'date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|unique:tables,number',
        ]);

        // Saat create, token akan terisi otomatis berkat fungsi boot() di Model
        Table::create([
            'number' => $request->number,
            'status' => 'Tersedia'
        ]);

        return back()->with('success', 'Meja baru berhasil ditambahkan!');
    }

    // --- BAGIAN CUSTOMER (PELANGGAN) ---

    public function customerOrder(Request $request)
    {
        // 1. Cari meja berdasarkan token 't' di URL
        $token = $request->query('t');
        $table = Table::where('token', $token)->first();

        // Keamanan: Jika token salah, arahkan kembali ke halaman awal
        if (!$table) {
            return redirect('/')->with('error', 'Meja tidak valid. Silakan scan ulang QR Code.');
        }

        // 2. Ambil produk yang stoknya masih ada
        $products = Product::where('stock', '>', 0)->get();

        // 3. AMBIL DATA KATEGORI (Solusi Error)
        $categories = Category::all();

        $tableNumber = $table->number;

        // 4. Kirim SEMUA variabel ke view customer.order
        return view('customer.order', compact('products', 'categories', 'tableNumber', 'table'));
    }

    public function processOrder(Request $request)
    {
        // 1. Gunakan manual validator agar tidak terjadi Redirect 302 jika gagal
        $validator = Validator::make($request->all(), [
            'table_token'   => 'required',
            'customer_name' => 'required', 
            'items'         => 'required|array', 
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak lengkap: ' . implode(', ', $validator->errors()->all())
            ], 422);
        }

        // 2. Cari meja berdasarkan token
        $table = Table::where('token', $request->table_token)->first();

        if (!$table) {
            return response()->json([
                'success' => false, 
                'message' => 'Akses Meja Ilegal!'
            ], 403);
        }

        // 3. Simpan Pesanan dengan DB Transaction & Row Locking
        try {
            DB::beginTransaction();

            // Buat string group ID unik agar tidak bertabrakan jika di-klik barengan
            $orderGroupId = 'ORD-' . strtoupper(Str::random(8));

            foreach ($request->items as $item) {
                // LOCK FOR UPDATE: Baris data dikunci saat dibaca request ini agar stok aman dari tabrakan request
                $product = Product::where('name', $item['name'])->lockForUpdate()->first();

                if ($product && $product->stock >= $item['qty']) {
                    Order::create([
                        'order_group_id' => $orderGroupId,
                        'table_number'   => $table->number,
                        'customer_name'  => $request->customer_name,
                        'product_name'   => $item['name'],
                        'quantity'       => $item['qty'],
                        'total_price'    => $item['price'] * $item['qty'],
                        'status'         => 'pending'
                    ]);

                    // Potong Stok Produk Otomatis
                    $product->decrement('stock', $item['qty']);
                } else {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Stok ' . $item['name'] . ' baru saja habis atau tidak mencukupi!'
                    ], 400);
                }
            }

            DB::commit();

            // REVISI REDIRECT: Mengembalikan response JSON dengan rute tujuan halaman status pelanggan
            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dikirim! Mohon tunggu ya kak.',
                'redirect_url' => route('order.status', ['order_id' => $orderGroupId])
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    // --- BAGIAN DAPUR & ADMIN ---

    /**
     * REVISI: Fungsi Kitchen dialihkan ke Cashier
     * Karena halaman index kitchen sudah dihapus/digabung.
     */
    public function kitchen()
    {
        return redirect()->route('cashier.index');
    }

    public function done(Order $order)
    {
        $order->update(['status' => 'done']);
        return back()->with('success', 'Pesanan telah diselesaikan!');
    }

    public function destroy(Table $table)
    {
        $table->delete();
        return redirect()->route('tables.index')->with('success', 'Meja berhasil dihapus!');
    }

    public function generateQR($id) 
    {
        $table = Table::findOrFail($id);
        
        // GANTI INI: Dari /order/meja/2 menjadi /?t=token_acak
        $url = url('/?t=' . $table->token); 

        return QrCode::size(300)->generate($url);
    }

    public function doneGroup(Request $request)
    {
        // Ambil ID grup dari input hidden di form
        $groupId = $request->order_group_id;

        // Cari semua pesanan yang memiliki order_group_id tersebut
        // Dan ubah statusnya dari 'waiting' menjadi 'done'
        $updated = Order::where('order_group_id', $groupId)
            ->where('status', 'waiting')
            ->update(['status' => 'done']);

        if ($updated) {
            return redirect()->back()->with('success', 'Pesanan Meja tersebut telah diselesaikan!');
        }

        return redirect()->back()->with('error', 'Gagal memproses pesanan.');
    }

    public function cashier()
    {
        // Bagian 1: Pesanan yang butuh ACC Kasir
        $orders = Order::where('status', 'pending')
            ->latest()
            ->get()
            ->groupBy('order_group_id');

        // Bagian 2: Monitor Dapur (Antrean Masak)
        $kitchenOrders = Order::where('status', 'waiting')
            ->latest()
            ->get()
            ->groupBy('order_group_id');

        // Bagian 3: History pesanan selesai hari ini
        $completedOrders = Order::where('status', 'done')
            ->whereDate('updated_at', Carbon::today())
            ->latest()
            ->get()
            ->groupBy('order_group_id');

        // REVISI FALLBACK VIEW: Deteksi otomatis letak folder kasir agar anti-eror 404
        if (view()->exists('admin.cashier.index')) {
            return view('admin.cashier.index', compact('orders', 'kitchenOrders', 'completedOrders'));
        }
        return view('cashier.index', compact('orders', 'kitchenOrders', 'completedOrders'));
    }

    public function approveOrder(Request $request)
    {
        // Mengubah status menjadi 'waiting' agar muncul di dapur
        Order::where('order_group_id', $request->order_group_id)
            ->update(['status' => 'waiting']);

        return back()->with('success', 'Pembayaran Berhasil! Pesanan dikirim ke dapur.');
    }

    public function dashboard()
    {
        // 1. Total Produk & Total Meja Fisik
        $totalProducts = Product::count();
        $totalTables = Table::count();
        
        // 2. Pendapatan Hari Ini
        $incomeToday = Order::where('status', 'done')
            ->whereDate('updated_at', Carbon::today())
            ->sum('total_price');

        // 3. Status Pesanan untuk Kasir
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        $waitingOrdersCount = Order::where('status', 'waiting')->count();
        
        // 4. Menghitung jumlah meja aktif unik
        $activeTablesCount = Order::whereIn('status', ['pending', 'waiting'])
            ->whereNotNull('table_number')
            ->distinct()
            ->count('table_number');

        // 5. Pesanan Terbaru
        $recentOrders = Order::latest()->take(6)->get();

        // REVISI FALLBACK VIEW: Deteksi otomatis folder file dashboard agar kebal eror 500
        if (view()->exists('admin.dashboard')) {
            return view('admin.dashboard', compact(
                'totalProducts', 
                'totalTables', 
                'incomeToday', 
                'pendingOrdersCount',
                'waitingOrdersCount',
                'activeTablesCount',
                'recentOrders'
            ));
        }
        
        return view('dashboard', compact(
            'totalProducts', 
            'totalTables', 
            'incomeToday', 
            'pendingOrdersCount',
            'waitingOrdersCount',
            'activeTablesCount',
            'recentOrders'
        ));
    }

    /**
     * MENAMPILKAN HALAMAN STATUS PESANAN PELANGGAN
     * Memanggil file fisik resources/views/customer/status.blade.php
     */
    public function orderStatus($order_id)
    {
        $orders = Order::where('order_group_id', $order_id)->get();

        if ($orders->isEmpty()) {
            abort(404, 'Kode pesanan tidak ditemukan.');
        }

        return view('customer.status', compact('orders', 'order_id'));
    }
}