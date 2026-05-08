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
@endphp

<div class="min-h-screen font-sans relative overflow-hidden pb-32" style="background-color: {{ $bgHex }};">
    <!-- Static Background Decorations -->
    <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-30">
        <div class="absolute -top-24 -left-24 w-96 h-96 bg-white/5 rounded-full blur-3xl"></div>
        <div class="absolute top-1/2 -right-24 w-64 h-64 bg-white/5 rounded-full blur-3xl"></div>
    </div>

    <!-- Sticky Navigation -->
    <nav class="sticky top-0 z-50 bg-slate-900/90 backdrop-blur-xl border-b border-white/5 px-6 py-4">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h1 class="text-white font-black tracking-tight leading-none uppercase text-xs">Roadmap <span class="text-white/40 ml-1">{{ $currentLevel }}</span></h1>
            </div>

            <!-- Level Tabs -->
            <div class="flex items-center bg-black/40 rounded-2xl p-1 border border-white/10">
                @foreach(['N5', 'N4', 'Tokutei Ginou'] as $level)
                    @php 
                        $isLocked = !($access[$level] ?? false); 
                        $isActive = ($currentLevel === $level);
                    @endphp
                    @if($isLocked)
                        <div class="px-5 py-2.5 rounded-xl text-[10px] font-black text-white/20 uppercase tracking-widest flex items-center gap-2 cursor-not-allowed">
                            {{ $level }} <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    @else
                        <a href="{{ route('dashboard', ['level' => $level]) }}" 
                           class="px-6 py-2.5 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ $isActive ? 'bg-white text-slate-900 shadow-xl' : 'text-white/50 hover:text-white hover:bg-white/5' }}">
                            {{ $level }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto px-6 pt-24 relative z-10">
        @if(!($access[$currentLevel] ?? false))
            <!-- Locked State -->
            <div class="text-center py-32 bg-slate-800/30 rounded-[3rem] border border-white/5 backdrop-blur-md">
                <div class="w-20 h-20 bg-white/5 rounded-2xl flex items-center justify-center mx-auto mb-10 border border-white/10">
                    <svg class="w-10 h-10 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="text-4xl font-black text-white mb-6 uppercase tracking-tighter">BELUM TERBUKA</h3>
                <p class="text-white/40 max-w-sm mx-auto mb-12 font-medium">Upgrade paket Anda untuk membuka kurikulum ini.</p>
                <a href="{{ route('landing') }}#pricing" class="px-12 py-6 bg-white text-slate-900 font-black rounded-2xl shadow-xl hover:scale-105 transition-all uppercase tracking-widest text-xs">Beli Paket {{ $currentLevel }}</a>
            </div>
        @else
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-12 mb-32">
                <div>
                    <h2 class="text-7xl font-black text-white tracking-tighter uppercase leading-none mb-4">Roadmap</h2>
                    <p class="text-white/30 text-xl font-medium">Kurikulum resmi untuk mencapai target {{ $currentLevel }}.</p>
                </div>
                <div class="flex gap-4">
                    <div class="bg-white/5 p-8 rounded-3xl border border-white/5 text-center min-w-[140px]">
                        <p class="text-[9px] font-black text-white/20 uppercase tracking-widest mb-1">XP</p>
                        <p class="text-3xl font-black text-white">{{ number_format($totalXP) }}</p>
                    </div>
                    <div class="bg-white p-8 rounded-3xl text-center min-w-[140px] shadow-2xl">
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">PROGRES</p>
                        <p class="text-3xl font-black text-slate-900">
                             @php
                                $completed = collect($stepsWithStatus)->where('is_completed', true)->count();
                                $total = count($stepsWithStatus);
                                $percent = $total > 0 ? ($completed / $total) * 100 : 0;
                            @endphp
                            {{ round($percent) }}%
                        </p>
                    </div>
                </div>
            </div>

            <!-- Roadmap visualization -->
            <div class="relative pb-20">
                <!-- Center Line -->
                <div class="absolute left-6 md:left-1/2 -translate-x-1/2 top-0 bottom-0 w-1.5 bg-white/5 rounded-full"></div>

                <div class="space-y-32 relative">
                    @forelse($stepsWithStatus as $index => $data)
                        @php
                            $step = $data->step;
                            $content = $step->content;
                            $isLocked = $data->is_locked;
                            $isCompleted = $data->is_completed;
                            $side = $index % 2 === 0 ? 'left' : 'right';
                            $boxColor = $isLocked ? 'bg-slate-800/50' : '';
                        @endphp

                        <div class="relative flex items-center">
                            <!-- Milestone Dot -->
                            <div class="absolute left-6 md:left-1/2 -translate-x-1/2 w-12 h-12 rounded-2xl flex items-center justify-center z-20 shadow-2xl transition-all duration-500 {{ $isLocked ? 'bg-slate-800 border border-white/5' : 'bg-white shadow-[0_0_20px_rgba(255,255,255,0.15)]' }}">
                                @if($isCompleted)
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M5 13l4 4L19 7"></path></svg>
                                @elseif($isLocked)
                                    <svg class="w-4 h-4 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                @else
                                    <span class="text-slate-900 font-black text-sm">{{ $index + 1 }}</span>
                                @endif
                            </div>

                            <!-- Content Box -->
                            <div class="w-full pl-20 md:pl-0 md:w-1/2 {{ $side === 'left' ? 'md:pr-20 md:text-right' : 'md:ml-auto md:pl-20 md:text-left' }}">
                                <div class="relative p-8 md:p-10 rounded-[2.5rem] transition-all duration-500 {{ $isLocked ? 'bg-slate-800/40 border border-white/5' : 'shadow-2xl' }}" 
                                     style="{{ !$isLocked ? 'background-color: ' . $accentColorHex . ';' : '' }}">
                                    
                                    <!-- Inner Container to prevent overlapping -->
                                    <div class="flex flex-col h-full min-h-[140px] relative">
                                        <!-- Step Meta -->
                                        <div class="flex items-center {{ $side === 'left' ? 'md:justify-end' : '' }} gap-3 mb-6">
                                            <span class="px-3 py-1 bg-black/20 rounded-lg text-[9px] font-black text-white/60 uppercase tracking-widest border border-white/5">{{ $step->content_type }}</span>
                                            @if($isCompleted)
                                                <span class="px-2 py-0.5 bg-white/10 text-white text-[8px] font-black rounded uppercase">SELESAI</span>
                                            @endif
                                        </div>

                                        <!-- Title -->
                                        <h4 class="text-3xl font-black text-white tracking-tighter leading-tight mb-8">
                                            {{ $step->title ?: ($content->title ?? 'Untitled Step') }}
                                        </h4>
                                        
                                        <!-- Action or Lock -->
                                        @if($isLocked)
                                            <div class="mt-auto pt-4 border-t border-white/5">
                                                <div class="flex items-center {{ $side === 'left' ? 'md:justify-end' : '' }} gap-2 text-white/30">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                    <span class="text-[9px] font-black uppercase tracking-widest">Langkah ini terkunci</span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="mt-auto pt-4">
                                                <div class="flex {{ $side === 'left' ? 'md:justify-end' : '' }}">
                                                    @if($step->content_type === 'quiz')
                                                        <a href="{{ route('quizzes.show', $step->content_id) }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-slate-950 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:scale-105 transition-all shadow-xl">Mulai Quiz</a>
                                                    @elseif($step->content_type === 'lesson')
                                                        <a href="{{ route('courses.lessons.show', ['course' => $step->course_id, 'lesson' => $step->content_id]) }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-slate-950 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:scale-105 transition-all shadow-xl">Pelajari Materi</a>
                                                    @else
                                                        <a href="{{ route('courses.show', $step->course_id) }}" class="inline-flex items-center gap-3 px-8 py-4 bg-white text-slate-950 text-[10px] font-black uppercase tracking-widest rounded-2xl hover:scale-105 transition-all shadow-xl">Buka Modul</a>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-20 bg-white/5 rounded-3xl border border-white/5">
                            <p class="text-white/20 font-black uppercase tracking-widest text-xs">Belum ada kurikulum aktif</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');
    body { font-family: 'Outfit', sans-serif; background-color: #0f172a; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
</style>
@endsection
