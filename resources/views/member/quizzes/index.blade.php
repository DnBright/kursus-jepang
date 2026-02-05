<x-app-layout>
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Latihan & Evaluasi</h2>
                <p class="text-slate-500 text-sm mt-1">Ukur pemahaman Anda dengan latihan soal dan tryout berkala.</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm">
                <span class="pl-3 text-xs font-bold text-slate-500 uppercase tracking-wide">Filter:</span>
                <select class="text-sm font-bold text-slate-800 border-none focus:ring-0 cursor-pointer py-1 pl-2 pr-8 bg-transparent">
                    <option>Semua Tipe</option>
                    <option>Latihan Harian (Mondai)</option>
                    <option>Quiz Modul</option>
                    <option>Tryout JLPT</option>
                </select>
            </div>
        </div>

        <!-- Overall Progress -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1: Completed -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-green-100 text-green-600 flex items-center justify-center text-xl font-bold">
                    ✅
                </div>
                <div>
                    <h4 class="text-slate-500 text-xs font-bold uppercase tracking-wide">Selesai</h4>
                    <p class="text-2xl font-bold text-slate-900">12 <span class="text-sm text-slate-400 font-medium">/ 40 Soal</span></p>
                </div>
            </div>
            <!-- Card 2: Average Score -->
            <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-yellow-100 text-yellow-600 flex items-center justify-center text-xl font-bold">
                    🏆
                </div>
                <div>
                    <h4 class="text-slate-500 text-xs font-bold uppercase tracking-wide">Rata-rata Nilai</h4>
                    <p class="text-2xl font-bold text-slate-900">85.5</p>
                </div>
            </div>
            <!-- Card 3: Next Exam -->
            <div class="bg-red-50 p-6 rounded-2xl border border-red-100 shadow-sm flex items-center gap-4">
                <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xl font-bold animate-pulse">
                    📅
                </div>
                <div>
                    <h4 class="text-red-600/70 text-xs font-bold uppercase tracking-wide">Tryout Bulanan</h4>
                    <p class="text-lg font-bold text-red-900">15 Jan 2024</p>
                </div>
            </div>
        </div>

        <!-- Quiz List -->
        <div class="space-y-6">
            
            <!-- Category: Vocabulary (Active) -->
            <div>
                <h3 class="flex items-center gap-2 text-lg font-bold text-slate-900 mb-4 px-2">
                    <span class="w-1.5 h-6 bg-red-600 rounded-full"></span>
                    Modul 2: Hiragana Lanjutan & Kosakata Dasar
                </h3>
                
                <div class="grid gap-4">
                    <!-- Quiz Item 1 (Done) -->
                    <div class="bg-white p-6 rounded-2xl border border-slate-200 hover:border-slate-300 transition-all flex flex-col md:flex-row items-start md:items-center gap-6 group">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 rounded-xl bg-green-50 text-green-600 flex flex-col items-center justify-center border border-green-100">
                                <span class="text-xs font-bold uppercase">Nilai</span>
                                <span class="text-2xl font-bold">90</span>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600 uppercase tracking-wide">Pilihan Ganda</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700 uppercase tracking-wide">Selesai</span>
                            </div>
                            <h4 class="text-lg font-bold text-slate-900 group-hover:text-red-600 transition-colors">Latihan Harian: Hiragana Sa-Ta-Na</h4>
                            <div class="flex items-center gap-4 mt-2 text-sm text-slate-500">
                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg> 20 Soal</span>
                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 15 Menit</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 w-full md:w-auto">
                            <button class="w-full md:w-auto px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-colors">
                                Lihat Pembahasan
                            </button>
                        </div>
                    </div>

                    <!-- Quiz Item 2 (Active) -->
                    <div class="bg-white p-6 rounded-2xl border-l-4 border-l-red-600 border-y border-r border-slate-200 shadow-lg shadow-red-100/50 flex flex-col md:flex-row items-start md:items-center gap-6 transform hover:-translate-y-1 transition-all">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 rounded-xl bg-red-100 text-red-600 flex flex-col items-center justify-center animate-pulse">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </div>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-600 uppercase tracking-wide">Essay / Isian</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-yellow-100 text-yellow-700 uppercase tracking-wide">Sedang Dikerjakan</span>
                            </div>
                            <h4 class="text-xl font-bold text-slate-900">Quiz Modul 2: Kosakata Keluarga & Salam</h4>
                            <div class="flex items-center gap-4 mt-2 text-sm text-slate-500">
                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg> 25 Soal</span>
                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 30 Menit</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 w-full md:w-auto">
                            <button class="w-full md:w-auto px-6 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/30 hover:bg-red-700 hover:shadow-red-600/50 transition-all">
                                Lanjutkan Quiz
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Category: Listening (Next) -->
            <div>
                <h3 class="flex items-center gap-2 text-lg font-bold text-slate-900 mb-4 px-2 mt-8">
                    <span class="w-1.5 h-6 bg-slate-300 rounded-full"></span>
                    Modul 3: Listening Comprehension (Choukai)
                </h3>
                
                <div class="grid gap-4">
                     <!-- Quiz Item 3 (Locked) -->
                    <div class="bg-slate-50/50 p-6 rounded-2xl border border-slate-200 flex flex-col md:flex-row items-center gap-6 opacity-60">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 rounded-xl bg-slate-200 text-slate-400 flex flex-col items-center justify-center">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                        </div>
                        <div class="flex-1">
                             <div class="flex items-center gap-2 mb-1">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-200 text-slate-600 uppercase tracking-wide">Listening</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-200 text-slate-500 uppercase tracking-wide">Terkunci</span>
                            </div>
                            <h4 class="text-lg font-bold text-slate-600">Latihan Choukai: Percakapan Dasar</h4>
                            <div class="flex items-center gap-4 mt-2 text-sm text-slate-400">
                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg> 10 Soal</span>
                                <span class="flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg> 20 Menit</span>
                            </div>
                        </div>
                        <div class="flex-shrink-0 w-full md:w-auto">
                            <button disabled class="w-full md:w-auto px-5 py-2.5 bg-slate-100 text-slate-400 font-bold rounded-xl cursor-not-allowed">
                                Belum Terbuka
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
