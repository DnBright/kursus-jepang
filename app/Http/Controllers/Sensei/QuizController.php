<?php

namespace App\Http\Controllers\Sensei;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Course;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
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
                ->count(),
            'avg_score' => 0, // In a real app, calculate this from attempts/submissions
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
            'type' => $request->type,
            'difficulty' => $request->difficulty,
            'time_limit' => $request->time_limit,
            'passing_score' => $request->passing_score,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('sensei.quizzes.edit', $quiz->id)->with('success', 'Quiz berhasil dibuat. Sekarang tambahkan pertanyaan.');
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

        $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false,fill_blank,matching,essay',
            'options' => 'nullable|array',
            'correct_answer' => 'nullable|string',
            'points' => 'required|integer|min:1',
        ]);

        $quiz->questions()->create($request->validated());

        return back()->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function destroyQuestion($quizId, $questionId)
    {
        $quiz = Quiz::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($quizId);
        $quiz->questions()->findOrFail($questionId)->delete();

        return back()->with('success', 'Pertanyaan berhasil dihapus.');
    }
}
