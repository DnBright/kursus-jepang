<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Mock Data for Overview
        $overviewStats = [
            'total_users' => 1250,
            'active_students' => 850,
            'active_sensei' => 12,
            'active_classes' => 24,
            'total_revenue' => 'Rp 450.000.000'
        ];

        // Mock Data for Users Tab
        $userStats = [
            'new_users_this_month' => 120,
            'active_users_growth' => '+15%',
            'retention_rate' => '85%',
        ];

        // Mock Data for Classes Tab
        $classMetrics = collect([
            (object)['name' => 'N5 Intensive Batch 12', 'students' => 25, 'avg_score' => 88, 'completion' => 90],
            (object)['name' => 'N4 Regular Batch 5', 'students' => 18, 'avg_score' => 82, 'completion' => 75],
            (object)['name' => 'N5 Basic Batch 20', 'students' => 30, 'avg_score' => 91, 'completion' => 40],
        ]);

        // Mock Data for Finance Tab
        $financeStats = [
            'gross_revenue' => 'Rp 52.000.000', // This Month
            'successful_transactions' => 142,
            'avg_transaction_value' => 'Rp 365.000'
        ];

        // Mock Data for Certificates Tab
        $certificateStats = [
            'issued_this_month' => 45,
            'avg_approval_time' => '1.5 Hari',
            'rejection_rate' => '5%'
        ];

        return view('admin.reports.index', compact('overviewStats', 'userStats', 'classMetrics', 'financeStats', 'certificateStats'));
    }
}
