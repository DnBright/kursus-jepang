<x-sensei-layout>
    <div class="space-y-8" x-data="{ 
        showAddModal: false, 
        showEditModal: false,
        questionType: 'multiple_choice',
        newQuestion: { question_text: '', points: 10, options: ['', '', '', ''], correct_answer: '', correctIndex: -1, order: 0 },
        editQuestion: { id: '', question_text: '', question_type: 'multiple_choice', points: 10, options: ['', '', '', ''], correct_answer: '', correctIndex: -1, order: 0 },
        init() {
            const urlParams = new URLSearchParams(window.location.search);
            const defType = urlParams.get('default_type');
            if (defType && ['multiple_choice', 'essay', 'handwriting'].includes(defType)) {
                this.questionType = defType;
                this.showAddModal = true;
            }
        },
        openEdit(question) {
            this.editQuestion = JSON.parse(JSON.stringify(question));
            this.questionType = question.question_type;
            if (question.question_type === 'multiple_choice' && Array.isArray(question.options)) {
                this.editQuestion.correctIndex = question.options.indexOf(question.correct_answer);
            }
            this.showEditModal = true;
        },
        resetNewQuestion() {
            this.newQuestion = { question_text: '', points: 10, options: ['', '', '', ''], correct_answer: '', correctIndex: -1, order: 0 };
        }
    }">
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
            
            <div class="flex items-center gap-2">
                <button @click="showAddModal = true; questionType = 'multiple_choice'" class="px-4 py-2 bg-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-600/20 hover:bg-green-700 transition-all flex items-center gap-2 text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    + Pilihan Ganda
                </button>
                <button @click="showAddModal = true; questionType = 'essay'" class="px-4 py-2 bg-slate-700 text-white font-bold rounded-xl shadow-lg shadow-slate-700/20 hover:bg-slate-800 transition-all flex items-center gap-2 text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    + Essai
                </button>
                <button @click="showAddModal = true; questionType = 'handwriting'" class="px-4 py-2 bg-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-600/20 hover:bg-orange-700 transition-all flex items-center gap-2 text-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    + Tulis Tangan
                </button>
            </div>
        </div>

        <!-- Questions List -->
        <div class="space-y-4 text-left">
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
                        <div class="px-4 py-3 rounded-xl border border-dashed border-slate-200 bg-slate-50 text-slate-700 text-sm">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Referensi Jawaban:</p>
                            {{ $question->correct_answer ?: '-' }}
                        </div>
                        @elseif($question->question_type === 'handwriting')
                        <div class="px-4 py-3 rounded-xl border border-dashed border-orange-200 bg-orange-50 text-orange-700 text-sm text-center">
                            <p class="text-[10px] font-black text-orange-400 uppercase tracking-widest mb-2">Target Tulisan:</p>
                            <span class="text-2xl font-bold">{{ $question->correct_answer ?: '-' }}</span>
                        </div>
                        @else
                        <div class="px-4 py-2 rounded-lg border bg-green-50 border-green-200 text-green-700 font-bold text-sm">
                            Jawaban Benar: {{ $question->correct_answer }}
                        </div>
                        @endif
                    </div>

                    <div class="flex flex-col gap-2">
                        <button @click="openEdit({{ json_encode($question) }})" 
                            class="p-2 text-slate-400 hover:text-blue-600 transition-all rounded-lg hover:bg-blue-50">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        <form action="{{ route('sensei.quizzes.questions.destroy', [$quiz->id, $question->id]) }}" method="POST" onsubmit="return confirm('Hapus pertanyaan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-all rounded-lg hover:bg-red-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl border border-dashed border-slate-300 p-12 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300 text-2xl">❓</div>
                <h3 class="text-lg font-bold text-slate-900">Belum Ada Pertanyaan</h3>
                <p class="text-slate-500 max-w-xs mx-auto mt-1 mb-8">Mulai tambahkan pertanyaan ke quiz ini dengan memilih tipe di bawah.</p>
                
                <div class="flex flex-wrap justify-center gap-3">
                    <button @click="showAddModal = true; questionType = 'multiple_choice'" class="px-6 py-2.5 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition-all text-sm shadow-lg shadow-green-600/20 flex items-center gap-2">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        + Pilihan Ganda
                    </button>
                    <button @click="showAddModal = true; questionType = 'essay'" class="px-6 py-2.5 bg-slate-700 text-white font-bold rounded-xl hover:bg-slate-800 transition-all text-sm shadow-lg shadow-slate-700/20 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        + Essai
                    </button>
                    <button @click="showAddModal = true; questionType = 'handwriting'" class="px-6 py-2.5 bg-orange-600 text-white font-bold rounded-xl hover:bg-orange-700 transition-all text-sm shadow-lg shadow-orange-600/20 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        + Tulis Tangan
                    </button>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Add Question Modal -->
        <div x-show="showAddModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div @click="showAddModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
                <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">Tambah Pertanyaan</h3>
                            <p class="text-[10px] font-black text-red-500 uppercase tracking-widest mt-0.5" x-text="questionType.replace('_', ' ')"></p>
                        </div>
                        <button @click="showAddModal = false" class="text-slate-400 hover:text-slate-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18"></path></svg></button>
                    </div>
                    <form action="{{ route('sensei.quizzes.questions.store', $quiz->id) }}" method="POST" class="p-6 space-y-4" id="addQuestionForm">
                        @csrf
                        @include('sensei.quizzes.partials.question-form-fields', ['type' => 'add'])
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Question Modal -->
        <div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div @click="showEditModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
                <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl overflow-hidden animate-in fade-in zoom-in duration-200">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h3 class="text-xl font-bold text-slate-900">Edit Pertanyaan</h3>
                            <p class="text-[10px] font-black text-blue-500 uppercase tracking-widest mt-0.5" x-text="questionType.replace('_', ' ')"></p>
                        </div>
                        <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18"></path></svg></button>
                    </div>
                    <form :action="`{{ route('sensei.quizzes.questions', $quiz->id) }}/${editQuestion.id}`" method="POST" class="p-6 space-y-4" id="editQuestionForm">
                        @csrf
                        @method('PUT')
                        @include('sensei.quizzes.partials.question-form-fields', ['type' => 'edit'])
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function syncCorrectAnswer(type) {
            const formId = type === 'add' ? 'addQuestionForm' : 'editQuestionForm';
            const form = document.getElementById(formId);
            const questionType = form.querySelector('select[name=question_type]').value;
            const correctInput = form.querySelector('input[name=correct_answer]');
            
            if (questionType === 'multiple_choice') {
                const radios = form.querySelectorAll('input[name=correct_answer_radio]');
                const options = form.querySelectorAll('input[name=\'options[]\']');
                for(let i=0; i<radios.length; i++) {
                    if(radios[i].checked) {
                        correctInput.value = options[i].value;
                        break;
                    }
                }
            } else if (questionType === 'essay') {
                correctInput.value = form.querySelector('textarea[name=essay_correct_answer]').value || 'ESSAY_REFERENCE';
            } else if (questionType === 'handwriting') {
                correctInput.value = form.querySelector('input[name=handwriting_correct_answer]').value || 'HANDWRITING_REFERENCE';
            } else {
                correctInput.value = '';
            }
        }
    </script>
</x-sensei-layout>
