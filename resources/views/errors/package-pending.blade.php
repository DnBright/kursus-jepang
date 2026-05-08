<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paket Menunggu Validasi - Kursus Jepang</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 flex items-center justify-center min-h-screen">
    <div class="max-w-lg w-full bg-white rounded-2xl shadow-xl p-8 text-center border border-slate-100">
        <div class="w-20 h-20 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        
        <h2 class="text-2xl font-bold text-slate-900 mb-3">Paket Sedang Diproses</h2>
        
        <p class="text-slate-600 mb-6 leading-relaxed">
            Akses ke fitur ini (Materi, Quiz, Live Class) memerlukan paket aktif. <br>
            Saat ini, transaksi pembelian paket <strong>{{ Auth::user()->selected_package ?? 'Kursus' }}</strong> Anda sedang dalam antrian validasi admin.
        </p>

        <div class="bg-yellow-50 rounded-xl p-4 mb-8 text-left flex gap-3 border border-yellow-100">
            <svg class="w-5 h-5 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <div class="text-sm text-yellow-800">
                <span class="font-bold">Info:</span> Admin kami akan segera memverifikasi bukti pembayaran Anda. Mohon cek kembali secara berkala atau hubungi dukungan jika proses memakan waktu lebih dari 24 jam.
            </div>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('dashboard') }}" class="inline-flex justify-center items-center px-6 py-2.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-colors">
                Kembali ke Dashboard
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline-block">
                @csrf
                <button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center px-6 py-2.5 bg-white text-slate-700 font-bold rounded-xl border border-slate-200 hover:bg-slate-50 transition-colors">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</body>
</html>
