<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk Sensei - Kursus Jepang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-800 bg-white">
    <div class="min-h-screen flex">
        <!-- Left Side (Visual) - Using Slate-900 to distinguish Sensei Portal -->
        <div class="hidden lg:flex lg:w-1/2 bg-slate-900 relative overflow-hidden flex-col justify-between p-12 text-white">
            <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/shattered-island.png');"></div>
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-red-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-96 h-96 bg-red-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            
            <div class="relative z-10">
                <a href="/" class="flex items-center gap-2 group">
                    <span class="text-3xl">🇯🇵</span>
                    <span class="font-jp font-bold text-2xl tracking-tight">Kursus<span class="text-red-500">Jepang</span></span>
                </a>
            </div>

            <div class="relative z-10 max-w-lg">
                <span class="inline-block py-1 px-3 bg-red-500/20 text-red-400 rounded-full text-xs font-bold tracking-widest uppercase mb-4 border border-red-500/20">Sensei Portal</span>
                <h2 class="text-4xl font-bold font-jp mb-4 leading-tight">Membentuk Masa Depan Melalui Bahasa</h2>
                <p class="text-slate-400 text-lg">Kelola kelas, pantau perkembangan siswa, dan bagikan materi pembelajaran terbaik Anda.</p>
            </div>

            <div class="relative z-10 text-sm text-slate-500">
                &copy; {{ date('Y') }} Kursus Jepang - Sensei Portal.
            </div>
        </div>

        <!-- Right Side (Form) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center lg:text-left">
                    <h2 class="mt-6 text-3xl font-bold text-slate-900">Okaeri, Sensei! 🎓</h2>
                    <p class="mt-2 text-sm text-slate-600">Masukan kredensial pengajar Anda untuk masuk.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('sensei.login') }}" class="mt-8 space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email Pengajar')" class="text-slate-700 font-medium" />
                        <x-text-input id="email" class="block mt-2 w-full px-4 py-3 rounded-xl border-slate-200 focus:border-slate-900 focus:ring-slate-900 transition-colors bg-slate-50" type="email" name="email" :value="old('email')" required autofocus placeholder="sensei@kursusjepang.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <div class="flex items-center justify-between">
                            <x-input-label for="password" :value="__('Password')" class="text-slate-700 font-medium" />
                        </div>
                        <x-text-input id="password" class="block mt-2 w-full px-4 py-3 rounded-xl border-slate-200 focus:border-slate-900 focus:ring-slate-900 transition-colors bg-slate-50"
                                        type="password"
                                        name="password"
                                        required autocomplete="current-password"
                                        placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" class="h-4 w-4 text-slate-900 focus:ring-slate-900 border-gray-300 rounded" name="remember">
                            <label for="remember_me" class="ml-2 block text-sm text-slate-600">
                                Ingat saya
                            </label>
                        </div>
                        
                        @if (Route::has('password.request'))
                            <a class="text-sm font-medium text-slate-900 hover:text-red-600" href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                        @endif
                    </div>

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 shadow-lg shadow-slate-900/30 transition-all hover:-translate-y-1">
                            Masuk Dashboard
                        </button>
                    </div>

                    <div class="pt-6 text-center border-t border-slate-100 space-y-2">
                        <p class="text-sm text-slate-500">Belum punya akun? <a href="{{ route('sensei.register') }}" class="text-slate-900 font-bold hover:text-red-600 transition-colors">Daftar sebagai Sensei</a></p>
                        <p class="text-sm text-slate-500">Bukan pengajar? <a href="{{ route('login') }}" class="text-slate-900 font-bold hover:text-red-600 transition-colors">Login sebagai Siswa</a></p>
                     </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>