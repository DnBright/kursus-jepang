<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Sensei - Kursus Jepang</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-800 bg-white">
    <div class="min-h-screen flex">
        <!-- Left Side (Visual) -->
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
                <span class="inline-block py-1 px-3 bg-red-500/20 text-red-400 rounded-full text-xs font-bold tracking-widest uppercase mb-4 border border-red-500/20">Bergabung Bersama Kami</span>
                <h2 class="text-4xl font-bold font-jp mb-4 leading-tight">Jadilah Bagian dari Perubahan</h2>
                <p class="text-slate-400 text-lg">Bantu ribuan siswa menguasai bahasa Jepang dan raih kesempatan karir internasional bersama komunitas pengajar terbaik.</p>
            </div>

            <div class="relative z-10 text-sm text-slate-500">
                &copy; {{ date('Y') }} Kursus Jepang - Sensei Portal.
            </div>
        </div>

        <!-- Right Side (Form) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white">
            <div class="w-full max-w-md space-y-6">
                <div class="text-center lg:text-left">
                    <h2 class="mt-6 text-3xl font-bold text-slate-900">Mari Mulai Mengajar! ✍️</h2>
                    <p class="mt-2 text-sm text-slate-600">Lengkapi data diri Anda untuk mendaftar sebagai pengajar.</p>
                </div>

                <form method="POST" action="{{ route('sensei.register') }}" class="mt-8 space-y-5">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-700 font-medium" />
                        <x-text-input id="name" class="block mt-2 w-full px-4 py-3 rounded-xl border-slate-200 focus:border-slate-900 focus:ring-slate-900 transition-colors bg-slate-50" type="text" name="name" :value="old('name')" required autofocus placeholder="Nama Anda" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="text-slate-700 font-medium" />
                        <x-text-input id="email" class="block mt-2 w-full px-4 py-3 rounded-xl border-slate-200 focus:border-slate-900 focus:ring-slate-900 transition-colors bg-slate-50" type="email" name="email" :value="old('email')" required placeholder="nama@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')" class="text-slate-700 font-medium" />
                        <x-text-input id="password" class="block mt-2 w-full px-4 py-3 rounded-xl border-slate-200 focus:border-slate-900 focus:ring-slate-900 transition-colors bg-slate-50"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password"
                                        placeholder="Min. 8 karakter" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" class="text-slate-700 font-medium" />
                        <x-text-input id="password_confirmation" class="block mt-2 w-full px-4 py-3 rounded-xl border-slate-200 focus:border-slate-900 focus:ring-slate-900 transition-colors bg-slate-50"
                                        type="password"
                                        name="password_confirmation"
                                        required
                                        placeholder="Ulangi password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div>
                        <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-xl text-white bg-slate-900 hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 shadow-lg shadow-slate-900/30 transition-all hover:-translate-y-1">
                            Daftar Sekarang
                        </button>
                    </div>

                    <div class="pt-6 text-center border-t border-slate-100">
                        <p class="text-sm text-slate-500">Sudah punya akun? <a href="{{ route('sensei.login') }}" class="text-slate-900 font-bold hover:text-red-600 transition-colors">Masuk disini</a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
