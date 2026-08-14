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
        // 1. Check if web user is suspended or rejected first
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            if ($user->status === 'rejected') {
                Auth::guard('web')->logout();
                return redirect()->route('login')->with('status', 'Akun Anda telah ditolak. Silakan hubungi admin.');
            }

            if ($user->status === 'suspended') {
                Auth::guard('web')->logout();
                return redirect()->route('login')->with('status', 'Akun Anda telah ditangguhkan (suspend). Silakan hubungi admin.');
            }
        }

        // Check if regular user (member) is logged in via web guard
        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            // Check if not active (pending or other)
            if ($user->status !== 'active' && $user->status !== 'approved') {
                return redirect()->route('verification.pending');
            }

            return $next($request);
        }

        // No user is logged in, proceed to next middleware (auth middleware should handle redirect)
        return $next($request);
    }
}
