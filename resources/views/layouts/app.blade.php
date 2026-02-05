<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kursus Jepang') }}</title>

        <!-- Fonts: Outfit for premium SaaS feel -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
        
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Outfit', 'Noto Sans JP', sans-serif; }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-900 selection:bg-red-500 selection:text-white">
            <!-- Sidebar -->
            <aside class="hidden lg:block w-80 bg-white min-h-screen fixed top-0 left-0 z-50 overflow-hidden border-r border-slate-200/60 shadow-[20px_0_40px_-15px_rgba(0,0,0,0.02)]">
                <div class="h-full flex flex-col">
                    @if(request()->is('sensei*'))
                        @include('layouts.sensei-navigation')
                    @else
                        @include('layouts.navigation')
                    @endif
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 lg:pl-80 flex flex-col min-h-screen">
                <!-- Top Header -->
                <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 sticky top-0 z-40 transition-all duration-300">
                    <div class="flex justify-between items-center px-8 py-5">
                        <div class="flex items-center gap-4 lg:hidden">
                            <!-- Mobile Menu Button -->
                            <button class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            </button>
                            <span class="font-black text-xl text-slate-900 tracking-tighter">Kursus<span class="text-red-600">Jepang</span></span>
                        </div>
                        
                        <!-- Search Bar (Premium Style) -->
                        <div class="hidden md:flex items-center flex-1 max-w-xl">
                            <div class="relative w-full group">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                    <svg class="h-5 w-5 group-focus-within:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                                </span>
                                <input type="text" class="w-full bg-slate-100/70 text-sm font-medium border-none rounded-2xl pl-12 pr-4 py-3 focus:ring-2 focus:ring-red-100 focus:bg-white transition-all placeholder-slate-400" placeholder="Search lessons, materials, or sensei...">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-[10px] font-black text-slate-400 border border-slate-200 rounded-lg px-2 py-1 bg-white shadow-sm">⌘K</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right Actions -->
                        <div class="flex items-center gap-4 ml-auto">
                            <!-- Notifications -->
                            <button class="relative p-2.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all group">
                                <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                                <span class="absolute top-2.5 right-2.5 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
                            </button>

                            <!-- User Profile -->
                            <div class="flex items-center gap-4 pl-4 border-l border-slate-200">
                                <div class="text-right hidden md:block">
                                    <p class="text-sm font-black text-slate-900 leading-none mb-1">{{ Auth::user()->name }}</p>
                                    @if(Auth::user()->role === 'sensei')
                                        <span class="text-[9px] text-white font-black uppercase tracking-widest bg-red-600 px-2.5 py-1 rounded-lg">Sensei Expert</span>
                                    @else
                                        <span class="text-[9px] text-green-600 font-black uppercase tracking-widest bg-green-50 px-2.5 py-1 rounded-lg border border-green-100">Premium Member</span>
                                    @endif
                                </div>
                                <button class="w-12 h-12 rounded-2xl border-2 border-white shadow-lg shadow-red-500/10 overflow-hidden hover:scale-105 transition-transform duration-300">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=1e293b&color=ffffff&bold=true" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                                </button>
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 p-8 lg:p-12 animate-fade-in-up">
                    {{ $slot }}
                </main>

                <!-- Dashboard Footer -->
                <x-footer />
            </div>
        </div>
    </body>
</html>
