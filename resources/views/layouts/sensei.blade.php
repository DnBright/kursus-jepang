<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kursus Jepang') }} - Sensei Portal</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-900">
        <div class="flex h-screen overflow-hidden">
            <!-- Sidebar -->
            <aside class="hidden lg:flex w-72 bg-slate-900 flex-col fixed inset-y-0 z-50">
                @include('layouts.sensei-navigation')
            </aside>

            <!-- Main Content Wrapper -->
            <div class="flex-1 flex flex-col lg:pl-72 w-full transition-all duration-300">
                <!-- Top Header -->
                <header class="h-16 bg-white/80 backdrop-blur-xl border-b border-slate-200/60 sticky top-0 z-40 flex items-center justify-between px-6 lg:px-8">
                    <!-- Mobile Toggle -->
                    <div class="lg:hidden">
                        <button class="text-slate-500 hover:text-slate-700">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </button>
                    </div>

                    <!-- Breadcrumbs / Page Title -->
                    <div class="flex items-center gap-2">
                        <h1 class="font-bold text-lg text-slate-800">Dashboard</h1>
                    </div>

                    <!-- Right Actions -->
                    <div class="flex items-center gap-4">
                        <!-- Notifications -->
                        <button class="relative p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-full transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <span class="absolute top-2 right-2.5 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
                        </button>
                        
                        <div class="h-8 w-px bg-slate-200 mx-1"></div>

                        <!-- User Menu -->
                        <div class="flex items-center gap-3">
                            <div class="text-right hidden md:block">
                                <p class="text-sm font-bold text-slate-800 leading-tight">{{ Auth::guard('sensei')->user()->name }}</p>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">Sensei</p>
                            </div>
                            <div class="h-10 w-10 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold text-sm ring-4 ring-slate-50">
                                {{ substr(Auth::guard('sensei')->user()->name, 0, 1) }}
                            </div>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto p-6 lg:p-8">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
