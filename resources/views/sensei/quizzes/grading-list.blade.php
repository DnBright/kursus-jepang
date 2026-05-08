<x-sensei-layout>
    <div class="max-w-6xl mx-auto py-8 px-4" x-data="{ 
        filterLevel: 'all', 
        filterType: 'all', 
        search: '',
        openLevel: false,
        openType: false
    }">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Penilaian & Review</h2>
                <p class="text-slate-500 mt-1 font-medium">Review jawaban siswa dan berikan penilaian untuk soal essay/tulis tangan.</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white p-1.5 rounded-2xl border border-slate-200 shadow-sm shrink-0">
                <a href="{{ route('sensei.quizzes.grading.index', ['status' => 'needs_grading']) }}" 
                   class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ request('status', 'needs_grading') === 'needs_grading' ? 'bg-red-600 text-white shadow-lg shadow-red-500/20' : 'text-slate-500 hover:bg-slate-50' }}">
                    Perlu Dinilai
                </a>
                <a href="{{ route('sensei.quizzes.grading.index', ['status' => 'completed']) }}" 
                   class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ request('status') === 'completed' ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20' : 'text-slate-500 hover:bg-slate-50' }}">
                    Selesai
                </a>
                <a href="{{ route('sensei.quizzes.grading.index', ['status' => 'all']) }}" 
                   class="px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest transition-all {{ request('status') === 'all' ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20' : 'text-slate-500 hover:bg-slate-50' }}">
                    Semua
                </a>
            </div>
        </div>

        <!-- Toolbar Row -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-slate-50/50 p-4 rounded-3xl border border-slate-100 mb-8">
            <div class="flex flex-wrap items-center gap-3">
                <!-- Search -->
                <div class="relative group">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400 group-focus-within:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" x-model="search" 
                        class="pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-red-500/10 focus:border-red-500 w-full sm:w-64 shadow-sm transition-all outline-none" 
                        placeholder="Cari nama siswa atau quiz...">
                </div>

                <!-- Filter Program (Dropdown) -->
                <div class="relative">
                    <button @click="openLevel = !openLevel" @click.away="openLevel = false"
                        class="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 hover:border-red-200 hover:bg-red-50/30 transition-all shadow-sm">
                        <span class="text-slate-400">Program:</span>
                        <span x-text="filterLevel === 'all' ? 'Semua' : filterLevel"></span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform" :class="openLevel ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openLevel" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
                        class="absolute left-0 mt-2 w-48 bg-white border border-slate-100 rounded-xl shadow-xl z-20 py-1 overflow-hidden" style="display: none;">
                        <button @click="filterLevel = 'all'; openLevel = false" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 transition-colors" :class="filterLevel === 'all' ? 'text-red-600 font-bold bg-red-50/50' : 'text-slate-600 font-medium'">Semua Program</button>
                        <button @click="filterLevel = 'N5'; openLevel = false" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 transition-colors" :class="filterLevel === 'N5' ? 'text-red-600 font-bold bg-red-50/50' : 'text-slate-600 font-medium'">N5 Level</button>
                        <button @click="filterLevel = 'N4'; openLevel = false" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 transition-colors" :class="filterLevel === 'N4' ? 'text-red-600 font-bold bg-red-50/50' : 'text-slate-600 font-medium'">N4 Level</button>
                        <button @click="filterLevel = 'N3'; openLevel = false" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 transition-colors" :class="filterLevel === 'N3' ? 'text-red-600 font-bold bg-red-50/50' : 'text-slate-600 font-medium'">N3 Level</button>
                    </div>
                </div>

                <!-- Filter Tipe (Dropdown) -->
                <div class="relative">
                    <button @click="openType = !openType" @click.away="openType = false"
                        class="flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-bold text-slate-700 hover:border-red-200 hover:bg-red-50/30 transition-all shadow-sm">
                        <span class="text-slate-400">Tipe:</span>
                        <span x-text="filterType === 'all' ? 'Semua' : (filterType === 'multiple_choice' ? 'PG' : (filterType === 'essay' ? 'Essay' : 'Tulis Tangan'))"></span>
                        <svg class="w-4 h-4 text-slate-400 transition-transform" :class="openType ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div x-show="openType" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
                        class="absolute left-0 mt-2 w-48 bg-white border border-slate-100 rounded-xl shadow-xl z-20 py-1 overflow-hidden" style="display: none;">
                        <button @click="filterType = 'all'; openType = false" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 transition-colors" :class="filterType === 'all' ? 'text-red-600 font-bold bg-red-50/50' : 'text-slate-600 font-medium'">Semua Tipe</button>
                        <button @click="filterType = 'multiple_choice'; openType = false" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 transition-colors" :class="filterType === 'multiple_choice' ? 'text-red-600 font-bold bg-red-50/50' : 'text-slate-600 font-medium'">Pilihan Ganda (PG)</button>
                        <button @click="filterType = 'essay'; openType = false" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 transition-colors" :class="filterType === 'essay' ? 'text-red-600 font-bold bg-red-50/50' : 'text-slate-600 font-medium'">Essay</button>
                        <button @click="filterType = 'handwriting'; openType = false" class="w-full text-left px-4 py-2 text-sm hover:bg-slate-50 transition-colors" :class="filterType === 'handwriting' ? 'text-red-600 font-bold bg-red-50/50' : 'text-slate-600 font-medium'">Tulis Tangan</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100">
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Siswa</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400">Quiz</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Tanggal</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Skor</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-center">Status</th>
                            <th class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($attempts as $attempt)
                            @php
                                $qtype = $attempt->quiz->question_type ?? 'multiple_choice';
                                $quizLevel = $attempt->quiz->course ? $attempt->quiz->course->level : ($attempt->quiz->difficulty === 'beginner' ? 'N5' : ($attempt->quiz->difficulty === 'intermediate' ? 'N4' : 'N3'));
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors group"
                                x-show="
                                    (filterLevel === 'all' || filterLevel === '{{ $quizLevel }}') &&
                                    (filterType === 'all' || filterType === '{{ $qtype }}') &&
                                    (search === '' || '{{ strtolower($attempt->user->name) }}'.includes(search.toLowerCase()) || '{{ strtolower($attempt->quiz->title) }}'.includes(search.toLowerCase()))
                                " x-transition>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-500 border border-slate-200">
                                            {{ substr($attempt->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-900 leading-tight">{{ $attempt->user->name }}</p>
                                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">{{ $attempt->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="font-bold text-slate-700 leading-tight">{{ $attempt->quiz->title }}</p>
                                        <div class="flex items-center gap-2 mt-1.5">
                                            <span class="px-1.5 py-0.5 bg-red-50 text-red-600 text-[8px] font-black rounded border border-red-100 uppercase tracking-widest">
                                                {{ $quizLevel }}
                                            </span>
                                            @php
                                                $badgeClasses = match($qtype) { 
                                                    'essay' => 'bg-slate-900 text-white', 
                                                    'handwriting' => 'bg-orange-500 text-white', 
                                                    default => 'bg-green-600 text-white' 
                                                };
                                            @endphp
                                            <span class="px-1.5 py-0.5 {{ $badgeClasses }} text-[8px] font-black uppercase tracking-widest rounded shadow-sm">
                                                {{ match($qtype) { 'essay' => 'Essay', 'handwriting' => 'Tulis Tangan', default => 'PG' } }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <p class="text-xs font-bold text-slate-500">{{ $attempt->created_at->format('d M Y') }}</p>
                                    <p class="text-[10px] text-slate-400 font-medium">{{ $attempt->created_at->format('H:i') }}</p>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($attempt->status === 'needs_grading')
                                        <span class="text-xs font-black text-slate-300">PENDING</span>
                                    @else
                                        <span class="text-lg font-black {{ $attempt->is_passed ? 'text-green-600' : 'text-red-600' }}">
                                            {{ round($attempt->score) }}<span class="text-[10px] text-slate-400 font-bold">/{{ $attempt->max_score }}</span>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($attempt->status === 'needs_grading')
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black bg-orange-50 text-orange-600 border border-orange-100 uppercase tracking-widest">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500 animate-pulse"></span> Belum Dinilai
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-black bg-green-50 text-green-600 border border-green-100 uppercase tracking-widest">
                                            Selesai
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('sensei.quizzes.grading.show', $attempt->id) }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-slate-50 hover:bg-red-600 text-slate-600 hover:text-white text-[10px] font-black uppercase tracking-widest rounded-xl border border-slate-200 hover:border-red-600 transition-all shadow-sm">
                                        @if($attempt->status === 'needs_grading')
                                            Nilai Sekarang
                                        @else
                                            Review Detail
                                        @endif
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="w-16 h-16 bg-slate-50 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                        <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <h3 class="text-lg font-bold text-slate-900">Tidak ada data penilaian</h3>
                                    <p class="text-slate-500 text-sm mt-1">Belum ada siswa yang mengerjakan quiz dalam kategori ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-sensei-layout>
