<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
public function index(Request $request)
{
    $filter = $request->get('filter', 'today'); // Default Hari Ini
    $search = $request->get('search');

    $query = Order::query();

    // Logika Filter Periode
    if ($filter == 'today') {
        $query->whereDate('created_at', Carbon::today());
    } elseif ($filter == 'week') {
        $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
    } elseif ($filter == 'month') {
        $query->whereMonth('created_at', Carbon::now()->month);
    }

    // Pencarian Nama Pelanggan
    if ($search) {
        $query->where('customer_name', 'LIKE', '%' . $search . '%');
    }

    $history = (clone $query)->orderBy('created_at', 'desc')->get();
    
    $totalIncome = (clone $query)->where('status', 'done')->sum('total_price') ?? 0;
    $totalTransactions = (clone $query)->distinct('order_group_id')->count('order_group_id');
    $pendingOrders = (clone $query)->where('status', '!=', 'done')->sum('quantity') ?? 0;
    $totalItems = (clone $query)->sum('quantity') ?? 0;

    return view('admin.reports.index', compact(
        'history', 'totalIncome', 'totalTransactions', 'pendingOrders', 'totalItems', 'filter', 'search'
    ));
}
}