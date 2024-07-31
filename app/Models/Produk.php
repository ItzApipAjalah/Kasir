<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $primaryKey = 'produk_id';

    protected $fillable = [
        'namaproduk',
        'thumbnail',
        'harga',
        'stok',
    ];

    public $incrementing = false; // If you're using a non-incrementing primary key
    protected $keyType = 'string'; // Change if you're using a different key type
}
