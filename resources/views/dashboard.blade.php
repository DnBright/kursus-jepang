@extends('layouts.app')

@section('content')
@php
    // Consistent Neutral Background for all programs
    $bgHex = '#0f172a'; // Slate-900
    
    // Theme Colors for the CARDS/STEPS only
    $accentColorHex = match($currentLevel) {
        'N4' => '#059669', // emerald-600
        'Tokutei Ginou' => '#334155', // slate-700
        default => '#f97316' // orange-500
    };
    
    $accentColorTailwind = match($currentLevel) {
        'N4' => 'emerald',
        'Tokutei Ginou' => 'slate',
        default => 'orange'
    };
@endphp

<div class="min-h-screen font-sans relative overflow-hidden" style="background-color: {{ $bgHex }};">
    <!-- Sophisticated Static Background Decorations -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_20%_20%,rgba(255,255,255,0.03),transparent_40%)]"></div>
        <div class="absolute bottom-0 right-0 w-full h-full bg-[radial-gradient(circle_at_80%_80%,rgba(255,255,255,0.02),transparent_50%)]"></div>
    </div>

    <!-- Professional Sticky Navigation -->
    <nav class="sticky top-0 z-50 bg-slate-900/80 backdrop-blur-2xl border-b border-white/5 px-6 py-4 shadow-2xl">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-white flex items-center justify-center font-black text-slate-950 shadow-lg">DNB</div>
                <div>
                    <h1 class="text-white font-black tracking-tight leading-none uppercase text-xs">Roadmap <span class="text-white/40 font-bold ml-1">{{ $currentLevel }}</span></h1>
                </div>
            </div>

            <!-- Level Tabs -->
            <div class="flex items-center bg-black/40 rounded-2xl p-1.5 border border-white/10">
                @foreach(['N5', 'N4', 'Tokutei Ginou'] as $level)
                    @php 
                        $isLocked = !($access[$level] ?? false); 
                        $isActive = ($currentLevel === $level);
                    @endphp
                    @if($isLocked)
                        <div class="px-5 py-2 rounded-xl text-[10px] font-black text-white/20 uppercase tracking-widest flex items-center gap-2 cursor-not-allowed">
                            {{ $level }} <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    @else
                        <a href="{{ route('dashboard', ['level' => $level]) }}" 
                           class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-[0.15em] transition-all duration-300 {{ $isActive ? 'bg-white text-slate-900 shadow-[0_0_20px_rgba(255,255,255,0.2)]' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                            {{ $level }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-6 py-24 relative z-10">
        @if(!($access[$currentLevel] ?? false))
            <!-- Locked State UI (Full Page) -->
            <div class="text-center py-32 bg-slate-800/40 rounded-[4rem] border border-white/5 backdrop-blur-xl shadow-2xl">
                <div class="w-24 h-24 bg-white/5 rounded-[2rem] flex items-center justify-center mx-auto mb-10 border border-white/10 shadow-inner">
                    <svg class="w-10 h-10 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="text-5xl font-black text-white mb-6 uppercase tracking-tighter">BELUM TERBUKA</h3>
                <p class="text-white/40 max-w-sm mx-auto mb-12 text-lg font-medium leading-relaxed">Silakan upgrade paket Anda untuk membuka kurikulum eksklusif ini.</p>
                <a href="{{ route('landing') }}#pricing" class="px-12 py-6 bg-white text-slate-900 font-black rounded-3xl shadow-2xl hover:scale-105 active:scale-95 transition-all uppercase tracking-widest text-xs">Beli Paket {{ $currentLevel }}</a>
            </div>
        @else
            <!-- Dashboard Stats Overview -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-12 mb-32 border-b border-white/5 pb-16">
                <div>
                    <span class="inline-block px-3 py-1 bg-white/5 rounded-lg text-[10px] font-black text-white/40 uppercase tracking-widest mb-6 border border-white/5">Member Dashboard</span>
                    <h2 class="text-7xl font-black text-white tracking-tighter uppercase leading-none">Roadmap</h2>
                    <p class="text-white/30 mt-6 text-xl font-medium leading-relaxed max-w-md">Selesaikan setiap langkah untuk menguasai materi {{ $currentLevel }} secara menyeluruh.</p>
                </div>
                <div class="flex gap-4">
                    <div class="bg-white/5 p-8 rounded-[2.5rem] border border-white/5 min-w-[160px] text-center shadow-xl">
                        <p class="text-[10px] font-black text-white/20 uppercase tracking-widest mb-2">Total XP</p>
                        <p class="text-4xl font-black text-white">{{ number_format($totalXP) }}</p>
                    </div>
                    <div class="bg-white p-8 rounded-[2.5rem] min-w-[160px] text-center shadow-2xl">
                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Progress</p>
                        <p class="text-4xl font-black text-slate-900">
                            @php
                                $completed = collect($stepsWithStatus)->where('is_completed', true)->count();
                                $total = count($stepsWithStatus);
                                $percent = $total > 0 ? ($completed / $total) * 100 : 0;
                            @endphp
                            {{ round($percent) }}<span class="text-slate-300 text-lg">%</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Enhanced Visual Roadmap -->
            <div class="relative">
                <!-- Solid Vertical Track -->
                <div class="absolute left-6 md:left-1/2 -translate-x-1/2 top-0 bottom-0 w-2 bg-white/5 rounded-full"></div>

                <div class="space-y-24 relative">
                    @forelse($stepsWithStatus as $index => $data)
                        @php
                            $step = $data->step;
                            $content = $step->content;
                            $isLocked = $data->is_locked;
                            $isCompleted = $data->is_completed;
                            $side = $index % 2 === 0 ? 'left' : 'right';
                            
                            // Visual State
                            $stateColor = $isLocked ? '#334155' : ($isCompleted ? '#10b981' : $accentColorHex);
                        @endphp

                        <div class="relative flex items-center transition-all duration-700">
                            <!-- High-Contrast Milestone Point -->
                            <div class="absolute left-6 md:left-1/2 -translate-x-1/2 w-12 h-12 rounded-2xl flex items-center justify-center z-20 shadow-2xl transition-all duration-500 {{ $isLocked ? 'bg-slate-800 border border-white/10' : 'bg-white shadow-[0_0_20px_rgba(255,255,255,0.2)]' }}">
                                @if($isCompleted)
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                                @elseif($isLocked)
                                    <svg class="w-4 h-4 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                @else
                                    <span class="text-slate-900 font-black text-sm">{{ $index + 1 }}</span>
                                @endif
                            </div>

                            <!-- Sequential Roadmap Card -->
                            <div class="w-full pl-20 md:pl-0 md:w-1/2 {{ $side === 'left' ? 'md:pr-20 md:text-right' : 'md:ml-auto md:pl-20 md:text-left' }}">
                                <div class="relative overflow-hidden p-8 rounded-[2.5rem] transition-all duration-500 group {{ $isLocked ? 'bg-slate-800/40 border border-white/5 opacity-40 cursor-not-allowed' : 'shadow-2xl' }}"
                                     style="{{ !$isLocked ? 'background-color: ' . $stateColor . ';' : '' }}">
                                    
                                    @if($isLocked)
                                        <div class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center gap-3 z-30">
                                            <svg class="w-8 h-8 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                            <span class="text-[9px] font-black text-white/30 uppercase tracking-[0.2em] px-4 text-center">Terkunci! Selesaikan sebelumnya</span>
                                        </div>
                                    @endif

                                    <!-- Step Label -->
                                    <div class="flex items-center {{ $side === 'left' ? 'md:justify-end' : '' }} gap-3 mb-6">
                                        <span class="px-3 py-1 bg-black/20 rounded-lg text-[9px] font-black text-white/60 uppercase tracking-widest border border-white/10">Step {{ $index + 1 }}</span>
                                        <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">{{ $step->content_type }}</span>
                                    </div>

                                    <!-- Title -->
                                    <h4 class="text-2xl font-black text-white mb-8 tracking-tighter leading-tight group-hover:scale-[1.02] transition-transform duration-500">
                                        {{ $step->title ?: ($content->title ?? 'Untitled Step') }}
                                    </h4>
                                    
                                    <!-- Action Button -->
                                    @if(!$isLocked)
                                        <div class="flex {{ $side === 'left' ? 'md:justify-end' : '' }}">
                                            @if($step->content_type === 'quiz')
                                                <a href="{{ route('quizzes.show', $step->content_id) }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-slate-950 text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-slate-50 shadow-xl transition-all">Mulai Quiz</a>
                                            @elseif($step->content_type === 'lesson')
                                                <a href="{{ route('courses.lessons.show', ['course' => $step->course_id, 'lesson' => $step->content_id]) }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-slate-950 text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-slate-50 shadow-xl transition-all">Pelajari Materi</a>
                                            @else
                                                <a href="{{ route('courses.show', $step->course_id) }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-slate-950 text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-slate-50 shadow-xl transition-all">Buka Modul</a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-32 bg-white/5 rounded-[4rem] border border-white/5">
                            <p class="text-white/20 font-black uppercase tracking-[0.3em] text-xs">Belum ada kurikulum aktif</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');
    body { font-family: 'Outfit', sans-serif; }
</style>
@endsection
