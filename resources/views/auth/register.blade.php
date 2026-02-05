<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar - Kursus Jepang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-800 bg-white">
    <div class="min-h-screen flex flex-row-reverse">
        <!-- Right Side (Visual) - Reversed for Register -->
        <div class="hidden lg:flex lg:w-1/2 bg-red-900 relative overflow-hidden flex-col justify-between p-12 text-white">
            <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/shattered-island.png');"></div>
            <div class="absolute top-0 left-0 -ml-20 -mt-20 w-96 h-96 bg-slate-900 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute bottom-0 right-0 -mr-20 -mb-20 w-96 h-96 bg-slate-900 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            
            <div class="relative z-10 text-right">
                <a href="/" class="flex items-center justify-end gap-2 group">
                    <span class="text-3xl">🇯🇵</span>
                    <span class="font-jp font-bold text-2xl tracking-tight">Kursus<span class="text-red-300">Jepang</span></span>
                </a>
            </div>

            <div class="relative z-10 max-w-lg ml-auto text-right">
                <h2 class="text-4xl font-bold font-jp mb-4 leading-tight">Mulai Perjalanan Anda Menuju Jepang</h2>
                <p class="text-red-200 text-lg">Platform belajar bahasa Jepang #1 dengan kurikulum terstruktur dan akses ke peluang kerja di Jepang.</p>
            </div>

            <div class="relative z-10 text-sm text-red-300 text-right">
                &copy; {{ date('Y') }} Kursus Jepang. All rights reserved.
            </div>
        </div>

        <!-- Left Side (Form) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md space-y-8">
                <div class="text-center lg:text-left">
                    <h2 class="mt-6 text-3xl font-bold text-slate-900">Buat Akun Baru 🚀</h2>
                    <p class="mt-2 text-sm text-slate-600">Lengkapi data diri Anda untuk memulai balajar.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-700 font-medium" />
                        <x-text-input id="name" class="block mt-2 w-full px-4 py-3 rounded-xl border-slate-200 focus:border-red-500 focus:ring-red-500 transition-colors bg-slate-50" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-slate-700 font-medium" />
                        <x-text-input id="email" class="block mt-2 w-full px-4 py-3 rounded-xl border-slate-200 focus:border-red-500 focus:ring-red-500 transition-colors bg-slate-50" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="nama@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-slate-700 font-medium" />
                        <x-text-input id="password" class="block mt-2 w-full px-4 py-3 rounded-xl border-slate-200 focus:border-red-500 focus:ring-red-500 transition-colors bg-slate-50"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password"
                                        placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-slate-700 font-medium" />
                        <x-text-input id="password_confirmation" class="block mt-2 w-full px-4 py-3 rounded-xl border-slate-200 focus:border-red-500 focus:ring-red-500 transition-colors bg-slate-50"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="••••••••" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-lg shadow-red-600/30 transition-all hover:-translate-y-1">
                            Daftar Sekarang
                        </button>
                    </div>

                    <p class="mt-2 text-center text-sm text-slate-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="font-medium text-red-600 hover:text-red-500">
                            Masuk
                        </a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
