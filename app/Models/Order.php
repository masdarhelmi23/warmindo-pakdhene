<?php

namespace App\Http\Controllers; //

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    /**
     * Jurus Maut: Mematikan proteksi Mass Assignment.
     * Dengan guarded kosong, semua kolom (termasuk customer_name & order_group_id)
     * bisa diisi secara otomatis tanpa perlu didaftarkan satu-satu.
     */
    protected $guarded = [];

    // REVISI: Fungsi booted() yang memotong stok otomatis dihapus total 
    // karena urusan potong stok sudah dihandle dengan aman oleh TableController.
}