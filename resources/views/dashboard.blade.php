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

                    @if(Auth::user()->selected_package)
                        <!-- Active Course Card -->
                        <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex flex-col md:flex-row gap-6">
                                <div class="w-full md:w-1/3 aspect-video bg-slate-100 rounded-xl flex items-center justify-center relative overflow-hidden group">
                                     <div class="text-4xl group-hover:scale-110 transition-transform">🇯🇵</div>
                                     <div class="absolute inset-0 bg-black/5 group-hover:bg-black/0 transition-colors"></div>
                                </div>
                                <div class="flex-1 flex flex-col justify-between">
                                    <div>
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-2.5 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-bold uppercase tracking-wide">Aktif</span>
                                            <span class="text-xs text-slate-400">• Paket {{ Auth::user()->selected_package }}</span>
                                        </div>
                                        <h3 class="text-lg font-bold text-slate-900 mb-1">Bahasa Jepang Dasar (N5)</h3>
                                        <p class="text-sm text-slate-500 line-clamp-2">Pelajari dasar-dasar bahasa Jepang mulai dari Hiragana, Katakana, hingga percakapan sehari-hari.</p>
                                    </div>
                                    
                                    <div class="mt-4">
                                        <div class="flex justify-between text-xs font-semibold mb-1">
                                            <span class="text-slate-600">Progress</span>
                                            <span class="text-slate-900">0%</span>
                                        </div>
                                        <div class="w-full bg-slate-100 rounded-full h-2">
                                            <div class="bg-red-600 h-2 rounded-full" style="width: 5%"></div>
                                        </div>
                                        <div class="mt-4 flex gap-3">
                                            <button class="flex-1 py-2 px-4 bg-red-600 text-white text-sm font-bold rounded-lg hover:bg-red-700 transition-colors">
                                                Lanjut Belajar
                                            </button>
                                            <button class="py-2 px-3 border border-slate-200 text-slate-600 rounded-lg hover:bg-slate-50 transition-colors" title="Download Materi">
                                                📥
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
