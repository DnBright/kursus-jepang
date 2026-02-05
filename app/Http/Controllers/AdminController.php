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
            'pending_registrations' => User::where('payment_status', 'pending')->count(),
            'total_transactions' => 156, // Mock
            'certificates_issued' => 45, // Mock
        ];

        $pendingUsers = User::where('payment_status', 'pending')
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

        return view('admin.dashboard', compact('stats', 'pendingUsers', 'recent_activities'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->update([
            'role' => 'member',
            'payment_status' => 'paid'
        ]);
        return back()->with('success', 'User ' . $user->name . ' has been approved as a Member.');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->update(['status' => 'rejected']);
        return back()->with('success', 'User ' . $user->name . ' has been rejected.');
    }
}
