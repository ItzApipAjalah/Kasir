<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $primaryKey = 'produk_id';

    protected $fillable = [
        'produk_id', 'namaproduk', 'thumbnail', 'harga', 'stok',
    ];

    public $incrementing = false;
    protected $keyType = 'string'; // Bisa juga 'string' jika ingin menggunakan varchar
}
