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
            VisitorStat::updateOrCreate(
                ['page_path' => '/'],
                ['views_count' => \Illuminate\Support\Facades\DB::raw('views_count + 1')]
            );
        }

        return $next($request);
    }
}
