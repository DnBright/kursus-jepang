<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $article->title }} - Kursus Jepang</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Noto+Sans+JP:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Outfit', 'Noto Sans JP', sans-serif; }
        .article-content { line-height: 1.8; }
        .article-content p { margin-bottom: 1.5rem; font-size: 1.125rem; font-weight: 500; color: #475569; }
        .article-content h2 { font-size: 1.875rem; font-weight: 900; color: #0f172a; margin-top: 2.5rem; margin-bottom: 1.25rem; }
    </style>
</head>
<body class="bg-white text-slate-900 selection:bg-red-500 selection:text-white">
    <!-- Header -->
    <nav class="bg-white/80 backdrop-blur-xl border-b border-slate-100 sticky top-0 z-50 py-4">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl overflow-hidden bg-white shadow-lg border border-slate-100">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-cover scale-150">
                </div>
                <span class="text-xl font-black tracking-tighter leading-none">Kursus<span class="text-red-600">Jepang</span></span>
            </a>
            <a href="{{ route('articles.index') }}" class="text-sm font-bold text-slate-500 hover:text-red-600 transition-colors uppercase tracking-widest flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
                Semua Artikel
            </a>
        </div>
    </nav>

    <article class="py-20">
        <div class="max-w-4xl mx-auto px-6">
            <!-- Breadcrumb -->
            <nav class="flex items-center gap-3 text-xs font-black text-slate-400 uppercase tracking-widest mb-10">
                <a href="/" class="hover:text-red-600 transition-colors">Home</a>
                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                <a href="{{ route('articles.index') }}" class="hover:text-red-600 transition-colors">Artikel</a>
            </nav>

            <header class="mb-16">
                <h1 class="text-4xl md:text-6xl font-black text-slate-900 mb-8 tracking-tight leading-tight">{{ $article->title }}</h1>
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-600 font-black text-xs">KJ</div>
                        <div>
                            <p class="text-xs font-black text-slate-900 uppercase">Editorial Team</p>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $article->created_at->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </header>

            @if($article->image)
            <div class="aspect-[21/9] rounded-[3rem] overflow-hidden mb-16 shadow-2xl shadow-slate-200/50">
                <img src="{{ str_starts_with($article->image, 'http') ? $article->image : Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
            </div>
            @endif

            <div class="article-content prose prose-slate max-w-none text-slate-600 font-medium leading-relaxed">
                {!! $article->content !!}
            </div>

            <!-- Share Section -->
            <div class="mt-20 pt-10 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-6">
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Bagikan artikel ini</p>
                <div class="flex items-center gap-3">
                    <!-- Basic Share Buttons -->
                    <button class="w-12 h-12 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-red-600 hover:border-red-600 hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </button>
                    <button class="w-12 h-12 rounded-full bg-slate-50 border border-slate-100 flex items-center justify-center text-slate-400 hover:bg-red-600 hover:border-red-600 hover:text-white transition-all">
                         <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C5.373 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.6.113.793-.26.793-.577v-2.234c-3.338.726-4.042-1.416-4.042-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z"/></svg>
                    </button>
                </div>
            </div>
        </div>
    </article>

    <!-- Recent Articles -->
    <section class="py-20 bg-slate-50">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            <h3 class="text-2xl font-black text-slate-900 mb-12 tracking-tight">Artikel Menarik Lainnya</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($recentArticles as $recent)
                <a href="{{ route('articles.show', $recent->slug) }}" class="group block">
                    <div class="relative aspect-video rounded-3xl overflow-hidden mb-6 shadow-xl shadow-slate-200/50">
                         @if($recent->image)
                         <img src="{{ str_starts_with($recent->image, 'http') ? $recent->image : Storage::url($recent->image) }}" alt="{{ $recent->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                         @endif
                    </div>
                    <h4 class="text-xl font-black text-slate-900 group-hover:text-red-600 transition-colors leading-tight line-clamp-2">{{ $recent->title }}</h4>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    <x-footer />
    <x-whatsapp-button />
</body>
</html>
