<x-admin-layout>
    <div x-data="{ activeTab: 'classes', classDetail: null, programDetail: null }" class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Kelas & Program</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola kelas, paket kursus, dan struktur pembelajaran.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                 <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Buat Program
                </button>
                <button class="px-4 py-2 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-colors text-sm flex items-center gap-2 shadow-lg shadow-red-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Buat Kelas Baru
                </button>
            </div>
        </div>

        <!-- Stats Overview (Optional) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Total Kelas Aktif</span>
                <span class="text-xl font-bold text-green-600">{{ $stats['total_active_classes'] }}</span>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Total Program</span>
                <span class="text-xl font-bold text-blue-600">{{ $stats['total_programs'] }}</span>
            </div>
             <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Kelas Paling Diminati</span>
                <span class="text-xl font-bold text-purple-600 truncate">{{ $stats['popular_class'] }}</span>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="border-b border-slate-200">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'classes'"
                    :class="{ 'border-red-500 text-red-600': activeTab === 'classes', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'classes' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                    Manajemen Kelas
                </button>

                <button @click="activeTab = 'programs'"
                    :class="{ 'border-red-500 text-red-600': activeTab === 'programs', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'programs' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Program / Paket
                </button>
            </nav>
        </div>

        <!-- Classes Management Tab -->
        <div x-show="activeTab === 'classes'" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden text-left" style="display: none;">
            <!-- Filter & Search -->
            <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row gap-3 justify-between">
                <div class="relative w-full sm:w-64">
                     <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 w-full shadow-sm" placeholder="Cari kelas...">
                </div>
                 <select class="py-2 pl-3 pr-8 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 shadow-sm cursor-pointer">
                    <option>Semua Status</option>
                    <option>Aktif</option>
                    <option>Selesai</option>
                    <option>Draft</option>
                </select>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                 <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Kelas</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Program</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Sensei</th>
                             <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Siswa</th>
                             <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jadwal</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($classes as $class)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4">
                                <div class="font-bold text-slate-900 text-sm">{{ $class->name }}</div>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $class->program_name }}
                                </span>
                            </td>
                            <td class="p-4 text-sm text-slate-600">
                                {{ $class->sensei_name }}
                            </td>
                           <td class="p-4 text-center text-sm font-bold text-slate-700">
                                {{ $class->student_count }}
                            </td>
                            <td class="p-4 text-sm text-slate-500">
                                {{ $class->schedule }}
                            </td>
                            <td class="p-4">
                                @if($class->status === 'active')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-100">
                                        Aktif
                                    </span>
                                @elseif($class->status === 'draft')
                                     <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                        Draft
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-yellow-50 text-yellow-700 border border-yellow-100">
                                        {{ ucfirst($class->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="classDetail = {{ json_encode($class) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100" title="Detail Kelas">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                     <button class="p-2 text-slate-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors border border-transparent hover:border-orange-100" title="Edit Kelas">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                         <tr>
                            <td colspan="7" class="p-12 text-center text-slate-400 text-sm">
                                Tidak ada data kelas ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Programs/Packages Tab -->
        <div x-show="activeTab === 'programs'" style="display: none;">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($programs as $program)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow group relative">
                     <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-100">
                            {{ ucfirst($program->status) }}
                        </span>
                    </div>
                    <div class="p-6">
                        <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                             <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="font-bold text-slate-900 text-lg mb-1">{{ $program->name }}</h3>
                        <p class="text-sm text-slate-500 mb-4 line-clamp-2">{{ $program->description }}</p>
                        
                        <div class="flex items-center justify-between items-end border-t border-slate-100 pt-4">
                            <div>
                                <p class="text-xs text-slate-400 font-bold uppercase mb-0.5">Harga</p>
                                <p class="font-bold text-slate-900">{{ $program->price }}</p>
                            </div>
                             <div>
                                <p class="text-xs text-slate-400 font-bold uppercase mb-0.5">Durasi</p>
                                <p class="font-bold text-slate-900 text-right">{{ $program->duration }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-6 py-3 flex gap-2">
                        <button class="flex-1 py-2 text-sm font-bold text-slate-600 hover:text-slate-800 hover:bg-white rounded-lg border border-transparent hover:border-slate-200 transition-all">Edit</button>
                        <button @click="programDetail = {{ json_encode($program) }}" class="flex-1 py-2 text-sm font-bold text-red-600 hover:text-red-700 hover:bg-white rounded-lg border border-transparent hover:border-red-100 transition-all">Detail</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Class Detail Modal -->
        <div x-show="classDetail" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="classDetail" @click="classDetail = null" class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-slate-900 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="classDetail" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                     <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-bold text-slate-900 mb-4" x-text="classDetail?.name"></h3>
                         <div class="space-y-4">
                            <!-- Mock Details -->
                            <p class="text-sm text-slate-600">Detail layout untuk kelas ini akan ditampilkan di sini.</p>
                         </div>
                     </div>
                     <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button @click="classDetail = null" type="button" class="w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
         <!-- Program Detail Modal -->
        <div x-show="programDetail" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="programDetail" @click="programDetail = null" class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-slate-900 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="programDetail" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                     <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-bold text-slate-900 mb-4" x-text="programDetail?.name"></h3>
                         <div class="space-y-4">
                             <!-- Mock Details -->
                            <p class="text-sm text-slate-600" x-text="programDetail?.description"></p>
                         </div>
                     </div>
                     <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button @click="programDetail = null" type="button" class="w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
