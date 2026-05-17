<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
   public function index(Request $request)
    {
        $startDate = $request->input('start_date', date('Y-m-01'));
        $endDate = $request->input('end_date', date('Y-m-d'));

        // Query dasar
        $baseQuery = Order::where('status', 'done')
                        ->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        $totalRevenue = (clone $baseQuery)->sum('total_price');
        $orderCount = (clone $baseQuery)->sum('quantity');
        $totalTransactions = (clone $baseQuery)->distinct('order_group_id')->count('order_group_id');
        $avgSpend = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;

        // Bagian yang tadi error
        $avgProcessingTime = (clone $baseQuery)
            ->selectRaw('AVG(TIMESTAMPDIFF(MINUTE, created_at, updated_at)) as avg_time')
            // Filter tambahan: Hanya hitung pesanan yang selesai dalam waktu kurang dari 120 menit
            ->whereRaw('TIMESTAMPDIFF(MINUTE, created_at, updated_at) < 120') 
            ->value('avg_time') ?? 0;

        $topMenus = Order::where('status', 'done')
            ->whereBetween('updated_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->select('product_name', \DB::raw('SUM(quantity) as total_qty'), \DB::raw('SUM(total_price) as total_sales'))
            ->groupBy('product_name')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();

        $recentTransactions = (clone $baseQuery)->orderBy('updated_at', 'desc')->get();

        return view('owner.index', compact(
            'totalRevenue', 'orderCount', 'avgSpend', 'avgProcessingTime',
            'topMenus', 'recentTransactions', 'startDate', 'endDate', 'totalTransactions'
        ));
    }
}