<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiAPIController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Add validation rules for transaction data
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'total_harga' => 'required|numeric',
            // Add other necessary fields
        ]);

        $transaksi = Transaksi::create($validatedData);
        return response()->json($transaksi, 201);
    }

    public function getTransactionDetails($id)
    {
        $transaksi = Transaksi::with('detailTransaksi')->findOrFail($id);
        return response()->json($transaksi);
    }

    public function getLatestTransaction()
    {
        $latestTransaction = Transaksi::with('detailTransaksi')->latest()->first();
        return response()->json($latestTransaction);
    }
}
