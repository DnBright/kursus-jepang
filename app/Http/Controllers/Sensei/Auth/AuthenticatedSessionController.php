<?php

namespace App\Http\Controllers\Sensei\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SenseiLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('sensei.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(SenseiLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('sensei.dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('sensei')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/sensei/login');
    }
}
