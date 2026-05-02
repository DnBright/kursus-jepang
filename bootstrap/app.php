<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeaders::class,
            \App\Http\Middleware\TrackWebsiteVisitors::class,
        ]);

        $middleware->alias([
            'active' => \App\Http\Middleware\EnsureUserIsActive::class,
            'member' => \App\Http\Middleware\EnsureUserIsMember::class,
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
            'sensei.approved' => \App\Http\Middleware\EnsureSenseiIsApproved::class,
            'package.active' => \App\Http\Middleware\EnsureHasActivePackage::class,
        ]);

        $middleware->redirectUsersTo(function () {
            if (\Illuminate\Support\Facades\Auth::guard('admin')->check()) {
                return route('admin.dashboard');
            }
            if (\Illuminate\Support\Facades\Auth::guard('sensei')->check()) {
                return route('sensei.dashboard');
            }
            if (\Illuminate\Support\Facades\Auth::guard('web')->check()) {
                return route('dashboard');
            }
            return '/';
        });

        $middleware->redirectGuestsTo(function (\Illuminate\Http\Request $request) {
            // Check if this is an admin route
            if (request()->is('admin/*') || request()->is('admin')) {
                return route('admin.login');
            }
            
            // Check if this is a sensei route - must be explicit
            if (request()->is('sensei/*') || request()->is('sensei') || request()->is('sensei/login')) {
                return route('sensei.login');
            }
            
            // Check referer for sensei routes (in case request path check fails)
            $referer = request()->headers->get('referer', '');
            if (str_contains($referer, '/sensei/')) {
                return route('sensei.login');
            }
            
            // Default to student login
            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
