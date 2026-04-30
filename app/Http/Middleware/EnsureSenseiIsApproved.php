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
        $user = Auth::guard('sensei')->user();

        if ($user && $user->status === 'approved') {
            return $next($request);
        }

        if ($user && $user->status === 'pending') {
            return response()->view('auth.pending');
        }

        Auth::guard('sensei')->logout();
        return redirect()->route('sensei.login')->with('error', 'Akun Anda belum disetujui atau telah dinonaktifkan.');
    }
}
