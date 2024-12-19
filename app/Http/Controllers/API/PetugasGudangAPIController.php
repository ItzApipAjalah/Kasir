<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PetugasGudang;
use Illuminate\Http\Request;

class PetugasGudangAPIController extends Controller
{
    public function index()
    {
        $petugasGudang = PetugasGudang::all();
        return response()->json($petugasGudang);
    }

    public function create()
    {
        return response()->json(['message' => 'Use POST request to create a new petugas gudang']);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:petugas_gudang',
            'password' => 'required|string|min:8',
        ]);

        $petugasGudang = PetugasGudang::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        return response()->json($petugasGudang, 201);
    }

    public function show($id)
    {
        $petugasGudang = PetugasGudang::findOrFail($id);
        return response()->json($petugasGudang);
    }

    public function edit($id)
    {
        $petugasGudang = PetugasGudang::findOrFail($id);
        return response()->json($petugasGudang);
    }

    public function update(Request $request, $id)
    {
        $petugasGudang = PetugasGudang::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:petugas_gudang,email,' . $id,
            'password' => 'sometimes|string|min:8',
        ]);

        $petugasGudang->update($validatedData);
        return response()->json($petugasGudang);
    }

    public function destroy($id)
    {
        $petugasGudang = PetugasGudang::findOrFail($id);
        $petugasGudang->delete();
        return response()->json(null, 204);
    }
}
