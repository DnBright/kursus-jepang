<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kursus Jepang - Belajar Bahasa Jepang & Persiapan Kerja</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-slate-800 antialiased bg-white selection:bg-red-500 selection:text-white">
    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/90 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="/" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 rounded-lg shadow-md shadow-red-200 overflow-hidden group-hover:scale-110 transition-transform duration-300">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-cover scale-[1.4]">
                    </div>
                    <span class="font-jp font-bold text-xl tracking-tight text-slate-900">Kursus<span class="text-red-600">Jepang</span></span>
                </a>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#program" class="text-sm font-medium text-slate-600 hover:text-red-600 transition-colors">Program</a>
                    <a href="#keunggulan" class="text-sm font-medium text-slate-600 hover:text-red-600 transition-colors">Keunggulan</a>
                    <a href="#mentor" class="text-sm font-medium text-slate-600 hover:text-red-600 transition-colors">Mentor</a>
                    <div class="flex items-center gap-4">
                        @auth
                            <!-- Notifications / Status Logic -->
                            @if(Auth::user()->role === 'member')
                                <a href="{{ route('dashboard') }}" class="hidden md:inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 transition-all hover:-translate-y-0.5">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                    Dashboard Member
                                </a>
                            @elseif(Auth::user()->payment_status === 'pending')
                                <div class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-yellow-50 text-yellow-700 border border-yellow-200 rounded-lg text-xs font-bold animate-pulse" title="Menunggu Konfirmasi Admin">
                                    <span class="relative flex h-2 w-2">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-400 opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-2 w-2 bg-yellow-500"></span>
                                    </span>
                                    Menunggu Verifikasi
                                </div>
                            @endif

                            <div class="relative group">
                                <button class="flex items-center gap-3 pl-6 border-l border-slate-200 ml-2 transition-all">
                                    <div class="text-right hidden md:block">
                                        <p class="text-sm font-bold text-slate-900 leading-none">{{ Auth::user()->name }}</p>
                                        @if(Auth::user()->role === 'member')
                                            <p class="text-[10px] text-green-600 font-bold mt-1 uppercase tracking-wider bg-green-50 px-2 py-0.5 rounded-full inline-block">Member Premium</p>
                                        @elseif(Auth::user()->role === 'sensei')
                                             <p class="text-[10px] text-red-600 font-bold mt-1 uppercase tracking-wider bg-red-50 px-2 py-0.5 rounded-full inline-block">Sensei</p>
                                        @else
                                            <p class="text-[10px] text-slate-500 font-bold mt-1 uppercase tracking-wider bg-slate-100 px-2 py-0.5 rounded-full inline-block">Basic User</p>
                                        @endif
                                    </div>
                                    <div class="w-10 h-10 rounded-full bg-white border-2 border-slate-100 flex items-center justify-center text-slate-600 font-bold shadow-sm group-hover:border-red-200 group-hover:ring-2 group-hover:ring-red-100 transition-all overflow-hidden">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=FEE2E2&color=DC2626&bold=true" alt="{{ Auth::user()->name }}">
                                    </div>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div class="absolute right-0 mt-4 w-60 bg-white rounded-2xl shadow-xl border border-slate-100 py-3 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all transform origin-top-right z-50 translate-y-2 group-hover:translate-y-0">
                                    <div class="px-4 py-3 border-b border-slate-50 md:hidden">
                                        <p class="text-sm font-bold text-slate-900 truncate">{{ Auth::user()->name }}</p>
                                        <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                                    </div>
                                    
                                    @if(Auth::user()->role === 'member')
                                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-red-600 transition-colors rounded-xl mx-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                            Dashboard
                                        </a>
                                    @elseif(Auth::user()->role === 'sensei')
                                         <a href="{{ route('sensei.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-red-600 transition-colors rounded-xl mx-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                                            Dashboard Sensei
                                        </a>
                                    @endif

                                    <div class="border-t border-slate-100 my-2"></div>
                                    
                                    <!-- User Actions (Bottom) -->
                                     <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-700 hover:bg-slate-50 hover:text-red-600 transition-colors rounded-xl mx-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Profil Saya
                                    </a>

                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium text-red-600 hover:bg-red-50 transition-colors rounded-xl mx-2 mb-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                            Keluar Akun
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-900 hover:text-red-600 transition-colors">Masuk</a>
                            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold rounded-full shadow-lg shadow-red-600/20 transition-all hover:-translate-y-0.5 hover:shadow-red-600/40">Daftar Sekarang</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </nav>

    @if (session('status'))
    <div class="fixed top-24 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-lg px-4 animate-fade-in-down">
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative shadow-lg" role="alert">
            <strong class="font-bold">Sukses!</strong>
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
    </div>
    @endif

    <!-- Hero Section -->
    <section class="relative pt-32 pb-24 lg:pt-48 lg:pb-40 overflow-hidden bg-white">
        <!-- Background Accents -->
        <div class="absolute inset-0 -z-10 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:24px_24px] [mask-image:radial-gradient(ellipse_60%_60%_at_50%_0%,#000_70%,transparent_100%)] opacity-30"></div>
        
        <!-- Enhanced Glow Effect -->
        <div class="absolute -top-[500px] -right-[500px] w-[1200px] h-[1200px] bg-gradient-to-br from-red-500/10 via-red-100/20 to-transparent rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute top-20 right-20 w-96 h-96 bg-red-500/5 rounded-full blur-3xl animate-pulse pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-white border border-red-50 text-red-600 text-[10px] md:text-xs font-bold uppercase tracking-[0.2em] mb-12 shadow-[0_8px_30px_rgb(220,38,38,0.06)] animate-fade-in-up hover:scale-105 transition-transform cursor-default">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span>
                </span>
                Batch 12 Dibuka • Hemat 50% Hari Ini
            </div>
            
            <!-- Headline -->
            <h1 class="text-5xl lg:text-8xl font-black text-slate-900 tracking-tighter mb-8 leading-[1.1] animate-fade-in-up delay-100 drop-shadow-sm">
                Kuasai Bahasa Jepang <br>
                <span class="relative inline-block">
                    <span class="relative z-10 text-transparent bg-clip-text bg-gradient-to-r from-red-600 to-red-500">Standar Profesional</span>
                    <!-- Decorative Underline/Highlight -->
                    <svg class="absolute w-[110%] h-4 -bottom-1 -left-[5%] text-red-100 -z-10" viewBox="0 0 100 10" preserveAspectRatio="none">
                        <path d="M0 5 Q 50 12 100 5" stroke="currentColor" stroke-width="12" fill="none" opacity="0.6" />
                    </svg>
                </span> <span class="inline-block hover:rotate-12 transition-transform duration-300">🇯🇵</span>
            </h1>
            
            <!-- Subheadline -->
            <p class="text-lg lg:text-xl text-slate-500 mb-14 max-w-2xl mx-auto leading-relaxed animate-fade-in-up delay-200 font-medium">
                Kurikulum terstruktur N5-N1 dengan mentor expert. Siapkan karir impianmu di Jepang tanpa ribet, mulai dari nol hingga mahir.
            </p>
            
            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-5 animate-fade-in-up delay-300">
                <a href="{{ route('register') }}" class="group w-full sm:w-auto px-10 py-5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-2xl shadow-[0_20px_50px_rgba(220,38,38,0.25)] hover:shadow-[0_20px_50px_rgba(220,38,38,0.4)] transition-all hover:-translate-y-1 text-lg flex items-center justify-center gap-3">
                    Mulai Belajar Sekarang
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                </a>
                
                <a href="#program" class="group w-full sm:w-auto px-10 py-5 bg-white text-slate-800 border-2 border-slate-100 font-bold rounded-2xl hover:border-slate-200 hover:bg-slate-50 transition-all hover:shadow-xl hover:shadow-slate-200/50 hover:-translate-y-1 text-lg flex items-center justify-center gap-3">
                    <svg class="w-5 h-5 text-slate-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Lihat Preview Kelas
                </a>
            </div>

            <!-- Trust Indicators -->
            <div class="mt-20 pt-10 border-t border-slate-100 max-w-4xl mx-auto animate-fade-in-up delay-500">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mb-8">Dipercaya oleh Alumni di Perusahaan Jepang</p>
                <div class="flex flex-wrap justify-center items-center gap-10 lg:gap-20 opacity-40 grayscale hover:grayscale-0 transition-all duration-700 hover:opacity-100">
                     <div class="flex items-center gap-2 font-black text-2xl text-slate-800 tracking-tighter"><span class="text-red-600">Toyota</span>Astra</div>
                     <div class="flex items-center gap-2 font-black text-2xl text-slate-800 tracking-tighter"><span class="text-blue-600">Honda</span>Prospect</div>
                     <div class="flex items-center gap-2 font-black text-2xl text-slate-800 tracking-tighter"><span class="italic font-serif">UNIQLO</span></div>
                     <div class="flex items-center gap-2 font-black text-2xl text-slate-800 tracking-tighter"><span class="text-red-600 font-mono">TOSHIBA</span></div>
                </div>
            </div>
        </div>
    </section>

    <!-- 5 Steps Section -->
    <section class="py-24 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-red-600 font-extrabold uppercase tracking-widest text-xs mb-3 block">Alur Belajar</span>
                <h2 class="text-3xl md:text-5xl font-bold text-slate-900 mb-6">5 Langkah Mudah Belajar di Kursus Jepang</h2>
            </div>

            <div class="relative">
                <!-- Connecting Line (Desktop) -->
                <div class="hidden lg:block absolute top-[2.5rem] left-0 w-full h-0.5 bg-slate-100 z-0"></div>

                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-8 relative z-10">
                    <!-- Step 1 -->
                    <div class="group relative bg-white p-6 pt-0 text-center">
                        <div class="w-20 h-20 mx-auto bg-white border-4 border-red-50 text-red-600 rounded-full flex items-center justify-center text-2xl font-bold mb-6 shadow-sm group-hover:scale-110 group-hover:border-red-100 group-hover:shadow-lg transition-all duration-300 relative z-10">
                            1
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-red-600 transition-colors">Daftar & Pilih Program</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Pilih jalur belajar sesuai tujuanmu: N5, N4, atau Tokutei Ginou (Kerja ke Jepang).
                            Daftar online, cepat & mudah.
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="group relative bg-white p-6 pt-0 text-center">
                        <div class="w-20 h-20 mx-auto bg-white border-4 border-slate-50 text-slate-400 rounded-full flex items-center justify-center text-2xl font-bold mb-6 shadow-sm group-hover:scale-110 group-hover:border-red-100 group-hover:text-red-600 group-hover:shadow-lg transition-all duration-300 relative z-10">
                            2
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-red-600 transition-colors">Verifikasi & Aktivasi</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Tim kami akan memvalidasi pendaftaranmu agar proses belajar lebih aman dan terarah.
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="group relative bg-white p-6 pt-0 text-center">
                        <div class="w-20 h-20 mx-auto bg-white border-4 border-slate-50 text-slate-400 rounded-full flex items-center justify-center text-2xl font-bold mb-6 shadow-sm group-hover:scale-110 group-hover:border-red-100 group-hover:text-red-600 group-hover:shadow-lg transition-all duration-300 relative z-10">
                            3
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-red-600 transition-colors">Belajar dengan Sensei</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Akses materi video, modul, dan live class langsung dengan sensei berpengalaman.
                        </p>
                    </div>

                     <!-- Step 4 -->
                     <div class="group relative bg-white p-6 pt-0 text-center">
                        <div class="w-20 h-20 mx-auto bg-white border-4 border-slate-50 text-slate-400 rounded-full flex items-center justify-center text-2xl font-bold mb-6 shadow-sm group-hover:scale-110 group-hover:border-red-100 group-hover:text-red-600 group-hover:shadow-lg transition-all duration-300 relative z-10">
                            4
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-red-600 transition-colors">Quiz & Evaluasi</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Uji kemampuanmu lewat quiz dan latihan untuk memastikan progres belajarmu.
                        </p>
                    </div>

                     <!-- Step 5 -->
                     <div class="group relative bg-white p-6 pt-0 text-center">
                        <div class="w-20 h-20 mx-auto bg-white border-4 border-slate-50 text-slate-400 rounded-full flex items-center justify-center text-2xl font-bold mb-6 shadow-sm group-hover:scale-110 group-hover:border-red-100 group-hover:text-red-600 group-hover:shadow-lg transition-all duration-300 relative z-10">
                            5
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 mb-3 group-hover:text-red-600 transition-colors">Lulus & Bersertifikat</h3>
                        <p class="text-sm text-slate-500 leading-relaxed">
                            Selesaikan program dan dapatkan sertifikat resmi sebagai bekal studi atau kerja di Jepang.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Programs (Pricing) -->
    <section id="program" class="py-24 bg-slate-50 relative">
        <!-- Background Blob -->
        <div class="absolute left-0 bottom-0 w-96 h-96 bg-red-100 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-red-600 font-extrabold uppercase tracking-widest text-xs mb-3 block">Program Pilihan</span>
                <h2 class="text-3xl md:text-5xl font-bold text-slate-900 mb-6">Investasi Karir Masa Depan</h2>
                <p class="text-slate-600 text-lg">Pilih paket yang sesuai dengan target level JLPT dan karir Anda.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 items-start">
                <!-- Basic N5 -->
                <div class="bg-white rounded-[2rem] p-8 border border-slate-100 hover:border-red-100 hover:shadow-2xl hover:shadow-red-900/5 transition-all duration-300 relative group group-hover:-translate-y-2">
                    <div class="inline-block px-4 py-1.5 rounded-full bg-green-50 text-green-700 text-xs font-bold mb-6 uppercase tracking-wide">Pemula Friendly</div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">Basic Class N5</h3>
                    <p class="text-slate-500 mb-6 text-sm h-10">Fondasi awal untuk Anda yang baru mulai belajar Bahasa Jepang dari nol.</p>
                    
                    <div class="mb-8">
                        <span class="text-sm text-slate-400 line-through">Rp 599.000</span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-extrabold text-slate-900 tracking-tight">Rp 399k</span>
                            <span class="text-sm text-slate-500 font-medium">/lifetime</span>
                        </div>
                    </div>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Video Pembelajaran N5 Lengkap</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>E-Book Modul & Latihan Soal</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Akses Web LMS Selamanya</span>
                        </li>
                    </ul>

                    <form action="{{ route('checkout', 'Basic N5') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full py-4 px-6 rounded-xl bg-slate-50 text-slate-900 font-bold border border-slate-200 hover:bg-slate-100 hover:border-slate-300 transition-all">Ambil Basic</button>
                    </form>
                </div>

                <!-- Intensive N4 (Highlight) -->
                <div class="bg-white rounded-[2rem] p-8 border-2 border-red-600 shadow-2xl shadow-red-900/20 relative transform md:-translate-y-6 z-10">
                    <div class="absolute top-0 right-0 left-0 -mt-5 flex justify-center">
                        <span class="bg-red-600 text-white text-xs font-bold px-6 py-2 rounded-full uppercase tracking-wide shadow-lg flex items-center gap-2">
                             <span class="animate-pulse">🔥</span> Best Seller
                        </span>
                    </div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2 mt-4">Intensive Class N4</h3>
                    <p class="text-slate-500 mb-6 text-sm h-10">Program intensif 3 bulan untuk mengejar target lulus JLPT N4.</p>
                    
                    <div class="mb-8">
                        <span class="text-sm text-slate-400 line-through">Rp 3.000.000</span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-5xl font-extrabold text-red-600 tracking-tight">Rp 2.25jt</span>
                        </div>
                        <span class="text-[10px] text-red-600 font-bold uppercase tracking-wide bg-red-50 px-2 py-1 rounded mt-2 inline-block">Cicilan Tersedia</span>
                    </div>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3 text-sm text-slate-800 font-medium">
                            <div class="w-5 h-5 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xs flex-shrink-0">✓</div>
                            <span><strong>Live Class Zoom 2x / Minggu</strong></span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-700">
                            <div class="w-5 h-5 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xs flex-shrink-0">✓</div>
                            <span>Koreksi Tugas Private oleh Sensei</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-700">
                            <div class="w-5 h-5 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xs flex-shrink-0">✓</div>
                            <span>Simulasi Ujian JLPT Real</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-700">
                            <div class="w-5 h-5 rounded-full bg-red-100 text-red-600 flex items-center justify-center text-xs flex-shrink-0">✓</div>
                            <span>Grup Diskusi Premium</span>
                        </li>
                    </ul>

                    <form action="{{ route('checkout', 'Intensive N4') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full py-4 px-6 rounded-xl bg-gradient-to-r from-red-600 to-red-700 text-white font-bold hover:shadow-lg hover:shadow-red-600/40 transition-all transform hover:-translate-y-1">Gabung Kelas Intensif</button>
                    </form>
                </div>

                <!-- Tokutei Ginou -->
                <div class="bg-white rounded-[2rem] p-8 border border-slate-100 hover:border-slate-900 hover:shadow-2xl transition-all duration-300 relative group hover:-translate-y-2">
                    <div class="inline-block px-4 py-1.5 rounded-full bg-slate-900 text-white text-xs font-bold mb-6 uppercase tracking-wide">Program Karir</div>
                    <h3 class="text-2xl font-bold text-slate-900 mb-2">Tokutei Ginou</h3>
                    <p class="text-slate-500 mb-6 text-sm h-10">Persiapan skill spesifik + bahasa untuk kerja di Jepang (SSW).</p>
                    
                    <div class="mb-8">
                        <span class="text-sm text-slate-400 line-through">Rp 12.000.000</span>
                        <div class="flex items-baseline gap-1">
                            <span class="text-4xl font-extrabold text-slate-900 tracking-tight">Rp 8.5jt</span>
                        </div>
                        <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wide mt-2 inline-block">*Include Job Matching</span>
                    </div>

                    <ul class="space-y-4 mb-8">
                        <li class="flex items-start gap-3 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-slate-900 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Pelatihan Skill Bidang (Caregiver/F&B)</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-slate-900 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Interview Mockup Session</span>
                        </li>
                        <li class="flex items-start gap-3 text-sm text-slate-700">
                            <svg class="w-5 h-5 text-slate-900 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            <span>Jaminan Penyaluran Kerja</span>
                        </li>
                    </ul>

                    <form action="{{ route('checkout', 'Tokutei Ginou') }}" method="POST">
                        @csrf
                        <button type="submit" class="block w-full py-4 px-6 rounded-xl bg-slate-900 text-white font-bold hover:bg-slate-800 transition-all hover:shadow-lg">Daftar Program Karir</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Features (Bento Grid) -->
    <section id="keunggulan" class="py-24 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-5xl font-bold text-slate-900 mb-6 tracking-tight">Kenapa KursusJepang? 🎌</h2>
                <p class="text-slate-600 text-lg">Kami tidak hanya mengajarkan bahasa, tapi membentuk mindset profesional untuk sukses berkarir di Jepang.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 auto-rows-[300px]">
                <!-- Item 1: Large Left -->
                <div class="md:col-span-2 row-span-2 rounded-3xl bg-slate-900 p-8 relative overflow-hidden group">
                    <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1528360983277-13d9b152c6d1?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center opacity-40 group-hover:scale-105 transition-transform duration-700"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/40 to-transparent"></div>
                    <div class="relative z-10 h-full flex flex-col justify-end">
                        <div class="w-16 h-16 bg-red-600 rounded-2xl flex items-center justify-center text-3xl mb-6 shadow-lg shadow-red-600/20">
                            🏢
                        </div>
                        <h3 class="text-3xl font-bold text-white mb-2">Karir & Penyaluran Kerja</h3>
                        <p class="text-slate-200 text-lg max-w-md">Koneksi langsung ke perusahaan Jepang. Kami bantu dari persiapan CV, interview, hingga keberangkatan.</p>
                    </div>
                </div>

                <!-- Item 2: Top Right -->
                <div class="rounded-3xl bg-slate-50 border border-slate-200 p-8 flex flex-col justify-between hover:shadow-lg transition-all group">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">📱</div>
                    <div>
                        <h4 class="text-xl font-bold text-slate-900 mb-2">LMS Modern</h4>
                        <p class="text-slate-500 text-sm">Akses materi video, kuis, dan tryout dalam satu aplikasi canggih.</p>
                    </div>
                </div>

                <!-- Item 3: Middle Right -->
                <div class="rounded-3xl bg-slate-50 border border-slate-200 p-8 flex flex-col justify-between hover:shadow-lg transition-all group">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">🗣️</div>
                    <div>
                        <h4 class="text-xl font-bold text-slate-900 mb-2">Live Speaking</h4>
                        <p class="text-slate-500 text-sm">Praktek bicara langsung dengan native speaker setiap minggu.</p>
                    </div>
                </div>

                <!-- Item 4: Bottom Wide -->
                <div class="md:col-span-3 rounded-3xl bg-red-600 p-8 relative overflow-hidden flex flex-col md:flex-row items-center gap-8 shadow-2xl shadow-red-900/20">
                    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_var(--tw-gradient-stops))] from-white/10 to-transparent"></div>
                    <div class="relative z-10 flex-1">
                        <h3 class="text-3xl font-bold text-white mb-2">Sertifikat Resmi</h3>
                        <p class="text-red-100">Dapatkan sertifikat digital & fisik yang diakui untuk melamar kerja.</p>
                    </div>
                    <div class="relative z-10 hidden md:block">
                        <div class="px-6 py-3 bg-white/10 backdrop-blur-md rounded-xl border border-white/20 text-white font-bold flex items-center gap-3">
                            <span class="w-3 h-3 bg-green-400 rounded-full animate-pulse"></span>
                            Terverifikasi ISO
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-1">
                    <a href="/" class="flex items-center gap-2 mb-6">
                        <div class="w-10 h-10 rounded-lg shadow-md shadow-red-200 overflow-hidden">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-cover scale-[1.4]">
                        </div>
                        <span class="font-jp font-bold text-lg text-slate-900">Kursus<span class="text-red-600">Jepang</span></span>
                    </a>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">
                        Jalan menuju karir impian di Jepang dimulai di sini. Bergabunglah dengan komunitas pembelajar terbesar di Indonesia.
                    </p>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-6">Program</h4>
                    <ul class="space-y-3 text-sm text-slate-500">
                        <li><a href="#" class="hover:text-red-600 transition-colors">Kelas N5 Basic</a></li>
                        <li><a href="#" class="hover:text-red-600 transition-colors">Kelas N4 Intensive</a></li>
                        <li><a href="#" class="hover:text-red-600 transition-colors">Tokutei Ginou</a></li>
                        <li><a href="#" class="hover:text-red-600 transition-colors">Magang Jepang</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-6">Dukungan</h4>
                    <ul class="space-y-3 text-sm text-slate-500">
                        <li><a href="#" class="hover:text-red-600 transition-colors">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-red-600 transition-colors">Syarat & Ketentuan</a></li>
                        <li><a href="#" class="hover:text-red-600 transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="#" class="hover:text-red-600 transition-colors">Hubungi Kami</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 mb-6">Newsletter</h4>
                    <form class="flex gap-2">
                        <input type="email" placeholder="Email Anda" class="w-full px-4 py-2 rounded-lg bg-slate-50 border border-slate-200 focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all text-sm">
                        <button class="px-4 py-2 bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition-colors">
                            →
                        </button>
                    </form>
                </div>
            </div>
            <div class="border-t border-slate-100 pt-8 text-center">
                <p class="text-slate-400 text-sm">&copy; {{ date('Y') }} PT Kursus Jepang Indonesia. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
