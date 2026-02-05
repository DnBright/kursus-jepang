<x-admin-layout>
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard Admin</h1>
            <p class="text-slate-500 text-sm mt-1">Ringkasan sistem & aktivitas platform Kursus Jepang.</p>
        </div>
        
        <div class="flex items-center gap-3">
             <button class="p-2 relative text-slate-400 hover:text-slate-600 hover:bg-white rounded-xl transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-red-500 border border-white"></span>
            </button>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-8">
        <!-- Total Siswa -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                 <div class="p-2 rounded-lg bg-blue-50 text-blue-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Total Siswa</span>
            </div>
            <div class="text-2xl font-bold text-slate-900">{{ $stats['total_students'] }}</div>
        </div>

        <!-- Total Sensei -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                 <div class="p-2 rounded-lg bg-purple-50 text-purple-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Total Sensei</span>
            </div>
            <div class="text-2xl font-bold text-slate-900">{{ $stats['total_sensei'] }}</div>
        </div>

         <!-- Kelas Aktif -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                 <div class="p-2 rounded-lg bg-green-50 text-green-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Kelas Aktif</span>
            </div>
            <div class="text-2xl font-bold text-slate-900">{{ $stats['active_classes'] }}</div>
        </div>

        <!-- Pending Reg (Highlighted) -->
        <div class="bg-red-50 p-5 rounded-2xl border border-red-100 shadow-sm relative overflow-hidden group">
             <div class="absolute right-0 top-0 p-3 opacity-10 text-red-600 group-hover:scale-110 transition-transform">
                <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
            </div>
            <div class="flex items-center gap-3 mb-2 relative z-10">
                 <div class="p-2 rounded-lg bg-white/50 text-red-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-red-800 uppercase tracking-wider">Pending Validasi</span>
            </div>
            <div class="text-2xl font-bold text-red-600 relative z-10">{{ $stats['pending_registrations'] }}</div>
        </div>

         <!-- Transaksi -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                 <div class="p-2 rounded-lg bg-yellow-50 text-yellow-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Transaksi</span>
            </div>
            <div class="text-2xl font-bold text-slate-900">{{ $stats['total_transactions'] }}</div>
        </div>

        <!-- Sertifikat -->
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center gap-3 mb-2">
                 <div class="p-2 rounded-lg bg-teal-50 text-teal-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138z"></path></svg>
                </div>
                <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Sertifikat</span>
            </div>
            <div class="text-2xl font-bold text-slate-900">{{ $stats['certificates_issued'] }}</div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        <!-- Left Column: Validation Panel -->
        <div class="xl:col-span-2 space-y-8">
            <!-- Pending Users -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Validasi Pendaftaran Siswa</h2>
                        <p class="text-slate-500 text-sm">Konfirmasi pembayaran dan akses member baru.</p>
                    </div>
                    <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-3 py-1 rounded-full">{{ $pendingUsers->count() }} Pending</span>
                </div>
                
                @if(session('success'))
                    <div class="p-4 bg-green-50 text-green-700 border-b border-green-100 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">User</th>
                                <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Paket</th>
                                <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                                <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($pendingUsers as $user)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                                            {{ substr($user->name, 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-slate-900 text-sm">{{ $user->name }}</div>
                                            <div class="text-xs text-slate-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 uppercase">
                                        {{ $user->selected_package ?? 'N5 Basic' }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-yellow-50 text-yellow-700 border border-yellow-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-yellow-500 animate-pulse"></span> Pending Payment
                                    </span>
                                </td>
                                <td class="p-4 text-right space-x-1">
                                    <form action="{{ route('admin.users.approve', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="p-1.5 text-green-600 hover:bg-green-50 rounded-lg transition-colors" title="Approve">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.reject', $user->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="p-1.5 text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Reject">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="p-8 text-center text-slate-500 text-sm italic">
                                    Tidak ada pendaftaran pending saat ini.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <!-- Right Column: Charts & Activity -->
        <div class="space-y-8">
            <!-- Charts (Placeholder) -->
             <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-4">Statistik Pendaftaran</h3>
                <div class="h-48 bg-slate-50 rounded-xl flex items-end justify-between p-4 px-6 gap-2">
                    <!-- Mock Bars -->
                    <div class="w-full bg-red-100 rounded-t-lg h-[40%] hover:bg-red-200 transition-colors relative group">
                        <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">12</div>
                    </div>
                    <div class="w-full bg-red-100 rounded-t-lg h-[60%] hover:bg-red-200 transition-colors relative group">
                         <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">18</div>
                    </div>
                    <div class="w-full bg-red-100 rounded-t-lg h-[30%] hover:bg-red-200 transition-colors relative group">
                         <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">8</div>
                    </div>
                    <div class="w-full bg-red-500 rounded-t-lg h-[80%] hover:bg-red-600 transition-colors relative group">
                         <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">24</div>
                    </div>
                    <div class="w-full bg-red-100 rounded-t-lg h-[50%] hover:bg-red-200 transition-colors relative group">
                         <div class="absolute -top-6 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-[10px] py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition-opacity">15</div>
                    </div>
                </div>
                 <div class="flex justify-between mt-2 text-[10px] text-slate-400 font-bold uppercase">
                    <span>Sen</span>
                    <span>Sel</span>
                    <span>Rab</span>
                    <span>Kam</span>
                    <span>Jum</span>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
                <h3 class="font-bold text-slate-900 mb-4">Aktivitas Terbaru</h3>
                <div class="space-y-6 relative before:absolute before:inset-y-0 before:left-3.5 before:w-0.5 before:bg-slate-100">
                    @foreach($recent_activities as $activity)
                    <div class="relative pl-10">
                        <div class="absolute left-0 top-1 w-8 h-8 rounded-full border-4 border-white shadow-sm flex items-center justify-center bg-{{ $activity['color'] }}-100 text-{{ $activity['color'] }}-600 z-10">
                             <!-- Icons handling -->
                             @if($activity['icon'] == 'user-plus')
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                             @elseif($activity['icon'] == 'currency-dollar')
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                             @elseif($activity['icon'] == 'check-circle')
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                             @else
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                             @endif
                        </div>
                        <p class="text-sm font-bold text-slate-800">{{ $activity['description'] }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $activity['time'] }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
