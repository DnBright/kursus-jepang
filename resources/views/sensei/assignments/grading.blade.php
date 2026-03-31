<x-sensei-layout>
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-xs font-medium text-slate-500">
                        <li><a href="{{ route('sensei.quizzes.index') }}" class="hover:text-red-600">Quiz & Penilaian</a></li>
                        <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                        <li class="text-slate-900 font-bold">Beri Nilai</li>
                    </ol>
                </nav>
                <h2 class="text-2xl font-bold text-slate-900">{{ $assignment->title }}</h2>
                <p class="text-slate-500 text-sm mt-1">Total Submisi: {{ $assignment->submissions->count() }} | Skor Maksimal: {{ $assignment->max_score }}</p>
            </div>
            <a href="{{ route('sensei.quizzes.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">Kembali</a>
        </div>

        <!-- Submissions List -->
        <div class="grid grid-cols-1 gap-6">
            @forelse($assignment->submissions as $submission)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden" x-data="{ isGrading: false }">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between items-start gap-6">
                        <!-- Student Info & Content -->
                        <div class="flex-1 space-y-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center font-bold text-red-600">
                                    {{ substr($submission->user->name, 0, 2) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900">{{ $submission->user->name }}</h4>
                                    <p class="text-xs text-slate-500">Dikumpulkan pada {{ $submission->submitted_at->format('d M Y, H:i') }}</p>
                                </div>
                                @if($submission->status === 'graded')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Sudah Dinilai ({{ $submission->score }}/{{ $assignment->max_score }})</span>
                                @else
                                <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-xs font-bold animate-pulse">Perlu Dinilai</span>
                                @endif
                            </div>

                            <div class="p-5 bg-slate-50 rounded-xl border border-slate-100 text-slate-700 leading-relaxed italic">
                                "{!! nl2br(e($submission->content)) !!}"
                            </div>
                            
                            @if($submission->file_path)
                            <a href="{{ Storage::url($submission->file_path) }}" target="_blank" class="flex items-center gap-2 text-sm font-bold text-red-600 hover:underline">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                Lihat File Lampiran
                            </a>
                            @endif
                        </div>

                        <!-- Grading Form -->
                        <div class="w-full md:w-80">
                            <button x-show="!isGrading" @click="isGrading = true" 
                                class="w-full px-6 py-3 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all text-sm">
                                {{ $submission->status === 'graded' ? 'Ubah Nilai' : 'Beri Nilai Sekarang' }}
                            </button>

                            <form x-show="isGrading" action="{{ route('sensei.assignments.submit-grade', $submission->id) }}" method="POST" class="space-y-4" style="display: none;">
                                @csrf
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700">Skor (Max: {{ $assignment->max_score }})</label>
                                    <input type="number" name="score" value="{{ $submission->score ?? 0 }}" max="{{ $assignment->max_score }}" min="0" required
                                        class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-sm font-bold text-slate-700">Feedback / Masukan</label>
                                    <textarea name="feedback" rows="3" 
                                        class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500"
                                        placeholder="Kerja bagus! Perhatikan tata bahasa..."></textarea>
                                </div>
                                <div class="flex gap-2">
                                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white font-bold rounded-lg hover:bg-red-700 text-xs">Simpan</button>
                                    <button type="button" @click="isGrading = false" class="px-4 py-2 bg-slate-100 text-slate-600 font-bold rounded-lg hover:bg-slate-200 text-xs">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-20 bg-white rounded-3xl border border-slate-200 border-dashed">
                <p class="text-slate-500">Belum ada siswa yang mengumpulkan tugas ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</x-sensei-layout>
