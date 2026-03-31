<?php

namespace App\Http\Controllers\Sensei;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MaterialController extends Controller
{
    public function index()
    {
        $sensei = Auth::guard('sensei')->user();
        
        // Modules and Lessons owned by this sensei
        $modules = Module::where('instructor_id', $sensei->id)
            ->with(['lessons' => function($q) {
                $q->orderBy('order');
            }, 'course'])
            ->get()
            ->map(function($module) {
                return [
                    'id' => $module->id,
                    'title' => $module->title,
                    'level' => $module->course->level ?? 'N/A',
                    'material_count' => $module->lessons->count(),
                    'status' => 'published', // You could add a status column to Module if needed
                    'materials' => $module->lessons->map(function($lesson) {
                        return [
                            'id' => $lesson->id,
                            'title' => $lesson->title,
                            'type' => ucfirst($lesson->type),
                            'students_access' => 0, // Mock for now, can be linked to enrollment/views
                            'status' => 'published',
                        ];
                    })
                ];
            });

        $summary = [
            'active_materials' => Lesson::where('instructor_id', $sensei->id)->count(),
            'total_modules' => $modules->count(),
            'popular_material' => Lesson::where('instructor_id', $sensei->id)->first()->title ?? '-',
            'draft_materials' => 0,
        ];

        return view('sensei.materials.index', compact('summary', 'modules'));
    }

    // Module Management
    public function storeModule(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
        ]);

        Module::create([
            'title' => $request->title,
            'course_id' => $request->course_id,
            'description' => $request->description,
            'instructor_id' => Auth::guard('sensei')->id(),
            'order' => Module::where('course_id', $request->course_id)->count() + 1,
        ]);

        return back()->with('success', 'Modul berhasil dibuat.');
    }

    public function destroyModule($id)
    {
        $module = Module::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($id);
        $module->delete();
        return back()->with('success', 'Modul berhasil dihapus.');
    }

    // Lesson Management
    public function createLesson()
    {
        $sensei = Auth::guard('sensei')->user();
        $courses = Course::all();
        $modules = Module::where('instructor_id', $sensei->id)->get();
        return view('sensei.materials.lessons.create', compact('courses', 'modules'));
    }

    public function storeLesson(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
            'type' => 'required|in:video,text,pdf',
            'content_text' => 'nullable|string',
            'content_video' => 'nullable|url',
            'content_pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $content = null;
        if ($request->type === 'video') {
            $content = $request->content_video;
        } elseif ($request->type === 'text') {
            $content = $request->content_text;
        } elseif ($request->type === 'pdf' && $request->hasFile('content_pdf')) {
            $path = $request->file('content_pdf')->store('materials/pdf', 'public');
            $content = $path;
        }

        Lesson::create([
            'module_id' => $request->module_id,
            'instructor_id' => Auth::guard('sensei')->id(),
            'title' => $request->title,
            'type' => $request->type,
            'content' => $content,
            'duration' => $request->duration,
            'order' => Lesson::where('module_id', $request->module_id)->count() + 1,
            'is_free' => $request->has('is_free'),
        ]);

        return redirect()->route('sensei.materials.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    public function editLesson($id)
    {
        $lesson = Lesson::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($id);
        $courses = Course::all();
        $modules = Module::where('instructor_id', Auth::guard('sensei')->id())->get();
        return view('sensei.materials.lessons.edit', compact('lesson', 'courses', 'modules'));
    }

    public function updateLesson(Request $request, $id)
    {
        $lesson = Lesson::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'module_id' => 'required|exists:modules,id',
            'type' => 'required|in:video,text,pdf',
        ]);

        $content = $lesson->content;
        if ($request->type === 'video') {
            $content = $request->content_video;
        } elseif ($request->type === 'text') {
            $content = $request->content_text;
        } elseif ($request->type === 'pdf' && $request->hasFile('content_pdf')) {
            // Delete old file if exists
            if ($lesson->type === 'pdf' && $lesson->content) {
                Storage::disk('public')->delete($lesson->content);
            }
            $path = $request->file('content_pdf')->store('materials/pdf', 'public');
            $content = $path;
        }

        $lesson->update([
            'module_id' => $request->module_id,
            'title' => $request->title,
            'type' => $request->type,
            'content' => $content,
            'duration' => $request->duration,
            'is_free' => $request->has('is_free'),
        ]);

        return redirect()->route('sensei.materials.index')->with('success', 'Materi berhasil diperbarui.');
    }

    public function destroyLesson($id)
    {
        $lesson = Lesson::where('instructor_id', Auth::guard('sensei')->id())->findOrFail($id);
        
        if ($lesson->type === 'pdf' && $lesson->content) {
            Storage::disk('public')->delete($lesson->content);
        }
        
        $lesson->delete();
        return back()->with('success', 'Materi berhasil dihapus.');
    }
}
