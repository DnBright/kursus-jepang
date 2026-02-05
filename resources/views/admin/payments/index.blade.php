<x-admin-layout>
    <div x-data="{ transactionDetail: null }" class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Pembayaran</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola dan pantau seluruh transaksi pembayaran.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                 <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    Filter Transaksi
                </button>
                <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12"></path></svg>
                    Export Data
                </button>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
             <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Pendapatan Bulan Ini</span>
                <span class="text-xl font-bold text-slate-900">{{ $stats['revenue_this_month'] }}</span>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Pembayaran Berhasil</span>
                <span class="text-xl font-bold text-green-600">{{ $stats['success_count'] }}</span>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Menunggu Verifikasi</span>
                <span class="text-xl font-bold text-yellow-600">{{ $stats['pending_count'] }}</span>
            </div>
             <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Pembayaran Gagal</span>
                <span class="text-xl font-bold text-red-600">{{ $stats['failed_count'] }}</span>
            </div>
        </div>

        <!-- Transaction Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden text-left">
            <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row gap-3 justify-between">
                <div class="relative w-full sm:w-64">
                     <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 w-full shadow-sm" placeholder="Cari ID transaksi atau nama...">
                </div>
                 <select class="py-2 pl-3 pr-8 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 shadow-sm cursor-pointer">
                    <option>Semua Status</option>
                    <option>Berhasil</option>
                    <option>Pending</option>
                    <option>Gagal</option>
                </select>
            </div>
            
            <div class="overflow-x-auto">
                 <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">ID Transaksi</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Siswa</th>
                             <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Program</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Metode</th>
                             <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nominal</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($transactions as $trx)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 text-xs font-bold text-slate-500">
                                {{ $trx->id }}
                            </td>
                            <td class="p-4 font-bold text-slate-900 text-sm">
                                {{ $trx->student_name }}
                            </td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $trx->program }}
                                </span>
                            </td>
                             <td class="p-4 text-sm text-slate-600">
                                {{ $trx->method }}
                            </td>
                             <td class="p-4 text-xs text-slate-500">
                                {{ $trx->date->format('d M Y H:i') }}
                            </td>
                            <td class="p-4 font-bold text-slate-900 text-sm">
                                {{ $trx->amount }}
                            </td>
                            <td class="p-4">
                                @if($trx->status == 'success')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-100">
                                        Berhasil
                                    </span>
                                @elseif($trx->status == 'pending')
                                     <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-yellow-50 text-yellow-700 border border-yellow-100">
                                        Pending
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-700 border border-red-100">
                                        Gagal
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                     <button @click="transactionDetail = {{ json_encode($trx) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                         <tr>
                            <td colspan="8" class="p-12 text-center text-slate-400 text-sm">Tidak ada transaksi ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Payment Detail Modal -->
        <div x-show="transactionDetail" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="transactionDetail" @click="transactionDetail = null" class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-slate-900 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="transactionDetail" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                     <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h3 class="text-lg leading-6 font-bold text-slate-900">Detail Pembayaran</h3>
                                <p class="text-xs text-slate-500" x-text="transactionDetail?.id"></p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-yellow-50 text-yellow-700 border border-yellow-100" x-text="transactionDetail?.status"></span>
                        </div>
                        
                         <div class="space-y-4">
                            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-slate-500">Siswa</span>
                                    <span class="text-sm font-bold text-slate-900" x-text="transactionDetail?.student_name"></span>
                                </div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm text-slate-500">Program</span>
                                    <span class="text-sm font-bold text-slate-900" x-text="transactionDetail?.program"></span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-sm text-slate-500">Nominal Transfer</span>
                                    <span class="text-sm font-bold text-slate-900" x-text="transactionDetail?.amount"></span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Bukti Pembayaran</label>
                                <div class="border-2 border-dashed border-slate-300 rounded-lg p-8 text-center bg-slate-50">
                                    <span class="text-sm text-slate-400">Placeholder Bukti Transfer</span>
                                </div>
                            </div>
                         </div>
                     </div>
                     <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="button" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Konfirmasi Pembayaran
                        </button>
                         <button type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Tolak
                        </button>
                        <button @click="transactionDetail = null" type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
