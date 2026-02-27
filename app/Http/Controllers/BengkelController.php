<?php

namespace App\Http\Controllers;

use App\Models\Bengkel;
use Illuminate\Http\Request;

class BengkelController extends Controller
{
    public function index()
    {
        $bengkels = Bengkel::orderBy('nama')->get();
        return view('settings.bengkel', compact('bengkels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'alamat'  => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
        ]);

        Bengkel::create($request->only(['nama', 'alamat', 'telepon']));
        return redirect()->route('settings.bengkel')->with('success', 'Bengkel berhasil ditambahkan!');
    }

    public function update(Request $request, Bengkel $bengkel)
    {
        $request->validate([
            'nama'    => 'required|string|max:255',
            'alamat'  => 'nullable|string',
            'telepon' => 'nullable|string|max:20',
        ]);

        $bengkel->update($request->only(['nama', 'alamat', 'telepon']));
        return redirect()->route('settings.bengkel')->with('success', 'Data bengkel berhasil diupdate!');
    }

    public function destroy(Bengkel $bengkel)
    {
        $bengkel->delete();
        return redirect()->route('settings.bengkel')->with('success', 'Bengkel berhasil dihapus!');
    }
}