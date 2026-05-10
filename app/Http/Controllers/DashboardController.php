<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Table;
use Illuminate\Http\Request;
use App\Models\Order;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Hitung Total Produk & Meja
        $totalProducts = Product::count();
        $totalTables = Table::count();

        // 2. Hitung Pendapatan Real Hari Ini
        // Menjumlahkan kolom total_price dari tabel orders yang statusnya 'done' hari ini
        $incomeToday = Order::whereDate('created_at', Carbon::today())
                            ->where('status', 'done')
                            ->sum('total_price');

        // 3. (Opsional) Hitung Growth jika dibanding kemarin
        $incomeYesterday = Order::whereDate('created_at', Carbon::yesterday())
                                ->where('status', 'done')
                                ->sum('total_price');
        
        $growth = 0;
        if ($incomeYesterday > 0) {
            $growth = (($incomeToday - $incomeYesterday) / $incomeYesterday) * 100;
        }

        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalTables', 
            'incomeToday', 
            'growth'
        ));
    }

    public function processOrder(Request $request)
    {
        // Simpan ke tabel orders
        // Otomatis memicu fungsi potong stok yang kita buat kemarin di Model Order
        $order = \App\Models\Order::create([
            'table_number' => $request->table_number,
            'product_name' => $request->product_name,
            'quantity'     => $request->quantity,
            'total_price'  => $request->total_price,
            'status'       => 'pending' // Masuk ke antrean dapur
        ]);

        return response()->json(['success' => true]);
    }
}