@extends('layouts.onboarding')

@section('content')
    <div class="py-24 bg-gradient-to-br from-slate-50 via-white to-red-50/30 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-12 shadow-2xl border border-slate-100 text-center relative overflow-hidden">
                <!-- Decorative background shapes -->
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-red-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-emerald-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
                
                <div class="relative z-10 space-y-8">
                    <div class="w-24 h-24 bg-amber-100 text-amber-500 rounded-full flex items-center justify-center mx-auto shadow-inner border-4 border-amber-50">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    
                    <div>
                        <h2 class="text-4xl font-black text-slate-800 tracking-tight mb-4 text-transparent bg-clip-text bg-gradient-to-r from-slate-800 to-slate-600">
                            Menunggu Verifikasi Pembayaran
                        </h2>
                        <p class="text-slate-500 text-lg mx-auto leading-relaxed max-w-lg">
                            Terima kasih! Bukti pembayaran Anda telah kami terima dan sedang dalam proses verifikasi oleh tim admin kami.
                        </p>
                    </div>

                    <div class="bg-slate-50 rounded-2xl p-6 shadow-inner text-sm text-slate-600 inline-block border border-slate-100 mx-auto w-full max-w-md">
                        <p class="font-medium">Proses verifikasi biasanya memakan waktu <strong class="text-slate-800">1x24 jam</strong> kerja. Anda akan dapat mengakses materi pembelajaran segera setelah pembayaran disetujui.</p>
                    </div>

                    <div class="pt-6">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center px-10 py-5 border border-transparent text-base font-bold rounded-full text-white bg-slate-900 hover:bg-slate-800 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                            Kembali ke Dasbor
                            <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
