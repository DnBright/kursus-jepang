<x-admin-layout>
    <div x-data="{ userDetail: null }" class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Manajemen Siswa</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola akun siswa secara terpusat.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 w-full sm:w-auto">
                 <div class="relative flex-1 sm:flex-none">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="pl-9 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500 w-full sm:w-64 shadow-sm" placeholder="Cari nama atau email...">
                </div>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4">
            <div class="bg-white p-3 md:p-4 rounded-2xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Total Siswa</span>
                <span class="text-xl md:text-2xl font-bold text-blue-600">{{ $stats['total_students'] }}</span>
            </div>
            <div class="bg-white p-3 md:p-4 rounded-2xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Total Aktif</span>
                <span class="text-xl md:text-2xl font-bold text-green-600">{{ $stats['total_active'] }}</span>
            </div>
             <div class="bg-white p-3 md:p-4 rounded-2xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Suspended / Nonaktif</span>
                <span class="text-xl md:text-2xl font-bold text-red-600">{{ $stats['total_inactive'] }}</span>
            </div>
        </div>

        <!-- Student Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
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
                                @elseif(isset($student->status) && $student->status === 'pending')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-yellow-50 text-yellow-700 border border-yellow-100">
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-100">
                                        Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if($student->status === 'pending')
                                        <a href="{{ route('admin.users.approve.get', $student->id) }}" class="inline-block p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors border border-transparent hover:border-green-100" title="Approve User">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </a>
                                        <a href="{{ route('admin.users.reject.get', $student->id) }}" class="inline-block p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100" title="Reject User">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </a>
                                    @endif
                                    <button @click="userDetail = {{ json_encode($student) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100" title="Detail Siswa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                    @if(isset($student->status) && $student->status === 'suspended')
                                        <a href="{{ route('admin.users.approve.get', $student->id) }}" onclick="return confirm('Apakah Anda yakin ingin mengaktifkan akun ini?');" class="inline-block p-2 text-green-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition-colors border border-transparent hover:border-green-100" title="Aktifkan Akun">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </a>
                                    @elseif(!isset($student->status) || $student->status !== 'pending')
                                        <a href="{{ route('admin.users.suspend.get', $student->id) }}" onclick="return confirm('Apakah Anda yakin ingin me-suspend akun ini?');" class="inline-block p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100" title="Suspend Akun">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        </a>
                                    @endif
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

        <!-- Student Detail Modal -->
        <div x-show="userDetail" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="userDetail" @click="userDetail = null" class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-slate-900 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="userDetail" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                     <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-bold text-slate-900 mb-4">Detail Data Siswa</h3>
                         <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                                <div class="mt-1 p-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm font-medium" x-text="userDetail?.name"></div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Email Address</label>
                                <div class="mt-1 p-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm font-medium" x-text="userDetail?.email"></div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Paket Kursus</label>
                                <div class="mt-1 p-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm font-medium" x-text="userDetail?.selected_package ?? 'N5 Basic'"></div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Tanggal Bergabung</label>
                                <div class="mt-1 p-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm font-medium" x-text="userDetail ? new Date(userDetail.created_at).toLocaleDateString('id-ID', {day: 'numeric', month: 'long', year: 'numeric'}) : ''"></div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">Status Akun</label>
                                <div class="mt-1 p-2.5 bg-slate-50 border border-slate-200 rounded-lg text-slate-800 text-sm font-medium" x-text="userDetail?.status === 'suspended' ? 'Suspended' : (userDetail?.status === 'pending' ? 'Pending' : 'Aktif')"></div>
                            </div>
                         </div>
                     </div>
                     <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button @click="userDetail = null" type="button" class="w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none sm:w-auto sm:text-sm">
                            Tutup
                        </button>
                     </div>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
