<?php

namespace App\Http\Controllers\Sensei\Auth;

use App\Http\Controllers\Controller;
use App\Models\Sensei;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('sensei.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Sensei::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $sensei = Sensei::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'pending',
            'is_active' => true,
        ]);

        event(new Registered($sensei));

        Auth::guard('sensei')->login($sensei);

        return redirect(route('sensei.dashboard', absolute: false));
    }
}
