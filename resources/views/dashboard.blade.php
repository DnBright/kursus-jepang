@extends('layouts.app')

@section('content')
@php
    $bgHex = match($currentLevel) {
        'N4' => '#065f46', // emerald-800
        'Tokutei Ginou' => '#0f172a', // slate-900
        default => '#c2410c' // orange-700
    };
    $accentColor = match($currentLevel) {
        'N4' => 'emerald',
        'Tokutei Ginou' => 'slate',
        default => 'orange'
    };
@endphp

<div class="min-h-screen transition-colors duration-700 font-sans" style="background-color: {{ $bgHex }};">
    <!-- Clean Background Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none opacity-20">
        <div class="absolute top-0 left-0 w-full h-full bg-[radial-gradient(circle_at_50%_50%,rgba(255,255,255,0.1),transparent)]"></div>
    </div>

    <!-- Sticky Navigation -->
    <nav class="sticky top-0 z-50 bg-black/30 backdrop-blur-xl border-b border-white/10 px-6 py-4">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center font-black text-slate-900 text-xs">DNB</div>
                <h1 class="text-white font-bold tracking-tight text-sm uppercase">Roadmap <span class="text-white/50">{{ $currentLevel }}</span></h1>
            </div>

            <!-- Level Tabs -->
            <div class="flex items-center bg-black/40 rounded-xl p-1 border border-white/5">
                @foreach(['N5', 'N4', 'Tokutei Ginou'] as $level)
                    @php 
                        $isLocked = !($access[$level] ?? false); 
                        $isActive = ($currentLevel === $level);
                    @endphp
                    @if($isLocked)
                        <div class="px-4 py-2 rounded-lg text-[10px] font-black text-white/20 uppercase tracking-widest flex items-center gap-2 cursor-not-allowed">
                            {{ $level }} <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                    @else
                        <a href="{{ route('dashboard', ['level' => $level]) }}" 
                           class="px-5 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all {{ $isActive ? 'bg-white text-slate-900 shadow-lg' : 'text-white/60 hover:text-white hover:bg-white/5' }}">
                            {{ $level }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto px-6 py-16">
        @if(!($access[$currentLevel] ?? false))
            <!-- Locked Program UI -->
            <div class="text-center py-32 bg-white/5 rounded-[3rem] border border-white/10 backdrop-blur-md">
                <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center mx-auto mb-8">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <h3 class="text-4xl font-black text-white mb-4">PROGRAM TERKUNCI</h3>
                <p class="text-white/60 max-w-sm mx-auto mb-10">Silakan beli paket program {{ $currentLevel }} untuk membuka roadmap pembelajaran ini.</p>
                <a href="{{ route('landing') }}#pricing" class="px-10 py-5 bg-white text-slate-900 font-black rounded-2xl shadow-xl hover:scale-105 transition-all uppercase tracking-widest text-xs">Beli Sekarang</a>
            </div>
        @else
            <!-- Header Stats -->
            <div class="flex items-center justify-between mb-20">
                <div>
                    <h2 class="text-5xl font-black text-white tracking-tighter uppercase leading-none mb-2">Kurikulum</h2>
                    <p class="text-white/50 font-medium text-lg">Selesaikan langkah demi langkah untuk lanjut.</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-white/40 uppercase tracking-widest mb-1">Kemajuan Anda</p>
                    <p class="text-4xl font-black text-white">
                        @php
                            $completed = collect($stepsWithStatus)->where('is_completed', true)->count();
                            $total = count($stepsWithStatus);
                        @endphp
                        {{ $completed }}<span class="text-white/30">/{{ $total }}</span>
                    </p>
                </div>
            </div>

            <!-- Vertical Roadmap -->
            <div class="relative">
                <!-- Center Path -->
                <div class="absolute left-6 md:left-1/2 -translate-x-1/2 top-0 bottom-0 w-1 bg-white/10 rounded-full"></div>

                <div class="space-y-12">
                    @forelse($stepsWithStatus as $index => $data)
                        @php
                            $step = $data->step;
                            $content = $step->content;
                            $isLocked = $data->is_locked;
                            $isCompleted = $data->is_completed;
                            $side = $index % 2 === 0 ? 'left' : 'right';
                        @endphp

                        <div class="relative flex items-center {{ $isLocked ? 'opacity-50 grayscale' : '' }}">
                            <!-- Milestone Node -->
                            <div class="absolute left-6 md:left-1/2 -translate-x-1/2 w-12 h-12 rounded-full border-4 {{ $isCompleted ? 'bg-white border-white shadow-[0_0_20px_rgba(255,255,255,0.5)]' : 'bg-slate-800 border-white/20' }} flex items-center justify-center z-10 transition-all duration-500">
                                @if($isCompleted)
                                    <svg class="w-6 h-6 text-slate-900" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                @elseif($isLocked)
                                    <svg class="w-4 h-4 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                @else
                                    <span class="text-white font-black text-xs">{{ $index + 1 }}</span>
                                @endif
                            </div>

                            <!-- Content Card -->
                            <div class="w-full pl-20 md:pl-0 md:w-1/2 {{ $side === 'left' ? 'md:pr-16 md:text-right' : 'md:ml-auto md:pl-16 md:text-left' }}">
                                <div class="bg-white/10 backdrop-blur-md border border-white/10 p-6 rounded-2xl hover:bg-white/20 transition-all group relative overflow-hidden">
                                    @if($isLocked)
                                        <div class="absolute inset-0 bg-black/20 flex items-center justify-center z-20">
                                            <div class="px-4 py-2 bg-white/10 backdrop-blur-md rounded-lg border border-white/10 text-[10px] font-black text-white uppercase tracking-widest">Selesaikan Langkah Sebelumnya</div>
                                        </div>
                                    @endif

                                    <div class="flex items-center {{ $side === 'left' ? 'md:justify-end' : '' }} gap-2 mb-3">
                                        <span class="text-[10px] font-black text-white/40 uppercase tracking-widest">{{ $step->content_type }}</span>
                                        @if($isCompleted)
                                            <span class="px-2 py-0.5 bg-green-500/20 text-green-400 text-[9px] font-black rounded uppercase">Selesai</span>
                                        @endif
                                    </div>

                                    <h4 class="text-xl font-bold text-white mb-6 leading-tight">{{ $step->title ?: ($content->title ?? 'Untitled Step') }}</h4>
                                    
                                    @if(!$isLocked)
                                        <div class="flex {{ $side === 'left' ? 'md:justify-end' : '' }}">
                                            @if($step->content_type === 'quiz')
                                                <a href="{{ route('quizzes.show', $step->content_id) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-slate-900 text-[10px] font-black uppercase tracking-widest rounded-xl hover:scale-105 transition-all">Mulai Quiz</a>
                                            @elseif($step->content_type === 'lesson')
                                                <a href="{{ route('courses.lessons.show', ['course' => $step->course_id, 'lesson' => $step->content_id]) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-slate-900 text-[10px] font-black uppercase tracking-widest rounded-xl hover:scale-105 transition-all">Buka Materi</a>
                                            @else
                                                <a href="{{ route('courses.show', $step->course_id) }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-slate-900 text-[10px] font-black uppercase tracking-widest rounded-xl hover:scale-105 transition-all">Lihat Modul</a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-24 bg-white/5 rounded-3xl border border-white/10">
                            <p class="text-white/40 font-bold uppercase tracking-widest">Belum ada kurikulum yang disusun.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
