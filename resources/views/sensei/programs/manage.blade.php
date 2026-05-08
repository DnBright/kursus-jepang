<x-sensei-layout>
    <div class="max-w-5xl mx-auto space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-bold uppercase tracking-widest">
                        <li class="inline-flex items-center">
                            <a href="{{ route('sensei.quizzes.index') }}" class="text-slate-400 hover:text-red-600 transition-colors">Program</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="text-slate-600">Kelola Roadmap</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Roadmap <span class="text-red-600">{{ $course->title }}</span></h2>
                <p class="text-slate-500 font-bold mt-1 uppercase text-[10px] tracking-[0.2em]">{{ $course->level }} • {{ $course->modules->count() }} Modul • {{ $course->quizzes->count() }} Quiz</p>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('sensei.materials.index') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-xs flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg> Tambah Modul
                </a>
                <a href="{{ route('sensei.quizzes.create') }}?course_id={{ $course->id }}" class="px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 transition-all text-xs flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg> Tambah Quiz
                </a>
            </div>
        </div>

        <!-- Roadmap Content -->
        <div class="relative">
            <!-- Vertical Line -->
            <div class="absolute left-8 top-0 bottom-0 w-1 bg-slate-100 rounded-full"></div>

            <div class="space-y-12">
                @php
                    $roadmapItems = collect();
                    foreach($course->modules as $module) {
                        $roadmapItems->push([
                            'type' => 'module',
                            'id' => $module->id,
                            'title' => $module->title,
                            'description' => $module->description,
                            'order' => $module->order,
                            'data' => $module
                        ]);
                    }
                    foreach($course->quizzes as $quiz) {
                        $roadmapItems->push([
                            'type' => 'quiz',
                            'id' => $quiz->id,
                            'title' => $quiz->title,
                            'description' => $quiz->description,
                            'order' => 99, // Quiz might need its own ordering or logic
                            'data' => $quiz
                        ]);
                    }
                    // For now, let's just list modules then quizzes, or sort by created_at if order isn't unified
                    $roadmapItems = $roadmapItems->sortBy('order');
                @endphp

                @foreach($roadmapItems as $index => $item)
                <div class="relative pl-20 group">
                    <!-- Dot -->
                    <div class="absolute left-[26px] top-4 w-4 h-4 rounded-full border-4 border-white shadow-sm transition-all duration-500
                        {{ $item['type'] === 'module' ? 'bg-blue-600 scale-125' : 'bg-red-600' }}">
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm group-hover:shadow-md group-hover:border-slate-300 transition-all">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-md
                                        {{ $item['type'] === 'module' ? 'bg-blue-50 text-blue-600' : 'bg-red-50 text-red-600' }}">
                                        {{ $item['type'] === 'module' ? 'Checkpoint Modul' : 'Checkpoint Quiz' }}
                                    </span>
                                    <span class="text-slate-400 font-bold text-[10px]">#{{ $index + 1 }}</span>
                                </div>
                                <h4 class="text-xl font-black text-slate-900 group-hover:text-red-600 transition-colors">{{ $item['title'] }}</h4>
                                <p class="text-slate-500 text-sm mt-2 line-clamp-2 font-medium">{{ $item['description'] ?: 'Tidak ada deskripsi.' }}</p>
                                
                                @if($item['type'] === 'module')
                                <div class="mt-4 flex items-center gap-4">
                                    <div class="flex items-center gap-1.5 text-xs font-bold text-slate-600">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                        {{ $item['data']->lessons->count() }} Materi
                                    </div>
                                </div>
                                @else
                                <div class="mt-4 flex items-center gap-4">
                                    <div class="flex items-center gap-1.5 text-xs font-bold text-slate-600">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                        {{ $item['data']->questions->count() }} Pertanyaan
                                    </div>
                                    <div class="flex items-center gap-1.5 text-xs font-bold text-slate-600">
                                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $item['data']->time_limit ?: 'Tidak ada' }} Menit
                                    </div>
                                </div>
                                @endif
                            </div>

                            <div class="flex flex-col gap-2">
                                @if($item['type'] === 'module')
                                <a href="{{ route('sensei.materials.index') }}" class="p-2 text-slate-400 hover:text-blue-600 transition-all bg-slate-50 rounded-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                @else
                                <a href="{{ route('sensei.quizzes.edit', $item['id']) }}" class="p-2 text-slate-400 hover:text-red-600 transition-all bg-slate-50 rounded-xl">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Ending Node -->
                <div class="relative pl-20">
                    <div class="absolute left-[26px] top-4 w-4 h-4 rounded-full bg-slate-200 border-4 border-white shadow-sm"></div>
                    <div class="p-6 text-slate-400 font-bold uppercase text-xs tracking-widest">
                        🏁 Akhir Roadmap
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-sensei-layout>
