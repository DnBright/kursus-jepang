<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    public function show($package)
    {
        $user = Auth::user();

        // Prevent duplicate purchase
        if ($user->hasActivePackage($package)) {
            return redirect()->route('dashboard')->with('error', 'Anda sudah memiliki paket ' . $package . '.');
        }

        if ($user->hasPendingPackage($package)) {
            return redirect()->route('dashboard')->with('error', 'Permintaan pembelian paket ' . $package . ' Anda sedang diproses.');
        }

        // Define prices or get from DB (Hardcoded for now based on views)
        $prices = [
            'Basic N5' => 399000,
            'Intensive N4' => 2250000,
            'Tokutei Ginou' => 8500000,
        ];

        $price = $prices[$package] ?? 0;

        return view('checkout.show', compact('package', 'price'));
    }

    public function store(Request $request, $package)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

         // Double check to prevent race conditions
        if ($user->hasActivePackage($package) || $user->hasPendingPackage($package)) {
            return redirect()->route('dashboard')->with('error', 'Transaksi tidak dapat diproses karena Anda sudah memiliki atau sedang mengajukan paket ini.');
        }

        $proofPath = null;
        if ($request->hasFile('proof')) {
            $proofPath = $request->file('proof')->store('payment_proofs', 'public');
        }

        // Determine price again
         $prices = [
            'Basic N5' => 399000,
            'Intensive N4' => 2250000,
            'Tokutei Ginou' => 8500000,
        ];
        $price = $prices[$package] ?? 0;

        $user->transactions()->create([
            'package_type' => $package,
            'status' => 'pending',
            'amount' => $price,
            'payment_method' => $request->payment_method,
            'payment_proof' => $proofPath,
        ]);

        return redirect()->route('dashboard')->with('status', 'Pembayaran berhasil dikirim! Admin kami akan segera memverifikasi bukti transfer Anda.');
    }
}
