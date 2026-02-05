<nav class="p-5 space-y-6 flex flex-col h-full">
    <!-- Logo -->
    <div class="flex items-center gap-3 px-2 py-3 border-b border-slate-100 pb-6">
        <div class="w-10 h-10 rounded-lg shadow-md shadow-red-200 overflow-hidden">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-cover scale-[1.4]">
        </div>
        <div class="flex flex-col">
            <span class="font-jp font-bold text-lg text-slate-800 tracking-tight leading-none">Kursus<span class="text-red-600">Jepang</span></span>
            <span class="text-[10px] text-slate-400 font-bold tracking-widest uppercase mt-0.5">Member Portal</span>
        </div>
    </div>

    <!-- Menu -->
    <div class="space-y-2 flex-1 overflow-y-auto pr-2 custom-scrollbar">
        <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-4">Navigasi Utama</p>
        
        <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Dashboard
        </x-sidebar-link>

        <x-sidebar-link :href="route('my-courses')" :active="request()->routeIs('my-courses')">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            Kursus Saya
        </x-sidebar-link>

        <x-sidebar-link :href="route('live-class')" :active="request()->routeIs('live-class')">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            Live Class
        </x-sidebar-link>

        <x-sidebar-link :href="route('materials.index')" :active="request()->routeIs('materials.index')">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Materi
        </x-sidebar-link>

        <x-sidebar-link :href="route('quizzes.index')" :active="request()->routeIs('quizzes.index')">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Latihan & Ujian
        </x-sidebar-link>

        <x-sidebar-link :href="route('certificates.index')" :active="request()->routeIs('certificates.index')">
            <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            Sertifikat
        </x-sidebar-link>
    </div>

    <!-- User Section -->
    <div class="mt-auto pt-6 border-t border-slate-100">
        <div class="px-4 mb-4 flex items-center gap-3">
             <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-600 font-bold text-sm">
                 {{ substr(Auth::user()->name, 0, 1) }}
             </div>
             <div class="overflow-hidden">
                 <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->name }}</p>
                 <p class="text-xs text-slate-400 truncate">Member Account</p>
             </div>
        </div>

        <x-sidebar-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            Profil Sayaa
        </x-sidebar-link>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-slate-500 hover:text-red-600 hover:bg-slate-50 rounded-lg font-medium transition-all group">
                <svg class="w-5 h-5 group-hover:text-red-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Keluar
            </button>
        </form>
    </div>
</nav>
