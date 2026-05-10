<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import ini biar rapi

class Category extends Model
{
    protected $fillable = ['name'];

    /**
     * Relasi: Satu Kategori memiliki Banyak Produk
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}