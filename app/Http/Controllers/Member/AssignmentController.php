<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\UserPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    public function index()
    {
        $upcoming = Assignment::where('due_date', '>=', now())
            ->orderBy('due_date', 'asc')
            ->get();

        $past = Assignment::where('due_date', '<', now())
            ->orderBy('due_date', 'desc')
            ->get();

        // Get user submissions
        $submissions = AssignmentSubmission::where('user_id', Auth::id())
            ->pluck('assignment_id')
            ->toArray();

        return view('member.assignments.index', compact('upcoming', 'past', 'submissions'));
    }

    public function show(Assignment $assignment)
    {
        $assignment->load('lesson', 'module');
        
        $submission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('user_id', Auth::id())
            ->first();

        return view('member.assignments.show', compact('assignment', 'submission'));
    }

    public function submit(Request $request, Assignment $assignment)
    {
        $validated = $request->validate([
            'content' => 'nullable|string',
            'file' => 'nullable|file|max:51200', // 50MB max
        ]);

        // Check if already submitted
        $existingSubmission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingSubmission && $existingSubmission->status !== 'returned') {
            return redirect()->back()->with('error', 'Anda sudah mengumpulkan assignment ini.');
        }

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('assignments/' . Auth::id(), 'public');
        }

        AssignmentSubmission::updateOrCreate(
            [
                'assignment_id' => $assignment->id,
                'user_id' => Auth::id(),
            ],
            [
                'content' => $validated['content'],
                'file_path' => $filePath,
                'submitted_at' => now(),
                'status' => 'pending',
            ]
        );

        // Award XP for submission
        UserPoint::create([
            'user_id' => Auth::id(),
            'points' => 100,
            'reason' => 'assignment_submission',
            'reference_id' => $assignment->id,
            'reference_type' => 'Assignment',
            'earned_at' => now(),
        ]);

        return redirect()->route('assignments.show', $assignment->id)
            ->with('success', 'Assignment berhasil dikumpulkan! +100 XP');
    }
}
