<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRoadmapStep;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\Lesson;
use Illuminate\Http\Request;

class RoadmapController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('admin.roadmap.index', compact('courses'));
    }

    public function manage($id)
    {
        $course = Course::findOrFail($id);
        $roadmapSteps = $course->roadmapSteps()->orderBy('order', 'asc')->get();
        
        $modules = Module::where('course_id', $course->id)->get();
        $quizzes = Quiz::where('course_id', $course->id)->get();
        
        return view('admin.roadmap.manage', compact('course', 'roadmapSteps', 'modules', 'quizzes'));
    }

    public function storeStep(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);

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
        $step = CourseRoadmapStep::findOrFail($stepId);

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
        $step = CourseRoadmapStep::findOrFail($stepId);
        $step->delete();

        return back()->with('success', 'Langkah roadmap berhasil dihapus.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'steps' => 'required|array',
            'steps.*.id' => 'required|integer',
            'steps.*.order' => 'required|integer',
        ]);

        foreach ($request->steps as $item) {
            CourseRoadmapStep::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}
