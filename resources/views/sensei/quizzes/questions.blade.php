<x-sensei-layout>
    <div class="max-w-4xl mx-auto py-8 px-4" x-data="{ 
        questions: @js($quiz->questions->map(function($q) use ($quiz) {
            $correct_answer = $q->correct_answer;
            if ($quiz->question_type !== 'multiple_choice' && empty($correct_answer)) {
                $correct_answer = 'MANUAL_GRADING';
            }
            return [
                'id' => $q->id,
                'question_text' => $q->question_text,
                'options' => $q->options ?? ['', '', '', ''],
                'correct_answer' => $correct_answer,
                'points' => $q->points,
                'order' => $q->order,
                'correctIndex' => ($q->options && $quiz->question_type === 'multiple_choice') ? array_search($q->correct_answer, $q->options) : -1
            ];
        })),
        isSaving: false,
        addQuestion() {
            const isMC = @js($quiz->question_type === 'multiple_choice');
            this.questions.push({
                id: null,
                question_text: '',
                options: isMC ? ['', '', '', ''] : null,
                correct_answer: isMC ? '' : 'MANUAL_GRADING',
                points: 10,
                order: this.questions.length + 1,
                correctIndex: -1
            });
            this.$nextTick(() => {
                window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
            });
        },
        removeQuestion(index) {
            if(confirm('Hapus soal ini?')) {
                this.questions.splice(index, 1);
            }
        },
        addOption(qIndex) {
            this.questions[qIndex].options.push('');
        },
        removeOption(qIndex, oIndex) {
            if (this.questions[qIndex].options.length <= 2) {
                alert('Minimal harus ada 2 pilihan jawaban.');
                return;
            }
            this.questions[qIndex].options.splice(oIndex, 1);
            if (this.questions[qIndex].correctIndex === oIndex) {
                this.questions[qIndex].correctIndex = -1;
                this.questions[qIndex].correct_answer = '';
            } else if (this.questions[qIndex].correctIndex > oIndex) {
                this.questions[qIndex].correctIndex--;
            }
        },
        setCorrect(qIndex, oIndex) {
            this.questions[qIndex].correctIndex = oIndex;
            this.questions[qIndex].correct_answer = this.questions[qIndex].options[oIndex];
        },
        async saveAll() {
            const isMC = @js($quiz->question_type === 'multiple_choice');
            // Validation
            for (let i = 0; i < this.questions.length; i++) {
                if (!this.questions[i].question_text.trim()) {
                    alert(`Soal #${i+1} belum memiliki teks pertanyaan.`);
                    return;
                }
                if (isMC && (this.questions[i].correctIndex === -1 || !this.questions[i].correct_answer)) {
                    alert(`Soal #${i+1} belum memilih jawaban yang benar.`);
                    return;
                }
            }

            this.isSaving = true;
            try {
                const response = await fetch('{{ route('sensei.quizzes.questions.batch', $quiz->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ questions: this.questions })
                });
                
                const result = await response.json();
                if (result.success) {
                    window.location.reload();
                } else {
                    alert('Error: ' + (result.message || 'Gagal menyimpan.'));
                }
            } catch (e) {
                console.error(e);
                alert('Terjadi kesalahan saat menyimpan data.');
            } finally {
                this.isSaving = false;
            }
        }
    }">
        <!-- Header Sticky -->
        <div class="sticky top-0 z-30 bg-slate-50/80 backdrop-blur-md pb-6 border-b border-slate-200 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <nav class="flex mb-1" aria-label="Breadcrumb">
                        <ol class="flex items-center space-x-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                            <li><a href="{{ route('sensei.quizzes.index') }}" class="hover:text-red-600">Quiz</a></li>
                            <li><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg></li>
                            <li class="text-slate-600">{{ $quiz->title }}</li>
                        </ol>
                    </nav>
                    <h2 class="text-2xl font-black text-slate-900 tracking-tight">Penyusun Soal</h2>
                </div>
                
                <div class="flex items-center gap-3">
                    <button @click="saveAll()" :disabled="isSaving"
                        class="px-6 py-2.5 bg-red-600 text-white font-black text-xs uppercase tracking-widest rounded-xl shadow-xl shadow-red-600/20 hover:bg-red-700 transition-all disabled:opacity-50 flex items-center gap-2">
                        <template x-if="isSaving">
                            <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </template>
                        <template x-if="!isSaving">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        </template>
                        <span x-text="isSaving ? 'Menyimpan...' : 'Simpan Semua'"></span>
                    </button>
                </div>
            </div>
        </div>

        <div class="space-y-8">
            <template x-for="(question, qIndex) in questions" :key="qIndex">
                <div class="bg-white rounded-3xl border-2 border-slate-200 shadow-sm overflow-hidden group focus-within:border-red-500 transition-all">
                    <!-- Card Toolbar -->
                    <div class="px-6 py-3 bg-slate-50 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-black text-slate-400" x-text="'PERTANYAAN #' + (qIndex + 1)"></span>
                            <span class="px-2 py-0.5 bg-red-50 text-red-600 text-[10px] font-black uppercase tracking-widest rounded border border-red-100">
                                {{ str_replace('_', ' ', $quiz->question_type ?? 'multiple_choice') }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="flex items-center gap-2 text-xs font-bold text-slate-500 mr-4">
                                <span>Point:</span>
                                <input type="number" x-model="questions[qIndex].points" class="w-16 px-2 py-1 bg-white border border-slate-200 rounded-lg text-center focus:ring-2 focus:ring-red-500 outline-none">
                            </div>
                            <button @click="removeQuestion(qIndex)" class="p-2 text-slate-300 hover:text-red-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="p-8 space-y-6">
                        <!-- Question Textarea -->
                        <div class="space-y-2">
                            <textarea x-model="questions[qIndex].question_text" 
                                class="w-full text-xl font-bold text-slate-900 border-none bg-slate-50 focus:bg-white rounded-2xl p-4 focus:ring-2 focus:ring-red-500 transition-all min-h-[100px] outline-none" 
                                placeholder="Tuliskan pertanyaan di sini..."></textarea>
                        </div>

                        <!-- Options Section -->
                        <template x-if="'{{ $quiz->question_type }}' === 'multiple_choice'">
                            <div class="space-y-4 pl-4 border-l-4 border-slate-100">
                                <template x-for="(option, oIndex) in questions[qIndex].options" :key="oIndex">
                                    <div class="flex items-center gap-4 group/option">
                                        <div class="flex-shrink-0">
                                            <button @click="setCorrect(qIndex, oIndex)" 
                                                class="w-6 h-6 rounded-full border-2 flex items-center justify-center transition-all"
                                                :class="questions[qIndex].correctIndex === oIndex ? 'bg-green-500 border-green-500 text-white' : 'bg-white border-slate-200 text-transparent hover:border-green-300'">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            </button>
                                        </div>
                                        <div class="flex-1 relative">
                                            <input type="text" x-model="questions[qIndex].options[oIndex]" 
                                                @input="if(questions[qIndex].correctIndex === oIndex) questions[qIndex].correct_answer = $event.target.value"
                                                class="w-full bg-white border-b-2 border-slate-100 focus:border-red-500 py-2 text-slate-700 font-medium transition-all outline-none" 
                                                :placeholder="'Pilihan ' + String.fromCharCode(65 + oIndex)">
                                        </div>
                                        <button @click="removeOption(qIndex, oIndex)" class="opacity-0 group-hover/option:opacity-100 text-slate-300 hover:text-red-500 transition-all p-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                </template>
                                
                                <button @click="addOption(qIndex)" class="flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-red-500 transition-colors pl-10 mt-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                    Tambah Pilihan
                                </button>
                            </div>
                        </template>

                        <!-- Non-MC placeholders -->
                        <template x-if="'{{ $quiz->question_type }}' !== 'multiple_choice'">
                             <div class="px-6 py-4 bg-blue-50 text-blue-600 rounded-2xl border border-blue-100 text-sm font-medium italic flex items-center gap-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Jawaban untuk tipe soal ini akan dinilai secara manual oleh Sensei.
                                <input type="hidden" x-model="questions[qIndex].correct_answer" x-init="questions[qIndex].correct_answer = 'MANUAL_GRADING'">
                             </div>
                        </template>
                    </div>
                </div>
            </template>

            <!-- Add Question Button -->
            <button @click="addQuestion()" class="w-full py-8 border-2 border-dashed border-slate-200 rounded-3xl text-slate-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50/30 transition-all flex flex-col items-center justify-center gap-2 group">
                <div class="w-12 h-12 rounded-full bg-slate-50 flex items-center justify-center group-hover:bg-red-100 group-hover:scale-110 transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <span class="font-black text-xs uppercase tracking-widest">Tambah Pertanyaan Baru</span>
            </button>
        </div>

        <!-- Float FAB for Save on Mobile -->
        <div class="fixed bottom-8 right-8 lg:hidden z-40">
             <button @click="saveAll()" :disabled="isSaving"
                class="w-16 h-16 bg-red-600 text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all">
                 <svg x-show="!isSaving" class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                 <svg x-show="isSaving" class="animate-spin h-8 w-8 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
             </button>
        </div>
    </div>
</x-sensei-layout>
