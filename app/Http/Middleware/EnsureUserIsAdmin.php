<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if admin is logged in
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // If sensei is trying to access admin routes, redirect to sensei dashboard
        if (Auth::guard('sensei')->check()) {
            return redirect()->route('sensei.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        // If regular member is trying to access admin routes, redirect to member dashboard
        if (Auth::guard('web')->check()) {
            return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        // Not logged in - redirect to admin login
        return redirect()->route('admin.login');
    }
}
