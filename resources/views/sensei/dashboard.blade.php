<x-sensei-layout>
    <div class="space-y-8">
    <div class="space-y-8">
        <!-- Header Content -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                 <h2 class="text-2xl font-bold text-slate-900">Ringkasan Hari Ini</h2>
                 <p class="text-slate-500 text-sm mt-1">Pantau aktivitas kelas dan siswa Anda.</p>
            </div>
            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold bg-green-100 text-green-700 shadow-sm">
                🎓 Sensei Aktif
            </span>
        </div>

        <!-- Summary Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Active Classes -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold">
                    📘
                </div>
                <div>
                    <h4 class="text-slate-500 text-xs font-bold uppercase tracking-wide">Kelas Aktif</h4>
                    <p class="text-2xl font-bold text-slate-900">5</p>
                </div>
            </div>

            <!-- Total Students -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-xl font-bold">
                    👥
                </div>
                <div>
                    <h4 class="text-slate-500 text-xs font-bold uppercase tracking-wide">Total Siswa</h4>
                    <p class="text-2xl font-bold text-slate-900">128</p>
                </div>
            </div>

            <!-- Today's Schedule -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-bold">
                    🗓
                </div>
                <div>
                    <h4 class="text-slate-500 text-xs font-bold uppercase tracking-wide">Jadwal Hari Ini</h4>
                    <p class="text-2xl font-bold text-slate-900">2 <span class="text-sm font-medium text-slate-400">Kelas</span></p>
                </div>
            </div>

            <!-- Grading Needed -->
            <div class="bg-white p-6 rounded-2xl border border-red-50 shadow-sm flex items-center gap-4 hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="absolute right-0 top-0 w-16 h-16 bg-red-500 rounded-full blur-2xl opacity-10 -mr-8 -mt-8"></div>
                <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-xl font-bold animate-pulse">
                    📝
                </div>
                <div>
                    <h4 class="text-red-500 text-xs font-bold uppercase tracking-wide">Perlu Dinilai</h4>
                    <p class="text-2xl font-bold text-slate-900">8 <span class="text-sm font-medium text-slate-400">Tugas</span></p>
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
                    <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:border-red-200 transition-colors group">
                        <div class="flex flex-col sm:flex-row gap-6">
                            <!-- Date Box -->
                            <div class="flex-shrink-0 w-full sm:w-24 bg-red-50 rounded-xl flex flex-col items-center justify-center p-4 border border-red-100 text-red-700">
                                <span class="text-xs font-bold uppercase mb-1">Hari Ini</span>
                                <span class="text-3xl font-bold">19:00</span>
                                <span class="text-sm font-medium">WIB</span>
                            </div>

                            <div class="flex-1">
                                <div class="flex flex-wrap gap-2 mb-2">
                                    <span class="px-2.5 py-0.5 rounded-md bg-slate-100 text-slate-600 text-xs font-bold uppercase tracking-wider">Intensive N4</span>
                                    <span class="px-2.5 py-0.5 rounded-md bg-blue-50 text-blue-600 text-xs font-bold uppercase tracking-wider">Live Zoom</span>
                                </div>
                                <h4 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-red-700 transition-colors">Bunpou Practice: Conditional Forms</h4>
                                <p class="text-slate-500 text-sm mb-4">Materi fokus pada penggunaan Tara, Ba, dan Nara dalam percakapan sehari-hari.</p>
                                
                                <div class="flex flex-wrap gap-3 mt-auto">
                                    <button class="px-6 py-2.5 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 hover:shadow-red-600/40 transition-all flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                        Mulai Kelas
                                    </button>
                                     <button class="px-6 py-2.5 bg-white text-slate-700 border border-slate-200 font-bold rounded-xl hover:bg-slate-50 transition-all flex items-center gap-2">
                                        Lihat Detail
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Recent Activity -->
                <section>
                    <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <span class="w-1.5 h-6 bg-slate-300 rounded-full"></span>
                        Aktivitas Terakhir
                    </h3>
                    <div class="bg-white rounded-2xl border border-slate-200 divide-y divide-slate-100">
                        
                        <!-- Item 1 -->
                        <div class="p-4 flex items-start gap-4 hover:bg-slate-50 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-lg">📝</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-slate-900 font-medium"><span class="font-bold">Ahmad Rizki</span> mengumpulkan tugas <span class="font-bold text-slate-700">Sakubun (Writing) N4</span></p>
                                <p class="text-xs text-slate-500 mt-1">10 Menit yang lalu</p>
                            </div>
                            <button class="text-xs font-bold text-blue-600 hover:text-blue-700">Review</button>
                        </div>

                        <!-- Item 2 -->
                        <div class="p-4 flex items-start gap-4 hover:bg-slate-50 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-lg">📚</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-slate-900 font-medium"><span class="font-bold">Siti Aminah</span> menyelesaikan modul <span class="font-bold text-slate-700">Kanji N5 Bab 3</span></p>
                                <p class="text-xs text-slate-500 mt-1">35 Menit yang lalu</p>
                            </div>
                        </div>

                         <!-- Item 3 -->
                        <div class="p-4 flex items-start gap-4 hover:bg-slate-50 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center flex-shrink-0">
                                <span class="text-lg">💬</span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-slate-900 font-medium"><span class="font-bold">Budi Santoso</span> bertanya di diskusi <span class="font-bold text-slate-700">Partikel Wa & Ga</span></p>
                                <p class="text-xs text-slate-500 mt-1">1 Jam yang lalu</p>
                            </div>
                             <button class="text-xs font-bold text-blue-600 hover:text-blue-700">Balas</button>
                        </div>

                    </div>
                </section>
            </div>

            <!-- Sidebar Column (Quick Actions) -->
            <div class="space-y-8">
                 <section>
                    <h3 class="text-lg font-bold text-slate-900 mb-4">Aksi Cepat</h3>
                    <div class="grid gap-3">
                        <button class="flex items-center gap-3 w-full p-4 bg-white border border-slate-200 rounded-xl hover:border-red-200 hover:shadow-md transition-all text-left group">
                            <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 group-hover:text-red-600">Buat Materi Baru</h4>
                                <p class="text-xs text-slate-500">Upload video atau PDF</p>
                            </div>
                        </button>

                         <button class="flex items-center gap-3 w-full p-4 bg-white border border-slate-200 rounded-xl hover:border-red-200 hover:shadow-md transition-all text-left group">
                            <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 group-hover:text-red-600">Jadwalkan Live Class</h4>
                                <p class="text-xs text-slate-500">Buat sesi Zoom baru</p>
                            </div>
                        </button>

                         <button class="flex items-center gap-3 w-full p-4 bg-white border border-slate-200 rounded-xl hover:border-red-200 hover:shadow-md transition-all text-left group">
                            <div class="w-10 h-10 rounded-lg bg-red-50 text-red-600 flex items-center justify-center group-hover:bg-red-600 group-hover:text-white transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 group-hover:text-red-600">Buat Quiz</h4>
                                <p class="text-xs text-slate-500">Evaluasi pemahaman siswa</p>
                            </div>
                        </button>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-sensei-layout>
