<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        // 1. Get all transactions with user relations
        $transactions = \App\Models\Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($trx) {
                return (object)[
                    'id' => $trx->id,
                    'student_name' => $trx->user ? $trx->user->name : 'Unknown',
                    'program' => $trx->package_type,
                    'method' => 'Bank Transfer', // Could be dynamic if column exists
                    'amount' => 'Rp ' . number_format($trx->amount, 0, ',', '.'),
                    'date' => $trx->created_at,
                    'status' => $this->mapStatus($trx->status),
                    'raw_status' => $trx->status,
                    'proof_url' => $trx->payment_proof ? asset('storage/' . $trx->payment_proof) : null
                ];
            });

        // 2. Real Stats
        $allTrx = \App\Models\Transaction::all();
        $stats = [
            'total_transactions' => $allTrx->count(),
            'revenue_this_month' => 'Rp ' . number_format($allTrx->where('status', 'approved')->where('created_at', '>=', now()->startOfMonth())->sum('amount'), 0, ',', '.'),
            'success_count' => $allTrx->where('status', 'approved')->count(),
            'pending_count' => $allTrx->where('status', 'pending')->count(),
            'failed_count' => $allTrx->where('status', 'rejected')->count()
        ];

        return view('admin.payments.index', compact('transactions', 'stats'));
    }

    private function mapStatus($status)
    {
        return match($status) {
            'approved' => 'success',
            'pending' => 'pending',
            'rejected' => 'failed',
            default => 'pending'
        };
    }

    public function approve($id)
    {
        $transaction = \App\Models\Transaction::findOrFail($id);
        $transaction->update(['status' => 'approved']);
        
        $user = $transaction->user;
        if ($user && $user->role !== 'member') {
            $user->update(['role' => 'member']);
        }

        return back()->with('success', 'Pembayaran oleh ' . ($user->name ?? 'User') . ' telah disetujui.');
    }

    public function reject($id)
    {
        $transaction = \App\Models\Transaction::findOrFail($id);
        $transaction->update(['status' => 'rejected']);
        
        return back()->with('success', 'Pembayaran telah ditolak.');
    }
}
