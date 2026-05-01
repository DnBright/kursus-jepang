<?php

namespace App\Http\Controllers\Sensei;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function index()
    {
        $sensei = Auth::guard('sensei')->user();
        
        // Get courses taught by this sensei
        $courseTitles = Course::where('instructor_id', $sensei->id)->pluck('title')->toArray();

        // Get students enrolled in those courses
        $studentQuery = User::whereIn('selected_package', $courseTitles)
            ->where('payment_status', 'approved');

        $studentsData = $studentQuery->get();

        // Calculate summary stats
        $summary = [
            'total_active' => $studentQuery->count(),
            'new_students' => $studentQuery->where('created_at', '>=', now()->subDays(7))->count(),
            'needs_evaluation' => 0, // Will be calculated if quiz grading is implemented
            'avg_progress' => 0, // Placeholder
        ];

        $students = $studentsData->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'class' => $user->selected_package ?? 'General',
                'level' => '-', // Can be derived from course level
                'progress' => 0, // Can be calculated from LessonProgress
                'avg_score' => 0, // Can be calculated from QuizAttempts
                'status' => 'active',
                'trend' => 'stable',
                'avatar' => strtoupper(substr($user->name, 0, 2)),
                'joined_at' => $user->created_at->format('d M Y'),
            ];
        });

        return view('sensei.students.index', compact('summary', 'students'));
    }
}
