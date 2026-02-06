@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-white to-red-50/30 py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Results Header -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden mb-8">
            <!-- Score Banner -->
            <div class="p-8 text-center {{ $attempt->is_passed ? 'bg-gradient-to-r from-green-500 to-emerald-600' : 'bg-gradient-to-r from-orange-500 to-amber-600' }}">
                @if($attempt->is_passed)
                    <div class="text-6xl mb-2">🎉</div>
                    <h1 class="text-3xl font-black text-white mb-2">Selamat! Anda Lulus!</h1>
                    <p class="text-white/90">Quiz {{ $attempt->quiz->title }} berhasil diselesaikan</p>
                @else
                    <div class="text-6xl mb-2">📝</div>
                    <h1 class="text-3xl font-black text-white mb-2">Quiz Selesai</h1>
                    <p class="text-white/90">Terus berlatihuntuk hasil lebih baik!</p>
                @endif
            </div>

            <!-- Score Details -->
            <div class="p-8">
                <div class="grid md:grid-cols-3 gap-6 mb-8">
                    <div class="text-center">
                        <div class="text-5xl font-black {{ $attempt->is_passed ? 'text-green-600' : 'text-orange-600' }} mb-2">
                            {{ number_format($attempt->percentage, 0) }}%
                        </div>
                        <div class="text-slate-500 text-sm font-bold">Skor Anda</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-slate-700 mb-2">
                            {{ $attempt->score }}/{{ $attempt->max_score }}
                        </div>
                        <div class="text-slate-500 text-sm font-bold">Poin</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-black text-slate-700 mb-2">
                            {{ gmdate('i:s', $attempt->time_taken ?? 0) }}
                        </div>
                        <div class="text-slate-500 text-sm font-bold">Waktu</div>
                    </div>
                </div>

                <!-- Passing Score Indicator -->
                <div class="mb-8">
                    <div class="flex items-center justify-between text-sm mb-2">
                        <span class="font-bold text-slate-600">Nilai Lulus: {{ $attempt->quiz->passing_score }}%</span>
                        <span class="font-bold {{ $attempt->is_passed ? 'text-green-600' : 'text-orange-600' }}">
                            {{ $attempt->is_passed ? 'LULUS' : 'BELUM LULUS' }}
                        </span>
                    </div>
                    <div class="w-full bg-slate-200 rounded-full h-3 overflow-hidden">
                        <div class="{{ $attempt->is_passed ? 'bg-gradient-to-r from-green-500 to-emerald-600' : 'bg-gradient-to-r from-orange-500 to-amber-600' }} h-3 rounded-full transition-all duration-1000" 
                             style="width: {{ min($attempt->percentage, 100) }}%">
                        </div>
                    </div>
                </div>

                <!-- XP Earned -->
                <div class="bg-gradient-to-r from-purple-50 to-violet-50 rounded-xl p-4 text-center">
                    <div class="flex items-center justify-center gap-2 text-purple-700">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="text-2xl font-black">+{{ $attempt->is_passed ? '50' : '25' }} XP</span>
                    </div>
                    <p class="text-purple-600 text-xs font-bold mt-1">{{ $attempt->is_passed ? 'Lulus Quiz!' : 'Mencoba Quiz' }}</p>
                </div>
            </div>
        </div>

        <!-- Detailed Answers Review -->
        <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
            <h2 class="text-2xl font-black text-slate-900 mb-6">Review Jawaban</h2>
            
            @php
                $answers = $attempt->answers;
                $questions = $attempt->quiz->questions;
            @endphp

            @foreach($questions as $index => $question)
                @php
                    $userAnswer = $answers[$question->id] ?? null;
                    $isCorrect = false;
                    
                    if($question->question_type === 'multiple_choice' || $question->question_type === 'true_false') {
                        $isCorrect = $userAnswer === $question->correct_answer;
                    } elseif($question->question_type === 'fill_blank') {
                        $isCorrect = strtolower(trim($userAnswer)) === strtolower(trim($question->correct_answer));
                    }
                @endphp

                <div class="mb-6 pb-6 border-b border-slate-100 last:border-0">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-8 h-8 rounded-lg {{ $isCorrect ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }} font-black flex items-center justify-center text-sm">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-slate-900 mb-3">{{ $question->question_text }}</p>
                            
                            <!-- User Answer -->
                            <div class="mb-2">
                                <span class="text-xs font-bold text-slate-500">Jawaban Anda:</span>
                                <div class="mt-1 p-3 rounded-lg {{ $isCorrect ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                                    <span class="font-medium {{ $isCorrect ? 'text-green-700' : 'text-red-700' }}">
                                        @if($question->question_type === 'multiple_choice' && isset($question->options[$userAnswer]))
                                            {{ $userAnswer }}. {{ $question->options[$userAnswer] }}
                                        @elseif($question->question_type === 'true_false')
                                            {{ $userAnswer === 'true' ? 'Benar (True)' : 'Salah (False)' }}
                                        @else
                                            {{ $userAnswer ?? '(Tidak dijawab)' }}
                                        @endif
                                    </span>
                                    @if($isCorrect)
                                        <svg class="w-5 h-5 inline-block ml-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                            </div>

                            <!-- Correct Answer (if wrong) -->
                            @if(!$isCorrect)
                                <div class="mb-2">
                                    <span class="text-xs font-bold text-slate-500">Jawaban Benar:</span>
                                    <div class="mt-1 p-3 rounded-lg bg-blue-50 border border-blue-200">
                                        <span class="font-medium text-blue-700">
                                            @if($question->question_type === 'multiple_choice' && isset($question->options[$question->correct_answer]))
                                                {{ $question->correct_answer }}. {{ $question->options[$question->correct_answer] }}
                                            @elseif($question->question_type === 'true_false')
                                                {{ $question->correct_answer === 'true' ? 'Benar (True)' : 'Salah (False)' }}
                                            @else
                                                {{ $question->correct_answer }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            @endif

                            <!-- Explanation -->
                            @if($question->explanation)
                                <div class="mt-2">
                                    <div class="flex items-start gap-2 text-sm text-slate-600 bg-slate-50 p-3 rounded-lg">
                                        <svg class="w-5 h-5 flex-shrink-0 text-slate-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <span>{{ $question->explanation }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Actions -->
        <div class="flex gap-4">
            <a href="{{ route('quizzes.index') }}" class="flex-1 py-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold rounded-xl transition-all text-center">
                Kembali ke Daftar Quiz
            </a>
            <a href="{{ route('quizzes.show', $attempt->quiz_id) }}" class="flex-1 py-4 bg-gradient-to-r from-red-600 to-rose-600 text-white font-bold rounded-xl hover:shadow-xl hover:shadow-red-600/30 transition-all text-center">
                Coba Lagi
            </a>
            <a href="{{ route('quizzes.leaderboard', $attempt->quiz_id) }}" class="px-6 py-4 bg-purple-100 hover:bg-purple-200 text-purple-700 font-bold rounded-xl transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection
