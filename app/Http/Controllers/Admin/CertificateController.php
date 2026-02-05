<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        // Mock Pending Approvals
        $pendingApprovals = collect([
            (object)[
                'id' => 1,
                'student_name' => 'Budi Santoso',
                'program' => 'N5 Intensive',
                'class_name' => 'N5 Intensive Batch 12',
                'progress' => 100,
                'final_score' => 95,
                'status' => 'pending',
                'request_date' => now()->subDays(1)
            ],
             (object)[
                'id' => 2,
                'student_name' => 'Siti Aminah',
                'program' => 'N4 Regular',
                'class_name' => 'N4 Regular Batch 5',
                'progress' => 100,
                'final_score' => 88,
                'status' => 'pending',
                'request_date' => now()->subHours(5)
            ]
        ]);

        // Mock Issued Certificates
        $issuedCertificates = collect([
            (object)[
                'certificate_no' => 'KJ-202512-001',
                'student_name' => 'Rudi Hartono',
                'program' => 'N5 Basic',
                'issue_date' => now()->subWeeks(2),
                'status' => 'valid'
            ],
            (object)[
                'certificate_no' => 'KJ-202512-002',
                'student_name' => 'Dewi Lestari',
                'program' => 'N5 Basic',
                'issue_date' => now()->subWeeks(1),
                'status' => 'valid'
            ]
        ]);

        // Mock Templates
        $templates = collect([
            (object)[
                'id' => 1,
                'name' => 'Standard Certificate N5',
                'level' => 'N5',
                'thumbnail' => 'https://via.placeholder.com/150',
                'is_active' => true
            ],
            (object)[
                'id' => 2,
                'name' => 'Premium Certificate N4',
                'level' => 'N4',
                'thumbnail' => 'https://via.placeholder.com/150',
                'is_active' => true
            ]
        ]);

        $stats = [
            'total_issued' => 1250,
            'pending_count' => $pendingApprovals->count(),
            'this_month' => 45,
            'rejected_count' => 3
        ];

        return view('admin.certificates.index', compact('pendingApprovals', 'issuedCertificates', 'templates', 'stats'));
    }
}
