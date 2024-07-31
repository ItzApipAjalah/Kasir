<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PetugasGudang;

class PetugasGudangController extends Controller
{
    public function index()
    {
        $petugasGudang = PetugasGudang::all();
        return view('admin.petugas_gudang.index', compact('petugasGudang'));
    }

    public function create()
    {
        return view('admin.petugas_gudang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:petugas_gudangs,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        PetugasGudang::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('petugas_gudang.index')->with('success', 'Petugas Gudang created successfully.');
    }

    public function edit($id)
    {
        $petugasGudang = PetugasGudang::findOrFail($id);
        return view('admin.petugas_gudang.edit', compact('petugasGudang'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:petugas_gudangs,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $petugasGudang = PetugasGudang::findOrFail($id);
        $petugasGudang->name = $request->name;
        $petugasGudang->email = $request->email;

        if ($request->password) {
            $petugasGudang->password = bcrypt($request->password);
        }

        $petugasGudang->save();

        return redirect()->route('petugas_gudang.index')->with('success', 'Petugas Gudang updated successfully.');
    }

    public function destroy($id)
    {
        PetugasGudang::destroy($id);
        return redirect()->route('petugas_gudang.index')->with('success', 'Petugas Gudang deleted successfully.');
    }
}
