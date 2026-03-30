<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->role !== 'member') {
            $hasPending = $request->user()->transactions()->where('status', 'pending')->exists();
            if ($hasPending) {
                return redirect()->route('payment.pending');
            }
            return redirect()->route('packages.index')->with('status', 'Silakan pilih paket Anda terlebih dahulu!');
        }

        return $next($request);
    }
}
