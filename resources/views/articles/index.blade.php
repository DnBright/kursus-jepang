<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Artikel & Wawasan - Kursus Jepang</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Noto+Sans+JP:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Outfit', 'Noto Sans JP', sans-serif; }
        .text-gradient {
            background: linear-gradient(to right, #DC2626, #991B1B);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-white text-slate-900 selection:bg-red-500 selection:text-white">
    <!-- Simple Header for Subpages -->
    <nav class="bg-white/80 backdrop-blur-xl border-b border-slate-100 sticky top-0 z-50 py-4">
        <div class="max-w-7xl mx-auto px-6 sm:px-8 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl overflow-hidden bg-white shadow-lg border border-slate-100">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-cover scale-150">
                </div>
                <span class="text-xl font-black tracking-tighter leading-none">Kursus<span class="text-red-600">Jepang</span></span>
            </a>
            <a href="/" class="text-sm font-bold text-slate-500 hover:text-red-600 transition-colors uppercase tracking-widest flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
                Kembali
            </a>
        </div>
    </nav>

    <main class="py-20 sm:py-32">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="text-red-600 font-black uppercase tracking-[0.3em] text-[10px] mb-4 block">Our Journal</span>
                <h1 class="text-4xl md:text-6xl font-black text-slate-900 mb-6 tracking-tight">Artikel & <span class="text-gradient">Wawasan</span></h1>
                <p class="text-slate-500 font-bold">Pelajari lebih dalam tentang bahasa, budaya, dan peluang karir di Jepang melalui tulisan para ahli kami.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 sm:gap-12">
                @forelse($articles as $article)
                <div class="group">
                    <div class="relative aspect-[16/10] rounded-[2.5rem] overflow-hidden mb-8 shadow-2xl shadow-slate-200/50">
                        @if($article->image)
                        <img src="{{ str_starts_with($article->image, 'http') ? $article->image : Storage::url($article->image) }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                        <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400">
                             <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002-2z"></path></svg>
                        </div>
                        @endif
                    </div>
                    <a href="{{ route('articles.show', $article->slug) }}" class="block">
                        <h2 class="text-2xl font-black text-slate-900 mb-4 group-hover:text-red-600 transition-colors leading-tight">{{ $article->title }}</h2>
                    </a>
                    <p class="text-slate-500 font-bold text-sm line-clamp-3 mb-6">{{ $article->excerpt }}</p>
                    <div class="flex items-center gap-4 text-xs font-black text-slate-400 uppercase tracking-widest">
                        <span>{{ $article->created_at->format('d M Y') }}</span>
                    </div>
                </div>
                @empty
                <div class="col-span-full py-20 text-center">
                    <p class="text-slate-400 font-bold">Belum ada artikel yang dipublikasikan.</p>
                </div>
                @endforelse
            </div>

            <div class="mt-20">
                {{ $articles->links() }}
            </div>
        </div>
    </main>

    <x-footer />
    <x-whatsapp-button />
</body>
</html>
