<x-app-layout>
    <div x-data="{ activeModule: 1 }" class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Materi Pembelajaran</h2>
                <p class="text-slate-500 text-sm mt-1">Akses semua modul, video, dan bahan bacaan kursus Anda.</p>
            </div>
            
            <div class="flex items-center gap-3 bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm">
                <span class="pl-3 text-xs font-bold text-slate-500 uppercase tracking-wide">Kursus:</span>
                <select class="text-sm font-bold text-slate-800 border-none focus:ring-0 cursor-pointer py-1 pl-2 pr-8 bg-transparent">
                    <option>Basic N5: Hiragana & Katakana</option>
                    <option>Intensive N4: Grammar Mastery</option>
                </select>
            </div>
        </div>

        <!-- Course Summary Card -->
        <div class="bg-gradient-to-br from-red-600 to-red-800 rounded-3xl p-6 md:p-8 text-white relative overflow-hidden shadow-xl shadow-red-900/20">
            <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/shattered-island.png');"></div>
            <div class="absolute right-0 top-0 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl -mr-16 -mt-16"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center gap-6">
                <!-- Progress Circle (CSS Only) -->
                <div class="flex-shrink-0 relative w-20 h-20 md:w-24 md:h-24">
                     <svg class="w-full h-full transform -rotate-90">
                        <circle cx="50%" cy="50%" r="40%" stroke="currentColor" stroke-width="8" fill="transparent" class="text-white/20" />
                        <circle cx="50%" cy="50%" r="40%" stroke="currentColor" stroke-width="8" fill="transparent" stroke-dasharray="251.2" stroke-dashoffset="62.8" class="text-white transition-all duration-1000" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center font-bold text-xl">75%</div>
                </div>

                <div class="flex-1">
                    <div class="inline-block px-3 py-1 rounded-full bg-red-500/50 border border-white/20 text-xs font-bold uppercase tracking-wider mb-2">
                        Sedang Dipelajari
                    </div>
                    <h3 class="text-2xl font-bold mb-2">Basic N5: Hiragana & Katakana Mastery</h3>
                    <p class="text-red-100 text-sm max-w-2xl">Lanjutkan modul terakhir Anda untuk menyelesaikan Bab 3. Semangat!</p>
                </div>

                <button class="flex-shrink-0 px-6 py-3 bg-white text-red-700 font-bold rounded-xl shadow-lg hover:bg-red-50 transition-colors flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Lanjut Belajar
                </button>
            </div>
        </div>

        <!-- Modules Accordion -->
        <div class="space-y-4">
            
            <!-- Module 1: Expanded -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm transition-all" :class="{ 'ring-2 ring-red-100 shadow-md': activeModule === 1 }">
                <!-- Header -->
                <button @click="activeModule = activeModule === 1 ? null : 1" class="w-full flex items-center justify-between p-6 hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-4 text-left">
                        <div class="w-10 h-10 rounded-full bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0 font-bold">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-lg">Modul 1: Pengenalan Huruf Hiragana</h4>
                            <p class="text-slate-500 text-sm">4 Materi • 45 Menit</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="hidden md:inline-block px-3 py-1 bg-green-50 text-green-600 rounded-full text-xs font-bold">Selesai</span>
                        <svg class="w-5 h-5 text-slate-400 transform transition-transform duration-200" :class="{ 'rotate-180': activeModule === 1 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </button>

                <!-- Content -->
                <div x-show="activeModule === 1" x-collapse>
                    <div class="border-t border-slate-100">
                        <!-- Item 1 -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between p-4 pl-[4.5rem] hover:bg-slate-50 transition-colors gap-4">
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-lg bg-red-50 text-red-500 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h5 class="font-bold text-slate-800 text-sm">Video: Sejarah & Dasar Hiragana</h5>
                                    <p class="text-xs text-slate-500 mt-0.5">12 Menit</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-green-600 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Selesai</span>
                                <button class="px-3 py-1.5 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-slate-900 transition-colors">Review</button>
                            </div>
                        </div>

                        <!-- Item 2 -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between p-4 pl-[4.5rem] hover:bg-slate-50 transition-colors gap-4 border-t border-slate-50">
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-500 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <div>
                                    <h5 class="font-bold text-slate-800 text-sm">PDF: Tabel & Cara Tulis A-Ko</h5>
                                    <p class="text-xs text-slate-500 mt-0.5">5 Halaman</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-green-600 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Selesai</span>
                                <button class="px-3 py-1.5 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-slate-900 transition-colors">Baca Ulang</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Module 2: Active -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm transition-all" :class="{ 'ring-2 ring-red-100 shadow-md': activeModule === 2 }">
                <!-- Header -->
                <button @click="activeModule = activeModule === 2 ? null : 2" class="w-full flex items-center justify-between p-6 hover:bg-slate-50 transition-colors">
                    <div class="flex items-center gap-4 text-left">
                        <div class="w-10 h-10 rounded-full bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0 font-bold animate-pulse">
                            2
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-lg">Modul 2: Hiragana Lanjutan (Sa-Yo)</h4>
                            <p class="text-slate-500 text-sm">3 Materi • 30 Menit</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                         <span class="hidden md:inline-block px-3 py-1 bg-yellow-50 text-yellow-600 rounded-full text-xs font-bold">In Progress</span>
                        <svg class="w-5 h-5 text-slate-400 transform transition-transform duration-200" :class="{ 'rotate-180': activeModule === 2 }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </button>

                <!-- Content -->
                <div x-show="activeModule === 2" x-collapse>
                    <div class="border-t border-slate-100">
                        <!-- Item 1 -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between p-4 pl-[4.5rem] bg-red-50/30 border-l-4 border-red-500 gap-4">
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <h5 class="font-bold text-slate-900 text-sm">Video: Pelafalan Sa-Shi-Su-Se-So</h5>
                                    <p class="text-xs text-slate-500 mt-0.5">15 Menit</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-red-600 uppercase tracking-wider animate-pulse">Sedang Putar</span>
                                <button class="px-5 py-2 text-xs font-bold text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-lg shadow-red-600/20 transition-all transform hover:-translate-y-0.5">Lanjutkan</button>
                            </div>
                        </div>

                         <!-- Item 2 -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between p-4 pl-[4.5rem] hover:bg-slate-50 transition-colors gap-4 border-t border-slate-50">
                            <div class="flex items-start gap-4 opacity-75">
                                <div class="w-8 h-8 rounded-lg bg-yellow-50 text-yellow-500 flex items-center justify-center flex-shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
                                </div>
                                <div>
                                    <h5 class="font-bold text-slate-800 text-sm">Audio: Listening Practice (Sa-Yo)</h5>
                                    <p class="text-xs text-slate-500 mt-0.5">5 Menit</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-xs font-bold text-slate-400">Belum Mulai</span>
                                <button class="px-3 py-1.5 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-red-600 transition-colors">Start</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Module 3: Locked -->
            <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden opacity-75 grayscale hover:grayscale-0 transition-all">
                <!-- Header -->
                <button class="w-full flex items-center justify-between p-6 cursor-not-allowed">
                    <div class="flex items-center gap-4 text-left">
                        <div class="w-10 h-10 rounded-full bg-slate-200 text-slate-500 flex items-center justify-center flex-shrink-0 font-bold">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-600 text-lg">Modul 3: Katakana Dasar</h4>
                            <p class="text-slate-400 text-sm">Selesaikan Modul 2 untuk membuka</p>
                        </div>
                    </div>
                </button>
            </div>

        </div>
    </div>
</x-app-layout>
