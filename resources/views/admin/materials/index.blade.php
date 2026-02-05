<x-admin-layout>
    <div x-data="{ activeTab: 'materials', materialDetail: null }" class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Materi & Konten</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola seluruh materi pembelajaran dan konten kursus.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                 <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                    Upload Konten
                </button>
                <button class="px-4 py-2 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-colors text-sm flex items-center gap-2 shadow-lg shadow-red-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Materi
                </button>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Total Materi Aktif</span>
                <span class="text-xl font-bold text-green-600">{{ $stats['total_materials'] }}</span>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Total Quiz</span>
                <span class="text-xl font-bold text-blue-600">{{ $stats['total_quizzes'] }}</span>
            </div>
             <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Total File Modul</span>
                <span class="text-xl font-bold text-purple-600">{{ $stats['total_files'] }}</span>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="border-b border-slate-200 overflow-x-auto">
            <nav class="-mb-px flex space-x-8 min-w-max">
                <button @click="activeTab = 'materials'"
                    :class="{ 'border-red-500 text-red-600': activeTab === 'materials', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'materials' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Materi Pembelajaran
                </button>

                <button @click="activeTab = 'files'"
                    :class="{ 'border-red-500 text-red-600': activeTab === 'files', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'files' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Modul & File
                </button>
                
                <button @click="activeTab = 'quizzes'"
                    :class="{ 'border-red-500 text-red-600': activeTab === 'quizzes', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'quizzes' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Quiz
                </button>

                <button @click="activeTab = 'general'"
                    :class="{ 'border-red-500 text-red-600': activeTab === 'general', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'general' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                    Konten Umum
                </button>
            </nav>
        </div>

        <!-- 1. Materi Tab -->
        <div x-show="activeTab === 'materials'" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden text-left" style="display: none;">
            <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row gap-3 justify-between">
                 <div class="relative w-full sm:w-64">
                    <input type="text" class="pl-4 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 w-full shadow-sm" placeholder="Cari judul materi...">
                </div>
                 <select class="py-2 pl-3 pr-8 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 shadow-sm cursor-pointer">
                    <option>Semua Tipe</option>
                    <option>Video</option>
                    <option>Teks</option>
                    <option>Audio</option>
                </select>
            </div>
            <div class="overflow-x-auto">
                 <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Judul Materi</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Program</th>
                             <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kelas</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tipe</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Terakhir Update</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($materials as $material)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $material->title }}</div>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $material->program }}
                                </span>
                            </td>
                             <td class="p-4 text-sm text-slate-600">
                                {{ $material->class_name }}
                            </td>
                            <td class="p-4">
                                @if($material->type == 'video')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-100">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> Video
                                    </span>
                                @elseif($material->type == 'text')
                                     <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg> Teks
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700 border border-purple-100">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg> Audio
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-sm text-slate-500">
                                {{ $material->last_updated->diffForHumans() }}
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                     <button class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100" title="Edit Materi">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                         <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400 text-sm">Tidak ada materi ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 2. Modul Tab -->
        <div x-show="activeTab === 'files'" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden text-left" style="display: none;">
             <div class="overflow-x-auto">
                 <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama File</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tipe</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Program</th>
                             <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Ukuran</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($files as $file)
                        <tr class="hover:bg-slate-50 transition-colors">
                             <td class="p-4 font-bold text-slate-900 text-sm">{{ $file->name }}</td>
                             <td class="p-4">
                                <span class="text-xs font-bold text-slate-500 bg-slate-100 px-2 py-1 rounded">{{ $file->type }}</span>
                             </td>
                             <td class="p-4 text-sm text-slate-600">{{ $file->program }}</td>
                             <td class="p-4 text-sm text-slate-500">{{ $file->size }}</td>
                             <td class="p-4 text-right">
                                <button class="text-xs text-blue-600 hover:text-blue-800 hover:underline">Download</button>
                             </td>
                        </tr>
                        @empty
                         <tr>
                            <td colspan="5" class="p-12 text-center text-slate-400 text-sm">Tidak ada file modul ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                 </table>
             </div>
        </div>

         <!-- 3. Quiz Tab -->
        <div x-show="activeTab === 'quizzes'" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden text-left" style="display: none;">
             <div class="overflow-x-auto">
                 <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Judul Quiz</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Level</th>
                             <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kelas</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Jml Soal</th>
                             <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($quizzes as $quiz)
                        <tr class="hover:bg-slate-50 transition-colors">
                             <td class="p-4 font-bold text-slate-900 text-sm">{{ $quiz->title }}</td>
                             <td class="p-4">
                                <span class="text-xs font-bold text-white bg-slate-700 px-2 py-1 rounded">{{ $quiz->level }}</span>
                             </td>
                             <td class="p-4 text-sm text-slate-600">{{ $quiz->class_name }}</td>
                             <td class="p-4 text-center text-sm font-bold text-slate-700">{{ $quiz->question_count }}</td>
                             <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-100">
                                    {{ ucfirst($quiz->status) }}
                                </span>
                             </td>
                             <td class="p-4 text-right">
                                <button class="text-xs text-red-600 hover:text-red-800 hover:underline">Edit Soal</button>
                             </td>
                        </tr>
                        @empty
                         <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400 text-sm">Tidak ada quiz ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                 </table>
             </div>
        </div>

         <!-- 4. General Content Tab (Mock) -->
        <div x-show="activeTab === 'general'" style="display: none;">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Mock Card 1 -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="h-32 bg-slate-100 rounded-xl mb-4 flex items-center justify-center text-slate-400">Banner Image</div>
                    <h3 class="font-bold text-slate-900">Promo Diskon Awal Tahun</h3>
                    <p class="text-xs text-slate-500 mt-1 mb-3">Published • 01 Jan 2026</p>
                    <button class="w-full py-2 bg-slate-50 text-slate-600 text-sm font-bold rounded-lg hover:bg-slate-100 transition-colors">Edit Konten</button>
                </div>
                 <!-- Mock Card 2 -->
                <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
                    <div class="h-32 bg-slate-100 rounded-xl mb-4 flex items-center justify-center text-slate-400">Banner Image</div>
                    <h3 class="font-bold text-slate-900">Pengumuman Libur Nasional</h3>
                    <p class="text-xs text-slate-500 mt-1 mb-3">Draft</p>
                    <button class="w-full py-2 bg-slate-50 text-slate-600 text-sm font-bold rounded-lg hover:bg-slate-100 transition-colors">Edit Konten</button>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
