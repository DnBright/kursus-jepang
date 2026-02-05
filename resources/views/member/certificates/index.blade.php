<x-app-layout>
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Sertifikat Kelulusan</h2>
                <p class="text-slate-500 text-sm mt-1">Bukti kompetensi resmi Anda yang diterbitkan oleh LPK Kursus Jepang.</p>
            </div>
        </div>

        <!-- Latest Achievement (Hero Card) -->
        <div class="relative bg-white rounded-3xl p-8 border border-slate-200 shadow-xl shadow-slate-200/50 overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-red-50 rounded-full blur-3xl -mr-16 -mt-16 opacity-50"></div>
            
            <div class="relative z-10 flex flex-col lg:flex-row gap-8 items-center">
                <!-- Certificate Preview -->
                <div class="flex-shrink-0 w-full lg:w-1/3 max-w-sm">
                    <div class="aspect-[1.414/1] bg-slate-50 rounded-xl border-4 border-slate-100 shadow-sm relative overflow-hidden group">
                        <!-- Mock Certificate Content -->
                        <div class="absolute inset-0 p-4 flex flex-col items-center justify-center text-center opacity-80 bg-white">
                            <div class="w-12 h-12 bg-red-600 rounded-full mb-2 opacity-20"></div>
                            <div class="w-3/4 h-2 bg-slate-200 rounded mb-2"></div>
                             <div class="w-1/2 h-2 bg-slate-200 rounded mb-4"></div>
                             <div class="w-full h-1 bg-slate-100 rounded mb-1"></div>
                             <div class="w-full h-1 bg-slate-100 rounded mb-1"></div>
                        </div>
                        
                        <!-- Overlay Action -->
                         <div class="absolute inset-0 bg-slate-900/0 group-hover:bg-slate-900/10 transition-colors flex items-center justify-center">
                             <div class="bg-white/90 backdrop-blur px-4 py-2 rounded-lg shadow-sm opacity-0 group-hover:opacity-100 transition-opacity transform translate-y-2 group-hover:translate-y-0 text-xs font-bold text-slate-700">
                                 Preview
                             </div>
                         </div>
                    </div>
                </div>

                <!-- Details -->
                <div class="flex-1 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-bold uppercase tracking-wide mb-4 border border-green-100">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Baru Saja Diterbitkan
                    </div>
                    <h3 class="text-3xl font-bold text-slate-900 mb-2">Basic N5: Hiragana & Katakana Mastery</h3>
                    <p class="text-slate-500 mb-6">Diberikan atas kelulusan pada program tingkat dasar dengan predikat <span class="font-bold text-slate-700">Sangat Memuaskan</span>.</p>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 text-left">
                        <div>
                            <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Tanggal</p>
                            <p class="font-semibold text-slate-700">05 Jan 2024</p>
                        </div>
                        <div>
                           <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Nomor ID</p>
                           <p class="font-mono text-sm font-semibold text-slate-700">CERT/2024/001</p>
                       </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                        <button class="px-6 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 hover:shadow-red-600/40 transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download PDF
                        </button>
                        <button class="px-6 py-3 bg-white text-slate-700 font-bold rounded-xl border border-slate-200 hover:bg-slate-50 transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-slate-200 my-8"></div>

        <!-- History Grid -->
        <h3 class="text-xl font-bold text-slate-900 mb-6">Riwayat Sertifikat</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Card Item (Mock) -->
            <!-- Use opacity if you want to mockup archived content, or normal for active -->
             <div class="bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-md transition-shadow group flex flex-col">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center border border-slate-100 text-2xl">
                        📜
                    </div>
                    <span class="px-2 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-bold uppercase tracking-wider">
                        2023
                    </span>
                </div>
                
                <h4 class="font-bold text-slate-800 text-lg mb-1 group-hover:text-red-700 transition-colors">Japanese Culture Basics</h4>
                <p class="text-xs text-slate-500 font-mono mb-6">CERT/2023/882</p>

                <div class="mt-auto flex gap-2">
                    <button class="flex-1 py-2 bg-slate-50 text-slate-600 font-bold text-sm rounded-lg hover:bg-slate-100 border border-slate-100 transition-colors flex items-center justify-center gap-2">
                         <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        PDF
                    </button>
                    <button class="flex-1 py-2 bg-white text-slate-600 font-bold text-sm rounded-lg hover:text-red-600 border border-slate-200 transition-colors">
                        View
                    </button>
                </div>
            </div>

             <!-- Card Item (Empty State Example if needed, but visually consistent) -->
        </div>

        <!-- Empty State (Hidden in design for now, shows if auth user has no certificates) -->
        <!--
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-4xl grayscale opacity-50">
                🏆
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Belum Ada Sertifikat</h3>
            <p class="text-slate-500 max-w-md mx-auto mb-6">Selesaikan kursus dan lulus ujian akhir untuk mendapatkan sertifikat resmi dari LPK Kursus Jepang.</p>
            <a href="{{ route('my-courses') }}" class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-colors">
                Lanjut Belajar
            </a>
        </div>
        -->

    </div>
</x-app-layout>
