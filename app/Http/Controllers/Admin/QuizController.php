<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    // Question Management
    public function questions($id)
    {
        $quiz = Quiz::with('questions')->findOrFail($id);
        return view('admin.quizzes.questions', compact('quiz'));
    }

    public function storeQuestion(Request $request, $quizId)
    {
        $quiz = Quiz::findOrFail($quizId);

        $data = $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false,fill_blank,matching,essay,handwriting',
            'options' => 'nullable|array',
            'correct_answer' => 'required|string',
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

    public function batchUpdateQuestions(Request $request, $quizId)
    {
        $quiz = Quiz::findOrFail($quizId);
        
        $request->validate([
            'questions' => 'required|array',
            'questions.*.question_text' => 'required|string',
            'questions.*.points' => 'required|integer|min:1',
            'questions.*.order' => 'nullable|integer',
            'questions.*.options' => 'nullable|array',
            'questions.*.correct_answer' => 'required|string',
        ]);

        $existingIds = $quiz->questions()->pluck('id')->toArray();
        $submittedIds = collect($request->questions)->pluck('id')->filter()->toArray();

        // 1. Delete removed questions
        $idsToDelete = array_diff($existingIds, $submittedIds);
        if (!empty($idsToDelete)) {
            $quiz->questions()->whereIn('id', $idsToDelete)->delete();
        }

        // 2. Update or Create questions
        foreach ($request->questions as $qData) {
            $qData['question_type'] = $quiz->question_type ?? 'multiple_choice';
            
            if (in_array($qData['question_type'], ['essay', 'handwriting'])) {
                $qData['correct_answer'] = 'MANUAL_GRADING';
                $qData['options'] = null;
            }

            if (isset($qData['id']) && in_array($qData['id'], $existingIds)) {
                // Update
                $question = $quiz->questions()->find($qData['id']);
                $question->update($qData);
            } else {
                // Create
                unset($qData['id']);
                $quiz->questions()->create($qData);
            }
        }

        return response()->json(['success' => true, 'message' => 'Semua perubahan berhasil disimpan.']);
    }

    public function destroyQuestion($quizId, $questionId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $quiz->questions()->findOrFail($questionId)->delete();

        return back()->with('success', 'Pertanyaan berhasil dihapus.');
    }

    public function updateQuestion(Request $request, $quizId, $questionId)
    {
        $quiz = Quiz::findOrFail($quizId);
        $question = $quiz->questions()->findOrFail($questionId);

        $data = $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false,fill_blank,matching,essay,handwriting',
            'options' => 'nullable|array',
            'correct_answer' => 'required|string',
            'points' => 'required|integer|min:1',
            'order' => 'nullable|integer',
        ]);

        if (in_array($data['question_type'], ['essay', 'handwriting'])) {
            $data['options'] = null;
        }

        $question->update($data);

        return back()->with('success', 'Pertanyaan berhasil diperbarui.');
    }
}
