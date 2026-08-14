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
        // This middleware is only for regular users (web guard)
        // If no web user is logged in, redirect to login
        if (!Auth::guard('web')->check()) {
            // If someone is logged in via wrong guard, redirect them appropriately
            return redirect()->route('login');
        }

        $user = Auth::guard('web')->user();

        // Check if user has ANY approved package
        $hasAnyPackage = $user->transactions()->where('status', 'approved')->exists();

        if (!$hasAnyPackage) {
            // Check if they have a pending package instead
            $hasPendingPackage = $user->transactions()->where('status', 'pending')->exists();
            if ($hasPendingPackage) {
                return response()->view('errors.package-pending');
            }
            
            return redirect()->route('packages.index')->with('warning', 'Silakan beli paket kursus terlebih dahulu untuk mengakses fitur ini.');
        }

        return $next($request);
    }
}
