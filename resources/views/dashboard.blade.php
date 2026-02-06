<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <!-- Dashboard Content -->
    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Welcome Section -->
            <div class="mb-8 flex flex-col md:flex-row justify-between items-end gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-slate-900">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-slate-600 mt-2">Siap melanjutkan pembelajaran hari ini?</p>
                </div>
                <div class="text-right hidden md:block">
                    <p class="text-sm text-slate-500 font-medium">{{ date('l, d F Y') }}</p>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Progress Belajar -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-red-600 text-xl font-bold">
                        📚
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Progress Belajar</p>
                        <h3 class="text-2xl font-bold text-slate-900">0%</h3>
                    </div>
                </div>
                
                <!-- Modul Selesai -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 text-xl font-bold">
                        ✅
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Modul Selesai</p>
                        <h3 class="text-2xl font-bold text-slate-900">0/20</h3>
                    </div>
                </div>

                <!-- Sertifikat -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-xl flex items-center justify-center text-yellow-600 text-xl font-bold">
                        🏆
                    </div>
                    <div>
                        <p class="text-sm text-slate-500 font-medium">Sertifikat</p>
                        <h3 class="text-2xl font-bold text-slate-900">0</h3>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content: Course List -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-bold text-slate-900">Kelas Saya</h2>
                        <a href="#" class="text-sm font-semibold text-red-600 hover:text-red-700">Lihat Semua</a>
                    </div>

                    @php
                        $transactions = Auth::user()->transactions()->orderBy('created_at', 'desc')->get();
                        $activeTransactions = $transactions->where('status', 'approved');
                        $pendingTransactions = $transactions->where('status', 'pending');
                    @endphp

                    @if($transactions->isNotEmpty())
                        
                        <!-- Pending Packages -->
                        <!-- Pending Packages -->
                        @foreach($pendingTransactions as $transaction)
                        <div class="bg-white rounded-2xl p-6 border-2 border-yellow-300 shadow-sm bg-yellow-50/20 relative overflow-hidden">
                            <!-- Stripe Pattern -->
                            <div class="absolute inset-0 opacity-[0.03]" style="background-image: repeating-linear-gradient(45deg, #000 0, #000 1px, transparent 0, transparent 50%); background-size: 10px 10px;"></div>
                            
                            <div class="flex items-center gap-5 relative z-10">
                                <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center text-2xl shadow-sm border border-yellow-100">
                                    <div class="animate-pulse">⏳</div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="font-black text-slate-800 text-lg">{{ $transaction->package_type }}</h3>
                                        <span class="px-2 py-0.5 rounded-md bg-yellow-100 text-yellow-700 text-[10px] font-black uppercase tracking-widest border border-yellow-200">Menunggu Konfirmasi</span>
                                    </div>
                                    <p class="text-sm text-slate-600 font-medium">Pembayaran Anda sedang divalidasi oleh admin. Akses akan terbuka otomatis setelah disetujui.</p>
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <!-- Active Packages -->
                        @foreach($activeTransactions as $transaction)
                        <div class="bg-white rounded-2xl p-6 border-2 border-emerald-400 shadow-lg shadow-emerald-50 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
                            <!-- Background Decoration -->
                            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-emerald-50 rounded-full blur-3xl opacity-50 group-hover:opacity-100 transition-opacity"></div>
                            
                            <div class="flex flex-col md:flex-row gap-6 relative z-10">
                                <div class="w-full md:w-1/3 aspect-video bg-slate-900 rounded-xl flex items-center justify-center relative overflow-hidden shadow-inner">
                                     <div class="text-5xl group-hover:scale-110 transition-transform duration-500">🇯🇵</div>
                                     <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent"></div>
                                     <div class="absolute bottom-3 left-3">
                                         <span class="px-2 py-1 rounded bg-white/20 backdrop-blur-sm text-white text-[10px] font-bold border border-white/10">PREMIUM CLASS</span>
                                     </div>
                                </div>
                                <div class="flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center gap-2 mb-3">
                                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-widest border border-emerald-200 flex items-center gap-1.5 shadow-sm">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                                AKSES TERBUKA
                                            </span>
                                            <span class="text-xs text-slate-400 font-bold">• {{ $transaction->package_type }}</span>
                                        </div>
                                        <h3 class="text-2xl font-black text-slate-900 mb-2">
                                            @if($transaction->package_type == 'Basic N5') Bahasa Jepang Dasar (N5)
                                            @elseif($transaction->package_type == 'Intensive N4') Intensive N4 Class
                                            @elseif($transaction->package_type == 'Tokutei Ginou') Tokutei Ginou Career
                                            @else {{ $transaction->package_type }}
                                            @endif
                                        </h3>
                                        
                                        <!-- Unlocked Features -->
                                        <div class="flex flex-wrap gap-2 mb-4">
                                            @foreach(['Materi Lengkap', 'Live Class', 'Ujian'] as $feature)
                                            <span class="flex items-center gap-1 text-[10px] font-bold text-slate-600 bg-slate-100 px-2 py-1 rounded border border-slate-200">
                                                <svg class="w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                                                {{ $feature }}
                                            </span>
                                            @endforeach
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 pt-4 border-t border-slate-100">
                                        <div class="flex justify-between text-xs font-bold mb-1.5">
                                            <span class="text-slate-500">Progress Belajar</span>
                                            <span class="text-emerald-600">0% Selesai</span>
                                        </div>
                                        <div class="w-full bg-slate-100 rounded-full h-2.5 mb-4 overflow-hidden">
                                            <div class="bg-emerald-500 h-full rounded-full w-[2%] shadow-[0_0_10px_rgba(16,185,129,0.5)]"></div>
                                        </div>
                                        <div class="flex gap-3">
                                            <button class="flex-1 py-3 px-6 bg-emerald-600 text-white text-sm font-black rounded-xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                                                MASUK KELAS
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                            </button>
                                            <button class="py-3 px-4 border-2 border-slate-100 text-slate-400 rounded-xl hover:border-slate-200 hover:text-slate-600 transition-colors" title="Download Silabus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    @else
                        <!-- Empty State -->
                        <div class="bg-white rounded-2xl p-8 border border-slate-100 shadow-sm text-center">
                            <div class="text-4xl mb-4">📭</div>
                            <h3 class="text-lg font-bold text-slate-900">Belum ada kelas aktif</h3>
                            <p class="text-slate-500 text-sm mt-1">Silakan beli paket untuk memulai belajar.</p>
                            <a href="/#program" class="inline-block mt-4 px-6 py-2 bg-red-600 text-white rounded-lg font-bold text-sm">Beli Paket</a>
                        </div>
                    @endif
                </div>

                <!-- Sidebar: Schedule & Info -->
                <div class="space-y-6">
                    <!-- Schedule Widget -->
                    <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                        <h3 class="font-bold text-slate-900 mb-4">📅 Jadwal Live Class</h3>
                        <div class="space-y-4">
                            <div class="flex gap-4 items-start">
                                <div class="w-12 h-12 rounded-lg bg-red-50 flex flex-col items-center justify-center text-red-600 border border-red-100 flex-shrink-0">
                                    <span class="text-xs font-bold uppercase">Sab</span>
                                    <span class="text-lg font-bold leading-none">12</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">Tata Bahasa N5 - Part 1</h4>
                                    <p class="text-xs text-slate-500 mt-0.5">19:30 - 21:00 WIB</p>
                                    <span class="inline-block mt-2 px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-bold rounded uppercase">Via Zoom</span>
                                </div>
                            </div>
                             <div class="flex gap-4 items-start opacity-60">
                                <div class="w-12 h-12 rounded-lg bg-slate-50 flex flex-col items-center justify-center text-slate-500 border border-slate-100 flex-shrink-0">
                                    <span class="text-xs font-bold uppercase">Min</span>
                                    <span class="text-lg font-bold leading-none">13</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">Latihan Percakapan</h4>
                                    <p class="text-xs text-slate-500 mt-0.5">10:00 - 11:30 WIB</p>
                                    <span class="inline-block mt-2 px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-bold rounded uppercase">Via Zoom</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Support Widget -->
                    <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-6 text-white text-center relative overflow-hidden">
                        <div class="relative z-10">
                            <h3 class="font-bold text-lg mb-1">Butuh Bantuan?</h3>
                            <p class="text-slate-400 text-sm mb-4">Mentor kami siap membantu kendala belajarmu.</p>
                            <button class="w-full py-2 bg-white text-slate-900 font-bold text-sm rounded-lg hover:bg-slate-100">Hubungi Mentor</button>
                        </div>
                        <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-red-600 rounded-full opacity-20 blur-xl"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
