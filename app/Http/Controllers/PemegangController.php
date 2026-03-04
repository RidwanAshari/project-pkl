<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PemegangController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('settings.pemegang', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|min:8',
            'role'       => 'required|in:staff,kabag,finance,admin,umum',
            'position'   => 'nullable|string',
            'department' => 'nullable|string',
            'phone'      => 'nullable|string|max:20',
        ]);

        User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'position'   => $request->position,
            'department' => $request->department,
            'phone'      => $request->phone,
            'username'   => strtolower(str_replace(' ', '', $request->name)) . rand(100, 999),
        ]);

        return redirect()->route('settings.pemegang')->with('success', 'Pengguna berhasil ditambahkan dengan role ' . ucfirst($request->role) . '!');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'position'   => 'nullable|string',
            'department' => 'nullable|string',
            'phone'      => 'nullable|string|max:20',
        ]);

        $user->update([
            'name'       => $request->name,
            'position'   => $request->position,
            'department' => $request->department,
            'phone'      => $request->phone,
        ]);

        return redirect()->route('settings.pemegang')->with('success', 'Data pengguna berhasil diupdate!');
    }

    /**
     * Update role user — hanya admin yang bisa, dan tidak bisa ubah role diri sendiri.
     */
    public function updateRole(Request $request, User $user)
    {
        // Tidak bisa ubah role diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak bisa mengubah role akun sendiri!');
        }

        $request->validate([
            'role' => 'required|in:staff,kabag,finance,admin,umum',
        ]);

        $user->update(['role' => $request->role]);

        return redirect()->route('settings.pemegang')
            ->with('success', 'Role ' . $user->name . ' berhasil diubah menjadi ' . ucfirst($request->role) . '!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }
        $user->delete();
        return redirect()->route('settings.pemegang')->with('success', 'Pengguna berhasil dihapus!');
    }
}