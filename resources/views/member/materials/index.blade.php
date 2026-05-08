<x-app-layout>
    <div x-data="{ activeModule: @if($modules->count() > 0) {{ $modules->first()->id }} @else null @endif }" class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Materi Pembelajaran</h2>
                <p class="text-slate-500 text-sm mt-1">Akses semua modul, video, dan bahan bacaan kursus Anda.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-3">
                <!-- Program Filter -->
                <div class="flex items-center gap-3 bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm w-full sm:w-auto">
                    <span class="pl-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Program:</span>
                    <select onchange="window.location.href='/materials?level=' + this.value" class="text-xs font-bold text-slate-800 border-none focus:ring-0 cursor-pointer py-1 pl-2 pr-8 bg-transparent">
                        <option value="all" {{ $selectedLevel == 'all' ? 'selected' : '' }}>Semua Program</option>
                        <option value="N5" {{ $selectedLevel == 'N5' ? 'selected' : '' }}>JLPT N5</option>
                        <option value="N4" {{ $selectedLevel == 'N4' ? 'selected' : '' }}>JLPT N4</option>
                        <option value="Tokutei" {{ $selectedLevel == 'Tokutei' ? 'selected' : '' }}>Tokutei Ginou</option>
                    </select>
                </div>

                @if($myCourses->count() > 0)
                <div class="flex items-center gap-3 bg-white p-1.5 rounded-xl border border-slate-200 shadow-sm w-full sm:w-auto">
                    <span class="pl-3 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kursus:</span>
                    <select onchange="window.location.href='/materials?level={{ $selectedLevel }}&course_id=' + this.value" class="text-xs font-bold text-slate-800 border-none focus:ring-0 cursor-pointer py-1 pl-2 pr-8 bg-transparent">
                        @foreach($myCourses as $course)
                        <option value="{{ $course->id }}" {{ $selectedCourse && $selectedCourse->id == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                        @endforeach
                    </select>
                </div>
                @endif
            </div>
        </div>

        @if($selectedCourse)
        <!-- Course Summary Card -->
        <div class="bg-gradient-to-br from-red-600 to-red-800 rounded-3xl p-6 md:p-8 text-white relative overflow-hidden shadow-xl shadow-red-900/20">
            <div class="absolute inset-0 opacity-10" style="background-image: url('https://www.transparenttextures.com/patterns/shattered-island.png');"></div>
            <div class="absolute right-0 top-0 w-64 h-64 bg-white opacity-5 rounded-full blur-3xl -mr-16 -mt-16"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center gap-6">
                <!-- Progress Circle -->
                <div class="flex-shrink-0 relative w-20 h-20 md:w-24 md:h-24">
                     <svg class="w-full h-full transform -rotate-90">
                        <circle cx="50%" cy="50%" r="40%" stroke="currentColor" stroke-width="8" fill="transparent" class="text-white/20" />
                        <circle cx="50%" cy="50%" r="40%" stroke="currentColor" stroke-width="8" fill="transparent" stroke-dasharray="251.2" stroke-dashoffset="{{ 251.2 * (1 - $progress / 100) }}" class="text-white transition-all duration-1000" />
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center font-bold text-xl">{{ $progress }}%</div>
                </div>

                <div class="flex-1">
                    <div class="inline-block px-3 py-1 rounded-full bg-red-500/50 border border-white/20 text-xs font-bold uppercase tracking-wider mb-2">
                        @if($progress == 100) Selesai @elseif($progress > 0) Sedang Dipelajari @else Belum Dimulai @endif
                    </div>
                    <h3 class="text-2xl font-bold mb-2">{{ $selectedCourse->title }} Mastery</h3>
                    <p class="text-red-100 text-sm max-w-2xl">
                        {{ $progress == 100 ? 'Luar biasa! Anda telah menyelesaikan kursus ini.' : 'Lanjutkan modul Anda untuk mencapai target belajar. Semangat!' }}
                    </p>
                </div>

                <a href="{{ route('courses.show', $selectedCourse->id) }}" class="flex-shrink-0 px-6 py-3 bg-white text-red-700 font-bold rounded-xl shadow-lg hover:bg-red-50 transition-colors flex items-center gap-2 text-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Lihat Kurikulum
                </a>
            </div>
        </div>

        <!-- Modules Accordion -->
        <div class="space-y-4">
            @forelse($modules as $module)
            @php
                $moduleLessons = $module->lessons;
                $completedInModule = $moduleLessons->filter(fn($l) => in_array($l->id, $completedLessonIds))->count();
                $isModuleCompleted = $moduleLessons->count() > 0 && $completedInModule == $moduleLessons->count();
            @endphp
            <!-- Module Item -->
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm transition-all" :class="{ 'ring-2 ring-red-100 shadow-md': activeModule === {{ $module->id }} }">
                <!-- Header -->
                <button @click="activeModule = activeModule === {{ $module->id }} ? null : {{ $module->id }}" class="w-full flex items-center justify-between p-6 hover:bg-slate-50 transition-colors text-left">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-full {{ $isModuleCompleted ? 'bg-green-100 text-green-600' : 'bg-slate-100 text-slate-500' }} flex items-center justify-center flex-shrink-0 font-bold">
                            @if($isModuleCompleted)
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            @else
                                {{ $loop->iteration }}
                            @endif
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-lg">{{ $module->title }}</h4>
                            <p class="text-slate-500 text-sm">{{ $moduleLessons->count() }} Materi • {{ $completedInModule }} Selesai</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        @if($isModuleCompleted)
                            <span class="hidden md:inline-block px-3 py-1 bg-green-50 text-green-600 rounded-full text-xs font-bold">Selesai</span>
                        @elseif($completedInModule > 0)
                            <span class="hidden md:inline-block px-3 py-1 bg-yellow-50 text-yellow-600 rounded-full text-xs font-bold">In Progress</span>
                        @endif
                        <svg class="w-5 h-5 text-slate-400 transform transition-transform duration-200" :class="{ 'rotate-180': activeModule === {{ $module->id }} }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </button>

                <!-- Content -->
                <div x-show="activeModule === {{ $module->id }}" x-collapse>
                    <div class="border-t border-slate-100">
                        @foreach($moduleLessons as $lesson)
                        @php $isDone = in_array($lesson->id, $completedLessonIds); @endphp
                        <!-- Lesson Item -->
                        <div class="flex flex-col md:flex-row md:items-center justify-between p-4 pl-12 md:pl-[4.5rem] hover:bg-slate-50 transition-colors gap-4 border-t border-slate-50">
                            <div class="flex items-start gap-4">
                                <div class="w-8 h-8 rounded-lg {{ $isDone ? 'bg-green-50 text-green-500' : 'bg-red-50 text-red-500' }} flex items-center justify-center flex-shrink-0">
                                    @if($lesson->type == 'video')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @elseif($lesson->type == 'pdf')
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    @else
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    @endif
                                </div>
                                <div class="@if($isDone) opacity-60 @endif">
                                    <h5 class="font-bold text-slate-800 text-sm">{{ $lesson->title }}</h5>
                                    <p class="text-xs text-slate-500 mt-0.5">{{ $lesson->duration ?? 10 }} Menit • {{ ucfirst($lesson->type) }}</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                @if($isDone)
                                    <span class="text-xs font-bold text-green-600 flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Selesai</span>
                                    <a href="{{ route('courses.lessons.show', [$selectedCourse->id, $lesson->id]) }}" class="px-3 py-1.5 text-xs font-bold text-slate-600 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 hover:text-slate-900 transition-colors">Review</a>
                                @else
                                    <span class="text-xs font-bold text-slate-400">Belum Mulai</span>
                                    <a href="{{ route('courses.lessons.show', [$selectedCourse->id, $lesson->id]) }}" class="px-5 py-2 text-xs font-bold text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-lg shadow-red-600/20 transition-all transform hover:-translate-y-0.5">Mulai Belajar</a>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-300">
                <div class="text-6xl mb-4">📓</div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Belum Ada Modul</h3>
                <p class="text-slate-500 max-w-sm mx-auto">Sensei sedang menyiapkan materi terbaik untuk kursus ini.</p>
            </div>
            @endforelse
        </div>
        @else
        <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-slate-300">
            <div class="text-6xl mb-4">📚</div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Belum Ada Kursus Terpilih</h3>
            <p class="text-slate-500 max-w-sm mx-auto mb-6">Silakan pilih kursus Anda untuk melihat materi pembelajaran.</p>
            <a href="{{ route('packages.index') }}" class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all">Beli Paket Kursus</a>
        </div>
        @endif
    </div>
</x-app-layout>
