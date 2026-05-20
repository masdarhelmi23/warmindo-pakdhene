<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'today'); // Default ke 'today'
        $search = $request->get('search');
        
        $query = Order::query();

        // Logika Filter Tanggal
        if ($filter == 'today') {
            $query->whereDate('created_at', Carbon::today());
        } elseif ($filter == 'week') {
            $query->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        }

        // Pencarian Nama Pelanggan
        if ($search) {
            $query->where('customer_name', 'LIKE', '%' . $search . '%');
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();

        return view('admin.transactions.index', compact('transactions', 'filter', 'search'));
    }
}