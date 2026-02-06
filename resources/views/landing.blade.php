<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kursus Jepang - Platform Belajar Bahasa Jepang No. 1</title>
    
    <!-- Fonts: Outfit for dynamic headings, Noto Sans JP for authentic feel -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Noto+Sans+JP:wght@400;500;700;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Outfit', 'Noto Sans JP', sans-serif; }
        .font-jp { font-family: 'Noto Sans JP', sans-serif; }
    </style>
</head>
<body class="text-slate-900 selection:bg-red-500 selection:text-white overflow-x-hidden">
    <!-- Navigation -->
    <nav class="fixed top-0 w-full z-[100] transition-all duration-500 glass-effect py-4" id="main-nav">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            <div class="flex justify-between items-center">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 group">
                    <div class="relative w-12 h-12 rounded-2xl overflow-hidden bg-white shadow-xl shadow-red-500/10 group-hover:rotate-6 transition-all duration-500">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-cover scale-150">
                    </div>
                    <div>
                        <span class="block text-2xl font-black tracking-tighter leading-none">Kursus<span class="text-red-600">Jepang</span></span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.3em]">Premium Academy</span>
                    </div>
                </a>

                <!-- Nav Links -->
                <div class="hidden lg:flex items-center gap-10">
                    <a href="#program" class="text-sm font-bold text-slate-500 hover:text-red-600 transition-colors uppercase tracking-widest">Alur</a>
                    <a href="#biaya" class="text-sm font-bold text-slate-500 hover:text-red-600 transition-colors uppercase tracking-widest">Program</a>
                    <a href="#keunggulan" class="text-sm font-bold text-slate-500 hover:text-red-600 transition-colors uppercase tracking-widest">Keunggulan</a>
                </div>

                <!-- CTA -->
                <div class="flex items-center gap-4">
                    @auth
                        <div class="relative group">
                            <button class="flex items-center gap-3 p-1.5 focus:outline-none">
                                <span class="hidden md:block text-right">
                                    <span class="block text-xs font-black text-slate-900 uppercase tracking-tight">{{ Auth::user()->name }}</span>
                                    <span class="block text-[9px] font-bold text-red-600 uppercase">{{ Auth::user()->role }}</span>
                                </span>
                                <div class="w-10 h-10 rounded-xl border-2 border-red-100 p-0.5 group-hover:border-red-500 transition-all duration-300">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=FEE2E2&color=DC2626&bold=true" class="w-full h-full rounded-lg object-cover">
                                </div>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 top-full mt-2 w-48 bg-white rounded-xl shadow-xl border border-slate-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform group-hover:translate-y-0 translate-y-2 z-50">
                                <div class="p-2 border-b border-slate-50">
                                    <p class="text-xs font-bold text-slate-400 px-3 py-2 uppercase tracking-wider">Menu</p>
                                    <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm font-bold text-slate-700 hover:bg-red-50 hover:text-red-700 transition-colors">
                                        Dashboard
                                    </a>
                                </div>
                                <div class="p-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-sm font-bold text-slate-700 hover:bg-slate-50 hover:text-red-600 transition-colors">
                                            Log Out
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="hidden sm:block text-sm font-bold text-slate-900 hover:text-red-600 transition-colors mr-2">Masuk</a>
                        <a href="{{ route('register') }}" class="btn-premium btn-premium-primary text-xs !py-3 !px-6">
                            Mulai Belajar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @if (session('status'))
    <div class="fixed top-24 left-1/2 transform -translate-x-1/2 z-[150] w-full max-w-lg px-4 animate-fade-in-down">
        <div class="bg-white/80 backdrop-blur-xl border border-green-200 text-green-700 px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4" role="alert">
            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center text-green-600 flex-shrink-0 font-bold">✓</div>
            <div>
                <strong class="font-black block text-sm uppercase tracking-tight">Sukses!</strong>
                <span class="block text-xs font-medium">{{ session('status') }}</span>
            </div>
        </div>
    </div>
    @endif

    <!-- Hero Section -->
    <section class="relative min-h-screen pt-40 pb-20 lg:pt-56 lg:pb-32 overflow-hidden bg-slate-900">
        <!-- Background Assets -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/hero-premium.png') }}" class="w-full h-full object-cover opacity-60 scale-110 animate-float" style="filter: brightness(0.7) contrast(1.1);">
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-transparent to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 sm:px-8 relative z-10">
            <div class="max-w-4xl">
                <!-- Achievement Badge -->
                <div class="inline-flex items-center gap-3 px-5 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] sm:text-xs font-black uppercase tracking-[0.2em] mb-10 animate-fade-in-up">
                    <span class="relative flex h-2.5 w-2.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-red-600"></span>
                    </span>
                    Batch 12: Terbuka & Terbatas
                </div>

                <!-- Main Headlines -->
                <h1 class="text-5xl sm:text-7xl lg:text-9xl font-black text-white tracking-tighter leading-[0.95] mb-10 animate-fade-in-up" style="animation-delay: 0.1s;">
                    Belajar Jepang <br>
                    <span class="text-gradient drop-shadow-2xl">Tanpa Batas.</span>
                </h1>

                <p class="text-lg sm:text-2xl text-slate-300 mb-14 max-w-2xl leading-relaxed font-medium animate-fade-in-up" style="animation-delay: 0.2s;">
                    Kurikulum standar profesional N5-N1. Siapkan karir impianmu di Negeri Sakura dengan bimbingan mentor terbaik dari industri.
                </p>

                <!-- Actions -->
                <div class="flex flex-col sm:flex-row items-center gap-6 animate-fade-in-up" style="animation-delay: 0.3s;">
                    <a href="{{ route('register') }}" class="btn-premium btn-premium-primary text-xl !px-12 !py-6 w-full sm:w-auto">
                        Mulai Sekarang
                        <svg class="w-6 h-6 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </a>
                    
                    <a href="#projek" class="group flex items-center gap-4 text-white font-bold text-lg hover:text-red-400 transition-all">
                        <div class="w-14 h-14 rounded-full border-2 border-white/20 flex items-center justify-center group-hover:border-red-500 group-hover:scale-110 transition-all duration-500">
                             <svg class="w-6 h-6" fill="white" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"></path></svg>
                        </div>
                        Lihat Kurikulum
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-10 mt-24 pt-10 border-t border-white/10 animate-fade-in-up" style="animation-delay: 0.4s;">
                    <div>
                        <span class="block text-4xl font-black text-white leading-none">12k+</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 block">Alumni Sukses</span>
                    </div>
                    <div>
                        <span class="block text-4xl font-black text-white leading-none">4.9/5</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 block">Rating Belajar</span>
                    </div>
                     <div>
                        <span class="block text-4xl font-black text-white leading-none">150+</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 block">Partner Kerja</span>
                    </div>
                    <div class="hidden md:block">
                        <span class="block text-4xl font-black text-white leading-none">ISO</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-2 block">Terakreditasi</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative elements -->
        <div class="absolute bottom-0 right-0 w-1/3 h-1/2 bg-red-600/10 blur-[150px] -z-10"></div>
    </section>

    <!-- Section: Steps -->
    <section class="py-32 bg-white relative overflow-hidden" id="program">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="text-red-600 font-black uppercase tracking-[0.3em] text-[10px] mb-4 block animate-fade-in-up">The Roadmap</span>
                <h2 class="text-4xl md:text-6xl font-black text-slate-900 mb-6 animate-fade-in-up" style="animation-delay: 0.1s;">5 Langkah Menuju <span class="text-gradient">Karir Impian</span></h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-12">
                <!-- Step 1 -->
                <div class="text-center group transition-all duration-500 animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="w-24 h-24 mx-auto rounded-[2rem] bg-slate-50 border-2 border-slate-100 flex items-center justify-center text-3xl font-black text-slate-400 group-hover:bg-red-600 group-hover:text-white group-hover:border-red-600 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 mb-8 shadow-xl shadow-slate-200/50 group-hover:shadow-red-600/20 leading-none">
                        01
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-4 tracking-tight">Pilih Program</h3>
                    <p class="text-sm font-medium text-slate-500 leading-relaxed px-4">Tentukan tujuanmu: N5, N4, atau Jalur Kerja Spesifik (SSW).</p>
                </div>

                <!-- Step 2 -->
                <div class="text-center group transition-all duration-500 animate-fade-in-up" style="animation-delay: 0.3s;">
                    <div class="w-24 h-24 mx-auto rounded-[2rem] bg-slate-50 border-2 border-slate-100 flex items-center justify-center text-3xl font-black text-slate-400 group-hover:bg-red-600 group-hover:text-white group-hover:border-red-600 group-hover:scale-110 group-hover:-rotate-6 transition-all duration-500 mb-8 shadow-xl shadow-slate-200/50 group-hover:shadow-red-600/20 leading-none">
                        02
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-4 tracking-tight">Aktivasi Akun</h3>
                    <p class="text-sm font-medium text-slate-500 leading-relaxed px-4">Verifikasi instan untuk keamanan dan personalisasi belajar Anda.</p>
                </div>

                <!-- Step 3 -->
                <div class="text-center group transition-all duration-500 animate-fade-in-up" style="animation-delay: 0.4s;">
                    <div class="w-24 h-24 mx-auto rounded-[2rem] bg-slate-50 border-2 border-slate-100 flex items-center justify-center text-3xl font-black text-slate-400 group-hover:bg-red-600 group-hover:text-white group-hover:border-red-600 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 mb-8 shadow-xl shadow-slate-200/50 group-hover:shadow-red-600/20 leading-none">
                        03
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-4 tracking-tight">Live Learning</h3>
                    <p class="text-sm font-medium text-slate-500 leading-relaxed px-4">Sesi interaktif via Zoom dengan Sensei berpengalaman.</p>
                </div>

                <!-- Step 4 -->
                <div class="text-center group transition-all duration-500 animate-fade-in-up" style="animation-delay: 0.5s;">
                    <div class="w-24 h-24 mx-auto rounded-[2rem] bg-slate-50 border-2 border-slate-100 flex items-center justify-center text-3xl font-black text-slate-400 group-hover:bg-red-600 group-hover:text-white group-hover:border-red-600 group-hover:scale-110 group-hover:-rotate-6 transition-all duration-500 mb-8 shadow-xl shadow-slate-200/50 group-hover:shadow-red-600/20 leading-none">
                        04
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-4 tracking-tight">Kuis & Review</h3>
                    <p class="text-sm font-medium text-slate-500 leading-relaxed px-4">Uji kemampuan mingguan untuk memastikan progres stabil.</p>
                </div>

                <!-- Step 5 -->
                <div class="text-center group transition-all duration-500 animate-fade-in-up" style="animation-delay: 0.6s;">
                    <div class="w-24 h-24 mx-auto rounded-[2rem] bg-slate-50 border-2 border-slate-100 flex items-center justify-center text-3xl font-black text-slate-400 group-hover:bg-red-600 group-hover:text-white group-hover:border-red-600 group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 mb-8 shadow-xl shadow-slate-200/50 group-hover:shadow-red-600/20 leading-none">
                        05
                    </div>
                    <h3 class="text-xl font-black text-slate-900 mb-4 tracking-tight">Job Placement</h3>
                    <p class="text-sm font-medium text-slate-500 leading-relaxed px-4">Penyaluran langsung ke ribuan lowongan di Jepang.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Pricing -->
    <section class="py-32 bg-slate-50 relative" id="biaya">
        <!-- Background accents -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-red-100 rounded-full blur-[120px] opacity-40"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-slate-200 rounded-full blur-[120px] opacity-40"></div>

        <div class="max-w-7xl mx-auto px-6 sm:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-20 animate-fade-in-up">
                <span class="text-red-600 font-black uppercase tracking-[0.3em] text-[10px] mb-4 block">Pricing Model</span>
                <h2 class="text-4xl md:text-6xl font-black text-slate-900 mb-6 tracking-tight">Investasi <span class="text-gradient">Terbaik</span> Anda</h2>
                <p class="text-lg font-medium text-slate-500">Pilih paket belajar yang dirancang untuk kesuksesan jangka panjang Anda.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 items-stretch pt-10">
                <!-- Basic N5 -->
                <div class="card-premium group hover:!border-slate-900/10 flex flex-col animate-fade-in-up">
                    <div class="mb-10">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest mb-4">Foundation</span>
                        <h3 class="text-3xl font-black text-slate-900 mb-2">Basic N5</h3>
                        <p class="text-sm font-medium text-slate-500">Mulai langkah pertama Anda dari nol hingga percaya diri.</p>
                    </div>

                    <div class="mb-10">
                        <span class="block text-sm text-slate-400 line-through font-bold">Rp 599.000</span>
                        <div class="flex items-baseline gap-2">
                            <span class="text-5xl font-black text-slate-900 tracking-tighter">Rp 399k</span>
                            <span class="text-sm font-bold text-slate-500 uppercase">/Lifetime</span>
                        </div>
                    </div>

                    <ul class="space-y-5 mb-12 flex-1">
                        @foreach(['Video N5 Lengkap', 'E-Book Modul Eksklusif', 'Akses LMS Selamanya', 'Sertifikat Digital'] as $feat)
                        <li class="flex items-center gap-3 text-sm font-bold text-slate-700">
                            <div class="w-6 h-6 bg-slate-100 rounded-lg flex items-center justify-center text-slate-600 flex-shrink-0 group-hover:bg-slate-900 group-hover:text-white transition-colors duration-300">✓</div>
                            {{ $feat }}
                        </li>
                        @endforeach
                    </ul>

                    @if(Auth::check() && Auth::user()->hasActivePackage('Basic N5'))
                        <div class="relative group w-full cursor-pointer" onclick="window.location='{{ route('dashboard') }}'">
                            <button class="w-full py-5 rounded-xl font-black text-xs uppercase tracking-widest bg-emerald-600 text-white shadow-lg shadow-emerald-200 hover:bg-emerald-700 transition-all transform group-hover:-translate-y-1">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    AKSES KELAS
                                </span>
                            </button>
                            <div class="absolute -top-4 -right-2">
                                <span class="bg-white text-emerald-600 text-[10px] font-black px-3 py-1 rounded-full shadow-md border border-emerald-100 flex items-center gap-1 transform rotate-6">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    OWNED
                                </span>
                            </div>
                        </div>
                    @elseif(Auth::check() && Auth::user()->hasPendingPackage('Basic N5'))
                         <button disabled class="btn-premium bg-slate-200 text-slate-500 border-slate-300 w-full uppercase text-xs tracking-widest !py-5 cursor-not-allowed">Menunggu Konfirmasi</button>
                    @else
                        <a href="{{ route('checkout.show', 'Basic N5') }}" class="btn-premium btn-premium-secondary w-full uppercase text-xs tracking-widest !py-5 text-center block">Pilih Basic</a>
                    @endif
                </div>

                <!-- Intensive N4 (High priority) -->
                <div class="card-premium !bg-slate-900 !text-white flex flex-col relative scale-105 shadow-[0_40px_100px_rgba(220,38,38,0.2)] animate-fade-in-up" style="animation-delay: 0.1s;">
                    <div class="absolute -top-5 left-1/2 -translate-x-1/2">
                        <span class="bg-red-600 text-white text-[10px] font-black px-6 py-2 rounded-full uppercase tracking-[0.2em] shadow-2xl flex items-center gap-2">
                             <span class="animate-pulse">●</span> MOST POPULAR
                        </span>
                    </div>

                    <div class="mb-10">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-white/10 text-white text-[10px] font-black uppercase tracking-widest mb-4">Intensive</span>
                        <h3 class="text-3xl font-black text-white mb-2">Intensive N4</h3>
                        <p class="text-sm font-medium text-slate-400">Program percepatan 3 bulan Lulus JLPT N4.</p>
                    </div>

                    <div class="mb-10">
                        <span class="block text-sm text-slate-500 line-through font-bold">Rp 3.000.000</span>
                        <div class="flex items-baseline gap-2">
                            <span class="text-5xl font-black text-white tracking-tighter">Rp 2.25jt</span>
                        </div>
                        <div class="inline-block px-3 py-1 bg-white/5 border border-white/10 rounded-lg mt-4">
                            <span class="text-[9px] font-black text-red-500 uppercase tracking-widest">Available with Installment</span>
                        </div>
                    </div>

                    <ul class="space-y-5 mb-12 flex-1">
                        <li class="flex items-center gap-3 text-sm font-black text-white">
                            <div class="w-6 h-6 bg-red-600 rounded-lg flex items-center justify-center flex-shrink-0">✓</div>
                            Live Class Zoom 2x / Week
                        </li>
                        @foreach(['Koreksi Tugas Private', 'Tryout JLPT Real Time', 'Grup Diskusi Premium', 'Job Matching Priority'] as $feat)
                        <li class="flex items-center gap-3 text-sm font-bold text-slate-300">
                            <div class="w-6 h-6 bg-white/10 rounded-lg flex items-center justify-center flex-shrink-0">✓</div>
                            {{ $feat }}
                        </li>
                        @endforeach
                    </ul>

                    @if(Auth::check() && Auth::user()->hasActivePackage('Intensive N4'))
                        <div class="relative group w-full cursor-pointer" onclick="window.location='{{ route('dashboard') }}'">
                            <button class="w-full py-5 rounded-xl font-black text-xs uppercase tracking-widest bg-emerald-500 text-white shadow-lg shadow-emerald-500/30 hover:bg-emerald-400 transition-all transform group-hover:-translate-y-1">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    AKSES INTENSIF
                                </span>
                            </button>
                            <div class="absolute -top-4 -right-2">
                                <span class="bg-white text-emerald-600 text-[10px] font-black px-3 py-1 rounded-full shadow-md border-2 border-emerald-500 flex items-center gap-1 transform rotate-6">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    OWNED
                                </span>
                            </div>
                        </div>
                    @elseif(Auth::check() && Auth::user()->hasPendingPackage('Intensive N4'))
                         <button disabled class="btn-premium bg-slate-800 text-slate-500 border-slate-700 w-full uppercase text-xs tracking-widest !py-5 cursor-not-allowed">Menunggu Konfirmasi</button>
                    @else
                        <a href="{{ route('checkout.show', 'Intensive N4') }}" class="btn-premium btn-premium-primary w-full uppercase text-xs tracking-widest !py-5 text-center block">Gabung Intensif</a>
                    @endif
                </div>

                <!-- Tokutei Ginou -->
                <div class="card-premium group flex flex-col animate-fade-in-up" style="animation-delay: 0.2s;">
                    <div class="mb-10">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-black uppercase tracking-widest mb-4">Career</span>
                        <h3 class="text-3xl font-black text-slate-900 mb-2">Tokutei Ginou</h3>
                        <p class="text-sm font-medium text-slate-500">Jaminan Penyaluran Kerja (SSW) di Jepang.</p>
                    </div>

                    <div class="mb-10">
                        <span class="block text-sm text-slate-400 line-through font-bold">Rp 12.000.000</span>
                        <div class="flex items-baseline gap-2">
                            <span class="text-5xl font-black text-slate-900 tracking-tighter">Rp 8.5jt</span>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 mt-2 uppercase">*All-in Job Matching</p>
                    </div>

                    <ul class="space-y-5 mb-12 flex-1">
                        @foreach(['Pelatihan Skill Bidang', 'Interview Mockup Session', 'Counseling Preparation', 'Direct Working Visa'] as $feat)
                        <li class="flex items-center gap-3 text-sm font-bold text-slate-700">
                            <div class="w-6 h-6 bg-slate-100 rounded-lg flex items-center justify-center text-slate-600 flex-shrink-0 group-hover:bg-slate-900 group-hover:text-white transition-colors duration-300">✓</div>
                            {{ $feat }}
                        </li>
                        @endforeach
                    </ul>

                    @if(Auth::check() && Auth::user()->hasActivePackage('Tokutei Ginou'))
                        <div class="relative group w-full cursor-pointer" onclick="window.location='{{ route('dashboard') }}'">
                            <button class="w-full py-5 rounded-xl font-black text-xs uppercase tracking-widest bg-emerald-600 text-white shadow-lg shadow-emerald-200 hover:bg-emerald-700 transition-all transform group-hover:-translate-y-1">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    AKSES KARIR
                                </span>
                            </button>
                            <div class="absolute -top-4 -right-2">
                                <span class="bg-white text-emerald-600 text-[10px] font-black px-3 py-1 rounded-full shadow-md border border-emerald-100 flex items-center gap-1 transform rotate-6">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    OWNED
                                </span>
                            </div>
                        </div>
                    @elseif(Auth::check() && Auth::user()->hasPendingPackage('Tokutei Ginou'))
                         <button disabled class="btn-premium bg-slate-200 text-slate-500 border-slate-300 w-full uppercase text-xs tracking-widest !py-5 cursor-not-allowed">Menunggu Konfirmasi</button>
                    @else
                        <a href="{{ route('checkout.show', 'Tokutei Ginou') }}" class="btn-premium btn-premium-secondary w-full uppercase text-xs tracking-widest !py-5 text-center block">Pilih Karir</a>
                    @endif
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
    <!-- Section: Keunggulan (Bento Grid) -->
    <section class="py-32 bg-white relative overflow-hidden" id="keunggulan">
        <div class="max-w-7xl mx-auto px-6 sm:px-8">
            <div class="text-center max-w-3xl mx-auto mb-20">
                <span class="text-red-600 font-black uppercase tracking-[0.3em] text-[10px] mb-4 block">Our Excellence</span>
                <h2 class="text-4xl md:text-6xl font-black text-slate-900 mb-6 tracking-tight">Kenapa Harus <span class="text-gradient">Kursus Jepang?</span></h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Large Feature -->
                <div class="md:col-span-2 md:row-span-2 rounded-[3rem] bg-slate-900 p-12 flex flex-col justify-between relative overflow-hidden group shadow-2xl">
                    <div class="absolute inset-0 bg-gradient-to-br from-red-600/20 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
                    <div class="relative z-10">
                        <div class="w-20 h-20 bg-red-600 rounded-3xl flex items-center justify-center text-4xl mb-8 shadow-xl shadow-red-600/20 group-hover:rotate-12 transition-transform duration-500">
                            🏢
                        </div>
                        <h3 class="text-4xl font-black text-white mb-6 leading-tight">Career & Job <br> Placement System</h3>
                        <p class="text-lg text-slate-400 font-medium max-w-sm leading-relaxed">Koneksi eksklusif ke 150+ perusahaan di Jepang. Kami kawal dari persiapan CV, latihan interview, hingga keberangkatan.</p>
                    </div>
                    <div class="relative z-10 pt-10">
                        <div class="flex -space-x-3">
                            @foreach(range(1,5) as $i)
                            <img src="https://i.pravatar.cc/100?img={{ $i+10 }}" class="w-12 h-12 rounded-full border-4 border-slate-900">
                            @endforeach
                            <div class="w-12 h-12 rounded-full border-4 border-slate-900 bg-red-600 flex items-center justify-center text-[10px] font-black text-white">+12k</div>
                        </div>
                        <p class="text-[10px] text-slate-500 font-black uppercase tracking-widest mt-4">Alumni telah berangkat</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="rounded-[2.5rem] bg-slate-50 border border-slate-100 p-10 flex flex-col justify-between hover:border-red-600/20 hover:shadow-2xl hover:shadow-red-600/5 transition-all duration-500 group">
                    <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">💻</div>
                    <div>
                        <h4 class="text-xl font-black text-slate-900 mb-4">LMS Modern</h4>
                        <p class="text-sm font-bold text-slate-500 leading-relaxed">Akses modul video dan materi 24/7 di semua perangkat Anda.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="rounded-[2.5rem] bg-slate-50 border border-slate-100 p-10 flex flex-col justify-between hover:border-red-600/20 hover:shadow-2xl hover:shadow-red-600/5 transition-all duration-500 group">
                    <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center text-2xl group-hover:scale-110 transition-transform">🗣️</div>
                    <div>
                        <h4 class="text-xl font-black text-slate-900 mb-4">Native Mentor</h4>
                        <p class="text-sm font-bold text-slate-500 leading-relaxed">Praktek bicara langsung dengan penutur asli Jepang.</p>
                    </div>
                </div>

                <!-- Feature 4 (Wide Content) -->
                <div class="md:col-span-2 rounded-[2.5rem] bg-slate-50 border border-slate-100 p-10 flex flex-col md:flex-row items-center gap-10 hover:border-green-600/20 hover:shadow-2xl hover:shadow-green-600/5 transition-all duration-500">
                    <div class="w-20 h-20 bg-green-100 rounded-3xl flex items-center justify-center text-4xl flex-shrink-0">📜</div>
                    <div>
                         <h4 class="text-xl font-black text-slate-900 mb-2">Sertifikat Terakreditasi</h4>
                         <p class="text-sm font-bold text-slate-500">Sertifikat resmi yang diakui secara internasional untuk kebutuhan visa dan kerja.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <x-footer />

    <script>
        // Smooth Navbar Shadow on Scroll
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('main-nav');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-2xl', 'shadow-slate-200/50', '!py-2');
            } else {
                nav.classList.remove('shadow-2xl', 'shadow-slate-200/50', '!py-2');
            }
        });
    </script>
</body>
</html>
