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

        // Fetch Roadmaps by Level - Prioritizing those with steps
        $fetchRoadmap = function($levelPattern) {
            return Course::where(function($q) use ($levelPattern) {
                    $q->where('level', $levelPattern)
                      ->orWhere('title', 'like', "%$levelPattern%");
                })
                ->whereHas('roadmapSteps') // Only get courses that actually have a roadmap
                ->with(['roadmapSteps'])
                ->orderBy('id', 'desc') // Get the latest one if multiple
                ->first() 
                ?? // Fallback to any course if no roadmap found
                Course::where('level', $levelPattern)
                    ->orWhere('title', 'like', "%$levelPattern%")
                    ->first();
        };

        $roadmaps = [
            'N5' => $fetchRoadmap('N5'),
            'N4' => $fetchRoadmap('N4'),
            'Tokutei Ginou' => $fetchRoadmap('Tokutei'),
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

        // Calculate Step Progression
        $stepsWithStatus = [];
        $previousCompleted = true; // First step is always unlocked

        foreach ($roadmapSteps as $step) {
            $isCompleted = false;
            $contentId = $step->content_id;
            $contentType = $step->content_type;

            if ($contentType === 'lesson') {
                $isCompleted = \App\Models\LessonProgress::where('user_id', $userId)
                    ->where('lesson_id', $contentId)
                    ->where('status', 'completed')
                    ->exists();
            } elseif ($contentType === 'quiz') {
                $isCompleted = \App\Models\UserQuizAttempt::where('user_id', $userId)
                    ->where('quiz_id', $contentId)
                    ->where('is_passed', true)
                    ->exists();
            } elseif ($contentType === 'module') {
                // Check if all lessons in module are completed
                $moduleLessons = \App\Models\Lesson::where('module_id', $contentId)->pluck('id');
                if ($moduleLessons->count() > 0) {
                    $completedCount = \App\Models\LessonProgress::where('user_id', $userId)
                        ->whereIn('lesson_id', $moduleLessons)
                        ->where('status', 'completed')
                        ->count();
                    $isCompleted = ($completedCount >= $moduleLessons->count());
                } else {
                    $isCompleted = true; // Empty module is completed?
                }
            }

            $stepsWithStatus[] = (object)[
                'step' => $step,
                'is_completed' => $isCompleted,
                'is_locked' => !$previousCompleted
            ];

            $previousCompleted = $isCompleted;
        }

        return view('dashboard', compact(
            'totalXP',
            'completedLessons',
            'roadmaps',
            'access',
            'currentLevel',
            'stepsWithStatus'
        ));
    }
}
