<x-sensei-layout>
    <div class="space-y-8">
        <!-- Header & Top Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Materi & Modul</h2>
                <p class="text-slate-500 text-sm mt-1">Kelola konten pembelajaran untuk kelas yang Anda ajar.</p>
            </div>
            
            <div class="flex items-center gap-3">
                 <button class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                    Kelola Modul
                </button>
                <button class="px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 hover:shadow-red-600/40 transition-all flex items-center gap-2 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Materi Baru
                </button>
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Active Materials -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                 <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-lg font-bold">
                    📚
                </div>
                <div>
                    <h4 class="text-slate-500 text-[10px] font-bold uppercase tracking-wide">Materi Aktif</h4>
                    <p class="text-xl font-bold text-slate-900">{{ $summary['active_materials'] }}</p>
                </div>
            </div>

             <!-- Total Modules -->
            <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                 <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-lg font-bold">
                    📦
                </div>
                <div>
                    <h4 class="text-slate-500 text-[10px] font-bold uppercase tracking-wide">Total Modul</h4>
                    <p class="text-xl font-bold text-slate-900">{{ $summary['total_modules'] }}</p>
                </div>
            </div>

            <!-- Popular -->
             <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                 <div class="w-10 h-10 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center text-lg font-bold">
                    🔥
                </div>
                <div class="min-w-0">
                    <h4 class="text-slate-500 text-[10px] font-bold uppercase tracking-wide">Terpopuler</h4>
                    <p class="text-sm font-bold text-slate-900 truncate" title="{{ $summary['popular_material'] }}">{{ Str::limit($summary['popular_material'], 15) }}</p>
                </div>
            </div>

            <!-- Drafts -->
             <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center gap-4">
                 <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-500 flex items-center justify-center text-lg font-bold">
                    📝
                </div>
                <div>
                    <h4 class="text-slate-500 text-[10px] font-bold uppercase tracking-wide">Draft</h4>
                    <p class="text-xl font-bold text-slate-900">{{ $summary['draft_materials'] }}</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content: Modules & Materials -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Filters -->
                 <div class="flex flex-col sm:flex-row gap-4">
                     <div class="relative flex-1">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </span>
                        <input type="text" class="pl-9 pr-4 py-2 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500 w-full shadow-sm" placeholder="Cari materi...">
                    </div>
                    <select class="py-2 pl-3 pr-8 bg-white border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500 shadow-sm">
                        <option>Semua Level</option>
                        <option>N5</option>
                        <option>N4</option>
                        <option>TG</option>
                    </select>
                </div>

                <!-- Module List -->
                <div class="space-y-4">
                    @foreach($modules as $module)
                    <div x-data="{ open: false }" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                        <!-- Module Header (Clickable) -->
                        <div @click="open = !open" class="p-5 flex items-center justify-between cursor-pointer hover:bg-slate-50 transition-colors select-none">
                            <div class="flex items-center gap-4">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center transition-transform duration-200" :class="open ? 'rotate-90 bg-red-50 text-red-600' : 'bg-slate-100 text-slate-400'">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                                <div>
                                    <div class="flex items-center gap-2">
                                        <h3 class="font-bold text-slate-900">{{ $module['title'] }}</h3>
                                         <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider
                                            {{ $module['level'] === 'N5' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $module['level'] === 'N4' ? 'bg-blue-100 text-blue-700' : '' }}
                                            {{ $module['level'] === 'TG' ? 'bg-orange-100 text-orange-700' : '' }}
                                        ">
                                            {{ $module['level'] }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-slate-500 mt-0.5">{{ $module['material_count'] }} Materi • {{ ucfirst($module['status']) }}</p>
                                </div>
                            </div>
                            <!-- Status Indicator -->
                            @if($module['status'] === 'published')
                                <div class="hidden sm:block">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-600 border border-green-100">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Published
                                    </span>
                                </div>
                            @elseif($module['status'] === 'draft')
                                <div class="hidden sm:block">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">
                                        Draft
                                    </span>
                                </div>
                            @endif
                        </div>

                        <!-- Module Content -->
                        <div x-show="open" x-collapse class="border-t border-slate-100 bg-slate-50/50">
                            @if(count($module['materials']) > 0)
                                <ul class="divide-y divide-slate-100">
                                    @foreach($module['materials'] as $material)
                                    <li class="p-4 pl-16 hover:bg-slate-100/50 transition-colors flex items-center justify-between group">
                                        <div class="flex items-center gap-3">
                                            @if($material['type'] === 'Video')
                                                 <div class="p-2 bg-red-100 text-red-600 rounded-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                            @elseif($material['type'] === 'PDF')
                                                <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @elseif($material['type'] === 'Quiz')
                                                <div class="p-2 bg-purple-100 text-purple-600 rounded-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                            @endif
                                            
                                            <div>
                                                <h5 class="text-sm font-bold text-slate-800">{{ $material['title'] }}</h5>
                                                <p class="text-xs text-slate-500">{{ $material['students_access'] }} Siswa Mengakses • {{ $material['status'] }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button class="p-1.5 text-slate-400 hover:text-slate-600 hover:bg-slate-200 rounded transition-colors" title="Preview">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            </button>
                                            <button class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </button>
                                             <button class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="p-8 text-center">
                                    <p class="text-slate-400 text-sm italic">Belum ada materi di modul ini.</p>
                                    <button class="mt-2 text-red-600 text-sm font-bold hover:underline">+ Tambah Materi</button>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Sidebar: Quick Actions -->
            <div class="lg:col-span-1 space-y-6">
                 <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sticky top-24">
                    <h3 class="font-bold text-slate-900 mb-4">Aksi Cepat</h3>
                    
                    <div class="space-y-3">
                        <button class="w-full p-4 rounded-xl border border-slate-200 hover:border-red-200 hover:bg-red-50/50 transition-all flex items-center gap-3 group text-left">
                            <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm group-hover:text-red-700">Upload Video</h4>
                                <p class="text-[10px] text-slate-500">MP4, MKV (Max 500MB)</p>
                            </div>
                        </button>

                         <button class="w-full p-4 rounded-xl border border-slate-200 hover:border-blue-200 hover:bg-blue-50/50 transition-all flex items-center gap-3 group text-left">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm group-hover:text-blue-700">Upload PDF</h4>
                                <p class="text-[10px] text-slate-500">Materi Bacaan & Slide</p>
                            </div>
                        </button>

                         <button class="w-full p-4 rounded-xl border border-slate-200 hover:border-purple-200 hover:bg-purple-50/50 transition-all flex items-center gap-3 group text-left">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm group-hover:text-purple-700">Buat Materi Teks</h4>
                                <p class="text-[10px] text-slate-500">Artikel & Penjelasan</p>
                            </div>
                        </button>
                        
                        <div class="border-t border-slate-100 pt-3">
                            <button class="w-full py-2 flex items-center justify-center gap-2 text-slate-500 hover:text-slate-800 text-sm font-bold transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Susun Modul Baru
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-sensei-layout>
