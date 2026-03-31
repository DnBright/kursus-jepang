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
            
        $courseIds = Course::whereIn('level', $levels)->pluck('id');

        // Get sessions for these courses
        $sessions = LiveSession::whereIn('course_id', $courseIds)
            ->with(['instructor', 'course'])
            ->get()
            ->sortBy('start_at');

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
