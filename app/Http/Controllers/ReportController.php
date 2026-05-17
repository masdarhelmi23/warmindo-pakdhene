<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; 

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('date', Carbon::today()->toDateString());

        // 1. Pendapatan Harian (REVISI: Sesuaikan status ke 'done' sesuai database)
        $totalIncome = Order::whereDate('created_at', $date)
                            ->where('status', 'done')
                            ->sum('total_price');

        // 2. Jumlah Transaksi Unik (Dihitung per order_group_id agar lebih akurat)
        $totalTransactions = Order::whereDate('created_at', $date)
                                  ->distinct('order_group_id')
                                  ->count('order_group_id');

        // 3. Pesanan Belum Jadi (REVISI: Sesuaikan ke status 'pending' dan 'waiting')
        $pendingOrders = Order::whereDate('created_at', $date)
                              ->whereIn('status', ['pending', 'waiting'])
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