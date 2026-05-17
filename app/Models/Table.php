<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['number', 'status', 'qrcode'];
    protected static function boot()
{
    parent::boot();
    static::creating(function ($table) {
        // Ini akan membuat token unik setiap meja baru dibuat
        $table->token = $table->token ?? bin2hex(random_bytes(8));
    });
}
}
