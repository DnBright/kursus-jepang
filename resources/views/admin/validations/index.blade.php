<x-admin-layout>
    <div class="p-6" x-data="{ activeTab: 'students', userDetail: null, previewImage: null }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Validasi Pendaftaran</h1>
                <p class="text-slate-500 text-sm mt-1">Review pendaftaran dan konfirmasi akses pengguna.</p>
            </div>
            
            <div class="flex items-center gap-2">
                 <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-3 py-1.5 rounded-full flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-yellow-500 animate-pulse"></span>
                    {{ $stats['pending_total'] }} Pending
                </span>
                <button class="p-2 text-slate-400 hover:text-slate-600 hover:bg-white rounded-xl transition-all relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-red-500 border border-white"></span>
                </button>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="border-b border-slate-200">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'students'"
                    :class="{ 'border-red-500 text-red-600': activeTab === 'students', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'students' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Pendaftaran Siswa
                    <span class="ml-1 bg-slate-100 text-slate-600 py-0.5 px-2 rounded-full text-xs" x-show="activeTab !== 'students'">{{ $pendingTransactions->count() }}</span>
                </button>
            </nav>
        </div>

        <!-- Student Validation Tab -->
        <div x-show="activeTab === 'students'" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden" style="display: none;">
            <!-- Filter & Search -->
            <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row gap-3 justify-between">
                <div class="relative w-full sm:w-64">
                     <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 w-full shadow-sm" placeholder="Cari nama atau email...">
                </div>
                <div class="flex gap-2">
                     <select class="py-2 pl-3 pr-8 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 shadow-sm cursor-pointer">
                        <option>Semua Status</option>
                        <option>Pending</option>
                        <option>Approved</option>
                        <option>Rejected</option>
                    </select>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                 <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Siswa</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Paket Kursus</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Pembayaran</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Daftar</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($pendingTransactions as $transaction)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                                        {{ substr($transaction->user->name, 0, 2) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm">{{ $transaction->user->name }}</div>
                                        <div class="text-xs text-slate-500">{{ $transaction->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $transaction->package_type }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="text-sm font-medium text-slate-700">{{ $transaction->payment_method ?? 'Transfer Bank' }}</div>
                                <button @click="previewImage = '{{ $transaction->payment_proof ? asset('storage/' . $transaction->payment_proof) : '' }}'; if('{{ $transaction->payment_proof }}') { previewImage = '{{ asset('storage/' . $transaction->payment_proof) }}' } else { alert('Tidak ada bukti transfer') }" class="text-xs text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1 mt-0.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                    Lihat Bukti
                                </button>
                            </td>
                            <td class="p-4 text-sm text-slate-600">
                                {{ $transaction->created_at->format('d M Y') }}
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-yellow-50 text-yellow-700 border border-yellow-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span> Pending
                                </span>
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button @click="userDetail = {{ json_encode($transaction->load('user')) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                     <form action="{{ route('admin.users.approve', $transaction->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="p-2 text-slate-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors border border-transparent hover:border-green-100" title="Setujui">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    </form>
                                     <form action="{{ route('admin.users.reject', $transaction->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors border border-transparent hover:border-red-100" title="Tolak">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                         <tr>
                            <td colspan="6" class="p-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <svg class="w-12 h-12 mb-3 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p class="text-sm font-medium text-slate-500">Tidak ada transaksi pending.</p>
                                </div>
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
                <div x-show="userDetail" class="fixed inset-0 transition-opacity" aria-hidden="true" @click="userDetail = null">
                    <div class="absolute inset-0 bg-slate-900 opacity-75"></div>
                </div>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    <div class="bg-white p-6">
                        <div class="flex justify-between items-start">
                            <h3 class="text-lg font-bold text-slate-900">
                                Detail Pendaftaran Siswa
                            </h3>
                            <button @click="userDetail = null" class="text-slate-400 hover:text-slate-500">
                                <span class="sr-only">Close</span>
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                        <div class="mt-4 space-y-4">
                            <div class="flex items-start gap-4 p-4 bg-slate-50 rounded-xl">
                                <div class="w-12 h-12 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-500 font-bold text-lg">
                                    <span x-text="userDetail?.user?.name.substring(0,2)"></span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900" x-text="userDetail?.user?.name"></h4>
                                    <p class="text-sm text-slate-500" x-text="userDetail?.user?.email"></p>
                                    <p class="text-xs text-slate-400 mt-1">Mendaftar pada <span x-text="new Date(userDetail?.created_at).toLocaleDateString()"></span></p>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div class="p-3 border border-slate-200 rounded-xl">
                                    <p class="text-xs text-slate-400 font-bold uppercase">Paket</p>
                                    <p class="font-bold text-blue-600" x-text="userDetail?.package_type || 'N5 Basic'"></p>
                                </div>
                                    <div class="p-3 border border-slate-200 rounded-xl">
                                    <p class="text-xs text-slate-400 font-bold uppercase">Metode Bayar</p>
                                    <p class="font-bold text-slate-700" x-text="userDetail?.payment_method || 'Transfer'"></p>
                                </div>
                            </div>
                            
                            <div class="p-3 border border-slate-200 rounded-xl">
                                <p class="text-xs text-slate-400 font-bold uppercase mb-2">Total Tagihan</p>
                                <p class="font-bold text-slate-900 text-xl" x-text="'Rp ' + (userDetail?.amount ? new Intl.NumberFormat('id-ID').format(userDetail.amount) : '0')"></p>
                            </div>

                            <div x-show="userDetail?.payment_proof" class="p-3 border border-slate-200 rounded-xl">
                                <p class="text-xs text-slate-400 font-bold uppercase mb-2">Bukti Transfer</p>
                                <img :src="'/storage/' + userDetail?.payment_proof" alt="Bukti Transfer" class="w-full rounded-lg border border-slate-200">
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-3">
                            <button @click="userDetail = null" class="px-4 py-2 bg-white text-slate-700 font-bold border border-slate-200 rounded-lg hover:bg-slate-50 text-sm">
                                Tutup
                            </button>
                            <!-- You might want to add approve/reject buttons here dynamically or keep them in the main table -->
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Preview Modal (Separate if needed, but included in detail now) -->
        <div x-show="previewImage" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
             <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true" @click="previewImage = null">
                    <div class="absolute inset-0 bg-slate-900 opacity-90"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="button" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            ACC & Aktifkan
                        </button>
                        <button type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Tolak
                        </button>
                        <button @click="userDetail = null" type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</x-admin-layout>
