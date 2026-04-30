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
        // Admin and Sensei bypass
        if (Auth::guard('admin')->check() || Auth::guard('sensei')->check()) {
            return $next($request);
        }

        $user = Auth::user();

        if ($user && $user->role !== 'member') {
            $hasPending = $user->transactions()->where('status', 'pending')->exists();
            if ($hasPending) {
                return redirect()->route('payment.pending');
            }
            return redirect()->route('packages.index')->with('status', 'Silakan pilih paket Anda terlebih dahulu!');
        }

        return $next($request);
    }
}
