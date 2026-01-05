<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Check if user has one of the required roles
        if (in_array(Auth::user()->role, $roles)) {
            return $next($request);
        }

        // User doesn't have the required role
        // Redirect to appropriate dashboard based on user's role
        if (Auth::user()->role === 'dosen') {
            return redirect()->route('dosen.dashboard')
                ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }

        return redirect()->route('mahasiswa.dashboard')
            ->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
