<?php

namespace App\Http\Controllers\Sensei;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRoadmapStep;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoadmapController extends Controller
{
    public function index()
    {
        $sensei = Auth::guard('sensei')->user();
        $courses = Course::where('instructor_id', $sensei->id)->get();
        
        return view('sensei.roadmap.index', compact('courses'));
    }

    public function manage($id)
    {
        $course = Course::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($id);
        $roadmapSteps = $course->roadmapSteps()->orderBy('order', 'asc')->get();
        
        $modules = Module::where('course_id', $course->id)->get();
        $quizzes = Quiz::where('course_id', $course->id)->get();
        
        return view('sensei.roadmap.manage', compact('course', 'roadmapSteps', 'modules', 'quizzes'));
    }

    public function storeStep(Request $request, $courseId)
    {
        $course = Course::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($courseId);

        $request->validate([
            'content_type' => 'required|in:module,quiz,lesson',
            'content_id' => 'required|integer',
            'order' => 'required|integer',
            'title' => 'nullable|string'
        ]);

        $course->roadmapSteps()->create($request->all());

        return back()->with('success', 'Langkah roadmap berhasil ditambahkan.');
    }

    public function updateStep(Request $request, $stepId)
    {
        $step = CourseRoadmapStep::whereHas('course', function($q) {
            $q->where('instructor_id', Auth::guard('sensei')->id());
        })->findOrFail($stepId);

        $request->validate([
            'content_type' => 'required|in:module,quiz,lesson',
            'content_id' => 'required|integer',
            'order' => 'required|integer',
            'title' => 'nullable|string'
        ]);

        $step->update($request->only(['content_type', 'content_id', 'order', 'title']));

        return back()->with('success', 'Langkah roadmap berhasil diperbarui.');
    }

    public function destroyStep($stepId)
    {
        $step = CourseRoadmapStep::whereHas('course', function($q) {
            $q->where('instructor_id', Auth::guard('sensei')->id());
        })->findOrFail($stepId);

        $step->delete();

        return back()->with('success', 'Langkah roadmap berhasil dihapus.');
    }
}
