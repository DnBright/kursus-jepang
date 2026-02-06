@extends('layouts.app')

@section('content')
<div x-data="{
    answers: {},
    timeStarted: Date.now(),
    submitted: false,
    submitQuiz() {
        if (!this.submitted && confirm('Yakin ingin mengumpulkan quiz?')) {
            this.submitted = true;
            const timeTaken = Math.floor((Date.now() - this.timeStarted) / 1000);
            document.getElementById('time_taken').value = timeTaken;
            document.getElementById('quiz-form').submit();
        }
    }
}" class="min-h-screen bg-slate-50 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-2xl shadow-lg p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-3xl font-black text-slate-900 mb-2">{{ $quiz->title }}</h1>
                    <p class="text-slate-600">{{ $quiz->description }}</p>
                </div>
                @if($quiz->time_limit)
                    <div class="text-center">
                        <div class="text-3xl font-black text-red-600">{{ $quiz->time_limit }}</div>
                        <div class="text-xs text-slate-500 font-bold">MENIT</div>
                    </div>
                @endif
            </div>

            <div class="flex gap-4 text-sm">
                <div class="flex items-center gap-2 text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-bold">{{ $quiz->questions->count() }} Soal</span>
                </div>
                <div class="flex items-center gap-2 text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    <span class="font-bold">Total {{ $totalPoints }} Poin</span>
                </div>
                <div class="flex items-center gap-2 text-slate-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="font-bold">Pass: {{ $quiz->passing_score }}%</span>
                </div>
            </div>
        </div>

        <!-- Quiz Form -->
        <form id="quiz-form" method="POST" action="{{ route('quizzes.submit', $quiz->id) }}">
            @csrf
            <input type="hidden" name="time_taken" id="time_taken" value="0">

            @foreach($quiz->questions as $index => $question)
                <div class="bg-white rounded-2xl shadow-lg p-6 mb-4">
                    <!-- Question Number & Text -->
                    <div class="flex gap-4 mb-4">
                        <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-red-100 text-red-600 font-black flex items-center justify-center">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1">
                            <p class="text-lg font-bold text-slate-900 mb-2">{{ $question->question_text }}</p>
                            <span class="text-xs text-slate-500 font-bold">{{ $question->points }} poin</span>
                        </div>
                    </div>

                    <!-- Answer Options -->
                    <div class="ml-14">
                        @if($question->question_type === 'multiple_choice')
                            <div class="space-y-2">
                                @foreach($question->options as $optionKey => $optionValue)
                                    <label class="flex items-center gap-3 p-4 rounded-xl border-2 border-slate-200 hover:border-red-300 hover:bg-red-50/50 cursor-pointer transition-all group">
                                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $optionKey }}" x-model="answers[{{ $question->id }}]" class="w-5 h-5 text-red-600 focus:ring-red-500">
                                        <span class="text-slate-700 font-medium group-hover:text-slate-900">{{ $optionValue }}</span>
                                    </label>
                                @endforeach
                            </div>

                        @elseif($question->question_type === 'true_false')
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 p-4 rounded-xl border-2 border-slate-200 hover:border-red-300 hover:bg-red-50/50 cursor-pointer transition-all">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="true" x-model="answers[{{ $question->id }}]" class="w-5 h-5 text-red-600">
                                    <span class="text-slate-700 font-medium">Benar (True)</span>
                                </label>
                                <label class="flex items-center gap-3 p-4 rounded-xl border-2 border-slate-200 hover:border-red-300 hover:bg-red-50/50 cursor-pointer transition-all">
                                    <input type="radio" name="answers[{{ $question->id }}]" value="false" x-model="answers[{{ $question->id }}]" class="w-5 h-5 text-red-600">
                                    <span class="text-slate-700 font-medium">Salah (False)</span>
                                </label>
                            </div>

                        @elseif($question->question_type === 'fill_blank')
                            <input type="text" name="answers[{{ $question->id }}]" x-model="answers[{{ $question->id }}]" class="w-full p-4 border-2 border-slate-200 rounded-xl focus:border-red-500 focus:ring-4 focus:ring-red-100 font-medium" placeholder="Ketik jawaban Anda...">
                        @endif
                    </div>
                </div>
            @endforeach

            <!-- Submit Button -->
            <div class="sticky bottom-6 bg-white rounded-2xl shadow-2xl p-6">
                <div class="flex items-center justify-between max-w-4xl mx-auto">
                    <a href="{{ route('quizzes.index') }}" class="px-6 py-3 text-slate-600 font-bold hover:bg-slate-100 rounded-xl transition-all">
                        Batal
                    </a>
                    <button type="button" @click="submitQuiz()" class="px-8 py-4 bg-gradient-to-r from-red-600 to-rose-600 text-white font-black rounded-xl hover:shadow-xl hover:shadow-red-600/30 transition-all text-lg">
                        Kumpulkan Quiz
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
