<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\LessonProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // 1. Get all courses the user has purchased
        $levels = $user->transactions()
            ->where('status', 'approved')
            ->pluck('package_type');
            
        $myCourses = Course::with('modules.lessons')
            ->whereIn('level', $levels)
            ->get();

        $certificates = [];

        foreach ($myCourses as $course) {
            $lessonIds = $course->modules->pluck('lessons')->flatten()->pluck('id');
            $totalLessons = $lessonIds->count();
            
            if ($totalLessons === 0) continue;

            $completedCount = LessonProgress::where('user_id', $user->id)
                ->whereIn('lesson_id', $lessonIds)
                ->where('status', 'completed')
                ->count();

            if ($completedCount === $totalLessons) {
                // Determine completion date (last lesson completed)
                $lastCompleted = LessonProgress::where('user_id', $user->id)
                    ->whereIn('lesson_id', $lessonIds)
                    ->where('status', 'completed')
                    ->orderBy('updated_at', 'desc')
                    ->first();

                $certificates[] = (object)[
                    'id' => $course->id,
                    'title' => $course->title,
                    'level' => $course->level,
                    'issue_date' => $lastCompleted ? $lastCompleted->updated_at : now(),
                    'cert_number' => "CERT/" . now()->year . "/" . str_pad($course->id, 3, '0', STR_PAD_LEFT) . str_pad($user->id, 3, '0', STR_PAD_LEFT),
                    'predikat' => 'Sangat Memuaskan' // Hardcoded logic or calculated from quiz averages if available
                ];
            }
        }

        // Sort certificates by date decending
        usort($certificates, fn($a, $b) => $b->issue_date <=> $a->issue_date);

        $latestCertificate = !empty($certificates) ? $certificates[0] : null;
        $historyCertificates = count($certificates) > 1 ? array_slice($certificates, 1) : [];

        return view('member.certificates.index', compact('latestCertificate', 'historyCertificates'));
    }
}
