<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login - Kursus Jepang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+JP:wght@400;500;700&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-900 font-sans text-gray-100 flex items-center justify-center min-h-screen relative overflow-hidden">
    <!-- Background Effects -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0">
        <div class="absolute w-96 h-96 bg-red-600 rounded-full blur-[128px] opacity-10 -top-20 -left-20 animate-pulse"></div>
        <div class="absolute w-96 h-96 bg-blue-600 rounded-full blur-[128px] opacity-10 bottom-0 right-0 animate-pulse delay-1000"></div>
    </div>

    <div class="w-full max-w-md bg-gray-800/50 backdrop-blur-xl border border-gray-700/50 rounded-2xl shadow-2xl p-8 relative z-10">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gray-700/50 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-inner border border-gray-600">
                <span class="text-4xl">🇯🇵</span>
            </div>
            <h1 class="text-2xl font-bold text-white font-jp">Admin Portal</h1>
            <p class="text-gray-400 text-sm mt-2">Akses terbatas untuk administrator.</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 bg-red-500/10 border border-red-500/20 text-red-500 p-4 rounded-xl text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}" class="space-y-6">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Email Address</label>
                <div class="relative">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full pl-4 pr-4 py-3 bg-gray-900/50 border border-gray-700 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all text-white placeholder-gray-500" placeholder="admin@kursusjepang.com">
                </div>
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-400 text-xs font-bold uppercase tracking-wider mb-2">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required
                        class="w-full pl-4 pr-4 py-3 bg-gray-900/50 border border-gray-700 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 outline-none transition-all text-white placeholder-••••••••">
                </div>
            </div>

            <button type="submit" class="w-full py-4 bg-gradient-to-r from-red-600 to-red-700 text-white font-bold rounded-xl hover:from-red-500 hover:to-red-600 transition-all transform hover:-translate-y-0.5 shadow-lg shadow-red-900/40">
                Masuk Dashboard
            </button>
        </form>
        
        <div class="mt-8 pt-6 border-t border-gray-700/50 text-center">
            <p class="text-xs text-gray-600">&copy; {{ date('Y') }} Kursus Jepang Admin System</p>
        </div>
    </div>
</body>
</html>
