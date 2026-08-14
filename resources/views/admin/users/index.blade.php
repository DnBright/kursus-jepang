<x-admin-layout>
    <div x-data="{ userDetail: null, editUser: null }" class="space-y-6">
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

        <!-- Success & Error Alerts -->
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl flex items-center gap-3 animate-fade-in">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span class="text-sm font-bold">{{ session('success') }}</span>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 bg-rose-50 border border-rose-100 text-rose-700 rounded-2xl animate-fade-in">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-sm font-bold">Terjadi kesalahan input:</span>
                </div>
                <ul class="list-disc pl-8 text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

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
                                <div class="flex items-center justify-end gap-1">
                                    @if($student->status === 'pending')
                                        <a href="{{ route('admin.users.approve.get', $student->id) }}" class="inline-block p-2 text-green-600 hover:bg-green-50 rounded-lg transition-colors border border-transparent hover:border-green-100" title="Approve User">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </a>
                                        <a href="{{ route('admin.users.reject.get', $student->id) }}" class="inline-block p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100" title="Reject User">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </a>
                                    @endif
                                    
                                    <!-- Detail Button -->
                                    <button @click="userDetail = {{ json_encode($student) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100" title="Detail Siswa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>

                                    <!-- Edit Button -->
                                    <button @click="editUser = {{ json_encode($student) }}" class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition-colors border border-transparent hover:border-amber-100" title="Edit Siswa">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>

                                    <!-- Block/Suspend/Activate Account -->
                                    @if(isset($student->status) && $student->status === 'suspended')
                                        <a href="{{ route('admin.users.approve.get', $student->id) }}" onclick="return confirm('Apakah Anda yakin ingin mengaktifkan akun ini?');" class="inline-block p-2 text-green-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition-colors border border-transparent hover:border-green-100" title="Aktifkan Akun">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        </a>
                                    @elseif(!isset($student->status) || $student->status !== 'pending')
                                        <a href="{{ route('admin.users.suspend.get', $student->id) }}" onclick="return confirm('Apakah Anda yakin ingin me-suspend akun ini?');" class="inline-block p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100" title="Suspend Akun">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                        </a>
                                    @endif

                                    <!-- Delete Button -->
                                    <form action="{{ route('admin.users.destroy', $student->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun siswa ini secara permanen? Semua data transaksi, progres belajar, kuis, dan sertifikat yang terkait akan ikut terhapus.');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100" title="Hapus Siswa">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
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

        <!-- Edit Student Modal -->
        <div x-show="editUser" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="editUser" @click="editUser = null" class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-slate-900 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="editUser" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                     <form :action="'{{ url('/admin/users') }}/' + editUser?.id" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-bold text-slate-900 mb-4">Edit Data Siswa</h3>
                             <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Nama Lengkap</label>
                                    <input type="text" name="name" :value="editUser?.name" required class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Email Address</label>
                                    <input type="email" name="email" :value="editUser?.email" required class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Paket Kursus</label>
                                    <select name="selected_package" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                        <option value="">Pilih Paket Kursus (None)</option>
                                        <option value="Basic N5" :selected="editUser?.selected_package === 'Basic N5'">Basic N5</option>
                                        <option value="N5 Basic" :selected="editUser?.selected_package === 'N5 Basic'">N5 Basic</option>
                                        <option value="Intensive N4" :selected="editUser?.selected_package === 'Intensive N4'">Intensive N4</option>
                                        <option value="Tokutei Ginou" :selected="editUser?.selected_package === 'Tokutei Ginou'">Tokutei Ginou</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Status Akun</label>
                                    <select name="status" required class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                        <option value="active" :selected="editUser?.status === 'active'">Aktif</option>
                                        <option value="pending" :selected="editUser?.status === 'pending'">Pending</option>
                                        <option value="suspended" :selected="editUser?.status === 'suspended'">Suspended</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">Password Baru (Opsional)</label>
                                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin diubah" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                </div>
                             </div>
                        </div>
                        <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                            <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                Simpan Perubahan
                            </button>
                            <button @click="editUser = null" type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                     </form>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
