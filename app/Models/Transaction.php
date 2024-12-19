<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'total',
        'customer_id',
        'staff_id',
        'pay',
        'refund',
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function transactionDetails()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'customer_id');
    }

    public function customer()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    public function staff()
    {
        return $this->belongsTo(Petugas::class);
    }
}
