<x-sensei-layout>
    <div class="space-y-8">
        <!-- Header & Action Toolbar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Kelas Saya</h2>
                <p class="text-slate-500 text-sm mt-1">Kelola semua kelas yang Anda ajar.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                <!-- Search -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 w-full sm:w-64 shadow-sm" placeholder="Cari nama kelas atau level...">
                </div>

                <!-- Filters -->
                <div class="flex bg-white rounded-lg border border-slate-200 p-1 shadow-sm">
                    <button class="px-3 py-1.5 text-xs font-bold rounded-md bg-slate-900 text-white shadow-sm">
                        Semua
                    </button>
                    <button class="px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:bg-slate-50">
                        Aktif
                    </button>
                     <button class="px-3 py-1.5 text-xs font-bold rounded-md text-slate-600 hover:bg-slate-50">
                        Selesai
                    </button>
                </div>
            </div>
        </div>

        <!-- Class Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($classes as $class)
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all group flex flex-col h-full relative overflow-hidden">
                @if($class['is_today'])
                    <div class="absolute top-0 right-0">
                        <div class="bg-red-600 text-white text-[10px] font-bold px-3 py-1 rounded-bl-xl uppercase tracking-wider">
                            Hari Ini
                        </div>
                    </div>
                @endif

                <div class="p-6 flex-1">
                    <!-- Level Badge -->
                    <div class="mb-4 flex justify-between items-start">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-bold uppercase tracking-wider
                            {{ $class['level'] === 'N5' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $class['level'] === 'N4' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $class['level'] === 'N3' ? 'bg-purple-100 text-purple-700' : '' }}
                            {{ $class['level'] === 'TG' ? 'bg-orange-100 text-orange-700' : '' }}
                        ">
                            {{ $class['level'] }}
                        </span>
                        @if($class['status'] === 'active')
                             <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                Aktif
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                Selesai
                            </span>
                        @endif
                    </div>

                    <!-- Title -->
                    <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-red-700 transition-colors line-clamp-2 min-h-[3.5rem]">{{ $class['name'] }}</h3>

                    <!-- Stats -->
                    <div class="space-y-3 mt-4">
                        <div class="flex items-center gap-3 text-sm text-slate-600">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <span class="font-medium">{{ $class['students_count'] }} Siswa</span>
                        </div>
                         <div class="flex items-center gap-3 text-sm text-slate-600">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div class="flex flex-col leading-tight">
                                <span class="font-medium">{{ $class['schedule_day'] }}</span>
                                <span class="text-xs text-slate-400">{{ $class['schedule_time'] }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 text-sm text-slate-600">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </div>
                            <span class="font-medium">{{ $class['platform'] }}</span>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="p-4 border-t border-slate-100 bg-slate-50/50 flex items-center gap-3">
                    @if($class['is_today'])
                        <button class="flex-1 px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-lg shadow-sm shadow-red-600/20 hover:bg-red-700 hover:shadow-red-600/40 transition-all flex items-center justify-center gap-2">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Mulai
                        </button>
                    @endif
                    <button class="flex-1 px-4 py-2 bg-white border border-slate-200 text-slate-700 text-sm font-bold rounded-lg hover:bg-slate-50 hover:border-slate-300 transition-all">
                        Detail
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-sensei-layout>
