<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 text-green-700 rounded-full text-xs font-bold uppercase tracking-wider mb-6">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    Lulus
                </div>
                <h1 class="text-3xl md:text-5xl font-black text-slate-900 mb-6 leading-tight">Omedetou Gozaimasu! 🎉</h1>
                <p class="text-lg text-slate-500 max-w-2xl mx-auto">Selamat! Anda telah menyelesaikan kelas <span class="font-bold text-slate-900">{{ $course['title'] }}</span> dengan hasil yang memuaskan.</p>
            </div>

            <!-- Certificate Card -->
            <div class="bg-white rounded-[2.5rem] p-8 md:p-12 border border-slate-100 shadow-xl shadow-slate-200/50 relative overflow-hidden mb-12 text-center">
                <!-- Decorative Elements -->
                <div class="absolute top-0 left-0 w-64 h-64 bg-green-50 rounded-full blur-3xl opacity-50 -ml-16 -mt-16 pointer-events-none"></div>
                <div class="absolute bottom-0 right-0 w-64 h-64 bg-yellow-50 rounded-full blur-3xl opacity-50 -mr-16 -mb-16 pointer-events-none"></div>

                <div class="relative z-10">
                    <div class="inline-block p-4 bg-green-50 rounded-2xl mb-6">
                        <div class="text-5xl">🏆</div>
                    </div>
                    
                    <h2 class="text-2xl font-bold text-slate-900 mb-2">Result Summary</h2>
                    <p class="text-slate-500 mb-8">Diselesaikan pada {{ date('d M Y') }}</p>

                    <div class="grid grid-cols-2 md:grid-cols-3 gap-6 max-w-lg mx-auto mb-10">
                        <div class="bg-slate-50 p-4 rounded-xl">
                            <div class="text-xs text-slate-500 font-bold uppercase mb-1">Nilai Akhir</div>
                            <div class="text-2xl font-black text-slate-900">{{ $course['stats']['final_score'] }}</div>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-xl">
                            <div class="text-xs text-slate-500 font-bold uppercase mb-1">Total Modul</div>
                            <div class="text-2xl font-black text-slate-900">{{ $course['total_modules'] }}</div>
                        </div>
                        <div class="bg-slate-50 p-4 rounded-xl col-span-2 md:col-span-1">
                            <div class="text-xs text-slate-500 font-bold uppercase mb-1">Predikat</div>
                            <div class="text-2xl font-black text-green-600">Excellent</div>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                        <a href="#" class="w-full sm:w-auto px-8 py-4 bg-slate-900 hover:bg-slate-800 text-white font-bold rounded-xl shadow-lg transition-all hover:-translate-y-1 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Lihat Sertifikat
                        </a>
                        <a href="{{ route('courses.show', 1) }}" class="w-full sm:w-auto px-8 py-4 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all flex items-center justify-center gap-2">
                            Review Materi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="text-center">
                <h3 class="font-bold text-slate-900 mb-6">Rekomendasi Selanjutnya</h3>
                <div class="grid md:grid-cols-2 gap-6 text-left">
                    <a href="#" class="bg-white p-6 rounded-2xl border border-slate-100 hover:border-red-200 hover:shadow-lg transition-all group">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-red-50 text-red-600 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">🚀</div>
                            <div>
                                <h4 class="font-bold text-slate-900 mb-1 group-hover:text-red-600 transition-colors">Lanjut ke N4</h4>
                                <p class="text-sm text-slate-500">Tingkatkan level bahasa Jepangmu ke tingkat selanjutnya.</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="bg-white p-6 rounded-2xl border border-slate-100 hover:border-blue-200 hover:shadow-lg transition-all group">
                         <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">💼</div>
                            <div>
                                <h4 class="font-bold text-slate-900 mb-1 group-hover:text-blue-600 transition-colors">Program Karir</h4>
                                <p class="text-sm text-slate-500">Persiapkan diri untuk bekerja di perusahaan Jepang.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
