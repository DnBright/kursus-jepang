<x-sensei-layout>
    <div class="space-y-8" x-data="{ showAddModal: false, questionType: 'multiple_choice' }">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-xs font-medium text-slate-500">
                        <li><a href="{{ route('sensei.quizzes.index') }}" class="hover:text-red-600">Quiz</a></li>
                        <li><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                        <li class="text-slate-900 font-bold">{{ $quiz->title }}</li>
                    </ol>
                </nav>
                <h2 class="text-2xl font-bold text-slate-900">Kelola Butir Soal</h2>
                <p class="text-slate-500 text-sm mt-1">Total: {{ $quiz->questions->count() }} Pertanyaan | Passing Score: {{ $quiz->passing_score }}%</p>
            </div>
            
            <button @click="showAddModal = true; questionType = 'multiple_choice'" class="px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 transition-all flex items-center gap-2 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Pertanyaan
            </button>
        </div>

        <!-- Questions List -->
        <div class="space-y-4">
            @forelse($quiz->questions as $index => $question)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden p-6 hover:border-red-200 transition-all">
                <div class="flex items-start justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3 mb-3">
                            <span class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-700 font-bold text-sm">#{{ $index + 1 }}</span>
                            <span class="px-2 py-0.5 bg-blue-50 text-blue-600 text-[10px] font-bold uppercase tracking-wider rounded border border-blue-100">
                                {{ str_replace('_', ' ', $question->question_type) }}
                            </span>
                             <span class="text-xs font-bold text-slate-400">{{ $question->points }} Point</span>
                        </div>
                        <p class="text-slate-800 font-medium text-lg mb-4">{{ $question->question_text }}</p>
                        
                        @if($question->question_type === 'multiple_choice' && is_array($question->options))
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            @foreach($question->options as $key => $option)
                            <div class="px-4 py-2 rounded-lg border {{ $question->correct_answer == $option ? 'bg-green-50 border-green-200 text-green-700 font-bold' : 'bg-slate-50 border-slate-100 text-slate-600' }} text-sm">
                                <span class="mr-2">{{ chr(65 + $loop->index) }}.</span> {{ $option }}
                            </div>
                            @endforeach
                        </div>
                        @elseif($question->question_type === 'essay')
                        <div class="px-4 py-3 rounded-xl border border-dashed border-slate-200 bg-slate-50 text-slate-500 text-sm italic">
                            Tipe soal essai (Jawaban teks bebas).
                        </div>
                        @else
                        <div class="px-4 py-2 rounded-lg border bg-green-50 border-green-200 text-green-700 font-bold text-sm">
                            Jawaban Benar: {{ $question->correct_answer }}
                        </div>
                        @endif
                    </div>

                    <form action="{{ route('sensei.quizzes.questions.destroy', [$quiz->id, $question->id]) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-all rounded-lg hover:bg-red-50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-12 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 text-2xl">❓</div>
                <h3 class="text-lg font-bold text-slate-900">Belum Ada Pertanyaan</h3>
                <p class="text-slate-500 max-w-xs mx-auto mt-1 mb-6">Mulai tambahkan pertanyaan pilihan ganda atau tipe lainnya ke quiz ini.</p>
                <button @click="showAddModal = true; questionType = 'multiple_choice'" class="px-6 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all text-sm">Tambah Pertanyaan Pertama</button>
            </div>
            @endforelse
        </div>

        <!-- Add Question Modal -->
        <div x-show="showAddModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div @click="showAddModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

                <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-slate-900">Tambah Pertanyaan</h3>
                        <button @click="showAddModal = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18"></path></svg>
                        </button>
                    </div>

                    <form action="{{ route('sensei.quizzes.questions.store', $quiz->id) }}" method="POST" class="p-6 space-y-4">
                        @csrf
                        
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Tipe Pertanyaan</label>
                            <select name="question_type" x-model="questionType" required
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium text-sm">
                                <option value="multiple_choice">Pilihan Ganda (Multiple Choice)</option>
                                <option value="essay">Essai (Free Text)</option>
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Teks Pertanyaan</label>
                            <textarea name="question_text" required rows="3" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium"
                                placeholder="Contoh: Jelaskan perbedaan antara Hiragana dan Katakana!"></textarea>
                        </div>

                        <!-- Multiple Choice Options -->
                        <div class="space-y-3" x-show="questionType === 'multiple_choice'">
                            <label class="text-sm font-bold text-slate-700 block">Pilihan Jawaban</label>
                            <div class="grid grid-cols-1 gap-3">
                                @foreach(['A', 'B', 'C', 'D'] as $letter)
                                <div class="flex items-center gap-3">
                                    <span class="font-bold text-slate-400">{{ $letter }}</span>
                                    <input type="text" name="options[]" :required="questionType === 'multiple_choice'" 
                                        class="flex-1 px-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500"
                                        placeholder="Pilihan {{ $letter }}">
                                    <input type="radio" name="correct_answer_radio" value="{{ $loop->index }}" {{ $loop->first ? 'checked' : '' }}
                                        class="w-4 h-4 text-red-600 focus:ring-red-500">
                                </div>
                                @endforeach
                            </div>
                            <p class="text-[10px] text-slate-500 font-medium">* Pilih salah satu sebagai jawaban benar menggunakan tombol radio.</p>
                        </div>

                        <!-- Essay Answer Reference -->
                        <div class="space-y-3" x-show="questionType === 'essay'">
                            <label class="text-sm font-bold text-slate-700">Referensi Jawaban (Kunci Jawaban)</label>
                            <textarea name="essay_correct_answer" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium text-sm"
                                placeholder="Masukkan contoh jawaban atau poin-poin penting yang harus ada..."></textarea>
                            <div class="p-4 bg-blue-50 border border-blue-100 rounded-2xl">
                                <div class="flex gap-3">
                                    <span class="text-xl">📝</span>
                                    <div>
                                        <h4 class="text-sm font-bold text-blue-900">Catatan</h4>
                                        <p class="text-xs text-blue-700 mt-0.5">Siswa akan menjawab dalam bentuk teks bebas. Referensi ini akan membantu Anda saat proses penilaian manual.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="correct_answer" id="correct_answer_input">

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700">Point</label>
                                <input type="number" name="points" value="10" min="1" required
                                    class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500">
                            </div>
                            <div class="space-y-2">
                                <label class="text-sm font-bold text-slate-700">Urutan (Optional)</label>
                                <input type="number" name="order" value="0"
                                    class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500">
                            </div>
                        </div>

                        <div class="pt-4 flex justify-end gap-3">
                            <button type="button" @click="showAddModal = false" class="px-6 py-2.5 text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">Batal</button>
                            <button type="submit" @click="syncCorrectAnswer()" class="px-8 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all text-sm shadow-lg shadow-red-600/20">Simpan Pertanyaan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function syncCorrectAnswer() {
            const questionType = document.querySelector('select[name=question_type]').value;
            if (questionType === 'multiple_choice') {
                const radios = document.getElementsByName('correct_answer_radio');
                const options = document.getElementsByName('options[]');
                for(let i=0; i<radios.length; i++) {
                    if(radios[i].checked) {
                        document.getElementById('correct_answer_input').value = options[i].value;
                        break;
                    }
                }
            } else if (questionType === 'essay') {
                document.getElementById('correct_answer_input').value = document.querySelector('textarea[name=essay_correct_answer]').value || 'ESSAY_REFERENCE';
            } else {
                document.getElementById('correct_answer_input').value = '';
            }
        }
    </script>
</x-sensei-layout>
