<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\UserPoint;
use App\Models\UserAchievement;
use App\Models\LessonProgress;
use App\Models\Quiz;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Calculate stats
        $totalXP = UserPoint::where('user_id', $userId)->sum('points');
        $achievements = UserAchievement::where('user_id', $userId)->orderBy('earned_at', 'desc')->take(3)->get();
        $completedLessons = LessonProgress::where('user_id', $userId)->where('status', 'completed')->count();
        
        // Get user's active packages
        $user = Auth::user();
        $activePackages = $user->transactions()
            ->where('status', 'approved')
            ->pluck('package_type')
            ->toArray();

        // Upcoming quizzes
        $allUpcomingQuizzes = Quiz::with(['lesson.module.course'])
            ->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('available_from')->orWhere('available_from', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('available_until')->orWhere('available_until', '>=', now());
            })
            ->orderBy('created_at', 'desc')
            ->get();

        $upcomingQuizzes = $allUpcomingQuizzes->filter(function($quiz) use ($activePackages) {
            if (Auth::guard('admin')->check() || Auth::guard('sensei')->check()) {
                return true;
            }

            if ($quiz->lesson && $quiz->lesson->module && $quiz->lesson->module->course) {
                $course = $quiz->lesson->module->course;
                foreach ($activePackages as $ap) {
                    if (stripos($course->title, $ap) !== false || stripos($course->level, $ap) !== false || stripos($ap, $course->level) !== false) {
                        return true;
                    }
                }
                return false;
            }

            foreach ($activePackages as $ap) {
                if (stripos($quiz->title, $ap) !== false) {
                    return true;
                }
            }
            return false;
        })->take(3);

        // Pending assignments
        $pendingAssignments = Assignment::where('due_date', '>=', now())
            ->whereDoesntHave('submissions', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orderBy('due_date', 'asc')
            ->take(3)
            ->get();

        return view('dashboard', compact(
            'totalXP',
            'achievements',
            'completedLessons',
            'upcomingQuizzes',
            'pendingAssignments'
        ));
    }
}
