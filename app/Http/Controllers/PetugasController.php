<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Petugas;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = Petugas::all();
        return view('admin.petugas.index', compact('petugas'));
    }

    public function create()
    {
        return view('admin.petugas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:petugas,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        Petugas::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('petugas.index')->with('success', 'Petugas created successfully.');
    }

    public function edit($id)
    {
        $petugas = Petugas::findOrFail($id);
        return view('admin.petugas.edit', compact('petugas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:petugas,email,' . $id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $petugas = Petugas::findOrFail($id);
        $petugas->name = $request->name;
        $petugas->email = $request->email;

        if ($request->password) {
            $petugas->password = bcrypt($request->password);
        }

        $petugas->save();

        return redirect()->route('petugas.index')->with('success', 'Petugas updated successfully.');
    }

    public function destroy($id)
    {
        Petugas::destroy($id);
        return redirect()->route('petugas.index')->with('success', 'Petugas deleted successfully.');
    }
}
