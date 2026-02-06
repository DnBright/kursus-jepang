<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Beli Paket') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-5xl font-bold text-slate-900 mb-6 tracking-tight">Upgrade Karirmu 🚀</h2>
                <p class="text-slate-600 text-lg">Pilih paket tambahan untuk meningkatkan skill bahasa Jepang dan peluang karirmu.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 items-stretch pt-10">
                @foreach($packages as $pkg)
                @php
                    $isActive = Auth::user()->hasActivePackage($pkg['name']);
                    $isPending = Auth::user()->hasPendingPackage($pkg['name']);
                @endphp
                <div class="card-premium flex flex-col relative {{ $pkg['type'] === 'primary' ? '!bg-slate-900 !text-white scale-105 shadow-[0_40px_100px_rgba(220,38,38,0.2)]' : 'hover:!border-slate-900/10' }}">
                    
                    @if(isset($pkg['popular']) && $pkg['popular'])
                    <div class="absolute -top-5 left-1/2 -translate-x-1/2">
                        <span class="bg-red-600 text-white text-[10px] font-black px-6 py-2 rounded-full uppercase tracking-[0.2em] shadow-2xl flex items-center gap-2">
                             <span class="animate-pulse">●</span> MOST POPULAR
                        </span>
                    </div>
                    @endif

                    <div class="mb-10">
                        <span class="inline-block px-4 py-1.5 rounded-full {{ $pkg['type'] === 'primary' ? 'bg-white/10 text-white' : 'bg-slate-100 text-slate-600' }} text-[10px] font-black uppercase tracking-widest mb-4">{{ $pkg['badge'] }}</span>
                        <h3 class="text-3xl font-black {{ $pkg['type'] === 'primary' ? 'text-white' : 'text-slate-900' }} mb-2">{{ $pkg['name'] }}</h3>
                    </div>

                    <div class="mb-10">
                        <span class="block text-sm {{ $pkg['type'] === 'primary' ? 'text-slate-500' : 'text-slate-400' }} line-through font-bold">Rp {{ number_format($pkg['original_price'], 0, ',', '.') }}</span>
                        <div class="flex items-baseline gap-2">
                            <span class="text-5xl font-black {{ $pkg['type'] === 'primary' ? 'text-white' : 'text-slate-900' }} tracking-tighter">Rp {{ number_format($pkg['price']/1000, 0) }}k</span>
                        </div>
                    </div>

                    <ul class="space-y-5 mb-12 flex-1">
                        @foreach($pkg['features'] as $feat)
                        <li class="flex items-center gap-3 text-sm font-bold {{ $pkg['type'] === 'primary' ? 'text-slate-300' : 'text-slate-700' }}">
                            <div class="w-6 h-6 rounded-lg flex items-center justify-center flex-shrink-0 {{ $pkg['type'] === 'primary' ? 'bg-red-600 text-white' : 'bg-slate-100 text-slate-600' }}">✓</div>
                            {{ $feat }}
                        </li>
                        @endforeach
                    </ul>

                    @if($isActive)
                         <div class="cursor-default relative group w-full">
                            <button disabled class="w-full py-5 rounded-xl font-black text-xs uppercase tracking-widest bg-slate-100 text-slate-400 border-2 border-slate-200 cursor-not-allowed">
                                SUDAH DIMILIKI
                            </button>
                            <div class="absolute -top-3 -right-3">
                                <span class="bg-emerald-500 text-white text-[10px] font-black px-3 py-1 rounded-full shadow-lg border-2 border-white flex items-center gap-1 transform rotate-6">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    ACTIVE
                                </span>
                            </div>
                        </div>
                    @elseif($isPending)
                        <button disabled class="w-full py-5 rounded-xl font-bold text-xs uppercase tracking-widest bg-slate-200 text-slate-500 cursor-not-allowed">
                             Menunggu Konfirmasi
                        </button>
                    @else
                        <a href="{{ route('checkout.show', $pkg['name']) }}" class="btn-premium {{ $pkg['type'] === 'primary' ? 'btn-premium-primary' : 'btn-premium-secondary' }} w-full uppercase text-xs tracking-widest !py-5 text-center block">
                            Pilih Paket
                        </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
