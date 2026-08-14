<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseRoadmapStep;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\Lesson;
use App\Models\LiveSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class RoadmapController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        
        return view('admin.roadmap.index', compact('courses'));
    }

    public function manage($id)
    {
        $course = Course::findOrFail($id);
        $roadmapSteps = $course->roadmapSteps()->orderBy('order', 'asc')->get();
        
        return view('admin.roadmap.manage', compact('course', 'roadmapSteps'));
    }

    public function storeStep(Request $request, $courseId)
    {
        $course = Course::findOrFail($courseId);
        
        $request->validate([
            'block_type' => 'required|in:quiz,materi,zoom',
            'title' => 'required|string',
            'order' => 'required|integer',
        ]);

        // Create a default module for this course if none exists
        $module = Module::firstOrCreate(
            ['course_id' => $course->id],
            ['title' => 'Default Module', 'order' => 1]
        );

        $content_id = null;
        $content_type = null;

        // Use the course instructor if creating a new item
        $instructorId = $course->instructor_id ?? Auth::guard('admin')->id(); // fallback to admin id if null

        if ($request->block_type === 'quiz') {
            $quiz = Quiz::create([
                'title' => $request->title,
                'course_id' => $course->id,
                'module_id' => $module->id,
                'instructor_id' => $instructorId,
                'question_type' => $request->quiz_type ?? 'multiple_choice',
                'duration' => 60,
                'passing_score' => 70,
            ]);
            $content_id = $quiz->id;
            $content_type = 'quiz';
        } elseif ($request->block_type === 'materi') {
            $contentData = '';
            if ($request->materi_type === 'pdf' && $request->hasFile('materi_file')) {
                $contentData = $request->file('materi_file')->store('materials', 'public');
            } elseif ($request->materi_type === 'video') {
                $contentData = $request->video_link;
            }

            $lesson = Lesson::create([
                'module_id' => $module->id,
                'title' => $request->title,
                'instructor_id' => $instructorId,
                'type' => $request->materi_type ?? 'text',
                'content' => $contentData,
                'order' => $request->order,
                'is_free' => false,
            ]);
            $content_id = $lesson->id;
            $content_type = 'lesson';
        } elseif ($request->block_type === 'zoom') {
            $live = LiveSession::create([
                'title' => $request->title,
                'course_id' => $course->id,
                'module_id' => $module->id,
                'instructor_id' => $instructorId,
                'scheduled_at' => $request->zoom_date . ' ' . $request->zoom_time,
                'zoom_link' => $request->zoom_link,
                'duration' => 90,
                'status' => 'scheduled'
            ]);
            $content_id = $live->id;
            $content_type = 'live_session';
        }

        $course->roadmapSteps()->create([
            'title' => $request->title,
            'content_type' => $content_type,
            'content_id' => $content_id,
            'order' => $request->order,
        ]);

        return back()->with('success', 'Langkah roadmap berhasil ditambahkan.');
    }

    public function updateStep(Request $request, $stepId)
    {
        $step = CourseRoadmapStep::findOrFail($stepId);

        $request->validate([
            'title' => 'required|string',
        ]);

        $step->update(['title' => $request->title]);

        // Update underlying content
        $content = $step->content;
        if ($content) {
            if ($step->content_type === 'quiz') {
                $content->update([
                    'title' => $request->title,
                    'question_type' => $request->quiz_type ?? $content->question_type,
                ]);
            } elseif ($step->content_type === 'lesson') {
                $contentData = $content->content;
                if ($request->materi_type === 'pdf' && $request->hasFile('materi_file')) {
                    if ($content->type === 'pdf' && $contentData) {
                        Storage::disk('public')->delete($contentData);
                    }
                    $contentData = $request->file('materi_file')->store('materials', 'public');
                } elseif ($request->materi_type === 'video') {
                    $contentData = $request->video_link;
                }
                
                $content->update([
                    'title' => $request->title,
                    'type' => $request->materi_type ?? $content->type,
                    'content' => $contentData,
                ]);
            } elseif ($step->content_type === 'live_session') {
                $content->update([
                    'title' => $request->title,
                    'scheduled_at' => $request->zoom_date . ' ' . $request->zoom_time,
                    'zoom_link' => $request->zoom_link,
                ]);
            }
        }

        return back()->with('success', 'Langkah roadmap berhasil diperbarui.');
    }

    public function destroyStep($stepId)
    {
        $step = CourseRoadmapStep::findOrFail($stepId);

        // Optional: delete underlying content
        $content = $step->content;
        if ($content) {
            if ($step->content_type === 'lesson' && $content->type === 'pdf' && $content->content) {
                Storage::disk('public')->delete($content->content);
            }
            $content->delete();
        }

        $step->delete();

        return back()->with('success', 'Langkah roadmap berhasil dihapus.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'steps' => 'required|array',
            'steps.*.id' => 'required|integer',
            'steps.*.order' => 'required|integer',
        ]);

        foreach ($request->steps as $item) {
            CourseRoadmapStep::where('id', $item['id'])
                ->update(['order' => $item['order']]);
        }

        return response()->json(['success' => true]);
    }
}
