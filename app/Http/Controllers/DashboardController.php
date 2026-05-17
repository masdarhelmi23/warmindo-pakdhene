<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Table;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalTables = Table::count();

        // Menghitung pendapatan hari ini dari pesanan yang sudah 'done'
        $incomeToday = Order::whereDate('created_at', Carbon::today())
                            ->where('status', 'done')
                            ->sum('total_price');

        $incomeYesterday = Order::whereDate('created_at', Carbon::yesterday())
                                ->where('status', 'done')
                                ->sum('total_price');
        
        $growth = 0;
        if ($incomeYesterday > 0) {
            $growth = (($incomeToday - $incomeYesterday) / $incomeYesterday) * 100;
        }

        $recentOrders = Order::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts', 
            'totalTables', 
            'incomeToday', 
            'growth',
            'recentOrders'
        ));
    }

    /**
     * Memproses pesanan dari pelanggan
     */
    public function processOrder(Request $request)
{
    // REVISI: Pastikan mencari 'table_number'
    $validator = Validator::make($request->all(), [
        'table_number'  => 'required', 
        'customer_name' => 'required|string|max:255',
        'items'         => 'required|array|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false, 
            'message' => 'Data tidak lengkap: ' . implode(', ', $validator->errors()->all())
        ], 422);
    }

    DB::beginTransaction();
    try {
        $groupId = 'ORD-' . time() . '-' . rand(100, 999);
        $items = $request->input('items');
        $customerName = $request->input('customer_name');
        $tableNumber = $request->input('table_number'); 

        foreach ($items as $item) {
            Order::create([
                'table_number'   => $tableNumber,
                'customer_name'  => $customerName, 
                'order_group_id' => $groupId,                        
                'product_name'   => $item['name'],
                'quantity'       => $item['qty'],
                'total_price'    => (int)$item['price'] * (int)$item['qty'],
                'status'         => 'pending' 
            ]);
        }

        DB::commit();
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}
}