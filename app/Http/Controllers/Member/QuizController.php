<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\UserQuizAttempt;
use App\Models\UserPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    /**
     * Display a listing of available quizzes
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->get('type', 'all');
        
        // Get user's active package levels from approved transactions
        $activePackages = $user->transactions()
            ->where('status', 'approved')
            ->pluck('package_type')
            ->toArray();
        
        $quizzesQuery = Quiz::with(['lesson.module.course'])
            ->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('available_from')
                  ->orWhere('available_from', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('available_until')
                  ->orWhere('available_until', '>=', now());
            });

        if ($filter !== 'all') {
            $quizzesQuery->where('type', $filter);
        }

        $allQuizzes = $quizzesQuery->orderBy('created_at', 'desc')->get();

        // Filter quizzes by user's active packages
        $quizzes = $allQuizzes->filter(function($quiz) use ($activePackages) {
            // Admin and Sensei bypass filtering
            if (Auth::guard('admin')->check() || Auth::guard('sensei')->check()) {
                return true;
            }

            // Case 1: Quiz is linked to a lesson/course
            if ($quiz->lesson && $quiz->lesson->module && $quiz->lesson->module->course) {
                $course = $quiz->lesson->module->course;
                foreach ($activePackages as $ap) {
                    if (stripos($course->title, $ap) !== false || 
                        stripos($course->level, $ap) !== false || 
                        stripos($ap, $course->level) !== false) {
                        return true;
                    }
                }
            }
            
            // Case 2: Quiz is part of a roadmap the user has access to
            $isRoadmapQuiz = \App\Models\CourseRoadmapStep::where('content_type', 'quiz')
                ->where('content_id', $quiz->id)
                ->whereHas('course', function($q) use ($activePackages) {
                    $q->where(function($sq) use ($activePackages) {
                        foreach ($activePackages as $ap) {
                            $sq->orWhere('title', 'like', "%$ap%")
                              ->orWhere('level', 'like', "%$ap%");
                        }
                    });
                })->exists();
            
            if ($isRoadmapQuiz) {
                return true;
            }
            
            // Case 3: Orphaned quiz fallback
            foreach ($activePackages as $ap) {
                if (stripos($quiz->title, $ap) !== false) {
                    return true;
                }
            }

            return false;
        });

        // Get user's attempts for each quiz
        $userAttempts = UserQuizAttempt::where('user_id', Auth::id())
            ->select('quiz_id', DB::raw('MAX(percentage) as best_score'), DB::raw('MAX(is_passed) as is_passed'))
            ->groupBy('quiz_id')
            ->get()
            ->keyBy('quiz_id');

        return view('member.quizzes.index', compact('quizzes', 'userAttempts', 'filter'));
    }

    /**
     * Display the quiz taking interface
     */
    public function show(Quiz $quiz)
    {
        $user = Auth::user();

        // Authorization check: Ensure user has access to this quiz's package
        $hasAccess = false;
        if (Auth::guard('admin')->check() || Auth::guard('sensei')->check()) {
            $hasAccess = true;
        } else {
            $activePackages = $user->transactions()->where('status', 'approved')->pluck('package_type')->toArray();
            
            // 1. Check Course link
            if ($quiz->lesson && $quiz->lesson->module && $quiz->lesson->module->course) {
                $course = $quiz->lesson->module->course;
                foreach ($activePackages as $ap) {
                    if (stripos($course->title, $ap) !== false || stripos($course->level, $ap) !== false || stripos($ap, $course->level) !== false) {
                        $hasAccess = true;
                        break;
                    }
                }
            }
            
            // 2. Check Roadmap link
            if (!$hasAccess) {
                $hasAccess = \App\Models\CourseRoadmapStep::where('content_type', 'quiz')
                    ->where('content_id', $quiz->id)
                    ->whereHas('course', function($q) use ($activePackages) {
                        $q->where(function($sq) use ($activePackages) {
                            foreach ($activePackages as $ap) {
                                $sq->orWhere('title', 'like', "%$ap%")
                                  ->orWhere('level', 'like', "%$ap%");
                            }
                        });
                    })->exists();
            }

            // 3. Orphaned quiz fallback
            if (!$hasAccess) {
                foreach ($activePackages as $ap) {
                    if (stripos($quiz->title, $ap) !== false) {
                        $hasAccess = true;
                        break;
                    }
                }
            }
        }

        if (!$hasAccess) {
            return redirect()->route('quizzes.index')->with('error', 'Anda tidak memiliki akses ke kuis ini.');
        }

        // Check if quiz is available
        if (!$quiz->is_active) {
            return redirect()->route('quizzes.index')->with('error', 'Quiz ini tidak tersedia.');
        }

        if ($quiz->available_from && $quiz->available_from > now()) {
            return redirect()->route('quizzes.index')->with('error', 'Quiz ini belum tersedia.');
        }

        if ($quiz->available_until && $quiz->available_until < now()) {
            return redirect()->route('quizzes.index')->with('error', 'Quiz ini sudah tidak tersedia.');
        }

        $quiz->load('questions');
        $totalPoints = $quiz->questions->sum('points');

        return view('member.quizzes.show', compact('quiz', 'totalPoints'));
    }

    /**
     * Submit and grade quiz
     */
    public function submit(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
            'time_taken' => 'nullable|integer',
        ]);

        $quiz->load('questions');
        $userAnswers = $validated['answers'];
        $score = 0;
        $maxScore = 0;
        $hasManualGrading = false;

        foreach ($quiz->questions as $question) {
            $questionId = $question->id;
            $userAnswer = $userAnswers[$questionId] ?? null;
            $isCorrect = false;

            $maxScore += $question->points;

            if ($question->question_type === 'multiple_choice') {
                $isCorrect = $userAnswer === $question->correct_answer;
            } elseif ($question->question_type === 'true_false') {
                $isCorrect = $userAnswer === $question->correct_answer;
            } elseif ($question->question_type === 'fill_blank') {
                $isCorrect = strtolower(trim($userAnswer)) === strtolower(trim($question->correct_answer));
            } elseif ($question->question_type === 'essay' || $question->question_type === 'handwriting') {
                $hasManualGrading = true;
                $isCorrect = false; // Manual grading required
            }

            if ($isCorrect) {
                $score += $question->points;
            }
        }

        $percentage = $maxScore > 0 ? ($score / $maxScore) * 100 : 0;
        $isPassed = $percentage >= ($quiz->passing_score ?? 70);

        // Save attempt
        $attempt = UserQuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
            'max_score' => $maxScore,
            'percentage' => $percentage,
            'time_taken' => $validated['time_taken'] ?? null,
            'answers' => $userAnswers,
            'is_passed' => $isPassed,
            'status' => $hasManualGrading ? 'needs_grading' : 'completed',
            'completed_at' => now(),
        ]);

        // Award XP
        $xpAmount = $isPassed ? 50 : 25;
        UserPoint::create([
            'user_id' => Auth::id(),
            'points' => $xpAmount,
            'reason' => $isPassed ? 'quiz_passed' : 'quiz_attempted',
            'reference_id' => $quiz->id,
            'reference_type' => 'Quiz',
            'earned_at' => now(),
        ]);

        return redirect()->route('quizzes.results', $attempt->id)
            ->with('success', $hasManualGrading ? 'Quiz berhasil dikumpulkan. Jawaban Anda akan diperiksa oleh Sensei.' : ($isPassed ? 'Selamat! Anda lulus quiz ini! 🎉' : 'Quiz selesai. Coba lagi untuk hasil lebih baik!'));
    }

    /**
     * Show quiz results
     */
    public function results(UserQuizAttempt $attempt)
    {
        // Ensure user can only see their own results
        if ($attempt->user_id != Auth::id()) {
            abort(403);
        }

        $attempt->load('quiz.questions');
        
        return view('member.quizzes.results', compact('attempt'));
    }

    /**
     * Display leaderboard for a quiz
     */
    public function leaderboard(Quiz $quiz)
    {
        $topAttempts = UserQuizAttempt::where('quiz_id', $quiz->id)
            ->with('user')
            ->orderBy('percentage', 'desc')
            ->orderBy('time_taken', 'asc')
            ->take(20)
            ->get();

        // Get current user's best attempt
        $userBestAttempt = UserQuizAttempt::where('quiz_id', $quiz->id)
            ->where('user_id', Auth::id())
            ->orderBy('percentage', 'desc')
            ->first();

        return view('member.quizzes.leaderboard', compact('quiz', 'topAttempts', 'userBestAttempt'));
    }
}
