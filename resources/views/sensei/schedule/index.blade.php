<x-sensei-layout>
    <div class="space-y-8">
        <!-- Header & Top Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Jadwal Mengajar</h2>
                <p class="text-slate-500 text-sm mt-1">Kelola dan pantau agenda kelas Anda secara terstruktur.</p>
            </div>
            
             <button class="px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 hover:shadow-red-600/40 transition-all flex items-center gap-2 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Jadwal
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
             <!-- Sidebar: Today's Agenda -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sticky top-24">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-bold text-slate-900">Agenda Hari Ini</h3>
                        <span class="text-xs font-bold text-white bg-red-500 px-2 py-1 rounded-full">{{ count($today_agenda) }}</span>
                    </div>
                    
                    @if(count($today_agenda) > 0)
                        <div class="space-y-4">
                            @foreach($today_agenda as $index => $agenda)
                            <div class="relative pl-4 border-l-2 {{ $agenda['status'] === 'upcoming' ? 'border-red-500' : 'border-slate-200' }}">
                                <div class="mb-1">
                                    <span class="text-xs font-bold text-slate-500">{{ $agenda['time_start'] }} - {{ $agenda['time_end'] }}</span>
                                </div>
                                <h4 class="font-bold text-slate-900 text-sm leading-tight">{{ $agenda['title'] }}</h4>
                                <p class="text-[11px] text-slate-500 mt-1">{{ $agenda['class'] }} • {{ $agenda['platform'] }}</p>
                                
                                @if($index === 0 && $agenda['status'] === 'upcoming')
                                    <button class="mt-3 w-full py-2 bg-red-600 text-white text-xs font-bold rounded-lg hover:bg-red-700 transition-colors shadow-sm shadow-red-600/20">
                                        Mulai Kelas Sekarang
                                    </button>
                                @elseif($agenda['type'] === 'consultation')
                                     <button class="mt-3 w-full py-2 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition-colors shadow-sm shadow-blue-600/20">
                                        Masuk Room Konsultasi
                                    </button>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    @else
                         <div class="text-center py-6">
                            <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-400">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <p class="text-slate-500 text-sm">Tidak ada agenda hari ini.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Main Content: Calendar View -->
            <div class="lg:col-span-3">
                 <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden min-h-[600px]">
                    <!-- Calendar Toolbar -->
                    <div class="p-4 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <button class="p-2 hover:bg-slate-100 rounded-lg text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                            </button>
                             <h3 class="font-bold text-slate-900 text-lg">Januari 2024</h3>
                             <button class="p-2 hover:bg-slate-100 rounded-lg text-slate-500">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>
                        
                         <div class="flex items-center bg-slate-100 p-1 rounded-lg">
                            <button class="px-3 py-1.5 text-xs font-bold rounded-md bg-white text-slate-900 shadow-sm">Mingguan</button>
                            <button class="px-3 py-1.5 text-xs font-bold rounded-md text-slate-500 hover:text-slate-900">Bulanan</button>
                            <button class="px-3 py-1.5 text-xs font-bold rounded-md text-slate-500 hover:text-slate-900">List View</button>
                        </div>
                    </div>

                    <!-- Weekly Grid (Simplified Visual Representation) -->
                    <div class="overflow-x-auto">
                        <div class="min-w-[800px]">
                            <!-- Header Row -->
                            <div class="grid grid-cols-7 border-b border-slate-100 bg-slate-50/50">
                                @foreach(['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'] as $day)
                                <div class="p-3 text-center border-r border-slate-100 last:border-r-0">
                                    <span class="text-xs font-bold text-slate-500 uppercase">{{ $day }}</span>
                                </div>
                                @endforeach
                            </div>

                             <!-- Days Columns -->
                            <div class="grid grid-cols-7 min-h-[500px] bg-slate-50/30">
                                @foreach($weekly_schedule as $day => $events)
                                <div class="border-r border-slate-100 last:border-r-0 p-2 space-y-2 relative group hover:bg-white transition-colors">
                                    @foreach($events as $event)
                                        <div class="p-3 rounded-lg border text-xs cursor-pointer hover:shadow-md transition-all
                                            {{ $event['type'] === 'live_class' ? 'bg-red-50 border-red-100 text-red-700' : '' }}
                                            {{ $event['type'] === 'consultation' ? 'bg-blue-50 border-blue-100 text-blue-700' : '' }}
                                            {{ $event['type'] === 'exam' ? 'bg-purple-50 border-purple-100 text-purple-700' : '' }}
                                        ">
                                            <div class="font-bold truncate" title="{{ $event['title'] }}">{{ $event['title'] }}</div>
                                            <div class="mt-1 opacity-75">{{ $event['time'] }}</div>
                                             @if(isset($event['level']))
                                            <div class="mt-1.5 inline-block px-1.5 py-0.5 bg-white/50 rounded text-[9px] font-bold border border-black/5 uppercase">
                                                {{ $event['level'] }}
                                            </div>
                                            @endif
                                        </div>
                                    @endforeach
                                    
                                    <!-- Add Button on Hover -->
                                    <button class="absolute bottom-2 right-2 p-1.5 rounded-full bg-slate-200 text-slate-500 hover:bg-slate-300 hover:text-slate-700 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-sensei-layout>
