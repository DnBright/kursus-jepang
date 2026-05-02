<x-sensei-layout>
    <div class="space-y-8" x-data="{ activeTab: 'quizzes' }">
        <!-- Header & Top Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Quiz & Penilaian</h2>
                <p class="text-slate-500 text-sm mt-1">Kelola evaluasi pembelajaran dan pantau hasil siswa.</p>
            </div>
            
            <div class="flex flex-wrap items-center gap-3">
                 <a href="{{ route('sensei.assignments.create') }}" class="px-4 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-xs">
                    Buat Tugas Mandiri
                </a>
                <a href="{{ route('sensei.quizzes.create') }}?default_type=multiple_choice" class="px-4 py-2.5 bg-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-600/20 hover:bg-green-700 transition-all flex items-center gap-2 text-xs">
                    + Quiz PG
                </a>
                <a href="{{ route('sensei.quizzes.create') }}?default_type=essay" class="px-4 py-2.5 bg-slate-900 text-white font-bold rounded-xl shadow-lg shadow-slate-900/20 hover:bg-slate-800 transition-all flex items-center gap-2 text-xs">
                    + Quiz Essai
                </a>
                <a href="{{ route('sensei.quizzes.create') }}?default_type=handwriting" class="px-4 py-2.5 bg-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-600/20 hover:bg-orange-700 transition-all flex items-center gap-2 text-xs">
                    + Quiz Tulis Tangan
                </a>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Active Quizzes -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                 <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center text-lg font-bold">
                    📝
                </div>
                <div>
                    <h4 class="text-slate-500 text-[10px] font-bold uppercase tracking-wide">Quiz Aktif</h4>
                    <p class="text-xl font-bold text-slate-900">{{ $summary['active_quizzes'] }}</p>
                </div>
            </div>

             <!-- Essay Assignments -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                 <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-lg font-bold">
                    ✍️
                </div>
                <div>
                    <h4 class="text-slate-500 text-[10px] font-bold uppercase tracking-wide">Tugas Essay</h4>
                    <p class="text-xl font-bold text-slate-900">{{ $summary['essay_assignments'] }}</p>
                </div>
            </div>

            <!-- Needs Grading -->
             <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                 <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center text-lg font-bold">
                    ⚠️
                </div>
                <div class="min-w-0">
                    <h4 class="text-slate-500 text-[10px] font-bold uppercase tracking-wide">Perlu Dinilai</h4>
                     <p class="text-xl font-bold text-slate-900">{{ $summary['needs_grading'] }} <span class="text-xs font-medium text-slate-400">Siswa</span></p>
                </div>
            </div>

            <!-- Avg Score -->
             <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                 <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center text-lg font-bold">
                    📊
                </div>
                <div>
                    <h4 class="text-slate-500 text-[10px] font-bold uppercase tracking-wide">Rata-rata Nilai</h4>
                    <p class="text-xl font-bold text-slate-900">{{ $summary['avg_score'] }}</p>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden min-h-[500px]">
            <!-- Tabs -->
             <div class="border-b border-slate-100 flex items-center px-4 bg-slate-50/50">
                <button @click="activeTab = 'quizzes'" class="px-6 py-4 text-sm font-bold border-b-2 transition-all" 
                    :class="activeTab === 'quizzes' ? 'border-red-600 text-red-600' : 'border-transparent text-slate-500 hover:text-slate-700'">
                    Daftar Quiz
                </button>
                 <button @click="activeTab = 'assignments'" class="px-6 py-4 text-sm font-bold border-b-2 transition-all" 
                    :class="activeTab === 'assignments' ? 'border-red-600 text-red-600' : 'border-transparent text-slate-500 hover:text-slate-700'">
                    Tugas & Essay
                </button>
                 <button @click="activeTab = 'results'" class="px-6 py-4 text-sm font-bold border-b-2 transition-all" 
                    :class="activeTab === 'results' ? 'border-red-600 text-red-600' : 'border-transparent text-slate-500 hover:text-slate-700'">
                    Hasil Penilaian
                </button>
            </div>

            <!-- Content Area -->
            <div class="p-6">
                 <!-- Filters (Common) -->
                 <div class="flex flex-col sm:flex-row gap-4 mb-6">
                     <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" class="pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500 w-full shadow-sm" placeholder="Cari quiz atau tugas...">
                    </div>
                    <div class="flex gap-2">
                        <select class="py-2 pl-3 pr-8 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500 shadow-sm">
                            <option>Semua Level</option>
                            <option>N5</option>
                            <option>N4</option>
                        </select>
                         <select class="py-2 pl-3 pr-8 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500 shadow-sm">
                            <option>Semua Status</option>
                            <option>Aktif</option>
                            <option>Selesai</option>
                        </select>
                    </div>
                </div>

                <!-- Tab: Quizzes -->
                <div x-show="activeTab === 'quizzes'" class="space-y-4">
                    @forelse($quizzes as $quiz)
                    <div class="flex flex-col md:flex-row md:items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-red-200 hover:bg-slate-50 transition-all gap-4">
                        <div class="flex items-start gap-4">
                             <div class="w-12 h-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="font-bold text-slate-900 text-lg">{{ $quiz['title'] }}</h3>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                        {{ $quiz['level'] === 'N5' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $quiz['level'] === 'N4' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $quiz['level'] === 'N3' ? 'bg-purple-100 text-purple-700' : '' }}
                                    ">
                                        {{ $quiz['level'] }}
                                    </span>
                                     @if($quiz['status'] === 'active')
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-green-50 text-green-600 border border-green-100">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                            Draft
                                        </span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-4 text-sm text-slate-500">
                                    <span>{{ $quiz['question_count'] }} Soal</span>
                                    <span>•</span>
                                    <span>{{ $quiz['type'] }}</span>
                                    <span>•</span>
                                    <span class="{{ $quiz['deadline'] === 'Hari Ini' ? 'text-red-500 font-bold' : '' }}">Deadline: {{ $quiz['deadline'] }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 self-end md:self-auto">
                            <a href="{{ route('sensei.quizzes.questions', $quiz['id']) }}" class="px-4 py-2 text-sm font-bold text-slate-600 border border-slate-200 rounded-lg hover:bg-white hover:text-red-600 hover:border-red-200 transition-all">
                                Kelola Soal
                            </a>
                             <a href="{{ route('sensei.quizzes.edit', $quiz['id']) }}" class="px-4 py-2 text-sm font-bold text-white bg-slate-900 rounded-lg hover:bg-slate-800 transition-all">
                                Edit Quiz
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-20 bg-slate-50/50 rounded-2xl border border-dashed border-slate-200">
                        <div class="w-20 h-20 bg-white rounded-full shadow-sm flex items-center justify-center mx-auto mb-6 text-3xl">📝</div>
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Belum Ada Quiz</h3>
                        <p class="text-slate-500 max-w-xs mx-auto mb-8 text-sm text-balance text-center">Pilih salah satu tipe di bawah untuk mulai membuat kuis pertama Anda.</p>
                        
                        <div class="flex flex-wrap justify-center gap-3">
                            <a href="{{ route('sensei.quizzes.create') }}?default_type=multiple_choice" class="px-6 py-2.5 bg-green-600 text-white font-bold rounded-xl hover:bg-green-700 transition-all text-sm shadow-lg shadow-green-600/20">
                                + Buat Quiz PG
                            </a>
                            <a href="{{ route('sensei.quizzes.create') }}?default_type=essay" class="px-6 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all text-sm shadow-lg shadow-slate-900/20">
                                + Buat Quiz Essai
                            </a>
                            <a href="{{ route('sensei.quizzes.create') }}?default_type=handwriting" class="px-6 py-2.5 bg-orange-600 text-white font-bold rounded-xl hover:bg-orange-700 transition-all text-sm shadow-lg shadow-orange-600/20">
                                + Buat Quiz Tulis Tangan
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>

                 <!-- Tab: Assignments -->
                <div x-show="activeTab === 'assignments'" class="space-y-4" style="display: none;">
                     @forelse($assignments as $assignment)
                    <div class="flex flex-col md:flex-row md:items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-slate-50 transition-all gap-4">
                        <div class="flex items-start gap-4">
                             <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 text-lg mb-1">{{ $assignment['title'] }}</h3>
                                <div class="flex items-center gap-4 text-sm text-slate-500">
                                    <span class="font-medium text-slate-700">{{ $assignment['class'] }}</span>
                                    <span>•</span>
                                    <span>{{ $assignment['submitted_count'] }} Siswa Mengumpulkan</span>
                                     <span>•</span>
                                    <span class="{{ $assignment['deadline'] === 'Hari Ini' ? 'text-red-500' : '' }}">Deadline: {{ $assignment['deadline'] }}</span>
                                </div>
                            </div>
                        </div>

                         <div class="flex items-center gap-4">
                            @if($assignment['status'] === 'needs_grading')
                                 <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700 animate-pulse">
                                    Perlu Dinilai
                                </span>
                                 <a href="{{ route('sensei.assignments.grading', $assignment['id']) }}" class="px-4 py-2 text-sm font-bold text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-sm shadow-red-600/20 transition-all">
                                    Beri Nilai
                                </a>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">
                                    Selesai Dinilai
                                </span>
                                 <a href="{{ route('sensei.assignments.grading', $assignment['id']) }}" class="px-4 py-2 text-sm font-bold text-slate-600 border border-slate-200 rounded-lg hover:bg-white transition-all">
                                    Lihat Hasil
                                </a>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-12">
                        <p class="text-slate-500">Belum ada tugas yang dibuat.</p>
                    </div>
                    @endforelse
                </div>

                <!-- Tab: Results (Placeholder) -->
                 <div x-show="activeTab === 'results'" class="flex flex-col items-center justify-center py-20 text-center space-y-4" style="display: none;">
                    <div class="w-20 h-20 bg-slate-100 rounded-full flex items-center justify-center text-slate-300 text-4xl">
                        📊
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-900">Analitik Belum Tersedia</h3>
                        <p class="text-slate-500 max-w-sm mx-auto">Fitur analisis mendalam untuk performa siswa sedang dalam pengembangan.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-sensei-layout>
