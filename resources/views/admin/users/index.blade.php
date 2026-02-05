<x-admin-layout>
    <div x-data="{ activeTab: 'students', userDetail: null, senseiDetail: null }" class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Manajemen User</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola akun siswa dan pengajar secara terpusat.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                 <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 w-full sm:w-64 shadow-sm" placeholder="Cari nama atau email...">
                </div>
                 <select class="py-2 pl-3 pr-8 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 shadow-sm cursor-pointer">
                    <option>Semua Role</option>
                    <option>Siswa</option>
                    <option>Sensei</option>
                </select>
            </div>
        </div>

        <!-- Stats Overview (Optional) -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Total Aktif</span>
                <span class="text-xl font-bold text-green-600">{{ $stats['total_active'] }}</span>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Total Siswa</span>
                <span class="text-xl font-bold text-blue-600">{{ $stats['total_students'] }}</span>
            </div>
             <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Total Sensei</span>
                <span class="text-xl font-bold text-purple-600">{{ $stats['total_sensei'] }}</span>
            </div>
             <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Nonaktif/Suspended</span>
                <span class="text-xl font-bold text-red-600">{{ $stats['total_inactive'] }}</span>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="border-b border-slate-200">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'students'"
                    :class="{ 'border-red-500 text-red-600': activeTab === 'students', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'students' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Manajemen Siswa
                </button>

                <button @click="activeTab = 'senseis'"
                    :class="{ 'border-red-500 text-red-600': activeTab === 'senseis', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'senseis' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Manajemen Sensei
                </button>
            </nav>
        </div>

        <!-- Student Management Tab -->
        <div x-show="activeTab === 'students'" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden" style="display: none;">
            <!-- Table -->
            <div class="overflow-x-auto">
                 <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Siswa</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Paket Kursus</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Bergabung</th>
                             <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider w-1/5">Progress</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($students as $student)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                                        {{ substr($student->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm">{{ $student->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $student->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $student->selected_package ?? 'N5 Basic' }}
                                </span>
                            </td>
                            <td class="p-4 text-sm text-slate-600">
                                {{ $student->created_at->format('d M Y') }}
                            </td>
                            <td class="p-4">
                                 <div class="flex items-center gap-3">
                                    <div class="flex-1 h-1.5 bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full rounded-full bg-blue-500" style="width: {{ $student->progress ?? 0 }}%"></div>
                                    </div>
                                    <span class="text-xs font-bold text-slate-600 w-6">{{ $student->progress ?? 0 }}%</span>
                                </div>
                            </td>
                            <td class="p-4">
                                @if(isset($student->status) && $student->status === 'suspended')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-100">
                                        Suspended
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-100">
                                        Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="userDetail = {{ json_encode($student) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100" title="Edit Siswa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                     <button class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100" title="Suspend Akun">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                         <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400 text-sm">
                                Tidak ada data siswa ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Sensei Management Tab -->
        <div x-show="activeTab === 'senseis'" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden" style="display: none;">
             <!-- Table -->
            <div class="overflow-x-auto">
                 <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Sensei</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Bidang Ajar</th>
                             <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Jumlah Kelas</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Bergabung</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($senseis as $sensei)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                                        {{ substr($sensei->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm">{{ $sensei->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $sensei->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[11px] font-bold bg-purple-50 text-purple-700 border border-purple-100">
                                    {{ $sensei->teaching_field ?? 'N5, N4' }}
                                </span>
                            </td>
                             <td class="p-4 text-center text-sm font-bold text-slate-700">
                                {{ $sensei->class_count ?? 0 }}
                            </td>
                            <td class="p-4 text-sm text-slate-600">
                                {{ $sensei->created_at->format('d M Y') }}
                            </td>
                            <td class="p-4">
                                @if(isset($sensei->status) && $sensei->status === 'inactive')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                        Nonaktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-100">
                                        Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                     <button @click="senseiDetail = {{ json_encode($sensei) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100" title="Edit Sensei">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                         <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400 text-sm">
                                Tidak ada data sensei ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Student Detail Modal -->
        <div x-show="userDetail" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <!-- Simple Modal Content for Demo -->
             <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="userDetail" @click="userDetail = null" class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-slate-900 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="userDetail" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                     <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-bold text-slate-900 mb-4">Edit Data Siswa</h3>
                         <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                                <input type="text" :value="userDetail?.name" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Email Address</label>
                                <input type="email" :value="userDetail?.email" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                            </div>
                         </div>
                     </div>
                     <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="button" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Simpan Perubahan
                        </button>
                        <button @click="userDetail = null" type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
