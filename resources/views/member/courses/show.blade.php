<x-app-layout>
    <div class="space-y-8">
        <!-- Header -->
        <div class="relative rounded-3xl overflow-hidden bg-slate-900 text-white shadow-xl">
            <!-- Background Decoration -->
            <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            <div class="absolute top-0 right-0 w-64 h-64 bg-red-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
            <div class="absolute -bottom-8 -left-8 w-64 h-64 bg-blue-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            
            <div class="relative p-8 sm:p-10 flex flex-col md:flex-row items-center gap-8">
                <div class="flex-1 space-y-4 text-center md:text-left">
                    <div class="inline-flex items-center px-3 py-1 rounded-full bg-white/10 border border-white/20 text-xs font-bold uppercase tracking-widest backdrop-blur-sm">
                        {{ $course->level }}
                    </div>
                    <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-tight">
                        {{ $course->title }}
                    </h1>
                    <p class="text-slate-300 text-lg max-w-2xl font-medium">
                        {{ $course->description }}
                    </p>
                    
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-6 pt-4 text-sm font-medium text-slate-300">
                        <div class="flex items-center gap-2">
                            <span class="p-2 rounded-lg bg-white/5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            </span>
                            {{ $course->modules->count() }} Modul
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="p-2 rounded-lg bg-white/5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            Est. 3 Bulan
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="p-2 rounded-lg bg-white/5">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </span>
                            Sertifikat Digital
                        </div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-md rounded-2xl p-6 border border-white/20 w-full md:w-80 flex-shrink-0">
                    <div class="mb-4">
                        <div class="flex justify-between text-xs font-bold text-white mb-2">
                            <span>Progress Kursus</span>
                            <span>0%</span>
                        </div>
                        <div class="w-full bg-black/20 rounded-full h-3 overflow-hidden shadow-inner">
                            <div class="bg-gradient-to-r from-green-400 to-emerald-500 h-3 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>
                    @php
                        $firstLesson = $course->modules->first()->lessons->first();
                    @endphp
                    @if($firstLesson)
                    <a href="{{ route('courses.lessons.show', [$course->id, $firstLesson->id]) }}" class="w-full py-4 bg-white text-slate-900 font-bold rounded-xl shadow-lg hover:bg-slate-50 transition-all flex items-center justify-center gap-2 group">
                        <span class="group-hover:scale-105 transition-transform">Mulai Belajar</span>
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </a>
                    @else
                    <button disabled class="w-full py-4 bg-slate-500/50 text-white font-bold rounded-xl cursor-not-allowed">
                        Coming Soon
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <!-- Curriculum Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Syllabus -->
            <div class="lg:col-span-2 space-y-6">
                <h2 class="text-2xl font-bold text-slate-900 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center text-lg">📑</span>
                    Silabus Materi
                </h2>

                <div class="space-y-4">
                    @forelse($course->modules as $module)
                    <div x-data="{ open: {{ $loop->first ? 'true' : 'false' }} }" class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm transition-shadow hover:shadow-md">
                        <!-- Module Header -->
                        <button @click="open = !open" class="w-full px-6 py-4 flex items-center justify-between text-left bg-slate-50 border-b border-slate-100 hover:bg-slate-100 transition-colors">
                            <div class="flex items-center gap-4">
                                <span class="flex-shrink-0 w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-500 font-black text-sm flex items-center justify-center shadow-sm">
                                    {{ $module->order }}
                                </span>
                                <div>
                                    <h3 class="font-bold text-slate-800">{{ $module->title }}</h3>
                                    <p class="text-xs text-slate-500 font-medium">{{ $module->lessons->count() }} Pelajaran • {{ $module->lessons->sum('duration') }} Menit</p>
                                </div>
                            </div>
                            <svg class="w-5 h-5 text-slate-400 transition-transform duration-300" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <!-- Lessons List -->
                        <div x-show="open" x-collapse class="divide-y divide-slate-100">
                            @foreach($module->lessons as $lesson)
                            <a href="{{ route('courses.lessons.show', [$course->id, $lesson->id]) }}" class="group flex items-center gap-4 px-6 py-4 hover:bg-red-50 transition-colors">
                                <div class="flex-shrink-0 text-slate-400 group-hover:text-red-500 transition-colors">
                                    @if($lesson->type == 'video')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    @elseif($lesson->type == 'quiz')
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                    @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="text-sm font-bold text-slate-700 group-hover:text-red-700 transition-colors">{{ $lesson->title }}</h4>
                                </div>
                                <div class="text-xs font-bold text-slate-400">
                                    {{ $lesson->duration }}m
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 border-slate-200 flex items-center justify-center text-white bg-white group-hover:border-red-500 transition-colors">
                                    <!-- Checkmark if completed (future) -->
                                    <!-- <svg class="w-3 h-3 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> -->
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10 bg-slate-50 rounded-xl border border-dashed border-slate-300">
                        <p class="text-slate-500 font-medium">Belum ada materi yang dirilis.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Right: Sidebar Info -->
            <div class="space-y-6">
                <!-- Instructor Card -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <h3 class="font-bold text-slate-900 mb-4">Instruktur Anda</h3>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-slate-100 overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name=Sensei+Tomo&background=random" alt="Sensei" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <div class="font-bold text-slate-800">Sensei Tomo</div>
                            <div class="text-xs text-slate-500">Certified JLPT N1 Instructor</div>
                        </div>
                    </div>
                    <button class="w-full mt-4 py-2 border border-slate-200 rounded-lg text-sm font-bold text-slate-600 hover:bg-slate-50 transition-colors">
                        Tanya Sensei
                    </button>
                </div>

                <!-- Community Card -->
                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg">
                    <h3 class="font-bold mb-2">Member Community</h3>
                    <p class="text-xs text-indigo-100 mb-4">Bergabung dengan diskusi kelas dan latihan bersama siswa lain.</p>
                    <a href="#" class="block w-full text-center py-2 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-lg text-sm font-bold transition-colors">
                        Join Discord Group
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
