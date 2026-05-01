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
        // Check if admin is logged in - they bypass all status checks
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Check if sensei is logged in
        if (Auth::guard('sensei')->check()) {
            $sensei = Auth::guard('sensei')->user();

            // Check if sensei is approved
            if ($sensei->status === 'approved') {
                return $next($request);
            }

            // Sensei not approved
            if ($sensei->status === 'pending') {
                return response()->view('auth.pending');
            }

            // Rejected or other status
            Auth::guard('sensei')->logout();
            return redirect()->route('sensei.login')->with('error', 'Akun Anda telah ditolak atau dinonaktifkan.');
        }

        // Check if regular user (member) is logged in via web guard
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            // Check if rejected first
            if ($user->status === 'rejected') {
                Auth::guard('web')->logout();
                return redirect()->route('login')->with('status', 'Akun Anda telah ditolak. Silakan hubungi admin.');
            }

            // Check if not active (pending or other)
            if ($user->status !== 'active' && $user->status !== 'approved') {
                return redirect()->route('verification.notice');
            }

            return $next($request);
        }

        // No user is logged in, proceed to next middleware (auth middleware should handle redirect)
        return $next($request);
    }
}
