<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product; // Import model produk

class Order extends Model
{
    protected $fillable = ['table_number', 'product_name', 'quantity', 'total_price', 'status'];

    protected static function booted()
    {
        // Fungsi ini jalan otomatis setiap ada pesanan baru tersimpan
        static::created(function ($order) {
            // 1. Cari produk berdasarkan nama
            $product = Product::where('name', $order->product_name)->first();
            
            // 2. Kalau produk ketemu, kurangi stoknya
            if ($product) {
                $product->decrement('stock', $order->quantity);
            }
        });
    }
}