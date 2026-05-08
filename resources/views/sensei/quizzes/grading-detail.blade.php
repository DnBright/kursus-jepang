<x-sensei-layout>
    <div class="max-w-4xl mx-auto py-8 px-4">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <li><a href="{{ route('sensei.quizzes.grading.index') }}" class="hover:text-red-600">Penilaian</a></li>
                        <li><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                        <li class="text-slate-600">Detail Review</li>
                    </ol>
                </nav>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Review Jawaban</h2>
                <div class="flex items-center gap-3 mt-2">
                    <span class="text-sm font-bold text-slate-500">{{ $attempt->user->name }}</span>
                    <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                    <span class="text-sm font-bold text-slate-500">{{ $attempt->quiz->title }}</span>
                </div>
            </div>

            @if($attempt->status !== 'needs_grading')
                <div class="bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm text-center">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Skor</p>
                    <p class="text-3xl font-black {{ $attempt->is_passed ? 'text-green-600' : 'text-red-600' }}">
                        {{ round($attempt->score) }}<span class="text-sm text-slate-300 font-bold">/{{ $attempt->max_score }}</span>
                    </p>
                </div>
            @endif
        </div>

        <form action="{{ route('sensei.quizzes.grading.submit', $attempt->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-8">
                @foreach($attempt->quiz->questions as $index => $question)
                    @php
                        $studentAnswer = $attempt->answers[$question->id] ?? null;
                        $isCorrect = ($question->question_type === 'multiple_choice' && $studentAnswer === $question->correct_answer);
                        $isManual = in_array($question->question_type, ['essay', 'handwriting']);
                    @endphp
                    
                    <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
                        <div class="px-6 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Pertanyaan #{{ $index + 1 }}</span>
                            <div class="flex items-center gap-3">
                                @if(!$isManual)
                                    @if($isCorrect)
                                        <span class="px-2 py-0.5 bg-green-50 text-green-600 text-[10px] font-black rounded uppercase tracking-widest border border-green-100">Benar</span>
                                    @else
                                        <span class="px-2 py-0.5 bg-red-50 text-red-600 text-[10px] font-black rounded uppercase tracking-widest border border-red-100">Salah</span>
                                    @endif
                                @endif
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Maks: {{ $question->points }} Point</span>
                            </div>
                        </div>
                        
                        <div class="p-8">
                            <p class="text-lg font-bold text-slate-800 mb-6">{{ $question->question_text }}</p>
                            
                            @if($question->question_type === 'multiple_choice')
                                <input type="hidden" name="grades[{{ $question->id }}]" value="{{ $isCorrect ? $question->points : 0 }}">
                                <div class="grid grid-cols-1 gap-3">
                                    @foreach($question->options as $option)
                                        <div class="flex items-center gap-4 p-4 rounded-xl border-2 transition-all {{ $studentAnswer === $option ? ($isCorrect ? 'border-green-500 bg-green-50' : 'border-red-500 bg-red-50') : ($option === $question->correct_answer ? 'border-green-200 bg-green-50/30' : 'border-slate-100 bg-white') }}">
                                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0 {{ $studentAnswer === $option ? ($isCorrect ? 'bg-green-500 border-green-500 text-white' : 'bg-red-500 border-red-500 text-white') : ($option === $question->correct_answer ? 'bg-green-200 border-green-200 text-white' : 'bg-white border-slate-200') }}">
                                                @if($studentAnswer === $option || $option === $question->correct_answer)
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                @endif
                                            </div>
                                            <span class="font-medium {{ $studentAnswer === $option ? 'text-slate-900' : 'text-slate-500' }}">{{ $option }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="space-y-4">
                                    <div class="p-6 bg-slate-900 rounded-2xl shadow-inner border border-white/10">
                                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-3">Jawaban Siswa:</p>
                                        <p class="text-white font-medium whitespace-pre-wrap leading-relaxed">{{ $studentAnswer ?: '(Siswa tidak menjawab)' }}</p>
                                    </div>
                                    
                                    <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
                                        <div class="flex-1">
                                            <p class="text-xs font-bold text-slate-500 mb-2">Berikan Nilai (0 - {{ $question->points }}):</p>
                                            <div class="flex items-center gap-3">
                                                <input type="number" name="grades[{{ $question->id }}]" 
                                                       value="{{ $attempt->status === 'completed' ? ($isCorrect ? $question->points : 0) : '' }}"
                                                       max="{{ $question->points }}" min="0" step="1" required
                                                       class="w-32 px-4 py-3 bg-white border-2 border-slate-200 rounded-xl focus:border-red-500 focus:ring-4 focus:ring-red-500/10 outline-none font-black text-xl text-center transition-all"
                                                       placeholder="0">
                                                <span class="text-slate-400 font-bold uppercase tracking-widest text-[10px]">Dari {{ $question->points }} Point</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12 flex items-center justify-between p-8 bg-slate-900 rounded-3xl shadow-2xl shadow-slate-900/20">
                <div class="text-white">
                    <h3 class="text-xl font-black tracking-tight">Simpan Penilaian</h3>
                    <p class="text-slate-400 text-xs font-medium mt-1">Pastikan semua jawaban essay telah dinilai dengan benar.</p>
                </div>
                <button type="submit" class="px-8 py-4 bg-red-600 text-white font-black text-xs uppercase tracking-[0.2em] rounded-2xl hover:bg-red-700 hover:-translate-y-1 active:translate-y-0 transition-all shadow-xl shadow-red-600/30">
                    Kirim Penilaian
                </button>
            </div>
        </form>
    </div>
</x-sensei-layout>
