<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kursus Jepang') }} - Admin Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased h-full text-slate-600 bg-slate-50">
        <div class="min-h-full flex">
            <!-- Sidebar -->
            <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white transition-transform duration-300 transform md:translate-x-0 md:static md:inset-auto flex flex-col items-center">
                 <!-- Logo -->
                <div class="flex items-center justify-center h-20 w-full border-b border-slate-800 bg-slate-950">
                     <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 group">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-red-600 to-red-700 flex items-center justify-center text-white font-bold text-lg shadow-lg shadow-red-900/20 group-hover:scale-110 transition-transform duration-300">
                            🇯🇵
                        </div>
                        <span class="text-lg font-bold tracking-tight text-white group-hover:text-red-400 transition-colors">Admin Panel</span>
                    </a>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 w-full px-4 py-6 space-y-1 overflow-y-auto custom-scrollbar">
                     @include('layouts.admin-navigation')
                </nav>

                <!-- User Profile -->
                <div class="p-4 border-t border-slate-800 w-full bg-slate-950">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-400 font-bold border border-slate-700">
                            {{ Auth::guard('admin')->check() ? substr(Auth::guard('admin')->user()->name, 0, 1) : 'A' }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-white truncate">
                                {{ Auth::guard('admin')->check() ? Auth::guard('admin')->user()->name : 'Admin' }}
                            </p>
                            <p class="text-xs text-slate-500 truncate">Administrator</p>
                        </div>
                         <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="p-2 text-slate-400 hover:text-white hover:bg-slate-800 rounded-lg transition-colors" title="Logout">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 min-w-0 overflow-y-auto bg-slate-50">
                 <!-- Top Header Mobile -->
                <div class="md:hidden flex items-center justify-between p-4 bg-white border-b border-slate-200 sticky top-0 z-40">
                     <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                         <div class="w-8 h-8 rounded-lg bg-red-600 flex items-center justify-center text-white font-bold">🇯🇵</div>
                        <span class="font-bold text-slate-900">Admin Panel</span>
                    </a>
                    <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </button>
                </div>

                <div class="p-4 md:p-8 max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </body>
</html>
