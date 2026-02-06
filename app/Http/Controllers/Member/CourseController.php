<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        // Get all courses with active flag for styling
        $courses = Course::all();
        return view('member.courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        // Ideally check if user has access to this course
        // if (!Auth::user()->hasActivePackage($course->level)) { abort(403); }

        $course->load('modules.lessons');
        return view('member.courses.show', compact('course'));
    }
}
