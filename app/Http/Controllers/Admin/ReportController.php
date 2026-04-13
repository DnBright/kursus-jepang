<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        // 1. Overview Stats
        $totalUsers = \App\Models\User::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->count();
        $activeStudents = \App\Models\User::where('role', 'member')->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])->count();
        $activeSensei = \App\Models\User::where('role', 'sensei')->count();
        $activeClasses = \App\Models\Course::count();
        $totalRevenue = \App\Models\Transaction::where('status', 'approved')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->sum('amount');

        $overviewStats = [
            'total_users' => $totalUsers,
            'active_students' => $activeStudents,
            'active_sensei' => $activeSensei,
            'active_classes' => $activeClasses,
            'total_revenue' => 'Rp ' . number_format($totalRevenue, 0, ',', '.')
        ];

        // 2. User Stats
        $userStats = [
            'new_users_this_month' => $totalUsers,
            'active_users_growth' => '+0%', // Dynamic calc would need previous period
            'retention_rate' => '100%',
        ];

        // 2.1 User Growth Chart (Last 15 Days based on end date)
        $userGrowthChart = collect();
        $baseDate = \Carbon\Carbon::parse($endDate);
        for ($i = 14; $i >= 0; $i--) {
            $date = (clone $baseDate)->subDays($i);
            $userGrowthChart->push([
                'label' => $date->format('d M'),
                'count' => \App\Models\User::whereDate('created_at', $date->toDateString())->count()
            ]);
        }
        $maxUserGrowth = $userGrowthChart->max('count') ?: 1;

        // 3. Class Metrics
        $courses = \App\Models\Course::with('lessons')->get();
        $classMetrics = $courses->map(function($course) use ($startDate, $endDate) {
            $studentCount = \App\Models\Transaction::where('package_type', $course->title)
                ->where('status', 'approved')
                ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->count();
            
            $courseLessonIds = $course->lessons->pluck('id');
            $totalPossibleProgress = $courseLessonIds->count() * ($studentCount ?: 1);
            $actualProgress = \App\Models\LessonProgress::whereIn('lesson_id', $courseLessonIds)
                ->where('status', 'completed')
                ->count();
            
            $completionRate = $totalPossibleProgress > 0 ? round(($actualProgress / $totalPossibleProgress) * 100) : 0;
            
            // Average Quiz Score
            $avgScore = \App\Models\UserQuizAttempt::whereIn('quiz_id', \App\Models\Quiz::whereIn('lesson_id', $courseLessonIds)->pluck('id'))
                ->avg('score') ?? 0;

            return (object)[
                'name' => $course->title,
                'students' => $studentCount,
                'avg_score' => round($avgScore, 1),
                'completion' => $completionRate
            ];
        });

        // 4. Finance Stats
        $financeTrx = \App\Models\Transaction::where('status', 'approved')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        
        $financeStats = [
            'gross_revenue' => 'Rp ' . number_format($financeTrx->sum('amount'), 0, ',', '.'),
            'successful_transactions' => $financeTrx->count(),
            'avg_transaction_value' => 'Rp ' . number_format($financeTrx->count() > 0 ? $financeTrx->avg('amount') : 0, 0, ',', '.')
        ];

        // 4.1 Monthly Revenue Chart (Last 6 Months)
        $monthlyRevenueChart = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = \Carbon\Carbon::parse($endDate)->subMonths($i);
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
        $certsInPeriod = \App\Models\UserAchievement::where('achievement_type', 'certificate')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->count();
        
        $certificateStats = [
            'issued_this_month' => $certsInPeriod,
            'avg_approval_time' => '1 Hari',
            'rejection_rate' => '0%'
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
            'maxMonthlyRevenue',
            'startDate',
            'endDate'
        ));
    }

    public function export(Request $request)
    {
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());

        $fileName = 'report_' . $startDate . '_to_' . $endDate . '.csv';
        
        $transactions = \App\Models\Transaction::with('user')
            ->where('status', 'approved')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
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
            fputcsv($file, ['ID', 'User', 'Package', 'Amount', 'Date', 'Status']);

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
}
