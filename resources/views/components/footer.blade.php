<footer class="bg-slate-900 pt-24 pb-12 text-white relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
    
    <div class="max-w-7xl mx-auto px-6 sm:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-16 mb-20">
            <div class="md:col-span-1">
                <a href="/" class="flex items-center gap-3 mb-8">
                    <div class="w-12 h-12 rounded-2xl overflow-hidden bg-white shadow-xl shadow-red-500/20">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-cover scale-150">
                    </div>
                    <span class="text-2xl font-black tracking-tighter">Kursus<span class="text-red-500">Jepang</span></span>
                </a>
                <p class="text-slate-400 text-sm font-bold leading-relaxed mb-10">
                    Transformasikan masa depanmu dengan kemampuan Bahasa Jepang profesional. Bergabunglah dengan platform belajar no. 1 di Indonesia.
                </p>
                <div class="flex items-center gap-4">
                    @foreach(['Instagram', 'Facebook', 'LinkedIn', 'YouTube'] as $social)
                    <a href="#" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-300 hover:bg-red-600 hover:text-white hover:border-red-600 transition-all group">
                         <span class="text-[10px] font-black uppercase tracking-tight">{{ substr($social, 0, 2) }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            <div>
                <h5 class="text-xs font-black uppercase tracking-[0.2em] text-white/40 mb-8">Explore</h5>
                <ul class="space-y-4">
                    <li><a href="#" class="text-sm font-bold text-slate-400 hover:text-red-500 transition-all">Program Kursus</a></li>
                    <li><a href="#" class="text-sm font-bold text-slate-400 hover:text-red-500 transition-all">Info Lowongan Kerja</a></li>
                    <li><a href="#" class="text-sm font-bold text-slate-400 hover:text-red-500 transition-all">Biaya & Pendaftaran</a></li>
                    <li><a href="#" class="text-sm font-bold text-slate-400 hover:text-red-500 transition-all">Testimoni Alumni</a></li>
                </ul>
            </div>

            <div>
                <h5 class="text-xs font-black uppercase tracking-[0.2em] text-white/40 mb-8">Support</h5>
                <ul class="space-y-4">
                    <li><a href="#" class="text-sm font-bold text-slate-400 hover:text-red-500 transition-all">Pusat Bantuan</a></li>
                    <li><a href="#" class="text-sm font-bold text-slate-400 hover:text-red-500 transition-all">Syarat & Ketentuan</a></li>
                    <li><a href="#" class="text-sm font-bold text-slate-400 hover:text-red-500 transition-all">Kebijakan Privasi</a></li>
                    <li><a href="#" class="text-sm font-bold text-slate-400 hover:text-red-500 transition-all">Hubungi Kami</a></li>
                </ul>
            </div>

            <div>
                <h5 class="text-xs font-black uppercase tracking-[0.2em] text-white/40 mb-8">Newsletter</h5>
                <p class="text-xs font-bold text-slate-500 mb-6 leading-relaxed">Dapatkan info batch terbaru dan lowongan kerja Jepang via email.</p>
                <form class="space-y-4">
                    <input type="email" placeholder="Email Address" class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-4 text-sm font-bold focus:outline-none focus:border-red-600 transition-all">
                    <button class="btn-premium btn-premium-primary !py-4 w-full shadow-lg shadow-red-500/20">SUBSCRIBE</button>
                </form>
            </div>
        </div>

        <div class="pt-10 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">&copy; {{ date('Y') }} PT. Kursus Jepang Indonesia. All Rights Reserved.</p>
            <div class="flex gap-8">
                 <a href="#" class="text-[10px] font-bold text-slate-500 uppercase tracking-widest hover:text-white transition-colors">Privacy Policy</a>
                 <a href="#" class="text-[10px] font-bold text-slate-500 uppercase tracking-widest hover:text-white transition-colors">Terms</a>
            </div>
        </div>
    </div>

    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/6281234567890" target="_blank" class="fixed bottom-8 right-8 z-[100] group flex items-center gap-3">
        <!-- Tooltip -->
        <span class="bg-white text-slate-900 text-[10px] font-black uppercase tracking-[0.2em] px-5 py-3 rounded-2xl shadow-2xl border border-slate-100 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-x-4 group-hover:translate-x-0 hidden md:block">
            Hubungi Admin
        </span>
        <!-- Button -->
        <div class="w-16 h-16 bg-[#25D366] rounded-[2rem] shadow-[0_20px_50px_rgba(37,211,102,0.3)] flex items-center justify-center text-white transform group-hover:scale-110 group-hover:rotate-6 transition-all duration-500 relative">
            <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full border-2 border-white animate-ping"></span>
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full border-2 border-white"></span>
        </div>
    </a>
</footer>
