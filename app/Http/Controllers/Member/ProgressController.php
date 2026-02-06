<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\UserPoint;
use App\Models\UserAchievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    /**
     * Mark lesson as completed
     */
    public function completeLesson(Request $request, Lesson $lesson)
    {
        $progress = LessonProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'lesson_id' => $lesson->id,
            ],
            [
                'status' => 'completed',
                'completed_at' => now(),
                'time_spent' => $request->input('time_spent', 0),
            ]
        );

        // Award XP for lesson completion
        if ($progress->wasRecentlyCreated || $progress->wasChanged('status')) {
            UserPoint::create([
                'user_id' => Auth::id(),
                'points' => 20,
                'reason' => 'lesson_completed',
                'reference_id' => $lesson->id,
                'reference_type' => 'Lesson',
                'earned_at' => now(),
            ]);

            // Check for achievements
            $this->checkAchievements();
        }

        return response()->json([
            'success' => true,
            'message' => 'Lesson completed! +20 XP',
            'xp_earned' => 20,
        ]);
    }

    /**
     * Update lesson notes
     */
    public function updateNotes(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'notes' => 'required|string',
        ]);

        LessonProgress::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'lesson_id' => $lesson->id,
            ],
            [
                'notes' => $validated['notes'],
            ]
        );

        return response()->json([
            'success' => true,
            'message' => 'Catatan berhasil disimpan!',
        ]);
    }

    /**
     * Get user statistics
     */
    public function stats()
{
        $userId = Auth::id();

        $stats = [
            'total_lessons' => LessonProgress::where('user_id', $userId)->count(),
            'completed_lessons' => LessonProgress::where('user_id', $userId)->where('status', 'completed')->count(),
            'total_xp' => UserPoint::where('user_id', $userId)->sum('points'),
            'total_achievements' => UserAchievement::where('user_id', $userId)->count(),
            'study_streak' => $this->calculateStreak(),
        ];

        return response()->json($stats);
    }

    /**
     * Check and award achievements
     */
    private function checkAchievements()
    {
        $userId = Auth::id();
        $completedLessons = LessonProgress::where('user_id', $userId)->where('status', 'completed')->count();

        // Achievement: First Lesson
        if ($completedLessons === 1) {
            $this->awardAchievement('First Step', 'Menyelesaikan lesson pertama', 'badge', '🎯');
        }

        // Achievement: 10 Lessons
        if ($completedLessons === 10) {
            $this->awardAchievement('Committed Learner', 'Menyelesaikan 10 lesson', 'milestone', '🔥');
        }

        // Achievement: 50 Lessons
        if ($completedLessons === 50) {
            $this->awardAchievement('Halfway Hero', 'Menyelesaikan 50 lesson', 'milestone', '🏆');
        }
    }

    private function awardAchievement($title, $description, $type, $icon)
    {
        $exists = UserAchievement::where('user_id', Auth::id())
            ->where('title', $title)
            ->exists();

        if (!$exists) {
            UserAchievement::create([
                'user_id' => Auth::id(),
                'achievement_type' => $type,
                'title' => $title,
                'description' => $description,
                'icon' => $icon,
                'earned_at' => now(),
            ]);
        }
    }

    private function calculateStreak()
    {
        // Simplified streak calculation
        // In production, you'd track daily login/activity
        return 1;
    }
}
