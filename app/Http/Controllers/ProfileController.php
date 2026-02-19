<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $profile = [
            'name'   => $user->name,
            'email'  => $user->email,
            'role'   => ($user->email === 'fajar@gmail.com') ? 'Kabag' : 'User',
            'joined' => optional($user->created_at)->format('Y-m-d'),
        ];

        return view('profile.index', compact('profile'));
    }
}
