<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Sensei; // Assuming Sensei model exists
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        // Real data where possible, mock for others
        $stats = [
            'total_students' => User::where('role', 'member')->count(),
            'total_sensei' => Sensei::count(), 
            'active_classes' => 12, // Mock
            'pending_registrations' => \App\Models\Transaction::where('status', 'pending')->count(),
            'total_transactions' => \App\Models\Transaction::count(), // Mock replaced
            'certificates_issued' => 45, // Mock
        ];

        $pendingTransactions = \App\Models\Transaction::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $pendingUsers = User::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Mock Recent Activity
        $recent_activities = [
            [
                'type' => 'user_register',
                'description' => 'User baru mendaftar: Budi Santoso',
                'time' => 'Baru saja',
                'icon' => 'user-plus',
                'color' => 'blue'
            ],
             [
                'type' => 'payment',
                'description' => 'Pembayaran diterima dari Siti Aminah',
                'time' => '15 menit yang lalu',
                'icon' => 'currency-dollar',
                'color' => 'green'
            ]
        ];

        return view('admin.dashboard', compact('stats', 'pendingTransactions', 'pendingUsers', 'recent_activities'));
    }

    public function approve($id)
    {
        $transaction = \App\Models\Transaction::findOrFail($id);
        $transaction->update([
            'status' => 'approved'
        ]);
        
        // Also update user role to member if not already
        $user = $transaction->user;
        if ($user->role !== 'member') {
            $user->update(['role' => 'member']);
        }

        return back()->with('success', 'Transaksi untuk ' . $user->name . ' telah disetujui.');
    }

    public function reject($id)
    {
        $transaction = \App\Models\Transaction::findOrFail($id);
        $transaction->update(['status' => 'rejected']);
        
        return back()->with('success', 'Transaksi untuk ' . $transaction->user->name . ' telah ditolak.');
    }

    public function approveAccount($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'active']);
        return back()->with('success', 'Akun ' . $user->name . ' telah disetujui.');
    }

    public function rejectAccount($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); 
        return back()->with('success', 'Pendaftaran akun ' . $user->name . ' telah ditolak.');
    }
}
