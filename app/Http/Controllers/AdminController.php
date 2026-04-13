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
        // Real data
        $stats = [
            'total_students' => User::where('role', 'member')->count(),
            'total_sensei' => Sensei::count(), 
<<<<<<< HEAD
            'active_classes' => 12, // Mock
            'pending_registrations' => User::where('status', 'pending')->count(),
            'total_transactions' => 156, // Mock
            'certificates_issued' => 45, // Mock
        ];

        $pendingUsers = User::where('status', 'pending')
            ->orWhere('payment_status', 'pending')
=======
            'active_classes' => \App\Models\Course::count(),
            'pending_registrations' => \App\Models\Transaction::where('status', 'pending')->count(),
            'total_transactions' => \App\Models\Transaction::count(),
            'certificates_issued' => \App\Models\UserAchievement::where('achievement_type', 'certificate')->count(),
            'home_visitors' => \App\Models\VisitorStat::where('page_path', '/')->first()->views_count ?? 0,
        ];

        $pendingTransactions = \App\Models\Transaction::with('user')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $pendingUsers = User::where('status', 'pending')
>>>>>>> e6e7c7f557a4b8aca27280b3c6c60b2b0511f814
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        // Dynamic Recent Activity
        $recentUsers = User::orderBy('created_at', 'desc')->limit(3)->get()->map(function($user) {
            return [
                'type' => 'user_register',
                'description' => 'User baru mendaftar: ' . $user->name,
                'time' => $user->created_at->diffForHumans(),
                'icon' => 'user-plus',
                'color' => 'blue',
                'timestamp' => $user->created_at
            ];
        });

        $recentPayments = \App\Models\Transaction::with('user')->orderBy('updated_at', 'desc')->limit(3)->get()->map(function($trx) {
            $statusText = $trx->status === 'approved' ? 'diterima dari ' : 'menunggu konfirmasi dari ';
            return [
                'type' => 'payment',
                'description' => 'Pembayaran ' . $statusText . ($trx->user->name ?? 'User'),
                'time' => $trx->updated_at->diffForHumans(),
                'icon' => $trx->status === 'approved' ? 'check-circle' : 'currency-dollar',
                'color' => $trx->status === 'approved' ? 'green' : 'yellow',
                'timestamp' => $trx->updated_at
            ];
        });

        $recent_activities = $recentUsers->concat($recentPayments)->sortByDesc('timestamp')->take(6)->values()->toArray();

        // Registration Statistics (Last 5 Days)
        $registration_stats = collect();
        for ($i = 4; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $count = User::whereDate('created_at', $date->toDateString())->count();
            $registration_stats->push([
                'label' => $date->translatedFormat('D'),
                'count' => $count,
                'is_today' => $i === 0
            ]);
        }
        $maxRegistration = $registration_stats->max('count') ?: 1;

        return view('admin.dashboard', compact('stats', 'pendingTransactions', 'pendingUsers', 'recent_activities', 'registration_stats', 'maxRegistration'));
    }

    public function approve($id)
    {
        $transaction = \App\Models\Transaction::findOrFail($id);
        $transaction->update([
            'status' => 'approved'
        ]);
        
        // Update user's selected package and role
        $user = $transaction->user;
        if ($user->role !== 'member') {
            $user->update(['role' => 'member']);
        }
        
        // Set the selected package so middleware can validate access
        $user->update(['selected_package' => $transaction->package_type]);

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
