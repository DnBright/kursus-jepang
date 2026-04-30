<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\VisitorStat;
use Symfony\Component\HttpFoundation\Response;

class TrackWebsiteVisitors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->is('/') && $request->method() === 'GET') {
            VisitorStat::firstOrCreate(['page_path' => '/'])->increment('views_count');
        }

        return $next($request);
    }
}
