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
            if (Auth::user()->role === 'admin') {
                return $next($request);
            }
            
            if (Auth::user()->status === 'pending') {
                Auth::logout();
                return redirect()->route('login')->with('status', 'Akun Anda sedang menunggu validasi Admin.');
            }

            if (Auth::user()->status === 'rejected') {
                Auth::logout();
                return redirect()->route('login')->with('status', 'Akun Anda telah ditolak. Silakan hubungi admin.');
            }
        }

        return $next($request);
    }
}
