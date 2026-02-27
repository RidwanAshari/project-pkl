<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Admin punya akses ke semua role
        if ($user->role === 'admin') {
            return $next($request);
        }
        
        // Cek apakah user punya role yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Jika tidak punya akses
        abort(403, 'AKSES KHUSUS ' . strtoupper(implode('/', $roles)) . '.');
    }
}