@extends('layouts.app')

@section('content')
@php
    $bgClass = match($currentLevel) {
        'N4' => 'bg-emerald-600',
        'Tokutei Ginou' => 'bg-slate-900',
        default => 'bg-orange-500'
    };
    $accentColor = match($currentLevel) {
        'N4' => 'emerald',
        'Tokutei Ginou' => 'slate',
        default => 'orange'
    };
@endphp

<div class="min-h-screen {{ $bgClass }} transition-colors duration-500">
    <div class="max-w-5xl mx-auto px-4 py-12">
        
        <!-- Welcome Header -->
        <div class="mb-12">
            <h1 class="text-4xl font-black text-white tracking-tight">Okaeri, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-white/70 mt-2 text-lg font-medium">Lanjutkan perjalanan belajarmu hari ini.</p>
        </div>

        <!-- Level Tabs -->
        <div class="flex flex-wrap items-center justify-start gap-4 mb-16 overflow-x-auto pb-4 no-scrollbar">
            @foreach(['N5', 'N4', 'Tokutei Ginou'] as $level)
                @php 
                    $isLocked = !($access[$level] ?? false); 
                    $isActive = ($currentLevel === $level);
                    $tabBg = $isActive ? 'bg-white shadow-2xl scale-105' : 'bg-white/10 hover:bg-white/20 backdrop-blur-md';
                    $textColor = $isActive ? 'text-slate-900' : 'text-white/80';
                @endphp
                
                @if($isLocked)
                    <div class="relative group cursor-not-allowed shrink-0">
                        <div class="px-8 py-4 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/10 text-white/40 flex items-center gap-3 grayscale">
                            <span class="font-black tracking-tighter text-xl uppercase">{{ $level }}</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div class="absolute bottom-full left-1/2 -translate-x-1/2 mb-4 w-48 p-3 bg-white rounded-xl shadow-2xl text-[10px] text-slate-900 font-bold text-center opacity-0 group-hover:opacity-100 transition-all pointer-events-none z-50">
                            Terkunci! Silahkan beli paket program {{ $level }} untuk membuka akses.
                            <div class="absolute top-full left-1/2 -translate-x-1/2 border-8 border-transparent border-t-white"></div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('dashboard', ['level' => $level]) }}" 
                       class="px-10 py-5 rounded-2xl {{ $tabBg }} {{ $textColor }} transition-all duration-300 flex items-center gap-3 border border-white/20 group shrink-0">
                        <span class="font-black tracking-tighter text-2xl uppercase">{{ $level }}</span>
                        @if($isActive)
                            <div class="w-2 h-2 rounded-full bg-{{ $accentColor }}-500 animate-pulse"></div>
                        @endif
                    </a>
                @endif
            @endforeach
        </div>

        @if(!($access[$currentLevel] ?? false))
            <!-- Locked State Content -->
            <div class="text-center py-20 px-8 rounded-[3rem] bg-white/5 backdrop-blur-xl border-2 border-dashed border-white/20">
                <div class="w-24 h-24 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-8 border border-white/20">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="text-4xl font-black text-white mb-4 uppercase">Roadmap {{ $currentLevel }} Terkunci</h3>
                <p class="text-white/60 max-w-lg mx-auto text-lg mb-10 font-medium">Mulai perjalanan karir Anda di Jepang dengan membuka akses ke kurikulum eksklusif kami.</p>
                <a href="{{ route('landing') }}#pricing" class="px-10 py-5 bg-white text-slate-900 font-black rounded-2xl shadow-2xl hover:scale-105 transition-all inline-block uppercase tracking-widest text-xs">Beli Paket Sekarang</a>
            </div>
        @else
            <!-- Roadmap Content -->
            <div class="relative">
                <!-- Center Line -->
                <div class="absolute left-1/2 -translate-x-1/2 top-0 bottom-0 w-3 bg-white/10 rounded-full shadow-inner"></div>

                <div class="space-y-32 relative pt-10 pb-20">
                    @forelse($roadmapSteps as $index => $step)
                        @php
                            $side = $index % 2 === 0 ? 'left' : 'right';
                            $content = $step->content;
                        @endphp

                        <div class="flex items-center justify-center w-full relative">
                            <!-- Node Circle -->
                            <div class="absolute left-1/2 -translate-x-1/2 z-10">
                                <div class="w-16 h-16 rounded-full bg-white shadow-2xl flex items-center justify-center ring-8 ring-white/10 group cursor-pointer hover:scale-125 transition-all duration-500">
                                    @if($step->content_type === 'quiz')
                                        <svg class="w-8 h-8 text-{{ $accentColor === 'slate' ? 'slate-800' : $accentColor . '-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    @elseif($step->content_type === 'lesson')
                                        <svg class="w-8 h-8 text-{{ $accentColor === 'slate' ? 'slate-800' : $accentColor . '-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                    @else
                                        <svg class="w-8 h-8 text-{{ $accentColor === 'slate' ? 'slate-800' : $accentColor . '-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                    @endif
                                </div>
                            </div>

                            <!-- Content Card -->
                            <div class="w-1/2 {{ $side === 'left' ? 'pr-24 text-right' : 'pl-24 ml-auto text-left' }}">
                                <div class="bg-white/10 backdrop-blur-xl border border-white/20 p-8 rounded-[2.5rem] hover:bg-white/20 transition-all duration-500 group shadow-2xl">
                                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-white/40 mb-3 block">Step {{ $index + 1 }}</span>
                                    <h4 class="text-2xl font-black text-white mb-6 leading-tight group-hover:text-white transition-colors">{{ $step->title ?: ($content->title ?? 'Untitled Step') }}</h4>
                                    
                                    <div class="flex items-center {{ $side === 'left' ? 'justify-end' : '' }} gap-3 mb-8">
                                        <span class="px-4 py-1.5 bg-white/10 rounded-xl text-[10px] font-black text-white uppercase tracking-widest border border-white/10">{{ $step->content_type }}</span>
                                    </div>

                                    @if($step->content_type === 'quiz')
                                        <a href="{{ route('quizzes.show', $step->content_id) }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-slate-900 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:scale-105 transition-all shadow-xl">Mulai Quiz</a>
                                    @elseif($step->content_type === 'lesson')
                                        <a href="{{ route('lessons.show', $step->content_id) }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-slate-900 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:scale-105 transition-all shadow-xl">Buka Materi</a>
                                    @else
                                        <a href="{{ route('modules.show', $step->content_id) }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-slate-900 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:scale-105 transition-all shadow-xl">Lihat Modul</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-24 bg-white/5 backdrop-blur-md rounded-[3.5rem] border border-white/10 max-w-2xl mx-auto shadow-2xl">
                            <div class="text-7xl mb-8">🏜️</div>
                            <h3 class="text-3xl font-black text-white mb-3">Roadmap Kosong</h3>
                            <p class="text-white/40 font-medium">Sensei sedang menyusun kurikulum terbaik untuk Anda.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif
        
        <!-- Stats Summary Footer -->
        <div class="mt-24 grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white/10 backdrop-blur-md p-10 rounded-[2.5rem] border border-white/10 flex items-center gap-8 shadow-xl">
                <div class="text-5xl">⭐</div>
                <div>
                    <p class="text-[10px] font-black text-white/40 uppercase tracking-widest mb-2">Total XP</p>
                    <p class="text-4xl font-black text-white">{{ number_format($totalXP) }}</p>
                </div>
            </div>
            <div class="bg-white/10 backdrop-blur-md p-10 rounded-[2.5rem] border border-white/10 flex items-center gap-8 shadow-xl">
                <div class="text-5xl">📚</div>
                <div>
                    <p class="text-[10px] font-black text-white/40 uppercase tracking-widest mb-2">Selesai</p>
                    <p class="text-4xl font-black text-white">{{ $completedLessons }} <span class="text-sm font-medium text-white/40 italic">unit</span></p>
                </div>
            </div>
            <div class="bg-white/10 backdrop-blur-md p-10 rounded-[2.5rem] border border-white/10 flex items-center gap-8 shadow-xl">
                <div class="text-5xl">🏆</div>
                <div>
                    <p class="text-[10px] font-black text-white/40 uppercase tracking-widest mb-2">Pencapaian</p>
                    <p class="text-4xl font-black text-white">Advanced</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endsection
