<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureHasActivePackage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Admin and Sensei bypass
        if ($user->role === 'admin' || $user->role === 'sensei') {
            return $next($request);
        }

        // Check if user has selected a package
        $package = $user->selected_package;

        if (!$package) {
            // If no package selected/purchased at all, redirect to packages list
            return redirect()->route('packages.index')->with('warning', 'Silakan pilih paket kursus terlebih dahulu.');
        }

        // Check active status
        if ($user->hasActivePackage($package)) {
            return $next($request);
        }

        // Check pending status
        if ($user->hasPendingPackage($package)) {
            return response()->view('errors.package-pending');
        }

        // Fallback: Has package name in profile but no valid transaction (maybe rejected or expired)
        return redirect()->route('packages.index')->with('error', 'Status paket Anda tidak aktif. Silakan lakukan pembelian ulang.');
    }
}
