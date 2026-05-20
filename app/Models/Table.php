<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    // Pastikan 'token' ada di sini, 'qrcode' bisa tetap ada jika ingin simpan gambar QR
    protected $fillable = ['number', 'status', 'token', 'qrcode']; 

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($table) {
            // Kita gunakan kolom 'token' untuk kode unik di URL
            $table->token = $table->token ?? bin2hex(random_bytes(8));
        });
    }
}