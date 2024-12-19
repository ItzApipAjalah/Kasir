<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Petugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class PetugasAPIController extends Controller
{
    public function index()
    {
        $petugas = Petugas::all();
        return response()->json($petugas);
    }

    public function create()
    {
        return response()->json(['message' => 'Use POST request to create a new petugas']);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:petugas',
            'password' => 'required|string|min:8',
        ]);

        $petugas = Petugas::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return response()->json($petugas, 201);
    }

    public function show($id)
    {
        $petugas = Petugas::findOrFail($id);
        return response()->json($petugas);
    }

    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);
        return response()->json($petugas);
    }

    public function update(Request $request, $id)
    {
        $petugas = Petugas::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:petugas,email,' . $id,
            'password' => 'sometimes|string|min:8',
        ]);

        $petugas->update($validatedData);
        return response()->json($petugas);
    }

    public function destroy($id)
    {
        $petugas = Petugas::findOrFail($id);
        $petugas->delete();
        return response()->json(null, 204);
    }

    public function dashboard()
    {
        // Implement dashboard logic
        return response()->json(['message' => 'Petugas dashboard data']);
    }

    public function history()
    {
        // Implement history logic
        return response()->json(['message' => 'Petugas history data']);
    }

    public function getPetugasId()
    {
        $petugasId = Auth::guard('petugas')->id();
        return response()->json(['id' => $petugasId]);
    }

    public function generatePdf($id)
    {
        // Implement PDF generation logic
        $data = ['transaction_id' => $id]; // Replace with actual data
        $pdf = PDF::loadView('pdf.transaction', $data);
        return $pdf->download('transaction.pdf');
    }
}
