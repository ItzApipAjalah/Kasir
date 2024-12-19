<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    protected $fillable = ['transaction_id', 'produk_id', 'quantity', 'harga', 'total'];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
