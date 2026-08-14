<?php

namespace App\Http\Controllers\Member;

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\LiveSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiveClassController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get courses the user has purchased
        $levels = $user->transactions()
            ->where('status', 'approved')
            ->pluck('package_type');
            
        // Parse levels from package types (e.g. "Paket N5 Reguler" -> "N5")
        $courseIds = collect();
        foreach ($levels as $pkg) {
            $up = strtoupper($pkg);
            $lvl = null;
            if (str_contains($up, 'N5')) $lvl = 'N5';
            elseif (str_contains($up, 'N4')) $lvl = 'N4';
            elseif (str_contains($up, 'TOKUTEI')) $lvl = 'Tokutei';
            
            if ($lvl) {
                // Find courses matching this level
                $cIds = Course::where('level', 'like', "%$lvl%")
                    ->orWhere('title', 'like', "%$lvl%")
                    ->pluck('id');
                $courseIds = $courseIds->concat($cIds);
            }
        }
        
        $courseIds = $courseIds->unique();

        // Get sessions for these courses
        $sessions = LiveSession::whereIn('course_id', $courseIds)
            ->with(['instructor', 'course'])
            ->get()
            ->sortBy('scheduled_at');

        // Categorize by status (using the model's calculated_status attribute)
        $liveNow = $sessions->filter(fn($s) => $s->calculated_status === 'live')->first();
        
        $upcoming = $sessions->filter(fn($s) => $s->calculated_status === 'upcoming')
            ->values();
            
        $completed = $sessions->filter(fn($s) => $s->calculated_status === 'completed')
            ->sortByDesc('start_at')
            ->values();

        return view('member.live.index', compact('liveNow', 'upcoming', 'completed'));
    }
}
