<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DisplayTransaction;
use Illuminate\Http\Request;

class DisplayTransactionAPIController extends Controller
{
    public function index()
    {
        $displayTransactions = DisplayTransaction::all();
        return response()->json($displayTransactions);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'transaction_id' => 'required|exists:transaksi,id',
            // Add other necessary fields
        ]);

        $displayTransaction = DisplayTransaction::create($validatedData);
        return response()->json($displayTransaction, 201);
    }

    public function destroy($id)
    {
        $displayTransaction = DisplayTransaction::findOrFail($id);
        $displayTransaction->delete();
        return response()->json(null, 204);
    }
}
