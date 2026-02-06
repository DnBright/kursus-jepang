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
        
        // Upcoming quizzes
        $upcomingQuizzes = Quiz::where('is_active', true)
            ->where(function($q) {
                $q->whereNull('available_from')->orWhere('available_from', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('available_until')->orWhere('available_until', '>=', now());
            })
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

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
