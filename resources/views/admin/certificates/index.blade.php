<x-admin-layout>
    <div x-data="{ activeTab: 'approvals', reviewModal: null }" class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Sertifikat</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola, validasi, dan terbitkan sertifikat kelulusan siswa.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                 <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Template Sertifikat
                </button>
                <button class="px-4 py-2 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-colors text-sm flex items-center gap-2 shadow-lg shadow-red-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Generate Sertifikat
                </button>
            </div>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Total Sertifikat Terbit</span>
                <span class="text-xl font-bold text-green-600">{{ $stats['total_issued'] }}</span>
            </div>
             <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Menunggu Persetujuan</span>
                <span class="text-xl font-bold text-yellow-600">{{ $stats['pending_count'] }}</span>
            </div>
            <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Terbit Bulan Ini</span>
                <span class="text-xl font-bold text-blue-600">{{ $stats['this_month'] }}</span>
            </div>
             <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Sertifikat Ditolak</span>
                <span class="text-xl font-bold text-red-600">{{ $stats['rejected_count'] }}</span>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="border-b border-slate-200">
            <nav class="-mb-px flex space-x-8">
                <button @click="activeTab = 'approvals'"
                    :class="{ 'border-red-500 text-red-600': activeTab === 'approvals', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'approvals' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Menunggu Approval
                </button>

                <button @click="activeTab = 'issued'"
                    :class="{ 'border-red-500 text-red-600': activeTab === 'issued', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'issued' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Sertifikat Terbit
                </button>
                
                 <button @click="activeTab = 'templates'"
                    :class="{ 'border-red-500 text-red-600': activeTab === 'templates', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'templates' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Template
                </button>
            </nav>
        </div>

        <!-- 1. Approval Tab -->
        <div x-show="activeTab === 'approvals'" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden text-left" style="display: none;">
            <!-- Filter -->
            <div class="p-4 border-b border-slate-100 flex justify-between items-center bg-yellow-50/50">
                 <p class="text-sm text-yellow-800 font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Ada {{ $stats['pending_count'] }} permohonan sertifikat yang perlu ditinjau.
                </p>
                 <div class="relative w-64">
                    <input type="text" class="pl-9 pr-4 py-1.5 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-yellow-500 w-full shadow-sm" placeholder="Cari siswa...">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                 </div>
            </div>
            
             <div class="overflow-x-auto">
                 <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Siswa</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Program</th>
                             <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kelas</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Progress</th>
                             <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Nilai Akhir</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                     <tbody class="divide-y divide-slate-100">
                        @forelse($pendingApprovals as $approval)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 font-bold text-slate-900 text-sm">{{ $approval->student_name }}</td>
                             <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded text-[11px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                    {{ $approval->program }}
                                </span>
                            </td>
                            <td class="p-4 text-sm text-slate-600">{{ $approval->class_name }}</td>
                             <td class="p-4 text-center">
                                 <span class="text-sm font-bold text-green-600">{{ $approval->progress }}%</span>
                             </td>
                             <td class="p-4 text-center">
                                 <span class="text-sm font-bold text-slate-900">{{ $approval->final_score }}</span>
                             </td>
                            <td class="p-4 text-right">
                                <button @click="reviewModal = {{ json_encode($approval) }}" class="px-3 py-1.5 bg-slate-900 text-white text-xs font-bold rounded-lg hover:bg-slate-800 transition-colors shadow-sm">Review</button>
                            </td>
                        </tr>
                        @empty
                         <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400 text-sm">Tidak ada permohonan sertifikat saat ini.</td>
                        </tr>
                        @endforelse
                     </tbody>
                 </table>
             </div>
        </div>

        <!-- 2. Issued Tab -->
        <div x-show="activeTab === 'issued'" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden text-left" style="display: none;">
             <div class="overflow-x-auto">
                 <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">No. Sertifikat</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Siswa</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Program</th>
                             <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Terbit</th>
                             <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($issuedCertificates as $cert)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4 text-xs font-mono font-bold text-slate-500">{{ $cert->certificate_no }}</td>
                            <td class="p-4 font-bold text-slate-900 text-sm">{{ $cert->student_name }}</td>
                            <td class="p-4 text-sm text-slate-600">{{ $cert->program }}</td>
                            <td class="p-4 text-sm text-slate-500">{{ $cert->issue_date->format('d M Y') }}</td>
                            <td class="p-4">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-100">Valid</span>
                            </td>
                            <td class="p-4 text-right">
                                <button class="text-xs text-blue-600 hover:text-blue-800 hover:underline">Download PDF</button>
                            </td>
                        </tr>
                        @empty
                         <tr>
                            <td colspan="6" class="p-12 text-center text-slate-400 text-sm">Belum ada sertifikat yang diterbitkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                 </table>
             </div>
        </div>
        
         <!-- 3. Templates Tab -->
        <div x-show="activeTab === 'templates'" style="display: none;">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                 @foreach($templates as $template)
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition-shadow cursor-pointer">
                    <div class="h-48 bg-slate-100 flex items-center justify-center text-slate-400 font-bold text-sm">
                        PREVIEW {{ strtoupper($template->name) }}
                    </div>
                    <div class="p-4">
                         <div class="flex justify-between items-center mb-2">
                            <h3 class="font-bold text-slate-900 text-sm">{{ $template->name }}</h3>
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                {{ $template->level }}
                            </span>
                        </div>
                        <div class="flex items-center gap-2 mt-4">
                            <button class="flex-1 py-1.5 bg-slate-50 border border-slate-200 rounded text-xs font-bold text-slate-600 hover:bg-slate-100">Edit</button>
                            <button class="flex-1 py-1.5 bg-slate-900 border border-transparent rounded text-xs font-bold text-white hover:bg-slate-800">Set Default</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Review Modal -->
        <div x-show="reviewModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="reviewModal" @click="reviewModal = null" class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-slate-900 opacity-75"></div>
                </div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="reviewModal" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl w-full">
                     <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="flex justify-between items-start mb-6">
                             <div>
                                <h3 class="text-lg leading-6 font-bold text-slate-900">Review Kelulusan Siswa</h3>
                                <p class="text-xs text-slate-500" x-text="'Request Date: ' + reviewModal?.student_name"></p>
                            </div>
                        </div>
                        
                         <div class="space-y-4">
                            <div class="p-4 bg-yellow-50 rounded-xl border border-yellow-100">
                                <h4 class="text-sm font-bold text-yellow-800 mb-3">Persyaratan Kelulusan</h4>
                                <ul class="text-xs text-yellow-700 space-y-1 ml-4 list-disc">
                                    <li>Progress materi minimal 100% <span class="font-bold text-green-700 ml-1">✓ OK</span></li>
                                    <li>Nilai akhir minimal 85 (Grade A) <span class="font-bold text-green-700 ml-1">✓ OK</span></li>
                                    <li>Tidak ada tunggakan administrasi <span class="font-bold text-green-700 ml-1">✓ OK</span></li>
                                </ul>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-100 text-center">
                                    <span class="block text-xs text-slate-500 uppercase font-bold">Progress</span>
                                    <span class="block text-xl font-bold text-slate-900" x-text="reviewModal?.progress + '%'"></span>
                                </div>
                                <div class="bg-slate-50 p-3 rounded-lg border border-slate-100 text-center">
                                    <span class="block text-xs text-slate-500 uppercase font-bold">Final Score</span>
                                    <span class="block text-xl font-bold text-slate-900" x-text="reviewModal?.final_score"></span>
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Preview Sertifikat</label>
                                <div class="aspect-video bg-slate-200 rounded-lg flex items-center justify-center text-slate-500 text-sm font-bold">
                                    PREVIEW GENERATED CERTIFICATE
                                </div>
                            </div>
                         </div>
                     </div>
                     <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse gap-2">
                        <button type="button" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                            Approve & Generate
                        </button>
                         <button type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Reject
                        </button>
                        <button @click="reviewModal = null" type="button" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-admin-layout>
