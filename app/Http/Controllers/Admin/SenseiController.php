<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sensei;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class SenseiController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.Sensei::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'title' => ['nullable', 'string', 'max:100'],
            'specialization' => ['nullable', 'string', 'max:100'],
            'phone_number' => ['nullable', 'string', 'max:20'],
        ]);

        Sensei::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'title' => $request->title ?? 'Sensei',
            'specialization' => $request->specialization ?? 'General Japanese',
            'phone_number' => $request->phone_number,
            'status' => 'active', // Bypass pending status
            'is_active' => true,  // Automatically active
            'years_of_experience' => 0,
        ]);

        return redirect()->back()->with('success', 'Sensei berhasil ditambahkan secara manual.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $sensei = Sensei::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:senseis,email,'.$sensei->id],
            'title' => ['nullable', 'string', 'max:100'],
            'specialization' => ['nullable', 'string', 'max:100'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'status' => ['required', 'in:active,inactive,suspended'],
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => ['confirmed', Rules\Password::defaults()],
            ]);
            $sensei->password = Hash::make($request->password);
        }

        $sensei->update([
            'name' => $request->name,
            'email' => $request->email,
            'title' => $request->title,
            'specialization' => $request->specialization,
            'phone_number' => $request->phone_number,
            'status' => $request->status,
            'is_active' => $request->status === 'active',
        ]);

        return redirect()->back()->with('success', 'Data Sensei berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sensei = Sensei::findOrFail($id);
        $sensei->delete();

        return redirect()->back()->with('success', 'Akun Sensei berhasil dihapus.');
    }
}
