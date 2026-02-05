<x-admin-layout>
    <div x-data="{ activeTab: 'overview' }" class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Laporan & Statistik</h1>
                <p class="text-slate-500 text-sm mt-1">Analisis performa platform, aktivitas pembelajaran, dan keuangan.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                 <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Pilih Periode
                </button>
                <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors text-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export Laporan
                </button>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="border-b border-slate-200 overflow-x-auto">
            <nav class="-mb-px flex space-x-8 min-w-max">
                @foreach(['overview' => 'Overview', 'users' => 'User', 'classes' => 'Kelas', 'finance' => 'Keuangan', 'certificates' => 'Sertifikat'] as $key => $label)
                <button @click="activeTab = '{{ $key }}'"
                    :class="{ 'border-red-500 text-red-600': activeTab === '{{ $key }}', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== '{{ $key }}' }"
                    class="whitespace-nowrap py-4 px-1 border-b-2 font-bold text-sm transition-colors uppercase tracking-wider">
                    {{ $label }}
                </button>
                @endforeach
            </nav>
        </div>

        <!-- 1. Overview Tab -->
        <div x-show="activeTab === 'overview'" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                 <div class="bg-slate-900 rounded-xl p-5 text-white shadow-lg shadow-slate-900/10">
                    <div class="text-slate-400 text-[10px] font-bold uppercase tracking-wider mb-1">Total Pendapatan</div>
                    <div class="text-xl font-bold">{{ $overviewStats['total_revenue'] }}</div>
                </div>
                 <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
                    <div class="text-slate-500 text-[10px] font-bold uppercase tracking-wider mb-1">Total User</div>
                    <div class="text-2xl font-bold text-slate-900">{{ $overviewStats['total_users'] }}</div>
                </div>
                <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
                    <div class="text-slate-500 text-[10px] font-bold uppercase tracking-wider mb-1">Siswa Aktif</div>
                    <div class="text-2xl font-bold text-blue-600">{{ $overviewStats['active_students'] }}</div>
                </div>
                <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
                    <div class="text-slate-500 text-[10px] font-bold uppercase tracking-wider mb-1">Sensei Aktif</div>
                    <div class="text-2xl font-bold text-purple-600">{{ $overviewStats['active_sensei'] }}</div>
                </div>
                 <div class="bg-white rounded-xl p-5 border border-slate-200 shadow-sm">
                    <div class="text-slate-500 text-[10px] font-bold uppercase tracking-wider mb-1">Kelas Aktif</div>
                    <div class="text-2xl font-bold text-green-600">{{ $overviewStats['active_classes'] }}</div>
                </div>
            </div>

            <!-- Mock Chart Area -->
             <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <h3 class="font-bold text-slate-900 mb-4">Pertumbuhan User (30 Hari Terakhir)</h3>
                    <div class="h-64 flex items-end gap-2 justify-between px-2">
                        @for($i = 0; $i < 15; $i++)
                            <div class="w-full bg-blue-100 rounded-t-sm hover:bg-blue-200 transition-colors relative group" style="height: {{ rand(20, 100) }}%">
                                 <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 hidden group-hover:block bg-slate-800 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                                   {{ rand(10, 50) }} User
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
                 <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <h3 class="font-bold text-slate-900 mb-4">Pendapatan Bulanan (2025-2026)</h3>
                    <div class="h-64 flex items-end gap-4 justify-between px-2">
                         @for($i = 0; $i < 6; $i++)
                            <div class="w-full bg-green-100 rounded-t-sm hover:bg-green-200 transition-colors relative group" style="height: {{ rand(40, 100) }}%">
                                <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-1 hidden group-hover:block bg-slate-800 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap z-10">
                                   Rp {{ rand(20, 100) }}jt
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. User Tab -->
        <div x-show="activeTab === 'users'" class="space-y-6 text-center py-12 bg-white rounded-2xl border border-slate-200 shadow-sm" style="display: none;">
             <div class="max-w-2xl mx-auto px-6">
                <h3 class="text-lg font-bold text-slate-900 mb-2">Analisis Pengguna</h3>
                <p class="text-slate-500 text-sm mb-8">Detail pertumbuhan dan aktivitas pengguna platform.</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                     <div class="p-4 bg-slate-50 rounded-xl">
                        <div class="text-2xl font-bold text-slate-900 mb-1">{{ $userStats['new_users_this_month'] }}</div>
                        <div class="text-xs text-slate-500 font-bold uppercase">User Baru / Bulan</div>
                     </div>
                     <div class="p-4 bg-slate-50 rounded-xl">
                        <div class="text-2xl font-bold text-green-600 mb-1">{{ $userStats['active_users_growth'] }}</div>
                        <div class="text-xs text-slate-500 font-bold uppercase">Pertumbuhan</div>
                     </div>
                     <div class="p-4 bg-slate-50 rounded-xl">
                        <div class="text-2xl font-bold text-blue-600 mb-1">{{ $userStats['retention_rate'] }}</div>
                        <div class="text-xs text-slate-500 font-bold uppercase">Retensi Siswa</div>
                     </div>
                </div>
             </div>
        </div>

        <!-- 3. Classes Tab -->
        <div x-show="activeTab === 'classes'" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden" style="display: none;">
             <div class="p-6 border-b border-slate-100">
                <h3 class="font-bold text-slate-900">Performa Kelas</h3>
            </div>
             <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Kelas</th>
                        <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Jml Siswa</th>
                        <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Rata-rata Nilai</th>
                        <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tingkat Penyelesaian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($classMetrics as $class)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="p-4 font-bold text-slate-900 text-sm">{{ $class->name }}</td>
                        <td class="p-4 text-center text-sm text-slate-600">{{ $class->students }}</td>
                        <td class="p-4 text-center">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold {{ $class->avg_score >= 85 ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ $class->avg_score }}
                            </span>
                        </td>
                         <td class="p-4 align-middle">
                            <div class="w-full bg-slate-100 rounded-full h-2.5 max-w-[150px]">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $class->completion }}%"></div>
                            </div>
                            <span class="text-xs text-slate-500 mt-1 inline-block">{{ $class->completion }}% Completed</span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
             </table>
        </div>

        <!-- 4. Finance Tab -->
        <div x-show="activeTab === 'finance'" class="space-y-6 text-center py-12 bg-white rounded-2xl border border-slate-200 shadow-sm" style="display: none;">
             <div class="max-w-2xl mx-auto px-6">
                <h3 class="text-lg font-bold text-slate-900 mb-2">Laporan Keuangan</h3>
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 mt-6">
                     <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="text-xl font-bold text-slate-900 mb-1">{{ $financeStats['gross_revenue'] }}</div>
                        <div class="text-xs text-slate-500 font-bold uppercase">Pendapatan Kotor</div>
                     </div>
                     <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="text-xl font-bold text-green-600 mb-1">{{ $financeStats['successful_transactions'] }}</div>
                        <div class="text-xs text-slate-500 font-bold uppercase">Transaksi Berhasil</div>
                     </div>
                      <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="text-xl font-bold text-blue-600 mb-1">{{ $financeStats['avg_transaction_value'] }}</div>
                        <div class="text-xs text-slate-500 font-bold uppercase">Rata-rata Transaksi</div>
                     </div>
                </div>
            </div>
        </div>
        
         <!-- 5. Certificates Tab -->
        <div x-show="activeTab === 'certificates'" class="space-y-6 text-center py-12 bg-white rounded-2xl border border-slate-200 shadow-sm" style="display: none;">
             <div class="max-w-2xl mx-auto px-6">
                 <h3 class="text-lg font-bold text-slate-900 mb-2">Metrik Sertifikat</h3>
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 mt-6">
                     <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="text-xl font-bold text-slate-900 mb-1">{{ $certificateStats['issued_this_month'] }}</div>
                        <div class="text-xs text-slate-500 font-bold uppercase">Terbit Bulan Ini</div>
                     </div>
                     <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="text-xl font-bold text-yellow-600 mb-1">{{ $certificateStats['avg_approval_time'] }}</div>
                        <div class="text-xs text-slate-500 font-bold uppercase">Rata-rata Approval</div>
                     </div>
                      <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="text-xl font-bold text-red-600 mb-1">{{ $certificateStats['rejection_rate'] }}</div>
                        <div class="text-xs text-slate-500 font-bold uppercase">Tingkat Penolakan</div>
                     </div>
                </div>
             </div>
        </div>

    </div>
</x-admin-layout>
