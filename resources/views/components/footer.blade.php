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
</footer>
