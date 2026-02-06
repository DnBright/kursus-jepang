<nav class="p-8 space-y-10 flex flex-col h-full">
    <!-- Logo Section -->
    <div class="flex items-center gap-4 px-2 py-2">
        <div class="relative w-12 h-12 rounded-2xl overflow-hidden bg-white shadow-xl shadow-red-500/10 group">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-cover scale-150 group-hover:scale-110 transition-transform duration-500">
        </div>
        <div class="flex flex-col">
            <span class="font-black text-xl text-slate-900 tracking-tighter leading-none">Kursus<span class="text-red-600">Jepang</span></span>
            <span class="text-[9px] text-slate-400 font-black tracking-[0.2em] uppercase mt-1">Member Hub</span>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="space-y-2 flex-1 overflow-y-auto pr-2 custom-scrollbar">
        <a href="{{ url('/') }}" class="flex items-center gap-4 px-5 py-4 text-slate-500 hover:text-red-600 hover:bg-slate-50 rounded-2xl font-bold text-sm transition-all group mb-4 border border-transparent hover:border-slate-100">
            <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Ke Beranda
        </a>

        <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6">Main Dashboard</p>
        
        <x-sidebar-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Overview
        </x-sidebar-link>

        <x-sidebar-link :href="route('packages.index')" :active="request()->routeIs('packages.index')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            Beli Paket
        </x-sidebar-link>

        <x-sidebar-link :href="route('my-courses')" :active="request()->routeIs('my-courses') || request()->routeIs('courses.*')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
            My Courses
        </x-sidebar-link>

        <x-sidebar-link :href="route('live-class')" :active="request()->routeIs('live-class')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            Live Classes
        </x-sidebar-link>

        <p class="px-4 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 mt-10">Learning Assets</p>

        <x-sidebar-link :href="route('materials.index')" :active="request()->routeIs('materials.index')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Materials
        </x-sidebar-link>

        <x-sidebar-link :href="route('quizzes.index')" :active="request()->routeIs('quizzes.index')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
            Quizzes & Exams
        </x-sidebar-link>

        <x-sidebar-link :href="route('certificates.index')" :active="request()->routeIs('certificates.index')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
            Certificates
        </x-sidebar-link>
    </div>

    <!-- Bottom Footer Section -->
    <div class="mt-auto pt-8 border-t border-slate-100 space-y-2">
        <x-sidebar-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            Settings
        </x-sidebar-link>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-4 px-5 py-4 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-2xl font-black text-xs uppercase tracking-widest transition-all group">
                <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Sign Out
            </button>
        </form>
    </div>
</nav>
