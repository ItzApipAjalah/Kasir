<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisplayTransaction extends Model
{
    use HasFactory;

    protected $fillable = ['produk_id', 'namaproduk', 'harga', 'quantity'];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }
}
