<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::where('is_published', true)->latest()->paginate(9);
        return view('articles.index', compact('articles'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->where('is_published', true)->firstOrFail();
        $recentArticles = Article::where('is_published', true)
            ->where('id', '!=', $article->id)
            ->latest()
            ->take(3)
            ->get();
            
        return view('articles.show', compact('article', 'recentArticles'));
    }
}
