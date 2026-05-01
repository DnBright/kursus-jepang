<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Admin bypass status checks
            if ($user->role === 'admin') {
                return $next($request);
            }

            // Check if rejected first
            if ($user->status === 'rejected') {
                Auth::logout();
                return redirect()->route('login')->with('status', 'Akun Anda telah ditolak. Silakan hubungi admin.');
            }
            
            // Check if not active
            if ($user->status !== 'active' && $user->status !== 'approved') {
                return redirect()->route('verification.notice');
            }
        }

        return $next($request);
    }
}
