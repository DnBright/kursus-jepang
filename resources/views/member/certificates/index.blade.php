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
        @if($latestCertificate)
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
                             <div class="text-[8px] font-bold text-slate-400 mb-1">{{ Auth::user()->name }}</div>
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
                        Sertifikat Terverifikasi
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">{{ $latestCertificate->title }} Mastery</h3>
                    <p class="text-slate-500 mb-6 font-medium">Diberikan kepada <span class="text-red-600 font-bold">{{ Auth::user()->name }}</span> atas kelulusan pada program tingkat {{ $latestCertificate->level }} dengan predikat <span class="font-bold text-slate-700">{{ $latestCertificate->predikat }}</span>.</p>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8 text-left">
                        <div>
                            <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Tanggal</p>
                            <p class="font-semibold text-slate-700">{{ $latestCertificate->issue_date->format('d M Y') }}</p>
                        </div>
                        <div class="col-span-1 md:col-span-2">
                           <p class="text-xs text-slate-400 uppercase font-bold tracking-wider">Nomor ID Sertifikat</p>
                           <p class="font-mono text-sm font-semibold text-slate-700">{{ $latestCertificate->cert_number }}</p>
                       </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
                        <button class="px-6 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 hover:shadow-red-600/40 transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Download PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @if(!empty($historyCertificates))
        <div class="border-t border-slate-200 my-8"></div>
        <!-- History Grid -->
        <h3 class="text-xl font-bold text-slate-900 mb-6">Riwayat Sertifikat</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($historyCertificates as $cert)
             <div class="bg-white rounded-2xl border border-slate-200 p-6 hover:shadow-md transition-shadow group flex flex-col">
                <div class="flex items-start justify-between mb-4">
                    <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center border border-slate-100 text-2xl">
                        📜
                    </div>
                    <span class="px-2 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-bold uppercase tracking-wider">
                        {{ $cert->issue_date->format('Y') }}
                    </span>
                </div>
                
                <h4 class="font-bold text-slate-800 text-lg mb-1 group-hover:text-red-700 transition-colors">{{ $cert->title }}</h4>
                <p class="text-xs text-slate-500 font-mono mb-6">{{ $cert->cert_number }}</p>

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
            @endforeach
        </div>
        @endif

        @else
        <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-300">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 text-5xl grayscale opacity-50">
                🏆
            </div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Belum Ada Sertifikat</h3>
            <p class="text-slate-500 max-w-md mx-auto mb-8 font-medium">Selesaikan seluruh materi di kursus Anda untuk mendapatkan sertifikat kelulusan resmi dari LPK Kursus Jepang.</p>
            <div class="flex justify-center gap-4">
                 <a href="{{ route('materials.index') }}" class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-colors">
                    Mulai Belajar
                </a>
            </div>
        </div>
        @endif

    </div>
</x-app-layout>
