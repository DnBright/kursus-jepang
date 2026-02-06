@extends('layouts.app')

@section('content')
<!-- Dashboard Content -->
<div class="py-12 bg-gradient-to-br from-slate-50 via-white to-red-50/30 min-h-screen">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Welcome Section -->
        <div class="mb-8 flex flex-col md:flex-row justify-between items-end gap-4">
            <div>
                <h1 class="text-4xl font-black text-slate-900">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                <p class="text-slate-600 mt-2 text-lg">Siap melanjutkan pembelajaran hari ini?</p>
            </div>
            <div class="text-right hidden md:block">
                <p class="text-sm text-slate-500 font-medium">{{ date('l, d F Y') }}</p>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total XP -->
            <div class="bg-gradient-to-br from-purple-500 to-violet-600 p-6 rounded-2xl shadow-lg text-white">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-purple-100">Total XP</p>
                    <div class="text-3xl">⭐</div>
                </div>
                <h3 class="text-5xl font-black mb-2">{{ number_format($totalXP) }}</h3>
                <p class="text-xs text-purple-100">Keep learning to earn more!</p>
            </div>
            
            <!-- Lessons Completed -->
            <div class="bg-gradient-to-br from-green-500 to-emerald-600 p-6 rounded-2xl shadow-lg text-white">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-green-100">Lessons Completed</p>
                    <div class="text-3xl">📚</div>
                </div>
                <h3 class="text-5xl font-black mb-2">{{ $completedLessons }}</h3>
                <p class="text-xs text-green-100">Great progress!</p>
            </div>

            <!-- Achievements -->
            <div class="bg-gradient-to-br from-orange-500 to-amber-600 p-6 rounded-2xl shadow-lg text-white">
                <div class="flex items-center justify-between mb-2">
                    <p class="text-sm font-medium text-orange-100">Achievements Earned</p>
                    <div class="text-3xl">🏆</div>
                </div>
                <h3 class="text-5xl font-black mb-2">{{ $achievements->count() }}</h3>
                <p class="text-xs text-orange-100">Unlock more badges!</p>
            </div>
        </div>

        <!-- Recent Achievements -->
        @if($achievements->count() > 0)
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8">
            <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                <span>🎖️</span> Recent Achievements
            </h3>
            <div class="grid md:grid-cols-3 gap-4">
                @foreach($achievements as $achievement)
                    <div class="flex items-center gap-3 p-4 rounded-xl bg-gradient-to-r from-yellow-50 to-amber-50 border border-yellow-200">
                        <div class="text-3xl">{{ $achievement->icon }}</div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">{{ $achievement->title }}</p>
                            <p class="text-xs text-slate-600">{{ $achievement->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Quick Actions Grid -->
        <div class="grid md:grid-cols-2 gap-6 mb-8">
            <!-- Upcoming Quizzes -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-blue-50 to-indigo-50">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <span>📝</span> Quiz Tersedia
                    </h3>
                </div>
                <div class="p-6">
                    @forelse($upcomingQuizzes as $quiz)
                        <a href="{{ route('quizzes.show', $quiz->id) }}" class="block mb-3 p-4 rounded-xl border-2 border-slate-100 hover:border-red-300 hover:bg-red-50/50 transition-all group">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="font-bold text-slate-900 group-hover:text-red-600 transition-colors">{{ $quiz->title }}</p>
                                    <p class="text-xs text-slate-500 mt-1">{{ $quiz->questions_count ?? 0 }} soal • {{ $quiz->time_limit }} menit</p>
                                </div>
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </div>
                        </a>
                    @empty
                        <p class="text-slate-500 text-sm text-center py-8">Tidak ada quiz tersedia saat ini</p>
                    @endforelse
                    
                    <a href="{{ route('quizzes.index') }}" class="block mt-4 text-center py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-all">
                        Lihat Semua Quiz →
                    </a>
                </div>
            </div>

            <!-- Pending Assignments -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100 bg-gradient-to-r from-orange-50 to-red-50">
                    <h3 class="text-lg font-bold text-slate-900 flex items-center gap-2">
                        <span>📋</span> Assignment Mendatang
                    </h3>
                </div>
                <div class="p-6">
                    @forelse($pendingAssignments as $assignment)
                        <a href="{{ route('assignments.show', $assignment->id) }}" class="block mb-3 p-4 rounded-xl border-2 border-slate-100 hover:border-orange-300 hover:bg-orange-50/50 transition-all group">
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="font-bold text-slate-900 group-hover:text-orange-600 transition-colors">{{ $assignment->title }}</p>
                                    <p class="text-xs text-slate-500 mt-1">Deadline: {{ $assignment->due_date->format('d M Y') }}</p>
                                </div>
                                @if($assignment->is_required)
                                    <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded">Required</span>
                                @endif
                            </div>
                        </a>
                    @empty
                        <p class="text-slate-500 text-sm text-center py-8">Semua assignment sudah dikumpulkan! 🎉</p>
                    @endforelse
                    
                    <a href="{{ route('assignments.index') }}" class="block mt-4 text-center py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-all">
                        Lihat Semua Assignment →
                    </a>
                </div>
            </div>
        </div>

        <!-- Continue Learning -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
            <h3 class="text-lg font-bold text-slate-900 mb-6 flex items-center gap-2">
                <span>🚀</span> Lanjutkan Belajar
            </h3>
            
            <div class="grid md:grid-cols-4 gap-4">
                <a href="{{ route('my-courses') }}" class="p-6 rounded-xl bg-gradient-to-br from-red-50 to-rose-100 border-2 border-red-200 hover:shadow-lg transition-all group text-center">
                    <div class="text-4xl mb-3">📖</div>
                    <p class="font-bold text-slate-900 group-hover:text-red-600 transition-colors">My Courses</p>
                </a>
                
                <a href="{{ route('quizzes.index') }}" class="p-6 rounded-xl bg-gradient-to-br from-blue-50 to-indigo-100 border-2 border-blue-200 hover:shadow-lg transition-all group text-center">
                    <div class="text-4xl mb-3">📝</div>
                    <p class="font-bold text-slate-900 group-hover:text-blue-600 transition-colors">Practice Quizzes</p>
                </a>
                
                <a href="{{ route('materials.index') }}" class="p-6 rounded-xl bg-gradient-to-br from-green-50 to-emerald-100 border-2 border-green-200 hover:shadow-lg transition-all group text-center">
                    <div class="text-4xl mb-3">📚</div>
                    <p class="font-bold text-slate-900 group-hover:text-green-600 transition-colors">Study Materials</p>
                </a>
                
                <a href="{{ route('live-class') }}" class="p-6 rounded-xl bg-gradient-to-br from-purple-50 to-violet-100 border-2 border-purple-200 hover:shadow-lg transition-all group text-center">
                    <div class="text-4xl mb-3">🎥</div>
                    <p class="font-bold text-slate-900 group-hover:text-purple-600 transition-colors">Live Classes</p>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
