<x-app-layout>
    <!-- Hide Default Nav for Focus Mode (Optional - for now keeping it but making page standalone-ish) -->
    
    <div class="min-h-screen bg-white" x-data="{ 
        completeModalOpen: false, 
        markAsComplete() {
            this.completeModalOpen = true;
        }
    }">
        
        <!-- 1. Top Bar (Breadcrumbs & Title) -->
        <div class="border-b border-slate-100 bg-white sticky top-0 z-40">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-4 overflow-hidden">
                    <a href="{{ route('courses.show', $course->id) }}" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div class="flex flex-col">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                             {{ $breadcrumbs[1] }} 
                             <span class="text-slate-300">/</span> 
                             {{ $breadcrumbs[2] }}
                        </div>
                        <h1 class="text-sm md:text-base font-bold text-slate-900 truncate">{{ $lesson->title }}</h1>
                    </div>
                </div>
                
                <div class="flex items-center gap-4">
                    <div class="hidden md:flex items-center gap-2 text-xs font-bold text-slate-500 bg-slate-50 px-3 py-1.5 rounded-full">
                        <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                        {{ $position }}
                    </div>
                    <button class="text-slate-400 hover:text-red-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                    </button>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-8 items-start">
                
                <!-- 2. Main Content (Video & Tabs) - 70% -->
                <div class="w-full lg:w-[70%] space-y-8">
                    
                    <!-- Video Player -->
                    @if($lesson->type == 'video')
                    <div class="bg-black rounded-2xl overflow-hidden shadow-xl aspect-video relative group">
                        <!-- Assuming content is URL for now -->
                         @if(str_contains($lesson->content, 'youtube') || str_contains($lesson->content, 'vimeo'))
                        <iframe class="w-full h-full" src="{{ $lesson->content }}" title="Video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @else
                        <div class="flex items-center justify-center w-full h-full text-white">
                            Video placeholder (Content: {{ $lesson->content }})
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="bg-slate-100 rounded-2xl p-8 min-h-[300px] flex items-center justify-center">
                        <div class="text-center">
                            <h3 class="text-xl font-bold text-slate-700">Materi Teks / Kuis</h3>
                            <p class="text-slate-500">{{ $lesson->content }}</p>
                        </div>
                    </div>
                    @endif

                    <!-- Meta Info -->
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h2 class="text-2xl font-bold text-slate-900 mb-2">{{ $lesson->title }}</h2>
                            <p class="text-slate-500 text-sm leading-relaxed">{{ $lesson->module->description ?? 'Tidak ada deskripsi.' }}</p>
                        </div>
                    </div>

                    <!-- 3. Tabs -->
                    <div x-data="{ activeTab: 'summary' }">
                        <div class="flex items-center gap-6 border-b border-slate-100 mb-6">
                            <button @click="activeTab = 'summary'" 
                                class="pb-3 text-sm font-bold border-b-2 transition-colors"
                                :class="activeTab === 'summary' ? 'text-red-600 border-red-600' : 'text-slate-400 border-transparent hover:text-slate-600'">
                                🔴 Ringkasan Materi
                            </button>
                            <button @click="activeTab = 'notes'" 
                                class="pb-3 text-sm font-bold border-b-2 transition-colors"
                                :class="activeTab === 'notes' ? 'text-red-600 border-red-600' : 'text-slate-400 border-transparent hover:text-slate-600'">
                                📘 Catatan Saya
                            </button>
                             <!--
                            <button @click="activeTab = 'files'" 
                                class="pb-3 text-sm font-bold border-b-2 transition-colors"
                                :class="activeTab === 'files' ? 'text-red-600 border-red-600' : 'text-slate-400 border-transparent hover:text-slate-600'">
                                📎 Lampiran
                            </button>
                            -->
                        </div>

                        <!-- Tab Contents -->
                        <div class="min-h-[200px]">
                            <!-- Summary -->
                            <div x-show="activeTab === 'summary'" x-transition.opacity>
                                <div class="prose prose-slate prose-sm max-w-none">
                                   <!-- TODO: Add summary column to lessons table? -->
                                   <p>Silakan tonton video atau baca materi di atas dengan seksama.</p>
                                </div>
                            </div>
                            
                            <!-- Notes -->
                            <div x-show="activeTab === 'notes'" x-transition.opacity style="display: none;">
                                <textarea class="w-full h-40 p-4 rounded-xl bg-slate-50 border border-slate-200 text-sm text-slate-700 focus:ring-red-500 focus:border-red-500" placeholder="Tulis catatan penting Anda di sini... (Autosaved)"></textarea>
                                <div class="text-right mt-2 text-xs text-slate-400">Terakhir disimpan: Barusan</div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- 4. Sidebar - 30% -->
                <div class="hidden lg:block w-[30%] space-y-6 sticky top-24">
                    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <div class="p-4 bg-slate-50 border-b border-slate-100 font-bold text-slate-900">
                            Daftar Materi
                        </div>
                        <div class="max-h-[calc(100vh-300px)] overflow-y-auto custom-scrollbar">
                            @foreach($modules as $module)
                                <div x-data="{ open: {{ $module->id == $lesson->module_id ? 'true' : 'false' }} }">
                                    <button @click="open = !open" class="w-full text-left p-4 bg-white hover:bg-slate-50 font-bold text-xs text-slate-500 uppercase tracking-wider flex items-center justify-between border-b border-slate-100">
                                        {{ $module->title }}
                                        <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div x-show="open" class="bg-white">
                                        @foreach($module->lessons as $m_lesson)
                                        <a href="{{ route('courses.lessons.show', [$course->id, $m_lesson->id]) }}" 
                                           class="flex items-center gap-3 p-3 pl-4 border-b border-slate-50 hover:bg-slate-50 transition-colors
                                           {{ $m_lesson->id == $lesson->id ? 'bg-red-50 border-l-4 border-l-red-600' : 'border-l-4 border-l-transparent' }}">
                                            
                                            <!-- Status Icon -->
                                            <div class="shrink-0">
                                                @if($m_lesson->id < $lesson->id)
                                                    <div class="w-6 h-6 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    </div>
                                                @elseif($m_lesson->id == $lesson->id)
                                                     <div class="w-6 h-6 rounded-full bg-red-100 text-red-600 flex items-center justify-center">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path></svg>
                                                    </div>
                                                @else
                                                     <div class="w-6 h-6 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="flex-1 min-w-0">
                                                <div class="text-sm font-medium text-slate-800 truncate">{{ $m_lesson->title }}</div>
                                                <div class="text-[10px] text-slate-400 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                    {{ $m_lesson->duration }}m
                                                </div>
                                            </div>
                                        </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- 5. Bottom Navigation (Sticky) -->
        <div class="fixed bottom-0 left-0 w-full bg-white border-t border-slate-200 p-4 z-50">
            <div class="max-w-7xl mx-auto flex items-center justify-between gap-4">
                <button onclick="window.location='{{ $prev_lesson_url ?? '#' }}'" class="px-6 py-3 rounded-xl font-bold text-slate-500 hover:text-slate-900 transition-colors {{ !$prev_lesson_url ? 'opacity-50 cursor-not-allowed' : '' }}" {{ !$prev_lesson_url ? 'disabled' : '' }}>
                    ← Sebelumnya
                </button>

                <div class="flex-1 max-w-md hidden md:block">
                     <div class="flex justify-between text-[10px] font-bold text-slate-500 mb-1 uppercase tracking-wider">
                        <span>Progress Modul</span>
                        <span>-</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                        <div class="bg-green-500 h-1.5 rounded-full" style="width: 20%"></div>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                     <button @click="markAsComplete()" class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-600/30 transition-all hover:-translate-y-1 flex items-center gap-2">
                        Selesai & Lanjut
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </div>
        </div>
        
        <!-- PADDING FOR BOTTOM NAV -->
        <div class="h-24"></div>

        <!-- 6. Completion Modal -->
        <div x-show="completeModalOpen" class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;">
            <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity bg-slate-900 bg-opacity-75" @click="completeModalOpen = false"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full p-6 text-center">
                    <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl animate-bounce">
                        🎉
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Materi Selesai!</h3>
                    <p class="text-sm text-slate-500 mb-6">Hebat! Anda telah menyelesaikan materi ini. Lanjutkan ke materi berikutnya?</p>

                    <div class="space-y-3">
                        <a href="{{ $next_lesson_url ?? '#' }}" class="block w-full px-4 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 transition-colors {{ !$next_lesson_url ? 'opacity-50 pointer-events-none' : '' }}">
                            Lanjut Materi Berikutnya
                        </a>
                        <button @click="completeModalOpen = false" class="block w-full px-4 py-3 bg-white text-slate-500 font-bold rounded-xl hover:bg-slate-50 transition-colors">
                            Ulangi Video
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
