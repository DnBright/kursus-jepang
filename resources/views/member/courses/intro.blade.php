<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-full text-xs font-bold uppercase tracking-wider mb-6">
                    <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                    Kursus Baru
                </div>
                <h1 class="text-3xl md:text-5xl font-black text-slate-900 mb-6 leading-tight">{{ $course['title'] }}</h1>
                <p class="text-lg text-slate-500 max-w-2xl mx-auto">{{ $course['subtitle'] }}</p>
            </div>

            <!-- Overview Card -->
            <div class="bg-white rounded-[2.5rem] p-8 md:p-12 border border-slate-100 shadow-xl shadow-slate-200/50 relative overflow-hidden mb-12">
                <!-- Decorative Elements -->
                <div class="absolute top-0 right-0 w-64 h-64 bg-red-50 rounded-full blur-3xl opacity-50 -mr-16 -mt-16 pointer-events-none"></div>
                <div class="absolute bottom-0 left-0 w-64 h-64 bg-blue-50 rounded-full blur-3xl opacity-50 -ml-16 -mb-16 pointer-events-none"></div>

                <div class="relative z-10">
                    <h2 class="text-2xl font-bold text-slate-900 mb-8 text-center">Apa yang akan Anda pelajari?</h2>
                    
                    <div class="grid md:grid-cols-2 gap-8 mb-12">
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 font-bold">1</div>
                                <div>
                                    <h3 class="font-bold text-slate-900 text-lg mb-1">Manners & Etika</h3>
                                    <p class="text-slate-500 leading-relaxed text-sm">Memahami aturan tidak tertulis di lingkungan kerja Jepang (Houvrensou, Salam, dll).</p>
                                </div>
                            </div>
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 font-bold">2</div>
                                <div>
                                    <h3 class="font-bold text-slate-900 text-lg mb-1">Budaya Perusahaan</h3>
                                    <p class="text-slate-500 leading-relaxed text-sm">Adaptasi dengan gaya kerja disiplin dan hierarki di perusahaan Jepang.</p>
                                </div>
                            </div>
                        </div>
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 font-bold">3</div>
                                <div>
                                    <h3 class="font-bold text-slate-900 text-lg mb-1">Kehidupan Sehari-hari</h3>
                                    <p class="text-slate-500 leading-relaxed text-sm">Tips bertahan hidup, membuang sampah, dan etika transportasi umum.</p>
                                </div>
                            </div>
                             <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex items-center justify-center shrink-0 font-bold">4</div>
                                <div>
                                    <h3 class="font-bold text-slate-900 text-lg mb-1">Mindset Sukses</h3>
                                    <p class="text-slate-500 leading-relaxed text-sm">Membangun mental baja untuk menghadapi tantangan karir di luar negeri.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row items-center justify-between gap-6 p-6 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-2 text-slate-600 text-sm font-bold">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                {{ $course['total_modules'] }} Modul Lengkap
                            </div>
                             <div class="w-px h-6 bg-slate-200 hidden md:block"></div>
                             <div class="flex items-center gap-2 text-slate-600 text-sm font-bold">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Video & E-Book
                            </div>
                        </div>
                        
                        <!-- CTA -->
                        <a href="{{ route('courses.lessons.show', [2, 1]) }}" class="w-full md:w-auto px-8 py-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-600/30 transition-all hover:-translate-y-1 flex items-center justify-center gap-2">
                            Mulai Modul 1
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <p class="text-center text-slate-400 text-sm">
                "Perjalanan ribuan mil dimulai dengan satu langkah." 
                <br>
                Ganbatte Kudasai! 🎌
            </p>

        </div>
    </div>
</x-app-layout>
