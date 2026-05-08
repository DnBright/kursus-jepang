<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Kursus Jepang') }} - Onboarding</title>
        <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

        <!-- Fonts -->
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
        <div class="min-h-screen flex flex-col">
            <!-- Simple Header -->
            <header class="bg-white/80 backdrop-blur-xl border-b border-slate-200/60 sticky top-0 z-40">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-5">
                        <div class="flex items-center gap-4">
                            <div class="relative w-10 h-10 rounded-xl overflow-hidden bg-white shadow-lg border border-slate-100">
                                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-cover">
                            </div>
                            <span class="font-black text-xl text-slate-900 tracking-tighter">Kursus<span class="text-red-600">Jepang</span></span>
                        </div>
                        
                        <div class="flex items-center gap-6">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-black text-slate-900 leading-none mb-1">{{ Auth::user()->name }}</p>
                                <span class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Awaiting Activation</span>
                            </div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="text-xs font-bold text-slate-400 hover:text-red-600 transition-colors uppercase tracking-widest">
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 flex flex-col justify-center py-12">
                @yield('content')
            </main>

            <!-- Simple Footer -->
            <footer class="py-10 border-t border-slate-200/60 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <p class="text-xs text-slate-400 font-medium">&copy; {{ date('Y') }} Kursus Jepang Indonesia. Semua Hak Dilindungi.</p>
                </div>
            </footer>
        </div>
        <x-whatsapp-button />
    </body>
</html>
