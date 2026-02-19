<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = $request->user();

        if (!$user) {
            abort(401);
        }

        // sementara: kabag pakai email (sesuai sistem lu sekarang)
        if ($role === 'kabag' && $user->email !== 'fajar@gmail.com') {
            abort(403, 'Akses khusus Kabag.');
        }

        return $next($request);
    }
}
