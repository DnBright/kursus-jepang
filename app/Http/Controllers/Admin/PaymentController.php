<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        // Mock Transactions
        $transactions = collect([
            (object)[
                'id' => 'TRX-20260105-001',
                'student_name' => 'Budi Santoso',
                'program' => 'N5 Intensive',
                'method' => 'Bank Transfer (BCA)',
                'amount' => 'Rp 2.500.000',
                'date' => now()->subHours(2),
                'status' => 'pending',
                'proof_url' => '#' // Placeholder
            ],
            (object)[
                'id' => 'TRX-20260104-005',
                'student_name' => 'Siti Aminah',
                'program' => 'N4 Regular',
                'method' => 'E-Wallet (GoPay)',
                'amount' => 'Rp 3.000.000',
                'date' => now()->subDay(),
                'status' => 'success',
                'proof_url' => '#'
            ],
            (object)[
                'id' => 'TRX-20260103-012',
                'student_name' => 'Rudi Hartono',
                'program' => 'Tokutei Ginou',
                'method' => 'Bank Transfer (Mandiri)',
                'amount' => 'Rp 5.000.000',
                'date' => now()->subDays(2),
                'status' => 'failed',
                'proof_url' => '#'
            ],
             (object)[
                'id' => 'TRX-20260105-002',
                'student_name' => 'Dewi Lestari',
                'program' => 'N5 Basic',
                'method' => 'Bank Transfer (BCA)',
                'amount' => 'Rp 1.500.000',
                'date' => now()->subHours(1),
                'status' => 'pending',
                'proof_url' => '#'
            ]
        ]);

        $stats = [
            'total_transactions' => 156,
            'revenue_this_month' => 'Rp 125.500.000',
            'success_count' => 142,
            'pending_count' => 8,
            'failed_count' => 6
        ];

        return view('admin.payments.index', compact('transactions', 'stats'));
    }
}
