<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = [
            'name'   => $user->name,
            'email'  => $user->email,
            'role'   => ucfirst($user->role ?? 'staff'),
            'joined' => $user->created_at,
            'phone'  => $user->phone ?? '-',
            'position'  => $user->position ?? '-',
            'department'=> $user->department ?? '-',
            'avatar' => $user->avatar ?? null,
        ];
        return view('profile.index', compact('profile', 'user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'phone'      => 'nullable|string|max:20',
            'position'   => 'nullable|string|max:100',
            'department' => 'nullable|string|max:100',
            'avatar'     => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) \Storage::disk('public')->delete($user->avatar);
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);
        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini tidak benar.']);
        }

        auth()->user()->update(['password' => Hash::make($request->password)]);
        return redirect()->route('profile.index')->with('success', 'Password berhasil diubah!');
    }
}
