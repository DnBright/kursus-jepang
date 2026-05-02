<?php

namespace App\Http\Controllers\Sensei;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\UserQuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        $sensei = Auth::guard('sensei')->user();
        
        // Summary stats
        $summary = [
            'active_quizzes' => $sensei->quizzes()->where('is_active', true)->count(),
            'essay_assignments' => $sensei->assignments()->count(),
            'needs_grading' => AssignmentSubmission::whereIn('assignment_id', $sensei->assignments()->pluck('id'))
                ->where('status', 'pending')
                ->count() + UserQuizAttempt::whereIn('quiz_id', $sensei->quizzes()->pluck('id'))
                ->where('status', 'needs_grading')
                ->count(),
            'avg_score' => 0, 
        ];

        // Quizzes
        $quizzes = $sensei->quizzes()->withCount('questions')->get()->map(function($quiz) {
            return [
                'id' => $quiz->id,
                'title' => $quiz->title,
                'level' => $quiz->difficulty === 'beginner' ? 'N5' : ($quiz->difficulty === 'intermediate' ? 'N4' : 'N3'),
                'question_count' => $quiz->questions_count,
                'type' => ucfirst($quiz->type),
                'deadline' => $quiz->available_until ? $quiz->available_until->format('d M Y') : '-',
                'status' => $quiz->is_active ? 'active' : 'draft',
            ];
        });

        // Assignments
        $assignments = $sensei->assignments()->withCount(['submissions as pending_count' => function($query) {
            $query->where('status', 'pending');
        }])->get()->map(function($assignment) {
            return [
                'id' => $assignment->id,
                'title' => $assignment->title,
                'class' => $assignment->module->course->title ?? 'General',
                'submitted_count' => $assignment->submissions()->count(),
                'deadline' => $assignment->due_date ? $assignment->due_date->format('d M Y') : '-',
                'status' => $assignment->pending_count > 0 ? 'needs_grading' : 'completed',
            ];
        });

        return view('sensei.quizzes.index', compact('summary', 'quizzes', 'assignments'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('sensei.quizzes.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'lesson_id' => 'required|exists:lessons,id',
            'type' => 'required|in:daily,weekly,module_test,mock_jlpt',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'time_limit' => 'nullable|integer',
            'passing_score' => 'required|integer|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        $quiz = Quiz::create([
            'title' => $request->title,
            'description' => $request->description,
            'instructor_id' => Auth::guard('sensei')->id(),
            'lesson_id' => $request->lesson_id,
            'type' => $request->type,
            'difficulty' => $request->difficulty,
            'time_limit' => $request->time_limit,
            'passing_score' => $request->passing_score,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('sensei.quizzes.questions', $quiz->id)->with('success', 'Quiz berhasil dibuat. Sekarang tambahkan soal PG atau Essai.');
    }

    public function edit($id)
    {
        $quiz = Quiz::where('instructor_id', Auth::guard('sensei')->id())->with('questions')->findOrFail($id);
        $courses = Course::all();
        return view('sensei.quizzes.edit', compact('quiz', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $quiz = Quiz::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:daily,weekly,module_test,mock_jlpt',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
            'time_limit' => 'nullable|integer',
            'passing_score' => 'required|integer|min:0|max:100',
        ]);

        $quiz->update([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'difficulty' => $request->difficulty,
            'time_limit' => $request->time_limit,
            'passing_score' => $request->passing_score,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('sensei.quizzes.index')->with('success', 'Quiz berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $quiz = Quiz::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($id);
        $quiz->delete();
        return redirect()->route('sensei.quizzes.index')->with('success', 'Quiz berhasil dihapus.');
    }

    // Question Management
    public function questions($id)
    {
        $quiz = Quiz::where('instructor_id', Auth::guard('sensei')->id())->with('questions')->findOrFail($id);
        return view('sensei.quizzes.questions', compact('quiz'));
    }

    public function storeQuestion(Request $request, $quizId)
    {
        $quiz = Quiz::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($quizId);

        $data = $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false,fill_blank,matching,essay,handwriting',
            'options' => 'nullable|array',
            'correct_answer' => 'nullable|string',
            'points' => 'required|integer|min:1',
            'order' => 'nullable|integer',
        ]);
        
        if (in_array($data['question_type'], ['essay', 'handwriting'])) {
            $data['options'] = null;
        }

        if (!isset($data['order']) || $data['order'] == 0) {
            $data['order'] = ($quiz->questions()->max('order') ?? 0) + 1;
        }

        $quiz->questions()->create($data);

        return back()->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function destroyQuestion($quizId, $questionId)
    {
        $quiz = Quiz::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($quizId);
        $quiz->questions()->findOrFail($questionId)->delete();

        return back()->with('success', 'Pertanyaan berhasil dihapus.');
    }

    public function updateQuestion(Request $request, $quizId, $questionId)
    {
        $quiz = Quiz::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($quizId);
        $question = $quiz->questions()->findOrFail($questionId);

        $data = $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false,fill_blank,matching,essay,handwriting',
            'options' => 'nullable|array',
            'correct_answer' => 'nullable|string',
            'points' => 'required|integer|min:1',
            'order' => 'nullable|integer',
        ]);

        if (in_array($data['question_type'], ['essay', 'handwriting'])) {
            $data['options'] = null;
        }

        if (!isset($data['order']) || $data['order'] == 0) {
            $data['order'] = ($quiz->questions()->max('order') ?? 0) + 1;
        }

        $question->update($data);

        return back()->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function gradingAttempts()
    {
        $sensei = Auth::guard('sensei')->user();
        $quizIds = $sensei->quizzes()->pluck('id');

        $attempts = UserQuizAttempt::whereIn('quiz_id', $quizIds)
            ->where('status', 'needs_grading')
            ->with(['user', 'quiz'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('sensei.quizzes.grading-list', compact('attempts'));
    }

    public function gradeAttempt($id)
    {
        $attempt = UserQuizAttempt::with(['user', 'quiz.questions'])
            ->whereHas('quiz', function($q) {
                $q->where('instructor_id', Auth::guard('sensei')->id());
            })
            ->findOrFail($id);

        return view('sensei.quizzes.grade-attempt', compact('attempt'));
    }

    public function submitAttemptGrade(Request $request, $id)
    {
        $attempt = UserQuizAttempt::whereHas('quiz', function($q) {
            $q->where('instructor_id', Auth::guard('sensei')->id());
        })->findOrFail($id);

        $request->validate([
            'score' => 'required|integer|min:0|max:' . $attempt->max_score,
        ]);

        $attempt->update([
            'score' => $request->score,
            'percentage' => ($request->score / $attempt->max_score) * 100,
            'is_passed' => (($request->score / $attempt->max_score) * 100) >= ($attempt->quiz->passing_score ?? 70),
            'status' => 'completed',
        ]);

        return redirect()->route('sensei.quizzes.grading.index')->with('success', 'Nilai quiz berhasil disimpan.');
    public function getLessons($moduleId)
    {
        $lessons = \App\Models\Lesson::where('module_id', $moduleId)->orderBy('order', 'asc')->get(['id', 'title']);
        return response()->json($lessons);
    }
}
