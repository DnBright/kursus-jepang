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

    public function show($id)
    {
        $course = Course::with(['modules.lessons'])->findOrFail($id);

        if (!Auth::user()->hasActivePackage($course->level)) {
            return redirect()->route('packages.index')->with('error', 'Anda harus membeli paket ini terlebih dahulu.');
        }

        return view('member.courses.show', compact('course'));
    }
}
