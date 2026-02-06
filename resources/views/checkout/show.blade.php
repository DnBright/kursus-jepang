<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pembayaran Paket') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="p-8">
                    <!-- Package Info -->
                    <div class="text-center mb-10">
                        <span class="inline-block py-1 px-3 rounded-full bg-red-100 text-red-600 text-xs font-bold uppercase tracking-wider mb-3">
                            Konfirmasi Pesanan
                        </span>
                        <h1 class="text-3xl font-black text-slate-900 mb-2">{{ $package }}</h1>
                        <p class="text-slate-500">Silakan selesaikan pembayaran untuk mengaktifkan paket Anda.</p>
                        
                        <div class="mt-6 inline-block bg-slate-50 border border-slate-200 rounded-xl px-6 py-4">
                            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mb-1">Total Tagihan</p>
                            <p class="text-3xl font-black text-slate-900">Rp {{ number_format($price, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <div class="space-y-6 mb-10">
                        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-8 bg-blue-700 rounded flex items-center justify-center text-white text-xs font-bold italic">BCA</div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900">Bank BCA</p>
                                    <p class="text-xs text-slate-500">PT. Kursus Jepang Indonesia</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between bg-white p-3 rounded-lg border border-slate-200">
                                <code class="font-mono font-bold text-slate-700 text-lg">1234 5678 90</code>
                                <button onclick="navigator.clipboard.writeText('1234567890')" class="text-xs font-bold text-blue-600 hover:text-blue-700">
                                    SALIN
                                </button>
                            </div>
                        </div>

                        <div class="p-4 rounded-xl border border-slate-200 bg-slate-50/50">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-8 bg-blue-900 rounded flex items-center justify-center text-white text-xs font-bold italic">MANDIRI</div>
                                <div>
                                    <p class="text-sm font-bold text-slate-900">Bank Mandiri</p>
                                    <p class="text-xs text-slate-500">PT. Kursus Jepang Indonesia</p>
                                </div>
                            </div>
                            <div class="flex items-center justify-between bg-white p-3 rounded-lg border border-slate-200">
                                <code class="font-mono font-bold text-slate-700 text-lg">0987 6543 21098</code>
                                <button onclick="navigator.clipboard.writeText('0987654321098')" class="text-xs font-bold text-blue-600 hover:text-blue-700">
                                    SALIN
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Upload Form -->
                    <form action="{{ route('checkout', $package) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" name="payment_method" value="Transfer Bank">
                        
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Upload Bukti Transfer</label>
                            <div class="relative group">
                                <input type="file" name="proof" required
                                    class="block w-full text-sm text-slate-500
                                    file:mr-4 file:py-3 file:px-6
                                    file:rounded-xl file:border-0
                                    file:text-sm file:font-bold
                                    file:bg-red-50 file:text-red-700
                                    hover:file:bg-red-100
                                    border border-slate-200 rounded-xl cursor-pointer
                                    focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500
                                    transition-all"
                                >
                            </div>
                            <p class="mt-2 text-xs text-slate-400">Format: JPG, PNG. Maksimal 2MB.</p>
                            @error('proof')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="pt-4 border-t border-slate-100">
                            <button type="submit" class="w-full py-4 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 hover:shadow-red-600/30 transition-all transform hover:-translate-y-0.5">
                                Konfirmasi Pembayaran
                            </button>
                            <a href="{{ route('dashboard') }}" class="block text-center mt-4 text-sm font-bold text-slate-400 hover:text-slate-600">
                                Batalkan
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
