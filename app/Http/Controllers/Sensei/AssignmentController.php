<?php

namespace App\Http\Controllers\Sensei;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function create()
    {
        $courses = Course::all();
        return view('sensei.assignments.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
            'assignment_type' => 'required|in:writing,speaking,reading,listening,project',
            'max_score' => 'required|integer|min:1',
            'due_date' => 'nullable|date',
        ]);

        Assignment::create([
            'title' => $request->title,
            'description' => $request->description,
            'instructor_id' => Auth::guard('sensei')->id(),
            'module_id' => $request->module_id,
            'assignment_type' => $request->assignment_type,
            'max_score' => $request->max_score,
            'due_date' => $request->due_date,
            'is_required' => $request->has('is_required'),
        ]);

        return redirect()->route('sensei.quizzes.index')->with('success', 'Tugas berhasil dibuat.');
    }

    public function edit($id)
    {
        $assignment = Assignment::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($id);
        $courses = Course::all();
        $modules = Module::where('course_id', $assignment->module->course_id)->get();
        return view('sensei.assignments.edit', compact('assignment', 'courses', 'modules'));
    }

    public function update(Request $request, $id)
    {
        $assignment = Assignment::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
            'assignment_type' => 'required|in:writing,speaking,reading,listening,project',
            'max_score' => 'required|integer|min:1',
        ]);

        $assignment->update([
            'title' => $request->title,
            'description' => $request->description,
            'module_id' => $request->module_id,
            'assignment_type' => $request->assignment_type,
            'max_score' => $request->max_score,
            'due_date' => $request->due_date,
            'is_required' => $request->has('is_required'),
        ]);

        return redirect()->route('sensei.quizzes.index')->with('success', 'Tugas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $assignment = Assignment::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($id);
        $assignment->delete();
        return redirect()->route('sensei.quizzes.index')->with('success', 'Tugas berhasil dihapus.');
    }

    public function grading($id)
    {
        $assignment = Assignment::where('instructor_id', Auth::guard('sensei')->id())
            ->with(['submissions.user'])
            ->findOrFail($id);
            
        return view('sensei.assignments.grading', compact('assignment'));
    }

    public function submitGrade(Request $request, $submissionId)
    {
        $submission = AssignmentSubmission::whereHas('assignment', function($query) {
            $query->where('instructor_id', Auth::guard('sensei')->id());
        })->findOrFail($submissionId);

        $request->validate([
            'score' => 'required|integer|min:0|max:' . $submission->assignment->max_score,
            'feedback' => 'nullable|string',
        ]);

        $submission->update([
            'score' => $request->score,
            'feedback' => $request->feedback,
            'status' => 'graded',
            'graded_at' => now(),
        ]);

        return back()->with('success', 'Nilai berhasil disimpan.');
    }
}
