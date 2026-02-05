<x-app-layout>
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Jadwal Kelas Live</h2>
                <p class="text-slate-500 text-sm mt-1">Jangan lewatkan sesi live teaching bersama Sensei expert kami.</p>
            </div>
            <!-- Toggle View (Optional Future Feature) -->
            <div class="flex bg-slate-100 p-1 rounded-xl">
                <button class="px-4 py-1.5 bg-white shadow-sm text-slate-900 text-sm font-bold rounded-lg truncate">List View</button>
                <button class="px-4 py-1.5 text-slate-500 hover:text-slate-700 text-sm font-medium rounded-lg truncate">Calendar</button>
            </div>
        </div>

        <!-- Featured / Live Now Section -->
        <div class="bg-red-900 rounded-3xl p-8 text-white relative overflow-hidden shadow-xl shadow-red-900/20">
            <!-- Background Decoration -->
            <div class="absolute inset-0 opacity-20" style="background-image: url('https://www.transparenttextures.com/patterns/shattered-island.png');"></div>
             <!-- Pulse Circle for LIVE effect -->
            <div class="absolute -right-20 -top-20 w-64 h-64 bg-red-600 rounded-full blur-3xl opacity-40 animate-pulse"></div>

            <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                <!-- Date Badge -->
                <div class="flex-shrink-0 text-center bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl p-4 w-full md:w-24">
                    <span class="block text-red-200 text-xs font-bold uppercase tracking-wider mb-1">Hari Ini</span>
                    <span class="block text-3xl font-bold">05</span>
                    <span class="block text-sm font-medium">Jan</span>
                </div>

                <!-- Content -->
                <div class="flex-1 text-center md:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-red-600 text-white text-xs font-bold uppercase tracking-wide mb-4 animate-pulse">
                        <span class="w-1.5 h-1.5 bg-white rounded-full"></span>
                        Sedang Berlangsung (Live Now)
                    </div>
                    <h3 class="text-3xl font-bold mb-2">Bunpou N4: Mastering Conditional Forms (Tara, Ba, Nara)</h3>
                    <p class="text-red-100 mb-4 flex items-center justify-center md:justify-start gap-4">
                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 19:00 - 20:30 WIB</span>
                        <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg> Tanaka Sensei</span>
                    </p>
                    <button class="inline-flex items-center gap-2 px-6 py-3 bg-white text-red-700 font-bold rounded-xl hover:bg-red-50 transition-colors shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                        Join Zoom Meeting
                    </button>
                </div>
            </div>
        </div>

        <!-- Upcoming & Past Classes Grid -->
        <h3 class="text-xl font-bold text-slate-800 pt-4">Kelas Mendatang & Riwayat</h3>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <!-- Card: Upcoming -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 hover:border-red-200 hover:shadow-lg transition-all group flex flex-col md:flex-row gap-6">
                <!-- Date Box -->
                <div class="flex-shrink-0 w-full md:w-20 bg-slate-50 rounded-xl flex flex-col items-center justify-center p-4 border border-slate-100 group-hover:bg-red-50 group-hover:border-red-100 transition-colors">
                    <span class="text-slate-400 text-xs font-bold uppercase mb-1">Besok</span>
                    <span class="text-2xl font-bold text-slate-900 group-hover:text-red-600">06</span>
                    <span class="text-sm font-medium text-slate-500">Jan</span>
                </div>

                <div class="flex-1">
                    <div class="flex justify-between items-start mb-2">
                        <span class="px-2.5 py-0.5 rounded-md bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider">Intensive N4</span>
                        <span class="text-sm font-medium text-slate-500">19:30 WIB</span>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-red-700 transition-colors">Kaiwa Practice: Job Interview Simulation</h4>
                    <p class="text-slate-500 text-sm mb-4 line-clamp-2">Simulasi wawancara kerja dengan native speaker. Persiapkan jikoshoukai terbaikmu.</p>
                    
                    <div class="flex items-center justify-between border-t border-slate-100 pt-4 mt-auto">
                        <div class="flex items-center gap-2 text-sm text-slate-600 font-medium">
                            <div class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-xs">S</div>
                            Sato Sensei
                        </div>
                        <button disabled class="px-4 py-2 bg-slate-100 text-slate-400 font-bold rounded-lg text-sm cursor-not-allowed">
                            Belum Mulai
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card: Completed -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200 hover:shadow-md transition-all group flex flex-col md:flex-row gap-6 opacity-75 hover:opacity-100">
                <!-- Date Box -->
                <div class="flex-shrink-0 w-full md:w-20 bg-slate-50 rounded-xl flex flex-col items-center justify-center p-4 border border-slate-100">
                    <span class="text-slate-400 text-xs font-bold uppercase mb-1">Selesai</span>
                    <span class="text-2xl font-bold text-slate-400">03</span>
                    <span class="text-sm font-medium text-slate-400">Jan</span>
                </div>

                <div class="flex-1">
                    <div class="flex justify-between items-start mb-2">
                        <span class="px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-500 text-xs font-bold uppercase tracking-wider">Basic N5</span>
                        <span class="text-sm font-medium text-slate-400">Selesai</span>
                    </div>
                    <h4 class="text-lg font-bold text-slate-700 mb-2">Materi 5: Partikel Dasar (Wa, Ga, O)</h4>
                    <p class="text-slate-400 text-sm mb-4 line-clamp-2">Pembahasan mendalam tentang penggunaan partikel dasar yang sering membingungkan pemula.</p>
                    
                    <div class="flex items-center justify-between border-t border-slate-100 pt-4 mt-auto">
                         <div class="flex items-center gap-2 text-sm text-slate-500 font-medium">
                            <div class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-xs">B</div>
                            Budi Sensei
                        </div>
                        <button class="px-4 py-2 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 font-bold rounded-lg text-sm flex items-center gap-2 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Tonton Rekaman
                        </button>
                    </div>
                </div>
            </div>

            <!-- Card: Upcoming 2 -->
             <div class="bg-white rounded-2xl p-6 border border-slate-200 hover:border-red-200 hover:shadow-lg transition-all group flex flex-col md:flex-row gap-6">
                <!-- Date Box -->
                <div class="flex-shrink-0 w-full md:w-20 bg-slate-50 rounded-xl flex flex-col items-center justify-center p-4 border border-slate-100 group-hover:bg-red-50 group-hover:border-red-100 transition-colors">
                    <span class="text-slate-400 text-xs font-bold uppercase mb-1">Minggu Depan</span>
                    <span class="text-2xl font-bold text-slate-900 group-hover:text-red-600">12</span>
                    <span class="text-sm font-medium text-slate-500">Jan</span>
                </div>

                <div class="flex-1">
                    <div class="flex justify-between items-start mb-2">
                        <span class="px-2.5 py-0.5 rounded-md bg-green-50 text-green-600 text-xs font-bold uppercase tracking-wider">Tokutei Ginou</span>
                        <span class="text-sm font-medium text-slate-500">10:00 WIB</span>
                    </div>
                    <h4 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-red-700 transition-colors">Caregiver Vocabulary Drill</h4>
                    <p class="text-slate-500 text-sm mb-4 line-clamp-2">Latihan kosakata khusus bidang Kaigo (Caregiver) part 1.</p>
                    
                    <div class="flex items-center justify-between border-t border-slate-100 pt-4 mt-auto">
                        <div class="flex items-center gap-2 text-sm text-slate-600 font-medium">
                            <div class="w-6 h-6 rounded-full bg-slate-200 flex items-center justify-center text-xs">Y</div>
                            Yuki Sensei
                        </div>
                        <button disabled class="px-4 py-2 bg-slate-100 text-slate-400 font-bold rounded-lg text-sm cursor-not-allowed">
                            Belum Mulai
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
