<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Produk;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'items' => 'required|array',
            'total' => 'required|numeric',
            'customer_id' => 'required|integer',
            'staff_id' => 'required|integer',
            'pay' => 'required|numeric',
        ]);

        // Calculate refund
        $refund = $validatedData['pay'] - $validatedData['total'];

        // Create transaction
        $transaction = Transaction::create([
            'customer_id' => $request->customer_id,
            'staff_id' => $request->staff_id,
            'total' => $request->total,
            'pay' => $request->pay,
            'change' => $request->change,
        ]);

        // Create transaction details
        foreach ($request->items as $item) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'produk_id' => $item['produk_id'],
                'quantity' => $item['quantity'],
                'harga' => $item['harga'],
                'total' => $item['total'],  // Add this line
            ]);

            // ... update stock code ...
        }

        return response()->json(['message' => 'Transaction successfully created'], 201);
    }



    public function getTransactionDetails($id)
    {
        // Retrieve transaction details along with the associated product name
        $transactionDetails = TransactionDetail::where('transaction_id', $id)
            ->join('produks', 'transaction_details.produk_id', '=', 'produks.produk_id')
            ->select('transaction_details.*', 'produks.namaproduk', 'produks.thumbnail')
            ->get();

        return response()->json($transactionDetails);
    }

    public function getLatestTransaction()
    {
        $latestTransaction = Transaction::with(['transactionDetails.produk', 'customer', 'staff'])
            ->latest()  
            ->first();

        if (!$latestTransaction) {
            return response()->json(['message' => 'No transactions found'], 404);
        }

        return response()->json($latestTransaction);
    }
}
