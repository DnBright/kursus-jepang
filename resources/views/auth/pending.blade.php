<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menunggu Validasi - Kursus Jepang</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-white rounded-lg shadow-lg p-8 text-center">
        <div class="w-16 h-16 bg-yellow-100 text-yellow-500 rounded-full flex items-center justify-center mx-auto mb-6 text-3xl">
            ⏳
        </div>
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Pendaftaran Sedang Diproses</h2>
        <p class="text-gray-600 mb-8">
            Terima kasih telah mendaftar. Akun Anda saat ini sedang dalam antrian validasi oleh Admin. 
            Kami akan memberitahu Anda via email setelah akun Anda aktif.
        </p>
        
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium hover:bg-gray-300 transition-colors">
                Kembali ke Halaman Utama
            </button>
        </form>
    </div>
</body>
</html>
