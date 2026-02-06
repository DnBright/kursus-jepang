<?php

namespace App\Http\Controllers\Sensei;

use App\Http\Controllers\Controller;
use App\Models\AssignmentSubmission;
use Illuminate\Http\Request;

class AssignmentGradingController extends Controller
{
    public function index()
    {
        $pending = AssignmentSubmission::with(['assignment', 'user'])
            ->where('status', 'pending')
            ->orderBy('submitted_at', 'asc')
            ->get();

        $graded = AssignmentSubmission::with(['assignment', 'user'])
            ->where('status', 'graded')
            ->orderBy('graded_at', 'desc')
            ->take(20)
            ->get();

        return view('sensei.grading.index', compact('pending', 'graded'));
    }

    public function show(AssignmentSubmission $submission)
    {
        $submission->load(['assignment', 'user']);
        return view('sensei.grading.show', compact('submission'));
    }

    public function grade(Request $request, AssignmentSubmission $submission)
    {
        $validated = $request->validate([
            'score' => 'required|integer|min:0|max:' . $submission->assignment->max_score,
            'feedback' => 'required|string',
        ]);

        $submission->update([
            'score' => $validated['score'],
            'feedback' => $validated['feedback'],
            'graded_at' => now(),
            'status' => 'graded',
        ]);

        return redirect()->route('sensei.grading.index')
            ->with('success', 'Assignment berhasil dinilai!');
    }
}
