@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-red-50/30 py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-12">
            <h1 class="text-4xl font-black text-slate-900 mb-3">
                <span class="bg-gradient-to-r from-red-600 to-rose-600 bg-clip-text text-transparent">Latihan</span> & Quiz
            </h1>
            <p class="text-slate-600 text-lg">Uji kemampuan bahasa Jepang Anda dengan berbagai quiz interaktif</p>
        </div>

        <!-- Filter Tabs -->
        <div class="flex gap-3 mb-8 overflow-x-auto pb-2">
            <a href="{{ route('quizzes.index') }}" class="px-6 py-3 rounded-xl font-bold text-sm transition-all {{ $filter == 'all' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                Semua Quiz
            </a>
            <a href="{{ route('quizzes.index', ['type' => 'daily']) }}" class="px-6 py-3 rounded-xl font-bold text-sm transition-all whitespace-nowrap {{ $filter == 'daily' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                Quiz Harian
            </a>
            <a href="{{ route('quizzes.index', ['type' => 'weekly']) }}" class="px-6 py-3 rounded-xl font-bold text-sm transition-all whitespace-nowrap {{ $filter == 'weekly' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                Quiz Mingguan
            </a>
            <a href="{{ route('quizzes.index', ['type' => 'module_test']) }}" class="px-6 py-3 rounded-xl font-bold text-sm transition-all whitespace-nowrap {{ $filter == 'module_test' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                Tes Modul
            </a>
            <a href="{{ route('quizzes.index', ['type' => 'mock_jlpt']) }}" class="px-6 py-3 rounded-xl font-bold text-sm transition-all whitespace-nowrap {{ $filter == 'mock_jlpt' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-white text-slate-600 hover:bg-slate-50' }}">
                Mock JLPT
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-red-700">
                {{ session('error') }}
            </div>
        @endif

        <!-- Quiz Grid -->
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($quizzes as $quiz)
                @php
                    $userAttempt = $userAttempts->get($quiz->id);
                    $bestScore = $userAttempt->best_score ?? null;
                    $isPassed = $userAttempt->is_passed ?? false;
                @endphp

                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all overflow-hidden group">
                    <!-- Quiz Type Badge -->
                    <div class="p-6 pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold 
                                {{ $quiz->type == 'daily' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $quiz->type == 'weekly' ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $quiz->type == 'module_test' ? 'bg-orange-100 text-orange-700' : '' }}
                                {{ $quiz->type == 'mock_jlpt' ? 'bg-red-100 text-red-700' : '' }}
                            ">
                                {{ ucfirst(str_replace('_', ' ', $quiz->type)) }}
                            </span>

                            @if($isPassed)
                                <div class="flex items-center gap-1 text-green-600">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-xs font-bold">Lulus</span>
                                </div>
                            @endif
                        </div>

                        <h3 class="text-xl font-black text-slate-900 mb-2 group-hover:text-red-600 transition-colors">
                            {{ $quiz->title }}
                        </h3>
                        
                        <p class="text-slate-600 text-sm mb-4 line-clamp-2">
                            {{ $quiz->description }}
                        </p>

                        <!-- Quiz Info -->
                        <div class="flex items-center gap-4 text-xs text-slate-500 mb-4">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>{{ $quiz->questions_count ?? $quiz->questions->count() }} Soal</span>
                            </div>
                            
                            @if($quiz->time_limit)
                                <div class="flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>{{ $quiz->time_limit }} menit</span>
                                </div>
                            @endif

                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span>Pass: {{ $quiz->passing_score }}%</span>
                            </div>
                        </div>

                        <!-- Best Score Display -->
                        @if($bestScore !== null)
                            <div class="mb-4 p-3 rounded-xl {{ $isPassed ? 'bg-green-50' : 'bg-orange-50' }}">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold {{ $isPassed ? 'text-green-700' : 'text-orange-700' }}">
                                        Skor Terbaik:
                                    </span>
                                    <span class="text-lg font-black {{ $isPassed ? 'text-green-700' : 'text-orange-700' }}">
                                        {{ number_format($bestScore, 0) }}%
                                    </span>
                                </div>
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <a href="{{ route('quizzes.show', $quiz->id) }}" class="flex-1 py-3 bg-gradient-to-r from-red-600 to-rose-600 text-white font-bold rounded-xl hover:shadow-lg hover:shadow-red-600/30 transition-all text-center text-sm">
                                {{ $bestScore !== null ? 'Coba Lagi' : 'Mulai Quiz' }}
                            </a>
                            
                            @if($bestScore !== null)
                                <a href="{{ route('quizzes.leaderboard', $quiz->id) }}" class="px-4 py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="text-slate-400 mb-4">
                        <svg class="w-24 h-24 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-700 mb-2">Belum Ada Quiz</h3>
                    <p class="text-slate-500">Quiz untuk kategori ini akan segera tersedia.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
