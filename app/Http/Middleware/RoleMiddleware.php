<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        
        if (!auth()->check()) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        $userRole = auth()->user()->role->name ?? null;

        // Pastikan user memiliki salah satu role yang diizinkan
        if (!in_array($userRole, $roles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}
