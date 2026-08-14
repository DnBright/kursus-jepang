<nav class="p-8 space-y-10 flex flex-col h-full bg-slate-900 border-r border-white/5">
    <!-- Logo Section -->
    <div class="flex items-center gap-4 px-2 py-2">
        <div class="relative w-12 h-12 rounded-2xl overflow-hidden bg-white shadow-xl shadow-red-500/20 group">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-full h-full object-cover scale-150 group-hover:scale-110 transition-transform duration-500">
        </div>
        <div class="flex flex-col text-white">
            <span class="font-black text-xl tracking-tighter leading-none">Kursus<span class="text-red-500">Jepang</span></span>
            <span class="text-[9px] text-slate-500 font-black tracking-[0.2em] uppercase mt-1">Sensei Expert</span>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="space-y-2 flex-1 overflow-y-auto pr-2 custom-scrollbar">
        <p class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-6">Management</p>
        
        <x-sidebar-link :href="route('sensei.dashboard')" :active="request()->routeIs('sensei.dashboard')" class="!bg-transparent text-slate-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
            Overview
        </x-sidebar-link>

        <x-sidebar-link :href="route('sensei.classes.index')" :active="request()->routeIs('sensei.classes.index')" class="!bg-transparent text-slate-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            My Classes
        </x-sidebar-link>

        <x-sidebar-link :href="route('sensei.live.index')" :active="request()->routeIs('sensei.live.index')" class="!bg-transparent text-slate-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            Live Sessions
        </x-sidebar-link>

        <p class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-6 mt-10">Curriculum</p>





        <x-sidebar-link :href="route('sensei.quizzes.grading.index')" :active="request()->routeIs('sensei.quizzes.grading.*')" class="!bg-transparent text-slate-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            Penilaian
        </x-sidebar-link>

        <x-sidebar-link :href="route('sensei.roadmap.index')" :active="request()->routeIs('sensei.roadmap.*')" class="!bg-transparent text-slate-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Roadmap
        </x-sidebar-link>


    </div>

    <!-- User Section -->
    <div class="mt-auto pt-8 border-t border-white/5 space-y-2">
        <x-sidebar-link :href="route('sensei.profile.edit')" :active="request()->routeIs('sensei.profile.edit')" class="!bg-transparent text-slate-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            Settings
        </x-sidebar-link>

        <form method="POST" action="{{ route('sensei.logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-4 px-5 py-4 text-slate-500 hover:text-red-500 hover:bg-red-500/5 rounded-2xl font-black text-xs uppercase tracking-widest transition-all group">
                <svg class="w-5 h-5 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Sign Out
            </button>
        </form>
    </div>
</nav>
