<?php

namespace App\Http\Controllers\Sensei;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Course;
use App\Models\User;
use App\Models\LiveSession;
use App\Models\AssignmentSubmission;
use App\Models\Assignment;
use App\Models\UserQuizAttempt;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $sensei = Auth::guard('sensei')->user();
        
        $courses = Course::where('instructor_id', $sensei->id)->get();
        $courseTitles = $courses->pluck('title');
        $courseIds = $courses->pluck('id');
        
        $assignments = Assignment::where('instructor_id', $sensei->id)->get();
        $assignmentIds = $assignments->pluck('id');

        $stats = [
            'active_classes' => $courses->count(),
            'total_students' => User::whereIn('selected_package', $courseTitles)
                ->where('payment_status', 'approved')
                ->count(),
            'today_schedule' => LiveSession::where('instructor_id', $sensei->id)
                ->whereDate('scheduled_at', now()->toDateString())
                ->count(),
            'grading_needed' => AssignmentSubmission::whereIn('assignment_id', $assignmentIds)
                ->where('status', 'pending')
                ->count(),
        ];

        $upcomingClass = LiveSession::where('instructor_id', $sensei->id)
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at', 'asc')
            ->first();

        // Recent Activity Aggregation
        $recentQuizzes = UserQuizAttempt::whereIn('quiz_id', function($query) use ($sensei) {
                $query->select('id')->from('quizzes')->where('instructor_id', $sensei->id);
            })
            ->with(['user', 'quiz'])
            ->latest()
            ->limit(3)
            ->get()
            ->map(function($q) {
                return [
                    'icon' => '📚',
                    'text' => "<strong>{$q->user->name}</strong> menyelesaikan quiz <strong>{$q->quiz->title}</strong>",
                    'time' => $q->created_at->diffForHumans(),
                    'action_label' => 'Detail',
                    'action_url' => route('sensei.quizzes.index')
                ];
            });

        $recentSubmissions = AssignmentSubmission::whereIn('assignment_id', $assignmentIds)
            ->with(['user', 'assignment'])
            ->latest()
            ->limit(3)
            ->get()
            ->map(function($s) {
                return [
                    'icon' => '📝',
                    'text' => "<strong>{$s->user->name}</strong> mengumpulkan tugas <strong>{$s->assignment->title}</strong>",
                    'time' => $s->created_at->diffForHumans(),
                    'action_label' => 'Review',
                    'action_url' => route('sensei.assignments.grading', $s->assignment_id)
                ];
            });

        $recentActivities = $recentQuizzes->concat($recentSubmissions)->sortByDesc('time')->values()->take(5);

        return view('sensei.dashboard', compact('stats', 'upcomingClass', 'recentActivities'));
    }
}
