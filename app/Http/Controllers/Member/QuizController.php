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
        $filter = $request->get('type', 'all');
        
        $quizzesQuery = Quiz::with('lesson')
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

        $quizzes = $quizzesQuery->orderBy('created_at', 'desc')->get();

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

        $results = [];

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
                // Case-insensitive comparison, trim whitespace
                $isCorrect = strtolower(trim($userAnswer)) === strtolower(trim($question->correct_answer));
            }

            if ($isCorrect) {
                $score += $question->points;
            }

            $results[$questionId] = [
                'user_answer' => $userAnswer,
                'correct_answer' => $question->correct_answer,
                'is_correct' => $isCorrect,
                'explanation' => $question->explanation,
            ];
        }

        $percentage = $maxScore > 0 ? ($score / $maxScore) * 100 : 0;
        $isPassed = $percentage >= $quiz->passing_score;

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
            ->with('success', $isPassed ? 'Selamat! Anda lulus quiz ini! 🎉' : 'Quiz selesai. Coba lagi untuk hasil lebih baik!');
    }

    /**
     * Show quiz results
     */
    public function results(UserQuizAttempt $attempt)
    {
        // Ensure user can only see their own results
        if ($attempt->user_id !== Auth::id()) {
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
