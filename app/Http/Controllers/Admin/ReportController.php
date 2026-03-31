<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Overview Stats
        $totalUsers = \App\Models\User::count();
        $activeStudents = \App\Models\User::where('role', 'member')->count();
        $activeSensei = \App\Models\User::where('role', 'sensei')->count();
        $activeClasses = \App\Models\Course::count();
        $totalRevenue = \App\Models\Transaction::where('status', 'approved')->sum('amount');

        $overviewStats = [
            'total_users' => $totalUsers,
            'active_students' => $activeStudents,
            'active_sensei' => $activeSensei,
            'active_classes' => $activeClasses,
            'total_revenue' => 'Rp ' . number_format($totalRevenue, 0, ',', '.')
        ];

        // 2. User Stats
        $newUsersThisMonth = \App\Models\User::where('created_at', '>=', now()->startOfMonth())->count();
        $userStats = [
            'new_users_this_month' => $newUsersThisMonth,
            'active_users_growth' => ($totalUsers > 0) ? '+' . round(($newUsersThisMonth / $totalUsers) * 100) . '%' : '0%',
            'retention_rate' => '100%', // Placeholder logic
        ];

        // 3. Class Metrics
        $courses = \App\Models\Course::all();
        $classMetrics = $courses->map(function($course) {
            $studentCount = \App\Models\Transaction::where('package_type', $course->title)
                ->where('status', 'approved')
                ->count();
            
            return (object)[
                'name' => $course->title,
                'students' => $studentCount,
                'avg_score' => 90, // Placeholder
                'completion' => 85 // Placeholder
            ];
        });

        // 4. Finance Stats
        $financeTrx = \App\Models\Transaction::where('status', 'approved')
            ->where('created_at', '>=', now()->startOfMonth());
        
        $financeStats = [
            'gross_revenue' => 'Rp ' . number_format($financeTrx->sum('amount'), 0, ',', '.'),
            'successful_transactions' => $financeTrx->count(),
            'avg_transaction_value' => 'Rp ' . number_format($financeTrx->count() > 0 ? $financeTrx->avg('amount') : 0, 0, ',', '.')
        ];

        // 5. Certificate Stats
        $certsThisMonth = \App\Models\UserAchievement::where('achievement_type', 'certificate')
            ->where('earned_at', '>=', now()->startOfMonth())
            ->count();

        $certificateStats = [
            'issued_this_month' => $certsThisMonth,
            'avg_approval_time' => '1 Hari',
            'rejection_rate' => '0%'
        ];

        return view('admin.reports.index', compact('overviewStats', 'userStats', 'classMetrics', 'financeStats', 'certificateStats'));
    }
}
