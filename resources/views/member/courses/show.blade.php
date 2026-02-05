<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- 1. Header Course -->
        <div class="bg-white rounded-[2rem] p-8 md:p-10 shadow-xl shadow-slate-200/50 mb-8 border border-slate-100 relative overflow-hidden">
             <!-- Background Pattern -->
             <div class="absolute top-0 right-0 w-64 h-64 bg-red-50 rounded-full blur-3xl opacity-50 -mr-16 -mt-16 pointer-events-none"></div>

            <div class="relative z-10">
                <div class="flex flex-col md:flex-row md:items-start justify-between gap-6 mb-8">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-bold rounded-full uppercase tracking-wider flex items-center gap-1.5">
                                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                                Aktif
                            </span>
                            <span class="text-slate-400 text-sm font-medium">Batch 12</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-bold text-slate-900 mb-2 leading-tight">{{ $course['title'] }}</h1>
                        <p class="text-slate-500 text-lg">{{ $course['subtitle'] }}</p>
                    </div>
                     <div class="hidden md:block text-right">
                        <div class="text-4xl font-black text-red-600 tracking-tight">{{ $course['progress'] }}%</div>
                        <div class="text-sm text-slate-400 font-medium">Selesai</div>
                    </div>
                </div>

                <!-- Progress Bar -->
                <div class="mb-8">
                    <div class="flex justify-between text-sm font-bold text-slate-700 mb-2">
                        <span>Progress Belajar</span>
                        <span class="md:hidden">{{ $course['progress'] }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                        <div class="bg-red-600 h-3 rounded-full transition-all duration-1000 ease-out shadow-[0_0_10px_rgba(220,38,38,0.5)]" style="width: {{ $course['progress'] }}%"></div>
                    </div>
                </div>

                <!-- CTA -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('courses.lessons.show', [1, 1]) }}" class="px-8 py-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-600/30 transition-all hover:-translate-y-1 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Lanjutkan Modul Terakhir
                    </a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Summary & Modules -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- 2. Info Cards (Grid) -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center text-center justify-center gap-1 group hover:border-red-100 transition-colors">
                        <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-1 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <span class="text-2xl font-bold text-slate-800">{{ $course['total_modules'] }}</span>
                        <span class="text-xs text-slate-500 font-medium uppercase tracking-wide">Total Modul</span>
                    </div>
                    <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center text-center justify-center gap-1 group hover:border-red-100 transition-colors">
                         <div class="w-10 h-10 rounded-full bg-orange-50 text-orange-600 flex items-center justify-center mb-1 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="text-2xl font-bold text-slate-800">±{{ $course['total_hours'] }} Jam</span>
                        <span class="text-xs text-slate-500 font-medium uppercase tracking-wide">Estimasi</span>
                    </div>
                     <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center text-center justify-center gap-2 group hover:border-red-100 transition-colors col-span-2 md:col-span-1">
                         <img src="{{ $course['sensei']['avatar_url'] }}" class="w-10 h-10 rounded-full border-2 border-slate-100 group-hover:border-red-200 transition-colors" alt="Sensei">
                        <div class="leading-tight">
                             <div class="text-sm font-bold text-slate-900">{{ $course['sensei']['name'] }}</div>
                             <span class="text-[10px] text-slate-500 font-medium uppercase tracking-wide">Sensei</span>
                        </div>
                    </div>
                </div>

                <!-- 3. Last Learned Card -->
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-6 md:p-8 text-white relative overflow-hidden shadow-lg shadow-slate-900/20">
                     <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10 pointer-events-none"></div>
                    
                    <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="flex-1">
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                                <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                                Terakhir Dipelajari
                            </div>
                            <h3 class="text-xl md:text-2xl font-bold mb-1">{{ $course['last_learned']['module_title'] }}</h3>
                            <p class="text-slate-300 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                {{ $course['last_learned']['lesson_title'] }}
                            </p>
                        </div>
                        <button class="w-full md:w-auto px-6 py-3 bg-white text-slate-900 hover:bg-slate-100 font-bold rounded-xl transition-colors shadow-lg shadow-white/10 shrink-0">
                            Lanjutkan Belajar
                        </button>
                    </div>
                </div>

                <!-- 4. Module List (Accordion) -->
                <div>
                     <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        Daftar Modul
                    </h3>

                    <div class="space-y-4" x-data="{ activeModule: 5 }">
                        @foreach($course['modules'] as $module)
                        <div class="bg-white border {{ $module['status'] === 'active' ? 'border-red-200 ring-4 ring-red-50' : 'border-slate-200' }} rounded-2xl overflow-hidden transition-all duration-300">
                            <!-- Header -->
                            <button @click="activeModule = activeModule === {{ $module['id'] }} ? null : {{ $module['id'] }}" 
                                class="w-full flex items-center justify-between p-5 {{ $module['status'] === 'locked' ? 'opacity-75 bg-slate-50 cursor-not-allowed' : 'hover:bg-slate-50' }}"
                                {{ $module['status'] === 'locked' ? 'disabled' : '' }}>
                                <div class="flex items-center gap-4 text-left">
                                    <!-- Icon Status -->
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0
                                        {{ $module['status'] === 'completed' ? 'bg-green-100 text-green-600' : '' }}
                                        {{ $module['status'] === 'active' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : '' }}
                                        {{ $module['status'] === 'locked' ? 'bg-slate-200 text-slate-400' : '' }}">
                                        
                                        @if($module['status'] === 'completed')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        @elseif($module['status'] === 'locked')
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        @endif
                                    </div>
                                    
                                    <div>
                                        <h4 class="font-bold text-slate-900 {{ $module['status'] === 'active' ? 'text-lg' : '' }}">{{ $module['title'] }}</h4>
                                        <p class="text-xs text-slate-500 font-medium">
                                            @if($module['status'] === 'completed')
                                                <span class="text-green-600">Selesai</span>
                                            @elseif($module['status'] === 'active')
                                                <span class="text-red-600">Sedang Dipelajari</span>
                                            @else
                                                Terkunci
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                <div class="transition-transform duration-300" :class="{'rotate-180': activeModule === {{ $module['id'] }}}">
                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </button>

                            <!-- Content -->
                            <div x-show="activeModule === {{ $module['id'] }}" x-collapse class="border-t border-slate-100 bg-slate-50/50">
                                <ul class="divide-y divide-slate-100">
                                    @foreach($module['lessons'] as $lesson)
                                    <li>
                                        <a href="#" class="flex items-center gap-4 p-4 hover:bg-white hover:text-red-600 transition-colors group {{ isset($lesson['current']) && $lesson['current'] ? 'bg-red-50' : '' }}">
                                             <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0
                                                {{ $lesson['completed'] ? 'bg-green-100 text-green-600' : 'bg-slate-200 text-slate-500' }}
                                                {{ isset($lesson['current']) && $lesson['current'] ? '!bg-red-600 !text-white' : '' }}">
                                                
                                                @if($lesson['type'] === 'video')
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                @else
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                @endif
                                            </div>
                                            <span class="text-sm font-medium text-slate-700 group-hover:text-red-600 flex-1">{{ $lesson['title'] }}</span>
                                            
                                            @if($lesson['completed'])
                                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            @elseif(isset($lesson['current']) && $lesson['current'])
                                                <span class="text-[10px] font-bold uppercase tracking-wider text-red-600 bg-red-100 px-2 py-0.5 rounded-full">Lanjut</span>
                                            @endif
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column: Sidebar Stats -->
            <div class="space-y-6">
                
                <!-- 5. Assessment Stats -->
                <div class="bg-white rounded-2xl p-6 border border-slate-100 shadow-sm">
                    <h3 class="font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Statistik Nilai
                    </h3>
                    
                    <div class="space-y-6">
                        <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-slate-500">Quiz Terakhir</span>
                                <span class="font-bold text-slate-900">{{ $course['stats']['quiz_score'] }}</span>
                            </div>
                           <div class="w-full bg-slate-100 rounded-full h-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $course['stats']['quiz_score'] }}%"></div>
                            </div>
                        </div>

                         <div>
                            <div class="flex justify-between text-sm mb-2">
                                <span class="text-slate-500">Rata-rata Nilai</span>
                                <span class="font-bold text-slate-900">{{ $course['stats']['avg_score'] }}</span>
                            </div>
                           <div class="w-full bg-slate-100 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $course['stats']['avg_score'] }}%"></div>
                            </div>
                        </div>

                         <div class="p-4 bg-slate-50 rounded-xl flex items-center gap-4">
                            <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center text-xl">🎯</div>
                            <div>
                                <div class="text-xs text-slate-400 font-bold uppercase">Status Kelulusan</div>
                                <div class="font-bold text-green-600">{{ $course['stats']['status'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Help Box -->
                <div class="bg-blue-50 rounded-2xl p-6 border border-blue-100">
                    <h4 class="font-bold text-blue-900 mb-2">Butuh Bantuan?</h4>
                    <p class="text-sm text-blue-700 mb-4">Jika mengalami kendala dalam materi, silakan tanyakan di grup diskusi.</p>
                    <button class="w-full py-2 bg-white text-blue-600 font-bold text-sm rounded-lg border border-blue-200 hover:bg-blue-50 transition-colors">
                        Tanya Sensei
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- 6. Sticky Footer (Mobile Only) -->
    <div class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-slate-100 p-4 z-50 flex items-center gap-3 shadow-[0_-5px_15px_rgba(0,0,0,0.05)]">
        <a href="{{ route('my-courses') }}" class="px-4 py-3 bg-slate-100 text-slate-600 rounded-xl font-bold">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <button class="flex-1 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20">
            Masuk ke Materi
        </button>
    </div>
</x-app-layout>
