<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\UserPoint;
use App\Models\LessonProgress;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) return redirect()->route('login');
        
        $userId = $user->id;

        // Calculate stats
        $totalXP = UserPoint::where('user_id', $userId)->sum('points');
        $completedLessons = LessonProgress::where('user_id', $userId)->where('status', 'completed')->count();
        
        // Get user's active packages (from approved transactions)
        $activePackages = $user->transactions()
            ->where('status', 'approved')
            ->pluck('package_type')
            ->toArray();

        // Fetch Roadmaps by Level
        $roadmaps = [
            'N5' => Course::where('level', 'N5')->orWhere('title', 'like', '%N5%')->with(['roadmapSteps'])->first(),
            'N4' => Course::where('level', 'N4')->orWhere('title', 'like', '%N4%')->with(['roadmapSteps'])->first(),
            'Tokutei Ginou' => Course::where('level', 'Tokutei Ginou')->orWhere('title', 'like', '%Tokutei%')->with(['roadmapSteps'])->first(),
        ];

        // Access Check
        $access = [
            'N5' => false,
            'N4' => false,
            'Tokutei Ginou' => false,
        ];

        foreach ($activePackages as $package) {
            $up = strtoupper($package);
            if (str_contains($up, 'N5')) $access['N5'] = true;
            if (str_contains($up, 'N4')) $access['N4'] = true;
            if (str_contains($up, 'TOKUTEI')) $access['Tokutei Ginou'] = true;
        }

        // Determine Active Tab
        $currentLevel = $request->get('level', null);
        
        if (!$currentLevel) {
            // Default logic: priority to higher levels or accessible levels
            if ($access['N4']) $currentLevel = 'N4';
            elseif ($access['Tokutei Ginou']) $currentLevel = 'Tokutei Ginou';
            else $currentLevel = 'N5';
        }

        // Get progress for current roadmap
        $currentRoadmap = $roadmaps[$currentLevel] ?? null;
        $roadmapSteps = $currentRoadmap ? $currentRoadmap->roadmapSteps : collect();

        return view('dashboard', compact(
            'totalXP',
            'completedLessons',
            'roadmaps',
            'access',
            'currentLevel',
            'roadmapSteps'
        ));
    }
}
