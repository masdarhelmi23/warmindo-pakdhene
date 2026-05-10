<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Penting untuk count distinct

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', Carbon::today()->toDateString());

        // 1. Pendapatan Harian (Hanya yang Lunas)
        $totalIncome = Order::whereDate('created_at', $date)
                            ->where('status', 'lunas')
                            ->sum('total_price');

        // 2. Jumlah Transaksi Unik (Dihitung per invoice/meja dalam waktu yang sama)
        // Kita hitung berdasarkan 'created_at' yang unik per meja
        $totalTransactions = Order::whereDate('created_at', $date)
                                  ->distinct()
                                  ->count(DB::raw('CONCAT(table_number, "-", created_at)'));

        // 3. Pesanan Belum Jadi (Status Pending/Cooking)
        $pendingOrders = Order::whereDate('created_at', $date)
                              ->whereIn('status', ['pending', 'cooking'])
                              ->count();

        // 4. Item/Porsi Terjual
        $totalItems = Order::whereDate('created_at', $date)->sum('quantity');

        $history = Order::whereDate('created_at', $date)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('admin.reports.index', compact(
            'totalIncome', 
            'totalTransactions', 
            'pendingOrders', 
            'totalItems', 
            'history', 
            'date'
        ));
    }
}