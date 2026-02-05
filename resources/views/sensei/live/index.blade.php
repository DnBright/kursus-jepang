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
            
            <button class="px-6 py-2.5 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 hover:shadow-red-600/40 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Jadwalkan Live Class
            </button>
        </div>

        <!-- Summary Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total This Month -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                 <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-bold">
                    📅
                </div>
                <div>
                    <h4 class="text-slate-500 text-xs font-bold uppercase tracking-wide">Total Bulan Ini</h4>
                    <p class="text-2xl font-bold text-slate-900">{{ $summary['total_this_month'] }} <span class="text-sm font-medium text-slate-400">Sesi</span></p>
                </div>
            </div>

             <!-- Today -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                 <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold">
                    🎯
                </div>
                <div>
                    <h4 class="text-slate-500 text-xs font-bold uppercase tracking-wide">Hari Ini</h4>
                    <p class="text-2xl font-bold text-slate-900">{{ $summary['today_count'] }} <span class="text-sm font-medium text-slate-400">Sesi</span></p>
                </div>
            </div>

            <!-- Ongoing -->
             <div class="bg-white p-6 rounded-2xl border border-red-50 shadow-sm flex items-center gap-4 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-16 h-16 bg-red-500 rounded-full blur-2xl opacity-10 -mr-8 -mt-8"></div>
                 <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl font-bold animate-pulse">
                    🎥
                </div>
                <div>
                    <h4 class="text-red-500 text-xs font-bold uppercase tracking-wide">Sedang Berlangsung</h4>
                    <p class="text-2xl font-bold text-slate-900">{{ $summary['ongoing_count'] }} <span class="text-sm font-medium text-slate-400">Sesi</span></p>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <!-- Tabs & Filters -->
            <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <!-- Tabs -->
                 <div class="flex bg-slate-100 rounded-lg p-1 gap-1 self-start sm:self-auto">
                    <button class="px-4 py-2 text-sm font-bold rounded-md bg-white text-slate-900 shadow-sm transition-all">
                        Akan Datang
                    </button>
                    <button class="px-4 py-2 text-sm font-bold rounded-md text-slate-500 hover:text-slate-700 hover:bg-slate-200/50 transition-all">
                        Sedang Berlangsung
                    </button>
                     <button class="px-4 py-2 text-sm font-bold rounded-md text-slate-500 hover:text-slate-700 hover:bg-slate-200/50 transition-all">
                        Selesai
                    </button>
                </div>

                <!-- Search & Actions -->
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <div class="relative flex-1 sm:flex-none">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" class="pl-9 pr-4 py-2 bg-slate-50 border-none rounded-lg text-sm focus:ring-2 focus:ring-red-500 w-full sm:w-64" placeholder="Cari sesi live...">
                    </div>
                    <button class="p-2 text-slate-400 hover:text-slate-600 bg-slate-50 rounded-lg hover:bg-slate-100 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    </button>
                </div>
            </div>

            <!-- Session List -->
            <div class="divide-y divide-slate-100">
                @foreach($sessions as $session)
                <div class="p-6 hover:bg-slate-50 transition-colors flex flex-col md:flex-row gap-6 group">
                     <!-- Date Badge (Left) -->
                    <div class="flex-shrink-0 w-full md:w-32 bg-slate-50 rounded-xl border border-slate-200 flex flex-col items-center justify-center p-4 text-center">
                         <span class="text-xs font-bold uppercase text-slate-500 mb-1">{{ $session['date'] }}</span>
                         <span class="text-xl font-bold text-slate-900">{{ $session['time_start'] }}</span>
                         <span class="text-[10px] font-bold text-slate-400 uppercase">WIB</span>
                    </div>

                    <!-- Main Info (Middle) -->
                    <div class="flex-1 min-w-0">
                         <div class="flex items-center gap-2 mb-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                {{ $session['level'] === 'N5' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $session['level'] === 'N4' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $session['level'] === 'N3' ? 'bg-purple-100 text-purple-700' : '' }}
                                {{ $session['level'] === 'TG' ? 'bg-orange-100 text-orange-700' : '' }}
                            ">
                                {{ $session['level'] }}
                            </span>
                             <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-500">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                {{ $session['platform'] }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-1 group-hover:text-red-700 transition-colors truncate">{{ $session['title'] }}</h3>
                        <p class="text-slate-500 text-sm mb-3 truncate">{{ $session['topic'] }}</p>
                        
                        <div class="flex items-center gap-4 text-xs font-medium text-slate-500">
                             <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $session['time'] }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                {{ $session['students_count'] }} Terdaftar
                            </span>
                        </div>
                    </div>

                    <!-- Status & Actions (Right) -->
                    <div class="flex flex-row md:flex-col items-center md:items-end justify-between md:justify-center gap-4 min-w-[140px]">
                        @if($session['status'] === 'live')
                             <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 border border-red-200 animate-pulse">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-600"></span>
                                LIVE
                            </span>
                            <button class="px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-lg shadow-sm shadow-red-600/20 hover:bg-red-700 transition-all w-full md:w-auto text-center">
                                Join Session
                            </button>
                        @elseif($session['status'] === 'upcoming')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                Akan Datang
                            </span>
                             <button class="px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-lg hover:bg-slate-50 transition-all w-full md:w-auto text-center">
                                Edit Jadwal
                            </button>
                        @else
                             <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                Selesai
                            </span>
                             <button class="px-4 py-2 text-slate-500 text-sm font-bold hover:text-slate-700 transition-all w-full md:w-auto text-center">
                                Lihat Rekaman
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
             <!-- Pagination -->
            <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex justify-center">
                <button class="text-xs font-bold text-slate-500 hover:text-slate-700 transition-colors">Muat Lebih Banyak</button>
            </div>
        </div>
    </div>
</x-sensei-layout>
