<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Sensei;
use Illuminate\Http\Request;

class ValidationController extends Controller
{
    public function index()
    {
        // Mock data logic for now, using models if available or array mock
        // Assuming User model has 'payment_status' and 'selected_package'
        $pendingStudents = User::where('payment_status', 'pending')
             ->orWhere('role', 'pending') // Adjustment based on potential schema
             ->orderBy('created_at', 'desc')
             ->get();

        // If no real data, let's mock some for UI development
        if($pendingStudents->isEmpty()) {
            $pendingStudents = collect([
                (object)[
                    'id' => 101,
                    'name' => 'Budi Santoso',
                    'email' => 'budi@example.com',
                    'selected_package' => 'N5 Intensive A',
                    'payment_method' => 'Transfer Bank BCA',
                    'payment_proof' => 'proof_budi.jpg',
                    'created_at' => now()->subHours(2),
                    'status' => 'pending'
                ],
                (object)[
                    'id' => 102,
                    'name' => 'Siti Aminah',
                    'email' => 'siti@example.com',
                    'selected_package' => 'N4 Regular B',
                    'payment_method' => 'GoPay',
                    'payment_proof' => 'proof_siti.jpg',
                    'created_at' => now()->subDay(),
                    'status' => 'pending'
                ]
            ]);
        }

        
        $stats = [
            'pending_total' => $pendingStudents->count(),
            'approved_today' => 5, // Mock
            'rejected_total' => 2, // Mock
            'avg_time' => '15 Menit'
        ];

        return view('admin.validations.index', compact('pendingStudents', 'stats'));
    }
}
