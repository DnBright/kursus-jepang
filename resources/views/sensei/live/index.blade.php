<x-sensei-layout>
    <div class="space-y-8">
        <!-- Header & Top Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Live Class</h2>
                <div class="flex items-center gap-2 text-sm text-slate-500 mt-1">
                    <span>Dashboard</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span>Live Class</span>
                </div>
            </div>
            
            <a href="{{ route('sensei.live.create') }}" class="px-6 py-2.5 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 hover:shadow-red-600/40 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Jadwalkan Live Class
            </a>
        </div>

        <!-- Summary Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                 <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-bold">📅</div>
                <div>
                    <h4 class="text-slate-500 text-xs font-bold uppercase tracking-wide">Total Bulan Ini</h4>
                    <p class="text-2xl font-bold text-slate-900">{{ $summary['total_this_month'] }} <span class="text-sm font-medium text-slate-400">Sesi</span></p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                 <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold">🎯</div>
                <div>
                    <h4 class="text-slate-500 text-xs font-bold uppercase tracking-wide">Hari Ini</h4>
                    <p class="text-2xl font-bold text-slate-900">{{ $summary['today_count'] }} <span class="text-sm font-medium text-slate-400">Sesi</span></p>
                </div>
            </div>

             <div class="bg-white p-6 rounded-2xl border border-red-50 shadow-sm flex items-center gap-4 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-16 h-16 bg-red-500 rounded-full blur-2xl opacity-10 -mr-8 -mt-8"></div>
                 <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl font-bold {{ $summary['ongoing_count'] > 0 ? 'animate-pulse' : '' }}">🎥</div>
                <div>
                    <h4 class="text-red-500 text-xs font-bold uppercase tracking-wide">Sedang Berlangsung</h4>
                    <p class="text-2xl font-bold text-slate-900">{{ $summary['ongoing_count'] }} <span class="text-sm font-medium text-slate-400">Sesi</span></p>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <!-- Tabs & Filters (Mock/Static for now) -->
            <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                 <div class="flex bg-slate-100 rounded-lg p-1 gap-1">
                    <button class="px-4 py-2 text-sm font-bold rounded-md bg-white text-slate-900 shadow-sm">Semua Sesi</button>
                </div>
                <div class="relative w-full sm:w-64">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="pl-9 pr-4 py-2 bg-slate-50 border-none rounded-lg text-sm focus:ring-2 focus:ring-red-500 w-full" placeholder="Cari sesi live...">
                </div>
            </div>

            <!-- Session List -->
            <div class="divide-y divide-slate-100">
                @forelse($sessions as $session)
                <div class="p-6 hover:bg-slate-50 transition-colors flex flex-col md:flex-row gap-6 group">
                     <!-- Date Badge -->
                    <div class="flex-shrink-0 w-full md:w-32 bg-slate-50 rounded-xl border border-slate-200 flex flex-col items-center justify-center p-4 text-center">
                         <span class="text-[10px] font-bold uppercase text-slate-500 mb-1">{{ $session['date'] }}</span>
                         <span class="text-xl font-bold text-slate-900">{{ $session['time_start'] }}</span>
                         <span class="text-[10px] font-bold text-slate-400 uppercase">WIB</span>
                    </div>

                    <!-- Info -->
                    <div class="flex-1 min-w-0">
                         <div class="flex items-center gap-2 mb-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-red-100 text-red-700">{{ $session['level'] }}</span>
                             <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-700">Zoom</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-1 group-hover:text-red-700 transition-colors truncate">{{ $session['title'] }}</h3>
                        <p class="text-slate-500 text-sm mb-3 truncate">{{ $session['topic'] }}</p>
                        <div class="flex items-center gap-4 text-xs font-medium text-slate-500">
                             <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>{{ $session['time'] }}</span>
                            <span class="flex items-center gap-1.5"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>{{ $session['students_count'] }} Terdaftar</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex flex-row md:flex-col items-center md:items-end justify-between md:justify-center gap-4 min-w-[140px]">
                        @if($session['status'] === 'live')
                             <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200 animate-pulse">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span> LIVE
                            </span>
                            <a href="{{ $session['zoom_link'] }}" target="_blank" class="px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-lg shadow-sm hover:bg-red-700 transition-all w-full md:w-auto text-center">Join Zoom</a>
                        @elseif($session['status'] === 'upcoming')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100">Akan Datang</span>
                             <div class="flex gap-2">
                                <a href="{{ route('sensei.live.edit', $session['id']) }}" class="p-2 bg-white border border-slate-200 text-slate-700 rounded-lg hover:bg-slate-50 transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg></a>
                                <form action="{{ route('sensei.live.destroy', $session['id']) }}" method="POST" onsubmit="return confirm('Hapus jadwal live class ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 bg-white border border-red-100 text-red-600 rounded-lg hover:bg-red-50 transition-all"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg></button>
                                </form>
                             </div>
                        @else
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">Selesai</span>
                        @endif
                    </div>
                </div>
                @empty
                <div class="p-20 text-center">
                    <p class="text-slate-500 italic">Belum ada jadwal Live Class.</p>
                    <a href="{{ route('sensei.live.create') }}" class="mt-4 inline-block text-red-600 font-bold hover:underline">+ Jadwalkan Sesi Pertama</a>
                </div>
                @endforelse
            </div>
             <!-- Pagination -->
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-center">
                <button class="text-xs font-bold text-slate-500 hover:text-slate-700 transition-colors">Tampilkan Semua</button>
            </div>
        </div>
    </div>
</x-sensei-layout>
