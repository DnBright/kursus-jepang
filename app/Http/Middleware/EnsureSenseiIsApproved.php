<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureSenseiIsApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // First check if user is actually logged in via sensei guard
        if (!Auth::guard('sensei')->check()) {
            // If admin or member is trying to access sensei routes, redirect them
            if (Auth::guard('admin')->check()) {
                return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman sensei.');
            }
            if (Auth::guard('web')->check()) {
                return redirect()->route('dashboard')->with('error', 'Anda tidak memiliki akses ke halaman sensei.');
            }
            // Not logged in at all - must redirect to sensei login
            return redirect()->route('sensei.login');
        }

        $sensei = Auth::guard('sensei')->user();

        // Check sensei status - must be approved to access
        if ($sensei->status === 'approved') {
            return $next($request);
        }

        // Pending approval - show pending page
        if ($sensei->status === 'pending') {
            // Only show pending page for dashboard, otherwise allow access
            if ($request->is('sensei/dashboard') || $request->is('sensei')) {
                return response()->view('auth.pending');
            }
            return $next($request);
        }

        // Rejected or any other status - logout and redirect
        Auth::guard('sensei')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $message = $sensei->status === 'rejected'
            ? 'Akun sensei Anda telah ditolak. Silakan hubungi admin.'
            : 'Akun Anda belum disetujui atau telah dinonaktifkan.';

        return redirect()->route('sensei.login')->with('error', $message);
    }
}
