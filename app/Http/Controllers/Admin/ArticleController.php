<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = [];
        if (\Illuminate\Support\Facades\Schema::hasTable('articles')) {
            $articles = Article::latest()->get();
        }
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $categories = [];
        if (\Illuminate\Support\Facades\Schema::hasTable('categories')) {
            $categories = \App\Models\Category::orderBy('name')->pluck('name')->toArray();
        }
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_url' => 'nullable|url|max:255',
            'category' => 'nullable|string|max:255',
            'new_category' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'is_member_only' => 'boolean',
        ]);

        if ($request->filled('new_category')) {
            $validated['category'] = $request->input('new_category');
            if (\Illuminate\Support\Facades\Schema::hasTable('categories')) {
                \App\Models\Category::firstOrCreate(['name' => $validated['category']]);
            }
        }

        $validated['slug'] = Str::slug($validated['title']);
        
        // Ensure slug is unique
        $count = Article::where('slug', 'LIKE', "{$validated['slug']}%")->count();
        if ($count > 0) {
            $validated['slug'] .= '-' . ($count + 1);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('articles', 'public');
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->input('image_url');
        }

        $validated['is_published'] = $request->input('is_published') === '1';
        $validated['is_member_only'] = $request->has('is_member_only');

        Article::create($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(Article $article)
    {
        $categories = [];
        if (\Illuminate\Support\Facades\Schema::hasTable('categories')) {
            $categories = \App\Models\Category::orderBy('name')->pluck('name')->toArray();
        }
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'image_url' => 'nullable|url|max:255',
            'category' => 'nullable|string|max:255',
            'new_category' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'is_member_only' => 'boolean',
        ]);

        if ($request->filled('new_category')) {
            $validated['category'] = $request->input('new_category');
            if (\Illuminate\Support\Facades\Schema::hasTable('categories')) {
                \App\Models\Category::firstOrCreate(['name' => $validated['category']]);
            }
        }

        if ($validated['title'] !== $article->title) {
            $validated['slug'] = Str::slug($validated['title']);
            $count = Article::where('slug', 'LIKE', "{$validated['slug']}%")->where('id', '!=', $article->id)->count();
            if ($count > 0) {
                $validated['slug'] .= '-' . ($count + 1);
            }
        }

        if ($request->hasFile('image')) {
            if ($article->image && !str_starts_with($article->image, 'http')) {
                Storage::disk('public')->delete($article->image);
            }
            $validated['image'] = $request->file('image')->store('articles', 'public');
        } elseif ($request->filled('image_url')) {
            $validated['image'] = $request->input('image_url');
        }

        $validated['is_published'] = $request->input('is_published') === '1';
        $validated['is_member_only'] = $request->has('is_member_only');

        $article->update($validated);

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article)
    {
        if ($article->image) {
            Storage::disk('public')->delete($article->image);
        }
        $article->delete();

        return redirect()->route('admin.articles.index')->with('success', 'Artikel berhasil dihapus.');
    }

    public function deleteCategory(Request $request)
    {
        $categoryName = $request->input('name');
        if ($categoryName) {
            \App\Models\Category::where('name', $categoryName)->delete();
            \App\Models\Article::where('category', $categoryName)->update(['category' => null]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Category name missing'], 400);
    }
}
