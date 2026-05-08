@extends('layouts.app')

@section('content')
@php
    $bgClass = match($currentLevel) {
        'N4' => 'bg-[#059669]',
        'Tokutei Ginou' => 'bg-[#0f172a]',
        default => 'bg-[#f97316]'
    };
    $accentColor = match($currentLevel) {
        'N4' => 'emerald',
        'Tokutei Ginou' => 'slate',
        default => 'orange'
    };
    $gradientOverlay = match($currentLevel) {
        'N4' => 'from-emerald-600/20 to-emerald-900/40',
        'Tokutei Ginou' => 'from-slate-800/20 to-black/60',
        default => 'from-orange-500/20 to-orange-800/40'
    };
@endphp

<div class="min-h-screen {{ $bgClass }} transition-colors duration-700 relative overflow-hidden">
    <!-- Animated background patterns -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute top-1/2 -right-24 w-64 h-64 bg-black/10 rounded-full blur-3xl animate-bounce" style="animation-duration: 10s"></div>
        <div class="absolute bottom-0 left-1/4 w-full h-1/2 bg-gradient-to-t {{ $gradientOverlay }} pointer-events-none"></div>
    </div>

    <div class="relative z-10">
        <!-- Navigation Header -->
        <div class="w-full bg-black/10 backdrop-blur-md border-b border-white/5 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center shadow-lg">
                    <span class="font-black text-{{ $accentColor === 'slate' ? 'slate-900' : $accentColor . '-600' }}">DNB</span>
                </div>
                <div class="hidden sm:block">
                    <h1 class="text-white font-black tracking-tight leading-none uppercase text-sm">Roadmap <span class="text-white/50">{{ $currentLevel }}</span></h1>
                    <p class="text-[10px] text-white/40 font-bold uppercase tracking-widest mt-1">Langkah Menuju Sukses</p>
                </div>
            </div>

            <!-- Level Tabs -->
            <div class="flex items-center gap-2 bg-black/20 p-1.5 rounded-2xl border border-white/5">
                @foreach(['N5', 'N4', 'Tokutei Ginou'] as $level)
                    @php 
                        $isLocked = !($access[$level] ?? false); 
                        $isActive = ($currentLevel === $level);
                    @endphp
                    @if($isLocked)
                        <div class="relative group">
                            <button class="px-5 py-2.5 rounded-xl text-[10px] font-black text-white/20 uppercase tracking-widest cursor-not-allowed flex items-center gap-2">
                                {{ $level }}
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </button>
                            <div class="absolute bottom-full right-0 mb-3 w-48 p-3 bg-white rounded-xl shadow-2xl text-[9px] text-slate-900 font-bold text-center opacity-0 group-hover:opacity-100 transition-all pointer-events-none z-50">
                                Beli paket {{ $level }} untuk membuka akses.
                                <div class="absolute top-full right-6 border-8 border-transparent border-t-white"></div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('dashboard', ['level' => $level]) }}" 
                           class="px-5 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $isActive ? 'bg-white text-slate-900 shadow-xl' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                            {{ $level }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-6 py-20">
            @if(!($access[$currentLevel] ?? false))
                <!-- Locked State -->
                <div class="text-center py-32 px-8 rounded-[4rem] bg-white/5 border border-white/10 backdrop-blur-sm max-w-3xl mx-auto shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-12 text-white/5 text-9xl font-black rotate-12 pointer-events-none uppercase">{{ $currentLevel }}</div>
                    <div class="w-24 h-24 bg-white rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-2xl rotate-3">
                        <svg class="w-12 h-12 text-{{ $accentColor === 'slate' ? 'slate-900' : $accentColor . '-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <h3 class="text-5xl font-black text-white mb-6 uppercase tracking-tighter">Akses Terbatas</h3>
                    <p class="text-white/60 max-w-md mx-auto text-lg mb-12 font-medium leading-relaxed">Roadmap ini hanya tersedia untuk siswa yang telah membeli paket program {{ $currentLevel }}.</p>
                    <a href="{{ route('landing') }}#pricing" class="px-12 py-6 bg-white text-slate-900 font-black rounded-2xl shadow-2xl hover:scale-105 active:scale-95 transition-all inline-block uppercase tracking-[0.2em] text-xs">Buka Akses Sekarang</a>
                </div>
            @else
                <!-- Roadmap Header -->
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-8 mb-24 border-b border-white/10 pb-12">
                    <div class="max-w-2xl">
                        <span class="inline-block px-3 py-1 bg-white/10 rounded-lg text-[10px] font-black text-white uppercase tracking-widest mb-4 border border-white/10">Active Roadmap</span>
                        <h2 class="text-6xl font-black text-white tracking-tighter uppercase leading-none">Kurikulum {{ $currentLevel }}</h2>
                        <p class="text-white/60 mt-4 text-xl font-medium leading-relaxed">Ikuti jalur pembelajaran yang telah disusun secara sistematis oleh Sensei untuk mencapai target Anda.</p>
                    </div>
                    <div class="flex items-center gap-6">
                        <div class="text-center px-8 py-4 bg-white/5 rounded-3xl border border-white/10 backdrop-blur-sm shadow-xl">
                            <p class="text-[10px] font-black text-white/40 uppercase tracking-widest mb-1">Total XP</p>
                            <p class="text-3xl font-black text-white">{{ number_format($totalXP) }}</p>
                        </div>
                        <div class="text-center px-8 py-4 bg-white rounded-3xl shadow-2xl">
                            <p class="text-[10px] font-black text-{{ $accentColor === 'slate' ? 'slate-400' : $accentColor . '-400' }} uppercase tracking-widest mb-1">Status</p>
                            <p class="text-3xl font-black text-slate-900">{{ $completedLessons }}<span class="text-sm text-slate-400">/{{ $roadmapSteps->count() }}</span></p>
                        </div>
                    </div>
                </div>

                <!-- Roadmap Visualization -->
                <div class="relative px-4">
                    <!-- The Glowing Path Line -->
                    <div class="absolute left-1/2 -translate-x-1/2 top-0 bottom-0 w-1 bg-white/20 rounded-full shadow-[0_0_15px_rgba(255,255,255,0.1)]">
                        <div class="absolute top-0 bottom-0 left-0 right-0 bg-gradient-to-b from-transparent via-white/40 to-transparent animate-pulse"></div>
                    </div>

                    <div class="space-y-40 relative">
                        @forelse($roadmapSteps as $index => $step)
                            @php
                                $side = $index % 2 === 0 ? 'left' : 'right';
                                $content = $step->content;
                                $colorIdx = ($index % 3) + 1;
                            @endphp

                            <div class="flex items-center justify-center w-full relative group">
                                <!-- Connection Line (Branch) -->
                                <div class="absolute top-1/2 -translate-y-1/2 h-1 bg-white/10 transition-all duration-700 group-hover:bg-white/40 {{ $side === 'left' ? 'right-1/2 w-24 rounded-l-full' : 'left-1/2 w-24 rounded-r-full' }}"></div>

                                <!-- Center Node -->
                                <div class="absolute left-1/2 -translate-x-1/2 z-20">
                                    <div class="w-12 h-12 rounded-full bg-white shadow-[0_0_30px_rgba(255,255,255,0.4)] flex items-center justify-center ring-4 ring-white/10 group-hover:scale-125 group-hover:rotate-12 transition-all duration-500 cursor-pointer overflow-hidden relative">
                                        <div class="absolute inset-0 bg-gradient-to-br from-transparent to-black/5"></div>
                                        <span class="text-slate-900 font-black text-sm z-10">{{ $index + 1 }}</span>
                                    </div>
                                </div>

                                <!-- Card Content -->
                                <div class="w-1/2 {{ $side === 'left' ? 'pr-32 text-right' : 'pl-32 ml-auto text-left' }}">
                                    <div class="relative">
                                        <!-- Hover Decoration -->
                                        <div class="absolute -inset-2 bg-white/10 rounded-[2.5rem] blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                                        
                                        <div class="relative bg-white/10 backdrop-blur-2xl border border-white/20 p-10 rounded-[3rem] hover:bg-white/15 hover:-translate-y-2 transition-all duration-500 shadow-2xl group/card">
                                            <div class="flex items-center {{ $side === 'left' ? 'justify-end' : 'justify-start' }} gap-3 mb-6">
                                                @php
                                                    $typeIcon = match($step->content_type) {
                                                        'quiz' => '📝',
                                                        'lesson' => '🎥',
                                                        default => '📖'
                                                    };
                                                @endphp
                                                <div class="w-8 h-8 rounded-xl bg-white/10 flex items-center justify-center text-lg border border-white/10 shadow-inner">{{ $typeIcon }}</div>
                                                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-white/50">{{ $step->content_type }}</span>
                                            </div>

                                            <h4 class="text-3xl font-black text-white mb-6 leading-tight group-hover/card:text-white transition-colors tracking-tighter">{{ $step->title ?: ($content->title ?? 'Untitled Step') }}</h4>
                                            
                                            <div class="{{ $side === 'left' ? 'flex justify-end' : '' }}">
                                                @if($step->content_type === 'quiz')
                                                    <a href="{{ route('quizzes.show', $step->content_id) }}" class="group/btn relative px-8 py-4 bg-white text-slate-900 text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl hover:shadow-[0_0_20px_rgba(255,255,255,0.4)] transition-all overflow-hidden flex items-center gap-3 w-fit">
                                                        <span class="relative z-10">Mulai Tantangan</span>
                                                        <svg class="w-4 h-4 relative z-10 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                                    </a>
                                                @elseif($step->content_type === 'lesson')
                                                    <a href="{{ route('courses.lessons.show', ['course' => $step->course_id, 'lesson' => $step->content_id]) }}" class="group/btn relative px-8 py-4 bg-white text-slate-900 text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl hover:shadow-[0_0_20px_rgba(255,255,255,0.4)] transition-all overflow-hidden flex items-center gap-3 w-fit">
                                                        <span class="relative z-10">Buka Materi</span>
                                                        <svg class="w-4 h-4 relative z-10 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                                    </a>
                                                @else
                                                    <a href="{{ route('courses.show', $step->course_id) }}" class="group/btn relative px-8 py-4 bg-white text-slate-900 text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl hover:shadow-[0_0_20px_rgba(255,255,255,0.4)] transition-all overflow-hidden flex items-center gap-3 w-fit">
                                                        <span class="relative z-10">Lihat Modul</span>
                                                        <svg class="w-4 h-4 relative z-10 group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-32 bg-white/5 backdrop-blur-md rounded-[4rem] border-2 border-dashed border-white/10 max-w-2xl mx-auto shadow-2xl group hover:border-white/20 transition-all duration-700">
                                <div class="text-8xl mb-8 group-hover:scale-125 transition-transform duration-700 inline-block">🚀</div>
                                <h3 class="text-4xl font-black text-white mb-3 tracking-tighter">BELUM ADA DATA</h3>
                                <p class="text-white/40 font-medium text-lg px-8">Sensei sedang menyusun kurikulum eksklusif untuk level ini. Cek kembali nanti!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    @keyframes bounce {
        0%, 100% { transform: translateY(-5%) rotate(-2deg); }
        50% { transform: translateY(5%) rotate(2deg); }
    }
    .animate-bounce {
        animation: bounce 10s infinite ease-in-out;
    }
</style>
@endsection
