<?php

namespace App\Http\Controllers\Sensei;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Course;
use App\Models\LiveSession;
use Illuminate\Support\Facades\Auth;

class ClassController extends Controller
{
    public function index()
    {
        $sensei = Auth::guard('sensei')->user();
        
        $courses = Course::where('instructor_id', $sensei->id)
            ->withCount('modules')
            ->get();

        $classes = $courses->map(function($course) {
            // Find if there's a live session today for this course
            $todaySession = LiveSession::where('course_id', $course->id)
                ->whereDate('scheduled_at', now()->toDateString())
                ->first();

            $nextSession = LiveSession::where('course_id', $course->id)
                ->where('scheduled_at', '>', now())
                ->orderBy('scheduled_at', 'asc')
                ->first();

            return [
                'id' => $course->id,
                'name' => $course->title,
                'level' => $course->level,
                'status' => 'active', // can be dynamic if we add a status column to courses
                'students_count' => $course->studentsCount(),
                'schedule_day' => '-', // need a separate schedule table if we want recurring days
                'schedule_time' => $todaySession ? $todaySession->scheduled_at->format('H:i') : '-',
                'platform' => 'Zoom',
                'is_today' => $todaySession ? true : false,
                'next_session' => $nextSession ? $nextSession->scheduled_at->translatedFormat('D, d M H:i') : '-',
            ];
        });

        return view('sensei.classes.index', compact('classes'));
    }
}
