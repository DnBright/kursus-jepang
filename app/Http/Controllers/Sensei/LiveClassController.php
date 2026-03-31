<?php

namespace App\Http\Controllers\Sensei;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\LiveSession;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LiveClassController extends Controller
{
    public function index()
    {
        $sensei = Auth::guard('sensei')->user();
        
        $allSessions = LiveSession::where('instructor_id', $sensei->id)
            ->with(['course'])
            ->orderBy('scheduled_at', 'desc')
            ->get();

        $sessions = $allSessions->map(function($session) {
            $status = $session->calculated_status; // Using the helper from model
            
            return [
                'id' => $session->id,
                'title' => $session->title,
                'topic' => $session->description,
                'level' => $session->course->level ?? '-',
                'platform' => 'Zoom',
                'students_count' => $session->attendees()->count(),
                'status' => $status,
                'date' => $session->scheduled_at->translatedFormat('d M Y'),
                'time' => $session->scheduled_at->format('H:i') . ' - ' . $session->scheduled_at->addMinutes($session->duration)->format('H:i') . ' WIB',
                'time_start' => $session->scheduled_at->format('H:i'),
                'zoom_link' => $session->zoom_link,
            ];
        });

        $summary = [
            'total_this_month' => $allSessions->whereBetween('scheduled_at', [now()->startOfMonth(), now()->endOfMonth()])->count(),
            'today_count' => $allSessions->whereBetween('scheduled_at', [now()->startOfDay(), now()->endOfDay()])->count(),
            'ongoing_count' => $sessions->where('status', 'live')->count(),
        ];

        return view('sensei.live.index', compact('summary', 'sessions'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('sensei.live.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'scheduled_at' => 'required|date',
            'duration' => 'required|integer|min:1',
            'zoom_link' => 'required|url',
        ]);

        LiveSession::create([
            'title' => $request->title,
            'description' => $request->description,
            'course_id' => $request->course_id,
            'module_id' => $request->module_id,
            'instructor_id' => Auth::guard('sensei')->id(),
            'scheduled_at' => $request->scheduled_at,
            'duration' => $request->duration,
            'zoom_link' => $request->zoom_link,
            'meeting_id' => $request->meeting_id,
            'meeting_password' => $request->meeting_password,
            'max_participants' => $request->max_participants,
            'status' => 'scheduled',
        ]);

        return redirect()->route('sensei.live.index')->with('success', 'Live class berhasil dijadwalkan.');
    }

    public function edit($id)
    {
        $session = LiveSession::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($id);
        $courses = Course::all();
        return view('sensei.live.edit', compact('session', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $session = LiveSession::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'scheduled_at' => 'required|date',
            'zoom_link' => 'required|url',
        ]);

        $session->update($request->all());

        return redirect()->route('sensei.live.index')->with('success', 'Jadwal live class diperbarui.');
    }

    public function destroy($id)
    {
        $session = LiveSession::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($id);
        $session->delete();
        return back()->with('success', 'Live class berhasil dihapus.');
    }
}
