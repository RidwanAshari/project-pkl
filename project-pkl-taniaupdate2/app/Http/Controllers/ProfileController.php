<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        // Data profil admin (hardcoded untuk fase 1)
        $profile = [
            'name' => 'Administrator',
            'email' => 'admin@asetkantor.com',
            'role' => 'Administrator',
            'joined' => '2024-01-01'
        ];

        return view('profile.index', compact('profile'));
    }
}