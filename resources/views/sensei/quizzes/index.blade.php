<x-sensei-layout>
    <div class="space-y-8" x-data="{ activeTab: 'program' }">
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
                <button @click="activeTab = 'program'" class="px-6 py-4 text-sm font-bold border-b-2 transition-all" 
                    :class="activeTab === 'program' ? 'border-red-600 text-red-600' : 'border-transparent text-slate-500 hover:text-slate-700'">
                    Program
                </button>
                 <button @click="activeTab = 'quizzes'" class="px-6 py-4 text-sm font-bold border-b-2 transition-all" 
                    :class="activeTab === 'quizzes' ? 'border-red-600 text-red-600' : 'border-transparent text-slate-500 hover:text-slate-700'">
                    Quiz
                </button>
                 <button @click="activeTab = 'nilai'" class="px-6 py-4 text-sm font-bold border-b-2 transition-all" 
                    :class="activeTab === 'nilai' ? 'border-red-600 text-red-600' : 'border-transparent text-slate-500 hover:text-slate-700'">
                    Nilai
                </button>
            </div>

            <!-- Content Area -->
            <div class="p-6">
                <!-- Tab: Program -->
                <div x-show="activeTab === 'program'" class="space-y-6">
                    <div class="flex flex-col sm:flex-row gap-4 mb-6">
                         <div class="relative flex-1">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text" class="pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500 w-full shadow-sm" placeholder="Cari program...">
                        </div>
                        <select class="py-2 pl-3 pr-8 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500 shadow-sm">
                            <option>Semua Level</option>
                            <option>N5</option>
                            <option>N4</option>
                            <option>Tokutei Ginou</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @forelse($programs as $program)
                        <div class="bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-xl hover:border-red-100 transition-all group">
                            <div class="flex items-center justify-between mb-4">
                                <span class="px-3 py-1 bg-red-50 text-red-600 text-[10px] font-black uppercase tracking-widest rounded-lg">
                                    {{ $program['level'] }}
                                </span>
                                <div class="flex -space-x-2">
                                    <div class="w-8 h-8 rounded-full bg-slate-900 border-2 border-white flex items-center justify-center text-[10px] text-white font-bold">R</div>
                                    <div class="w-8 h-8 rounded-full bg-red-600 border-2 border-white flex items-center justify-center text-[10px] text-white font-bold">+</div>
                                </div>
                            </div>
                            <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-red-600 transition-colors">{{ $program['title'] }}</h3>
                            <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-50">
                                <div class="flex items-center gap-4 text-xs text-slate-500 font-bold">
                                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg> {{ $program['modules_count'] }} Modul</span>
                                    <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg> {{ $program['students_count'] }} Siswa</span>
                                </div>
                                <a href="{{ route('sensei.programs.manage', $program['id']) }}" class="px-3 py-1.5 bg-slate-900 text-white text-[10px] font-bold rounded-lg hover:bg-slate-800 transition-all flex items-center gap-1.5">
                                    Kelola Roadmap <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </a>
                            </div>
                        </div>
                        @empty
                        <div class="col-span-full py-12 text-center">
                            <p class="text-slate-500">Anda belum mengampu program apapun.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Tab: Quiz -->
                <div x-show="activeTab === 'quizzes'" class="space-y-6" style="display: none;" x-data="{ filterLevel: 'all', filterType: 'all', search: '' }">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-4">
                        <div class="flex flex-wrap items-center gap-3">
                            <!-- Search -->
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" x-model="search" class="pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500 w-48 shadow-sm" placeholder="Cari kuis...">
                            </div>

                            <!-- Filter Program / Level -->
                            <div class="flex items-center gap-1.5 bg-slate-100 rounded-xl p-1">
                                <button @click="filterLevel = 'all'"
                                    :class="filterLevel === 'all' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                                    class="px-3 py-1.5 text-xs font-black rounded-lg transition-all">
                                    Semua Program
                                </button>
                                @foreach($programs as $prog)
                                <button @click="filterLevel = '{{ $prog['level'] }}'"
                                    :class="filterLevel === '{{ $prog['level'] }}' ? 'bg-white text-red-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'"
                                    class="px-3 py-1.5 text-xs font-black rounded-lg transition-all">
                                    {{ $prog['level'] }}
                                </button>
                                @endforeach
                            </div>

                            <!-- Filter Tipe Soal -->
                            <div class="flex items-center gap-1.5 bg-slate-100 rounded-xl p-1">
                                <button @click="filterType = 'all'" :class="filterType === 'all' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500'" class="px-3 py-1.5 text-xs font-black rounded-lg transition-all">Semua</button>
                                <button @click="filterType = 'multiple_choice'" :class="filterType === 'multiple_choice' ? 'bg-white text-green-600 shadow-sm' : 'text-slate-500'" class="px-3 py-1.5 text-xs font-black rounded-lg transition-all">PG</button>
                                <button @click="filterType = 'essay'" :class="filterType === 'essay' ? 'bg-white text-slate-700 shadow-sm' : 'text-slate-500'" class="px-3 py-1.5 text-xs font-black rounded-lg transition-all">Essay</button>
                                <button @click="filterType = 'handwriting'" :class="filterType === 'handwriting' ? 'bg-white text-orange-600 shadow-sm' : 'text-slate-500'" class="px-3 py-1.5 text-xs font-black rounded-lg transition-all">Tulis Tangan</button>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-3">
                            <a href="{{ route('sensei.quizzes.create') }}?default_type=multiple_choice" class="px-4 py-2 bg-green-600 text-white font-bold rounded-xl shadow-lg shadow-green-600/20 hover:bg-green-700 transition-all flex items-center gap-2 text-xs">
                                + Quiz PG
                            </a>
                            <a href="{{ route('sensei.quizzes.create') }}?default_type=essay" class="px-4 py-2 bg-slate-900 text-white font-bold rounded-xl shadow-lg shadow-slate-900/20 hover:bg-slate-800 transition-all flex items-center gap-2 text-xs">
                                + Quiz Essai
                            </a>
                            <a href="{{ route('sensei.quizzes.create') }}?default_type=handwriting" class="px-4 py-2 bg-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-600/20 hover:bg-orange-700 transition-all flex items-center gap-2 text-xs">
                                + Quiz Tulis Tangan
                            </a>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @forelse($quizzes as $quiz)
                        <div class="flex flex-col md:flex-row md:items-center justify-between p-4 rounded-xl border border-slate-200 hover:border-red-200 hover:bg-slate-50 transition-all gap-4"
                            x-show="
                                (filterLevel === 'all' || filterLevel === '{{ $quiz['level'] }}') &&
                                (filterType === 'all' || filterType === '{{ $quiz['question_type'] ?? 'multiple_choice' }}') &&
                                (search === '' || '{{ strtolower($quiz['title']) }}'.includes(search.toLowerCase()))
                            ">
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0
                                    {{ ($quiz['question_type'] ?? 'multiple_choice') === 'essay' ? 'bg-slate-100 text-slate-600' : (($quiz['question_type'] ?? '') === 'handwriting' ? 'bg-orange-100 text-orange-600' : 'bg-green-100 text-green-600') }}">
                                    @if(($quiz['question_type'] ?? 'multiple_choice') === 'essay')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    @elseif(($quiz['question_type'] ?? '') === 'handwriting')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-bold text-slate-900 text-lg">{{ $quiz['title'] }}</h3>
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-red-100 text-red-700">
                                            {{ $quiz['level'] }}
                                        </span>
                                        <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                            {{ ($quiz['question_type'] ?? 'multiple_choice') === 'essay' ? 'bg-slate-100 text-slate-600' : (($quiz['question_type'] ?? '') === 'handwriting' ? 'bg-orange-100 text-orange-600' : 'bg-green-100 text-green-600') }}">
                                            {{ match($quiz['question_type'] ?? 'multiple_choice') {
                                                'essay' => 'Essay',
                                                'handwriting' => 'Tulis Tangan',
                                                default => 'Pilihan Ganda'
                                            } }}
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
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 self-end md:self-auto">
                                <a href="{{ route('sensei.quizzes.questions', $quiz['id']) }}" class="px-4 py-2 text-sm font-bold text-slate-600 border border-slate-200 rounded-lg hover:bg-white hover:text-red-600 hover:border-red-200 transition-all">
                                    Kelola Soal
                                </a>
                                 <a href="{{ route('sensei.quizzes.edit', $quiz['id']) }}" class="px-4 py-2 text-sm font-bold text-white bg-slate-900 rounded-lg hover:bg-slate-800 transition-all">
                                    Edit
                                </a>
                                <form action="{{ route('sensei.quizzes.destroy', $quiz['id']) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus quiz ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-600 transition-all rounded-lg hover:bg-red-50">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12">
                            <p class="text-slate-500">Belum ada kuis yang dibuat.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Tab: Nilai -->
                <div x-show="activeTab === 'nilai'" class="space-y-6" style="display: none;">
                    <div class="flex flex-col sm:flex-row gap-4 mb-6">
                         <div class="relative flex-1">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            </span>
                            <input type="text" class="pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500 w-full shadow-sm" placeholder="Cari nama siswa atau tugas...">
                        </div>
                        <select class="py-2 pl-3 pr-8 bg-slate-50 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500 shadow-sm">
                            <option>Semua Tipe</option>
                            <option>Quiz</option>
                            <option>Tugas</option>
                        </select>
                    </div>

                    <div class="overflow-x-auto rounded-xl border border-slate-200">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-500">Siswa</th>
                                    <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-500">Quiz</th>
                                    <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-500">Tipe Soal</th>
                                    <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-500">Nilai</th>
                                    <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-500">Status</th>
                                    <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-500">Tanggal</th>
                                    <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-500">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse($results as $result)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-slate-900">{{ $result['user_name'] }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600 font-medium">{{ $result['task_title'] }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase
                                            {{ $result['type'] === 'Quiz' ? 'bg-purple-50 text-purple-600' : 'bg-blue-50 text-blue-600' }}">
                                            {{ $result['type'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-lg font-black {{ is_numeric($result['score']) && $result['score'] >= 70 ? 'text-green-600' : ($result['score'] === '-' ? 'text-orange-400' : 'text-red-600') }}">
                                            {{ $result['score'] }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if(in_array($result['status'], ['graded', 'completed']))
                                            <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                Selesai
                                            </span>
                                        @elseif($result['status'] === 'needs_grading')
                                            <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded-full animate-pulse">
                                                ⏳ Perlu Dinilai
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded-full">
                                                Menunggu
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-500">{{ $result['date'] }}</td>
                                    <td class="px-6 py-4">
                                        @if($result['status'] === 'needs_grading' && $result['type'] === 'Quiz')
                                            <a href="{{ route('sensei.quizzes.grading.show', $result['id']) }}"
                                               class="px-4 py-2 bg-red-600 text-white text-xs font-bold rounded-lg hover:bg-red-700 transition-all shadow-sm shadow-red-600/20 whitespace-nowrap">
                                                Nilai Sekarang
                                            </a>
                                        @else
                                            <span class="text-slate-300 text-xs">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-slate-500">
                                        <div class="text-4xl mb-3">📊</div>
                                        Belum ada hasil penilaian siswa.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-sensei-layout>
