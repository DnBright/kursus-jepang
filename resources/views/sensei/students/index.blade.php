<x-sensei-layout>
    <div class="space-y-8">
        <!-- Header & Top Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Siswa</h2>
                <p class="text-slate-500 text-sm mt-1">Pantau dan kelola siswa dari seluruh kelas yang Anda ajar.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                 <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 w-full sm:w-64 shadow-sm" placeholder="Cari nama siswa...">
                </div>
                 <select class="py-2 pl-3 pr-8 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 shadow-sm">
                    <option>Semua Kelas</option>
                    <option>N5 Intensive A</option>
                    <option>N4 Regular B</option>
                </select>
                <select class="py-2 pl-3 pr-8 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 shadow-sm">
                    <option>Semua Level</option>
                    <option>N5</option>
                    <option>N4</option>
                    <option>TG</option>
                </select>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Active Students -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                 <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-lg font-bold">
                    👥
                </div>
                <div>
                    <h4 class="text-slate-500 text-[10px] font-bold uppercase tracking-wide">Siswa Aktif</h4>
                    <p class="text-xl font-bold text-slate-900">{{ $summary['total_active'] }}</p>
                </div>
            </div>

             <!-- New Students -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                 <div class="w-10 h-10 rounded-lg bg-green-50 text-green-600 flex items-center justify-center text-lg font-bold">
                    ✨
                </div>
                <div>
                    <h4 class="text-slate-500 text-[10px] font-bold uppercase tracking-wide">Siswa Baru</h4>
                    <p class="text-xl font-bold text-slate-900">+{{ $summary['new_students'] }}</p>
                </div>
            </div>

            <!-- Needs Evaluation -->
             <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                 <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center text-lg font-bold">
                    ⚠️
                </div>
                <div>
                    <h4 class="text-slate-500 text-[10px] font-bold uppercase tracking-wide">Perlu Evaluasi</h4>
                     <p class="text-xl font-bold text-slate-900">{{ $summary['needs_evaluation'] }}</p>
                </div>
            </div>

            <!-- Avg Progress -->
             <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                 <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-lg font-bold">
                    📈
                </div>
                <div>
                    <h4 class="text-slate-500 text-[10px] font-bold uppercase tracking-wide">Progress Rata2</h4>
                    <p class="text-xl font-bold text-slate-900">{{ $summary['avg_progress'] }}%</p>
                </div>
            </div>
        </div>

        <!-- Student List -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50/50">
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Siswa</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kelas & Level</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider w-1/4">Progress Materi</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Rata-rata Nilai</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($students as $student)
                        <tr class="hover:bg-slate-50 transition-colors group">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-sm">
                                        {{ $student['avatar'] }}
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-900 group-hover:text-red-700 transition-colors">{{ $student['name'] }}</h4>
                                        <p class="text-[10px] text-slate-500">Bergabung {{ $student['joined_at'] }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="flex flex-col items-start gap-1">
                                    <span class="text-sm font-medium text-slate-700">{{ $student['class'] }}</span>
                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                        {{ $student['level'] === 'N5' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $student['level'] === 'N4' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $student['level'] === 'TG' ? 'bg-orange-100 text-orange-700' : '' }}
                                    ">
                                        {{ $student['level'] }}
                                    </span>
                                </div>
                            </td>
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 h-2 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full
                                            {{ $student['progress'] >= 75 ? 'bg-green-500' : '' }}
                                            {{ $student['progress'] >= 50 && $student['progress'] < 75 ? 'bg-blue-500' : '' }}
                                            {{ $student['progress'] < 50 ? 'bg-orange-500' : '' }}
                                        " style="width: {{ $student['progress'] }}%"></div>
                                    </div>
                                    <span class="text-xs font-bold text-slate-600 w-8">{{ $student['progress'] }}%</span>
                                </div>
                            </td>
                             <td class="p-4 text-center">
                                <span class="text-sm font-bold
                                     {{ $student['avg_score'] >= 90 ? 'text-green-600' : '' }}
                                     {{ $student['avg_score'] >= 70 && $student['avg_score'] < 90 ? 'text-slate-700' : '' }}
                                     {{ $student['avg_score'] < 70 ? 'text-red-600' : '' }}
                                ">{{ $student['avg_score'] }}</span>
                            </td>
                             <td class="p-4 text-center">
                                @if($student['status'] === 'active')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-600 border border-green-100">
                                        Aktif
                                    </span>
                                @elseif($student['status'] === 'warning')
                                     <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-orange-50 text-orange-600 border border-orange-100">
                                        Perlu Perhatian
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                        Tidak Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100" title="Detail Siswa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                     <button class="p-2 text-slate-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors border border-transparent hover:border-green-100" title="Kirim Pesan">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
             <!-- Pagination -->
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center justify-between">
                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Menampilkan 5 dari 45 siswa</p>
                <div class="flex gap-2">
                    <button class="px-3 py-1 text-xs font-bold text-slate-500 bg-white border border-slate-200 rounded-md hover:bg-slate-50 disabled:opacity-50" disabled>Sebelumnya</button>
                    <button class="px-3 py-1 text-xs font-bold text-slate-500 bg-white border border-slate-200 rounded-md hover:bg-slate-50">Selanjutnya</button>
                </div>
            </div>
        </div>
    </div>
</x-sensei-layout>
