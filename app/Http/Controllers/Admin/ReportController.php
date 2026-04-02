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
            'active_users_growth' => ($totalUsers > 2) ? '+' . round(($newUsersThisMonth / ($totalUsers - $newUsersThisMonth ?: 1)) * 100) . '%' : '0%',
            'retention_rate' => $activeStudents > 0 ? round((\App\Models\Transaction::where('status', 'approved')->distinct('user_id')->count() / $totalUsers) * 100) . '%' : '0%',
        ];

        // 2.1 User Growth Chart (Last 15 Days)
        $userGrowthChart = collect();
        for ($i = 14; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $userGrowthChart->push([
                'label' => $date->format('d M'),
                'count' => \App\Models\User::whereDate('created_at', $date->toDateString())->count()
            ]);
        }
        $maxUserGrowth = $userGrowthChart->max('count') ?: 1;

        // 3. Class Metrics
        $courses = \App\Models\Course::with('lessons')->get();
        $classMetrics = $courses->map(function($course) {
            $studentCount = \App\Models\Transaction::where('package_type', $course->title)
                ->where('status', 'approved')
                ->count();
            
            $courseLessonIds = $course->lessons->pluck('id');
            $totalPossibleProgress = $courseLessonIds->count() * ($studentCount ?: 1);
            $actualProgress = \App\Models\LessonProgress::whereIn('lesson_id', $courseLessonIds)
                ->where('status', 'completed')
                ->count();
            
            $completionRate = $totalPossibleProgress > 0 ? round(($actualProgress / $totalPossibleProgress) * 100) : 0;
            
            // Average Quiz Score
            $avgScore = \App\Models\UserQuizAttempt::whereIn('quiz_id', \App\Models\Quiz::where('course_id', $course->id)->pluck('id'))
                ->avg('score') ?? 0;

            return (object)[
                'name' => $course->title,
                'students' => $studentCount,
                'avg_score' => round($avgScore, 1),
                'completion' => $completionRate
            ];
        });

        // 4. Finance Stats (Current Month)
        $financeTrx = \App\Models\Transaction::where('status', 'approved')
            ->where('created_at', '>=', now()->startOfMonth());
        
        $financeStats = [
            'gross_revenue' => 'Rp ' . number_format($financeTrx->sum('amount'), 0, ',', '.'),
            'successful_transactions' => $financeTrx->count(),
            'avg_transaction_value' => 'Rp ' . number_format($financeTrx->count() > 0 ? $financeTrx->avg('amount') : 0, 0, ',', '.')
        ];

        // 4.1 Monthly Revenue Chart (Last 6 Months)
        $monthlyRevenueChart = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $revenue = \App\Models\Transaction::where('status', 'approved')
                ->whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('amount');
            
            $monthlyRevenueChart->push([
                'label' => $date->translatedFormat('M Y'),
                'amount' => $revenue,
                'display' => 'Rp ' . number_format($revenue / 1000000, 1, ',', '.') . 'jt'
            ]);
        }
        $maxMonthlyRevenue = $monthlyRevenueChart->max('amount') ?: 1;

        // 5. Certificate Stats
        $certsThisMonth = \App\Models\UserAchievement::where('achievement_type', 'certificate')
            ->where('created_at', '>=', now()->startOfMonth())
            ->count();
        
        // Rejection rate logic
        $totalCertAttempts = \App\Models\UserAchievement::where('achievement_type', 'certificate')->count();
        $rejectedCerts = 0; // If we have a 'rejected' status in a log, otherwise 0

        $certificateStats = [
            'issued_this_month' => $certsThisMonth,
            'avg_approval_time' => '1 Hari', // Simplified for now
            'rejection_rate' => $totalCertAttempts > 0 ? round(($rejectedCerts / $totalCertAttempts) * 100) . '%' : '0%'
        ];

        return view('admin.reports.index', compact(
            'overviewStats', 
            'userStats', 
            'classMetrics', 
            'financeStats', 
            'certificateStats',
            'userGrowthChart',
            'maxUserGrowth',
            'monthlyRevenueChart',
            'maxMonthlyRevenue'
        ));
    }
}
