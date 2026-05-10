<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;

class TableController extends Controller
{
    public function index()
{
    $tables = Table::orderBy('number', 'asc')->get();
    $date = date('Y-m-d'); // Tambahkan ini

    return view('admin.tables.index', compact('tables', 'date')); // Kirim $date ke view
}

    public function store(Request $request)
    {
        $request->validate([
            'number' => 'required|unique:tables,number',
        ]);

        Table::create([
            'number' => $request->number,
            'status' => 'Tersedia'
        ]);

        return back()->with('success', 'Meja baru berhasil ditambahkan!');
    }

    public function kitchen()
    {
        // Ambil pesanan yang statusnya masih 'pending', urutkan dari yang paling lama (FIFO)
        $orders = Order::where('status', 'pending')->orderBy('created_at', 'asc')->get();
        
        return view('admin.kitchen.index', compact('orders'));
    }

    // Fungsi untuk menandai pesanan selesai
    public function done(Order $order)
    {
        $order->update(['status' => 'done']);
        return back()->with('success', 'Pesanan telah diselesaikan!');
    }

    public function orderPage($number)
    {
        // Ambil semua produk yang tersedia
        $products = Product::where('status', 1)->get();
        $tableNumber = $number;

        return view('customer.order', compact('products', 'tableNumber'));
    }

    public function processOrder(Request $request)
    {
        // Simpan pesanan ke database (Ini akan otomatis potong stok lewat Model Order)
        Order::create([
            'table_number' => $request->table_number,
            'product_name' => $request->product_name,
            'quantity'     => $request->quantity,
            'total_price'  => $request->total_price,
            'status'       => 'pending'
        ]);

        return response()->json(['message' => 'Pesanan berhasil dikirim!']);
    }

    public function customerOrder($number)
    {
        // Ambil produk yang stoknya masih ada
        $products = \App\Models\Product::where('stock', '>', 0)->get();
        $tableNumber = $number;

        return view('customer.order', compact('products', 'tableNumber'));
    }
}