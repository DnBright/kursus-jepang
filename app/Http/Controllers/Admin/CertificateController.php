<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        // 1. Detect graduates (100% progress but no certificate yet)
        $members = \App\Models\User::where('role', 'member')->with('transactions')->get();
        $pendingApprovals = collect();

        foreach ($members as $user) {
            $approvedTransactions = $user->transactions->where('status', 'approved');
            foreach ($approvedTransactions as $trx) {
                $course = \App\Models\Course::where('title', $trx->package_type)->first();
                if (!$course) continue;

                // Check if already has certificate
                $hasCert = \App\Models\UserAchievement::where('user_id', $user->id)
                    ->where('achievement_type', 'certificate')
                    ->where('title', 'LIKE', '%' . $course->title . '%')
                    ->exists();

                if ($hasCert) continue;

                // Calculate progress
                $modules = $course->modules()->with('lessons')->get();
                $lessonIds = $modules->pluck('lessons')->flatten()->pluck('id');
                if ($lessonIds->isEmpty()) continue;

                $completedCount = \App\Models\LessonProgress::where('user_id', $user->id)
                    ->whereIn('lesson_id', $lessonIds)
                    ->where('status', 'completed')
                    ->count();

                $progress = ($completedCount / $lessonIds->count()) * 100;

                if ($progress >= 100) {
                    $pendingApprovals->push((object)[
                        'user_id' => $user->id,
                        'course_id' => $course->id,
                        'student_name' => $user->name,
                        'program' => $course->level,
                        'class_name' => $course->title,
                        'progress' => 100,
                        'final_score' => 100, // Placeholder for actual grading
                        'status' => 'pending',
                        'request_date' => now()
                    ]);
                }
            }
        }

        // 2. Issued Certificates
        $issuedCertificates = \App\Models\UserAchievement::where('achievement_type', 'certificate')
            ->with('user')
            ->get()
            ->map(function($ach) {
                return (object)[
                    'certificate_no' => 'CERT-' . strtoupper(substr(md5($ach->id), 0, 8)),
                    'student_name' => $ach->user ? $ach->user->name : 'Unknown',
                    'program' => $ach->title,
                    'issue_date' => $ach->earned_at,
                    'status' => 'valid'
                ];
            });

        // 3. Templates (Stay mock for now as requested for "100% functional" of core flow)
        $templates = collect([
            (object)['id' => 1, 'name' => 'Standard Certificate N5', 'level' => 'N5', 'thumbnail' => '', 'is_active' => true],
            (object)['id' => 2, 'name' => 'Premium Certificate N4', 'level' => 'N4', 'thumbnail' => '', 'is_active' => true]
        ]);

        $stats = [
            'total_issued' => $issuedCertificates->count(),
            'pending_count' => $pendingApprovals->count(),
            'this_month' => $issuedCertificates->where('issue_date', '>=', now()->startOfMonth())->count(),
            'rejected_count' => 0
        ];

        return view('admin.certificates.index', compact('pendingApprovals', 'issuedCertificates', 'templates', 'stats'));
    }

    public function approve(Request $request)
    {
        $userId = $request->user_id;
        $courseId = $request->course_id;

        $user = \App\Models\User::findOrFail($userId);
        $course = \App\Models\Course::findOrFail($courseId);

        \App\Models\UserAchievement::create([
            'user_id' => $user->id,
            'achievement_type' => 'certificate',
            'title' => 'Certificate of Completion: ' . $course->title,
            'description' => 'Successfully completed ' . $course->title . ' (' . $course->level . ')',
            'earned_at' => now(),
            'icon' => 'academic-cap'
        ]);

        return back()->with('success', 'Sertifikat untuk ' . $user->name . ' berhasil diterbitkan.');
    }
}
