<x-sensei-layout>
    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex mb-2">
                    <ol class="inline-flex items-center space-x-1 text-xs font-bold uppercase tracking-widest text-slate-400">
                        <li><a href="{{ route('sensei.quizzes.index') }}?tab=nilai" class="hover:text-red-600 transition-colors">Nilai</a></li>
                        <li><span class="mx-1">›</span></li>
                        <li class="text-slate-600">Penilaian Manual</li>
                    </ol>
                </nav>
                <h2 class="text-2xl font-black text-slate-900">Penilaian <span class="text-red-600">{{ $attempt->quiz->title }}</span></h2>
                <p class="text-slate-500 text-sm mt-1">
                    Siswa: <span class="font-bold text-slate-800">{{ $attempt->user->name }}</span> •
                    Dikerjakan: <span class="font-bold">{{ $attempt->created_at->format('d M Y, H:i') }}</span>
                </p>
            </div>
            <div class="px-5 py-3 bg-orange-50 border border-orange-200 rounded-2xl text-center">
                <p class="text-xs font-black text-orange-500 uppercase tracking-widest">Status</p>
                <p class="text-lg font-black text-orange-700">⏳ Menunggu Penilaian</p>
            </div>
        </div>

        @if(session('success'))
        <div class="p-4 text-sm text-green-800 rounded-xl bg-green-50 border border-green-200">
            <span class="font-bold">✅ Berhasil!</span> {{ session('success') }}
        </div>
        @endif

        <!-- Student Answers -->
        <div class="space-y-5">
            <h3 class="text-sm font-black uppercase tracking-widest text-slate-500">Jawaban Siswa</h3>

            @php $answers = $attempt->answers ?? []; @endphp

            @forelse($attempt->quiz->questions as $index => $question)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <!-- Question -->
                <div class="p-6 border-b border-slate-100 bg-slate-50/50">
                    <div class="flex items-start gap-4">
                        <span class="w-8 h-8 rounded-lg bg-slate-200 flex items-center justify-center text-slate-700 font-black text-sm flex-shrink-0">
                            {{ $index + 1 }}
                        </span>
                        <div>
                            <span class="text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded
                                {{ $question->question_type === 'essay' ? 'bg-slate-100 text-slate-600' : 'bg-orange-100 text-orange-700' }}">
                                {{ $question->question_type === 'essay' ? 'Essai' : 'Tulis Tangan' }}
                            </span>
                            <p class="text-slate-800 font-bold text-base mt-2">{{ $question->question_text }}</p>
                            <p class="text-xs text-slate-400 mt-1 font-bold uppercase tracking-widest">Poin Maksimal: {{ $question->points }}</p>
                        </div>
                    </div>
                </div>

                <!-- Student Answer -->
                <div class="p-6">
                    @php
                        $studentAnswer = null;
                        foreach ($answers as $ans) {
                            if ((isset($ans['question_id']) && $ans['question_id'] == $question->id) ||
                                (isset($ans['id']) && $ans['id'] == $question->id)) {
                                $studentAnswer = $ans['answer'] ?? $ans['student_answer'] ?? null;
                                break;
                            }
                        }
                        // Fallback: try index-based
                        if (!$studentAnswer && isset($answers[$index])) {
                            $studentAnswer = $answers[$index]['answer'] ?? $answers[$index]['student_answer'] ?? null;
                        }
                    @endphp

                    <label class="text-xs font-black uppercase tracking-widest text-slate-400 block mb-3">Jawaban Siswa:</label>
                    @if($studentAnswer)
                        <div class="px-4 py-4 bg-blue-50 border border-blue-100 rounded-xl text-slate-800 text-sm leading-relaxed whitespace-pre-wrap font-medium">
                            {{ $studentAnswer }}
                        </div>
                    @else
                        <div class="px-4 py-4 bg-slate-50 border border-dashed border-slate-200 rounded-xl text-slate-400 text-sm italic text-center">
                            Siswa tidak memberikan jawaban untuk soal ini.
                        </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="bg-slate-50 border border-dashed border-slate-200 rounded-2xl p-12 text-center text-slate-400">
                Tidak ada soal yang ditemukan untuk kuis ini.
            </div>
            @endforelse
        </div>

        <!-- Grading Form -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-8">
            <h3 class="text-lg font-black text-slate-900 mb-2">Berikan Nilai</h3>
            <p class="text-sm text-slate-500 mb-6">Nilai maksimal untuk kuis ini adalah <span class="font-bold text-slate-800">{{ $attempt->max_score ?? $attempt->quiz->questions->sum('points') }}</span> poin.</p>

            <form action="{{ route('sensei.quizzes.grading.submit', $attempt->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="flex flex-col sm:flex-row gap-6 items-start">
                    <div class="flex-1 space-y-2">
                        <label class="text-sm font-black text-slate-700 uppercase tracking-wider">Skor Akhir <span class="text-red-500">*</span></label>
                        <input type="number" name="score" required
                            min="0" max="{{ $attempt->max_score ?? $attempt->quiz->questions->sum('points') }}"
                            placeholder="Contoh: 85"
                            class="w-full px-5 py-4 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 text-2xl font-black text-center transition-all">
                        <p class="text-xs text-slate-400">Dari 0 s/d {{ $attempt->max_score ?? $attempt->quiz->questions->sum('points') }}</p>
                    </div>

                    <div class="sm:pt-8">
                        <button type="submit" class="px-10 py-4 bg-red-600 text-white font-black rounded-2xl shadow-xl shadow-red-600/25 hover:bg-red-700 hover:shadow-red-600/40 transition-all text-sm uppercase tracking-widest">
                            Simpan Nilai
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-sensei-layout>
