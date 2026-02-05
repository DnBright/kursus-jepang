<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kursus Jepang') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-900">
            <!-- Sidebar -->
            <aside class="hidden lg:block w-72 bg-white min-h-screen fixed top-0 left-0 z-50 overflow-hidden border-r border-slate-200 shadow-sm">
                @if(request()->is('sensei*'))
                    @include('layouts.sensei-navigation')
                @else
                    @include('layouts.navigation')
                @endif
            </aside>

            <!-- Main Content -->
            <div class="flex-1 lg:pl-72 flex flex-col min-h-screen">
                <!-- Top Header -->
                <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 sticky top-0 z-40 transition-all duration-300">
                    <div class="flex justify-between items-center px-6 py-4">
                        <div class="flex items-center gap-4 lg:hidden">
                            <!-- Mobile Menu Button -->
                            <button class="text-slate-500 hover:text-red-600 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                            <span class="font-bold text-lg text-slate-900 tracking-tight">Kursus<span class="text-red-600">Jepang</span></span>
                        </div>
                        
                        <!-- Search Bar (Desktop) -->
                        <div class="hidden md:flex items-center flex-1 max-w-xl ml-4">
                            <div class="relative w-full group">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" class="w-full bg-slate-100/50 text-sm border-none rounded-xl pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-red-100 focus:bg-white transition-all placeholder-slate-400" placeholder="Cari kursus, materi, atau mentor...">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <span class="text-xs text-slate-400 border border-slate-200 rounded px-1.5 py-0.5">⌘K</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Actions -->
                        <div class="flex items-center gap-2 sm:gap-4 ml-auto">
                            <!-- Notifications -->
                            <button class="relative p-2.5 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-xl transition-all group">
                                <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
                            </button>

                            <!-- User Profile -->
                            <div class="flex items-center gap-3 pl-2 sm:pl-6 border-l border-slate-200 ml-2">
                                <div class="text-right hidden md:block group cursor-pointer">
                                    <p class="text-sm font-bold text-slate-900 group-hover:text-red-700 transition-colors leading-none">{{ Auth::user()->name }}</p>
                                    @if(Auth::user()->role === 'sensei')
                                        <a href="{{ route('sensei.dashboard') }}" class="text-[10px] text-white font-bold mt-1 uppercase tracking-wider bg-red-600 px-2 py-0.5 rounded-full inline-block hover:bg-red-700 transition-colors">Switch to Sensei</a>
                                    @else
                                        <p class="text-[10px] text-green-600 font-bold mt-1 uppercase tracking-wider bg-green-50 px-2 py-0.5 rounded-full inline-block">Member Aktif</p>
                                    @endif
                                </div>
                                <button class="w-10 h-10 rounded-full bg-white border-2 border-slate-100 flex items-center justify-center text-slate-600 font-bold shadow-sm hover:border-red-200 hover:ring-2 hover:ring-red-100 transition-all overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=FEE2E2&color=DC2626&bold=true" alt="{{ Auth::user()->name }}">
                                </button>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 p-6 lg:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
