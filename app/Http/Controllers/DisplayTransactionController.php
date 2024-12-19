<?php

namespace App\Http\Controllers;

use App\Models\DisplayTransaction;
use Illuminate\Http\Request;

class DisplayTransactionController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'produk_id' => 'required|integer',
            'namaproduk' => 'required|string',
            'harga' => 'required|numeric',
            'quantity' => 'required|integer',
        ]);

        DisplayTransaction::create($validatedData);

        return response()->json(['message' => 'Item added to display transaction']);
    }

    public function index()
    {
        $displayTransactions = DisplayTransaction::all();
        return response()->json($displayTransactions);
    }

    public function destroy()
    {
        DisplayTransaction::truncate();
        return response()->json(['message' => 'All display transactions deleted']);
    }
}
