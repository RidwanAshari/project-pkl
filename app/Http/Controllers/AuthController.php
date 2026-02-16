<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Menampilkan form login
    public function loginForm()
    {
        return view('login');
    }

    // Proses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    // Menampilkan form register
    public function registerForm()
    {
        return view('register');
    }

    // Proses register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name'            => 'required|string|max:255',
            'last_name'             => 'required|string|max:255',
            'email'                 => 'required|string|email|max:255|unique:users',
            'phone'                 => 'required|string|max:20',
            'position'              => 'required|string|max:100',
            'department'            => 'required|string|max:100',
            'username'              => 'required|string|min:5|max:50|alpha_num|unique:users',
            'password'              => 'required|string|min:8|confirmed',
            'terms'                 => 'accepted',
        ]);

        User::create([
            'name'       => $validated['first_name'] . ' ' . $validated['last_name'],
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'position'   => $validated['position'],
            'department' => $validated['department'],
            'username'   => $validated['username'],
            'password'   => bcrypt($validated['password']),
        ]);

        // Login otomatis setelah register berhasil
        Auth::attempt([
            'email'    => $validated['email'],
            'password' => $request->password,
        ]);

        return redirect('/')->with('success', 'Akun berhasil dibuat! Selamat datang.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}