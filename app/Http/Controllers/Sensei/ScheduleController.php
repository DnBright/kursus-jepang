<?php

namespace App\Http\Controllers\Sensei;

use App\Http\Controllers\Controller;
use App\Models\LiveSession;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(Request $request)
    {
        $sensei = Auth::guard('sensei')->user();
        
        // Get the requested date or default to today
        $date = $request->has('date') ? Carbon::parse($request->date) : Carbon::today();
        
        // Calculate start and end of the week (Monday to Sunday)
        $startOfWeek = $date->copy()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = $date->copy()->endOfWeek(Carbon::SUNDAY);
        
        $monthYear = $date->format('F Y');
        
        // Fetch sessions for the week
        $sessions = LiveSession::where('instructor_id', $sensei->id)
            ->whereBetween('scheduled_at', [$startOfWeek, $endOfWeek->endOfDay()])
            ->with(['course', 'module'])
            ->orderBy('scheduled_at')
            ->get();

        // Group sessions by day of week for the grid
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        $weekly_schedule = [];
        foreach ($days as $day) {
            $weekly_schedule[$day] = [];
        }

        foreach ($sessions as $session) {
            $dayName = $this->getIndonesianDayName($session->scheduled_at);
            if (isset($weekly_schedule[$dayName])) {
                $weekly_schedule[$dayName][] = [
                    'id' => $session->id,
                    'title' => $session->title,
                    'time' => $session->scheduled_at->format('H:i') . ' - ' . $session->scheduled_at->copy()->addMinutes($session->duration)->format('H:i'),
                    'type' => 'live_class',
                    'level' => $session->course->level ?? 'N/A',
                    'status' => $session->status,
                ];
            }
        }

        // Today's Agenda
        $today_agenda = $sessions->filter(function($session) {
            return $session->scheduled_at->isToday();
        })->map(function($session) {
            return [
                'id' => $session->id,
                'title' => $session->title,
                'class' => $session->course->title,
                'time_start' => $session->scheduled_at->format('H:i'),
                'time_end' => $session->scheduled_at->copy()->addMinutes($session->duration)->format('H:i'),
                'type' => 'live_class',
                'status' => $session->status === 'scheduled' ? 'upcoming' : ($session->status === 'ongoing' ? 'ongoing' : 'completed'),
                'platform' => 'Zoom',
            ];
        })->values()->all();

        return view('sensei.schedule.index', compact(
            'today_agenda', 
            'weekly_schedule', 
            'monthYear', 
            'startOfWeek', 
            'endOfWeek',
            'date'
        ));
    }

    public function create()
    {
        $courses = Course::all();
        return view('sensei.schedule.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'module_id' => 'nullable|exists:modules,id',
            'scheduled_at' => 'required|date',
            'duration' => 'required|integer|min:15',
            'zoom_link' => 'nullable|url',
            'description' => 'nullable|string',
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
            'status' => 'scheduled',
        ]);

        return redirect()->route('sensei.schedule.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $session = LiveSession::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($id);
        $courses = Course::all();
        $modules = Module::where('course_id', $session->course_id)->get();
        return view('sensei.schedule.edit', compact('session', 'courses', 'modules'));
    }

    public function update(Request $request, $id)
    {
        $session = LiveSession::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'module_id' => 'nullable|exists:modules,id',
            'scheduled_at' => 'required|date',
            'duration' => 'required|integer|min:15',
            'zoom_link' => 'nullable|url',
            'status' => 'required|in:scheduled,ongoing,completed,cancelled',
        ]);

        $session->update($request->all());

        return redirect()->route('sensei.schedule.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $session = LiveSession::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($id);
        $session->delete();

        return redirect()->route('sensei.schedule.index')->with('success', 'Jadwal berhasil dihapus.');
    }

    private function getIndonesianDayName($date)
    {
        $days = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        return $days[$date->format('l')];
    }
}
