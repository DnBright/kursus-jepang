<x-sensei-layout>
    <div class="space-y-8">
        <!-- Header Content -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                 <h2 class="text-2xl font-bold text-slate-900">Ringkasan Hari Ini</h2>
                 <p class="text-slate-500 text-sm mt-1">Pantau aktivitas kelas dan siswa Anda.</p>
            </div>
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-700 shadow-sm">
                🎓 Sensei Aktif: {{ Auth::guard('sensei')->user()->name }}
            </span>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-6">
            <!-- Active Classes -->
            <div class="bg-white p-4 lg:p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center gap-3 lg:gap-4 hover:shadow-md transition-shadow">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg lg:text-xl font-bold shrink-0">📘</div>
                <div class="text-center sm:text-left">
                    <h4 class="text-slate-500 text-[10px] lg:text-xs font-bold uppercase tracking-wide">Kelas Aktif</h4>
                    <p class="text-xl lg:text-2xl font-bold text-slate-900">{{ $stats['active_classes'] }}</p>
                </div>
            </div>

            <!-- Total Students -->
            <div class="bg-white p-4 lg:p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center gap-3 lg:gap-4 hover:shadow-md transition-shadow">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-lg lg:text-xl font-bold shrink-0">👥</div>
                <div class="text-center sm:text-left">
                    <h4 class="text-slate-500 text-[10px] lg:text-xs font-bold uppercase tracking-wide">Total Siswa</h4>
                    <p class="text-xl lg:text-2xl font-bold text-slate-900">{{ $stats['total_students'] }}</p>
                </div>
            </div>

            <!-- Today's Schedule -->
            <div class="bg-white p-4 lg:p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center gap-3 lg:gap-4 hover:shadow-md transition-shadow">
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg lg:text-xl font-bold shrink-0">🗓</div>
                <div class="text-center sm:text-left">
                    <h4 class="text-slate-500 text-[10px] lg:text-xs font-bold uppercase tracking-wide">Jadwal Hari Ini</h4>
                    <p class="text-xl lg:text-2xl font-bold text-slate-900">{{ $stats['today_schedule'] }} <span class="text-xs lg:text-sm font-medium text-slate-400">Kelas</span></p>
                </div>
            </div>

            <!-- Grading Needed -->
            <div class="bg-white p-4 lg:p-6 rounded-2xl border border-red-50 shadow-sm flex flex-col sm:flex-row items-center gap-3 lg:gap-4 hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="absolute right-0 top-0 w-12 h-12 lg:w-16 lg:h-16 bg-red-500 rounded-full blur-2xl opacity-10 -mr-6 lg:-mr-8 -mt-6 lg:-mt-8"></div>
                <div class="w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-lg lg:text-xl font-bold shrink-0 {{ $stats['grading_needed'] > 0 ? 'animate-pulse' : '' }}">📝</div>
                <div class="text-center sm:text-left">
                    <h4 class="text-red-500 text-[10px] lg:text-xs font-bold uppercase tracking-wide">Perlu Dinilai</h4>
                    <p class="text-xl lg:text-2xl font-bold text-slate-900">{{ $stats['grading_needed'] }} <span class="text-xs lg:text-sm font-medium text-slate-400">Tugas</span></p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Column (Upcoming & Activity) -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Upcoming Class -->
                <section>
                    <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-red-600 rounded-full"></span>
                        Kelas Terdekat
                    </h3>
                    @if($upcomingClass)
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:border-red-200 transition-colors group">
                        <div class="flex flex-col sm:flex-row gap-6">
                            <div class="flex-shrink-0 w-full sm:w-24 bg-red-50 rounded-xl flex flex-col items-center justify-center p-4 border border-red-100 text-red-700">
                                <span class="text-[10px] font-bold uppercase mb-1">{{ $upcomingClass->scheduled_at->translatedFormat('d M') }}</span>
                                <span class="text-2xl font-bold">{{ $upcomingClass->scheduled_at->format('H:i') }}</span>
                                <span class="text-[10px] font-bold uppercase mt-1">WIB</span>
                            </div>

                            <div class="flex-1">
                                <div class="flex flex-wrap gap-2 mb-2">
                                    <span class="px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-600 text-xs font-bold uppercase tracking-wider">{{ $upcomingClass->course->title }}</span>
                                    <span class="px-2.5 py-0.5 rounded-md bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider">Zoom</span>
                                </div>
                                <h4 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-red-700 transition-colors">{{ $upcomingClass->title }}</h4>
                                <p class="text-slate-500 text-sm mb-4 line-clamp-2">{{ $upcomingClass->description }}</p>
                                
                                <div class="flex flex-wrap gap-3 mt-auto">
                                    <a href="{{ $upcomingClass->zoom_link }}" target="_blank" class="px-6 py-2.5 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 hover:shadow-red-600/40 transition-all flex items-center gap-2 text-sm">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        Join Zoom Meet
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="bg-white rounded-2xl p-12 border border-dashed border-slate-300 text-center">
                        <p class="text-slate-500 italic">Tidak ada jadwal live class terdekat.</p>
                        <a href="{{ route('sensei.live.create') }}" class="mt-4 inline-block text-red-600 font-bold hover:underline">+ Jadwalkan Sekarang</a>
                    </div>
                    @endif
                </section>

                <!-- Recent Activity -->
                <section>
                    <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-slate-300 rounded-full"></span>
                        Aktivitas Terakhir
                    </h3>
                    <div class="bg-white rounded-2xl border border-slate-200 divide-y divide-slate-100 overflow-hidden">
                        @forelse($recentActivities as $activity)
                        <div class="p-4 flex items-start gap-4 hover:bg-slate-50 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-lg">{{ $activity['icon'] }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-slate-900 font-medium">{!! $activity['text'] !!}</p>
                                <p class="text-[10px] text-slate-500 mt-1 uppercase font-bold tracking-wider">{{ $activity['time'] }}</p>
                            </div>
                             @if(isset($activity['action_url']))
                            <a href="{{ $activity['action_url'] }}" class="text-xs font-bold text-red-600 hover:text-red-700 bg-red-50 px-3 py-1 rounded-full">{{ $activity['action_label'] }}</a>
                            @endif
                        </div>
                        @empty
                        <div class="p-10 text-center text-slate-400 italic text-sm">
                            Belum ada aktivitas siswa baru-baru ini.
                        </div>
                        @endforelse
                    </div>
                </section>
            </div>

            <!-- Sidebar Column (Quick Actions) -->
            <div class="space-y-8">
                 <section>
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Aksi Cepat</h3>
                    <div class="grid gap-3">
                        <a href="{{ route('sensei.materials.lessons.create') }}" class="flex items-center gap-3 w-full p-4 bg-white border border-slate-200 rounded-xl hover:border-red-200 hover:shadow-md transition-all text-left group">
                            <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 group-hover:text-red-600">Buat Materi Baru</h4>
                                <p class="text-xs text-slate-500">Video, PDF, atau Teks</p>
                            </div>
                        </a>

                         <a href="{{ route('sensei.live.create') }}" class="flex items-center gap-3 w-full p-4 bg-white border border-slate-200 rounded-xl hover:border-red-200 hover:shadow-md transition-all text-left group">
                            <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 group-hover:text-red-600">Jadwalkan Live Class</h4>
                                <p class="text-xs text-slate-500">Buat sesi Zoom baru</p>
                            </div>
                        </a>

                         <a href="{{ route('sensei.quizzes.create') }}" class="flex items-center gap-3 w-full p-4 bg-white border border-slate-200 rounded-xl hover:border-red-200 hover:shadow-md transition-all text-left group">
                            <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 group-hover:text-red-600">Buat Quiz Baru</h4>
                                <p class="text-xs text-slate-500">Evaluasi pemahaman siswa</p>
                            </div>
                        </a>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-sensei-layout>
