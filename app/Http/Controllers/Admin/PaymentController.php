<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        // 1. Get filtered transactions with user relations
        $transactions = \App\Models\Transaction::with('user')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($trx) {
                return (object)[
                    'id' => $trx->id,
                    'student_name' => $trx->user ? $trx->user->name : 'Unknown',
                    'program' => $trx->package_type,
                    'method' => 'Bank Transfer',
                    'amount' => 'Rp ' . number_format($trx->amount, 0, ',', '.'),
                    'date' => $trx->created_at,
                    'status' => $this->mapStatus($trx->status),
                    'raw_status' => $trx->status,
                    'proof_url' => $trx->payment_proof ? asset('storage/' . $trx->payment_proof) : null
                ];
            });

        // 2. Real Stats filtered by period
        $allTrxInRange = \App\Models\Transaction::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->get();
        
        $stats = [
            'total_transactions' => $allTrxInRange->count(),
            'revenue_this_month' => 'Rp ' . number_format($allTrxInRange->where('status', 'approved')->sum('amount'), 0, ',', '.'),
            'success_count' => $allTrxInRange->where('status', 'approved')->count(),
            'pending_count' => $allTrxInRange->where('status', 'pending')->count(),
            'failed_count' => $allTrxInRange->where('status', 'rejected')->count()
        ];

        return view('admin.payments.index', compact('transactions', 'stats', 'startDate', 'endDate'));
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $fileName = 'payments_' . $startDate . '_to_' . $endDate . '.csv';
        
        $transactions = \App\Models\Transaction::with('user')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->get();

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($transactions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'Student', 'Package', 'Amount', 'Date', 'Status']);

            foreach ($transactions as $trx) {
                fputcsv($file, [
                    $trx->id,
                    $trx->user->name ?? 'N/A',
                    $trx->package_type,
                    $trx->amount,
                    $trx->created_at->format('Y-m-d H:i:s'),
                    $trx->status
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
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
