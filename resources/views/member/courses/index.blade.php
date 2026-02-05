<x-app-layout>
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Kursus Saya</h2>
                <p class="text-slate-500 text-sm mt-1">Lanjutkan pembelajaran Anda dari tempat terakhir Anda meninggalkannya.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-slate-500">Filter:</span>
                <select class="text-sm border-slate-200 rounded-lg focus:ring-red-500 focus:border-red-500 text-slate-700">
                    <option>Semua Kursus</option>
                    <option>Sedang Berjalan</option>
                    <option>Selesai</option>
                </select>
            </div>
        </div>

        <!-- Course Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card 1: Active Course -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all group">
                <!-- Cover Image/Icon Area -->
                <div class="h-32 bg-slate-50 relative flex items-center justify-center border-b border-slate-100 group-hover:bg-red-50 transition-colors">
                    <div class="text-6xl group-hover:scale-110 transition-transform duration-300">🇯🇵</div>
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
                            Aktif
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <!-- Header -->
                    <div class="mb-4">
                        <div class="text-xs font-bold text-red-600 uppercase tracking-wide mb-1">Paket Intensive N4</div>
                        <h3 class="text-lg font-bold text-slate-900 line-clamp-1 group-hover:text-red-600 transition-colors">Mastering N4 Grammar & Vocab</h3>
                        <p class="text-slate-500 text-sm mt-2 line-clamp-2">Pelajari tata bahasa tingkat lanjut dan 500+ kosakata penting untuk lulus JLPT N4.</p>
                    </div>

                    <!-- Progress -->
                    <div class="mb-6">
                        <div class="flex justify-between text-xs font-bold text-slate-600 mb-2">
                            <span>Progress Belajar</span>
                            <span>45%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-red-600 h-2 rounded-full transition-all duration-1000 ease-out" style="width: 45%"></div>
                        </div>
                    </div>

                    <!-- Meta Info & Action -->
                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-100">
                        <div class="flex items-center text-slate-500 text-xs font-medium">
                            <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            12 Modul
                        </div>
                        <a href="{{ route('courses.show', 1) }}" class="px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-lg shadow-md shadow-red-600/20 hover:bg-red-700 hover:shadow-red-600/40 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                            Lanjut
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 2: New Course -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all group">
                <div class="h-32 bg-slate-50 relative flex items-center justify-center border-b border-slate-100 group-hover:bg-red-50 transition-colors">
                    <div class="text-6xl group-hover:scale-110 transition-transform duration-300">🎎</div>
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                            Baru
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="mb-4">
                        <div class="text-xs font-bold text-red-600 uppercase tracking-wide mb-1">Bonus Class</div>
                        <h3 class="text-lg font-bold text-slate-900 line-clamp-1 group-hover:text-red-600 transition-colors">Japanese Culture & Manners</h3>
                        <p class="text-slate-500 text-sm mt-2 line-clamp-2">Etika kerja dan tata krama sehari-hari yang wajib diketahui sebelum ke Jepang.</p>
                    </div>

                    <div class="mb-6">
                        <div class="flex justify-between text-xs font-bold text-slate-600 mb-2">
                            <span>Progress Belajar</span>
                            <span>0%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-slate-300 h-2 rounded-full" style="width: 2%"></div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-100">
                        <div class="flex items-center text-slate-500 text-xs font-medium">
                            <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            5 Modul
                        </div>
                        <a href="{{ route('courses.show', 2) }}" class="px-4 py-2 bg-slate-900 text-white text-sm font-bold rounded-lg shadow hover:bg-slate-800 transition-all flex items-center gap-2">
                            Mulai
                        </a>
                    </div>
                </div>
            </div>

            <!-- Card 3: Completed Course -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all group opacity-75 hover:opacity-100">
                <div class="h-32 bg-slate-50 relative flex items-center justify-center border-b border-slate-100 group-hover:bg-red-50 transition-colors">
                    <div class="text-6xl group-hover:scale-110 transition-transform duration-300">🌱</div>
                    <div class="absolute top-4 right-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-600">
                            Selesai
                        </span>
                    </div>
                </div>

                <div class="p-6">
                    <div class="mb-4">
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wide mb-1">Basic N5</div>
                        <h3 class="text-lg font-bold text-slate-900 line-clamp-1 group-hover:text-red-600 transition-colors">Hiragana & Katakana Mastery</h3>
                        <p class="text-slate-500 text-sm mt-2 line-clamp-2">Fondasi dasar huruf Jepang. Wajib dikuasai sebelum masuk ke Kanji.</p>
                    </div>

                    <div class="mb-6">
                        <div class="flex justify-between text-xs font-bold text-slate-600 mb-2">
                            <span>Selesai</span>
                            <span class="text-green-600">100%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-green-500 h-2 rounded-full" style="width: 100%"></div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-100">
                        <div class="flex items-center text-slate-500 text-xs font-medium">
                            <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Lulus
                        </div>
                        <a href="{{ route('courses.show', 3) }}" class="px-4 py-2 bg-white text-slate-600 border border-slate-200 text-sm font-bold rounded-lg hover:bg-slate-50 transition-all flex items-center gap-2">
                            Review
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Empty State (Hidden, just for design ref) -->
        <!-- 
        <div class="text-center py-12 bg-white rounded-3xl border border-dashed border-slate-300">
            <div class="text-6xl mb-4">📚</div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Belum Ada Kursus</h3>
            <p class="text-slate-500 max-w-sm mx-auto mb-6">Anda belum mendaftar kelas apapun. Yuk mulai belajar sekarang!</p>
            <a href="/#program" class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-colors">
                Lihat Katalog Kelas
            </a>
        </div> 
        -->
    </div>
</x-app-layout>
