<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Admin bypass - can view member areas for management
        if (Auth::guard('admin')->check()) {
            return $next($request);
        }

        // Sensei bypass - can view member areas for teaching
        if (Auth::guard('sensei')->check()) {
            return $next($request);
        }

        // Check if regular user is logged in via web guard
        $user = Auth::guard('web')->user();

        if (!$user) {
            // No user logged in via web guard
            return redirect()->route('login');
        }

        // Check if user has member role
        if ($user->role !== 'member') {
            // Check if they are rejected
            if ($user->status === 'rejected') {
                Auth::guard('web')->logout();
                return redirect()->route('login')->with('status', 'Akun Anda telah ditolak.');
            }

            // Check if they are suspended
            if ($user->status === 'suspended') {
                Auth::guard('web')->logout();
                return redirect()->route('login')->with('status', 'Akun Anda telah ditangguhkan (suspend). Silakan hubungi admin.');
            }

            // Check if they have pending transactions (waiting for package approval)
            $hasPending = $user->transactions()->where('status', 'pending')->exists();
            if ($hasPending) {
                return redirect()->route('payment.pending');
            }

            // No package selected yet
            return redirect()->route('packages.index')->with('status', 'Silakan pilih paket Anda terlebih dahulu!');
        }

        // User is a valid member with active status
        return $next($request);
    }
}
