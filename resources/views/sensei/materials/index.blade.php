<x-sensei-layout>
    <div class="space-y-8" x-data="{ 
        showModuleModal: false, 
        showEditModuleModal: false,
        editingModule: {id: '', title: '', description: ''},
        openEditModal(module) {
            this.editingModule = {
                id: module.id,
                title: module.title,
                description: module.description || ''
            };
            this.showEditModuleModal = true;
        }
    }">
        <!-- Header & Top Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Materi & Modul</h2>
                <p class="text-slate-500 text-sm mt-1">Kelola konten pembelajaran untuk kursus Anda.</p>
            </div>
            
            <div class="flex items-center gap-3">
                 <button @click="showModuleModal = true" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm shadow-sm">
                    Buat Modul Baru
                </button>
                <a href="{{ route('sensei.materials.lessons.create') }}" class="px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 hover:shadow-red-600/40 transition-all flex items-center gap-2 text-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Buat Materi Baru
                </a>
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
                    <h4 class="text-slate-500 text-[10px] font-bold uppercase tracking-wide">Materi</h4>
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
                <!-- Module List -->
                <div class="space-y-4">
                    @forelse($modules as $module)
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
                                         <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-red-100 text-red-700">
                                            {{ $module['level'] }}
                                        </span>
                                    </div>
                                    <p class="text-sm text-slate-500 mt-0.5">{{ $module['material_count'] }} Materi • {{ ucfirst($module['status']) }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2" @click.stop="">
                                <!-- Edit Button -->
                                <button type="button" @click="openEditModal({{ json_encode($module) }})" class="p-2 text-slate-300 hover:text-blue-600 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </button>

                                <form action="{{ route('sensei.materials.modules.destroy', $module['id']) }}" method="POST" onsubmit="return confirm('Hapus modul ini beserta seluruh materinya?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-300 hover:text-red-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Module Content -->
                        <div x-show="open" x-collapse x-cloak class="border-t border-slate-100 bg-slate-50/50">
                            @if(count($module['materials']) > 0)
                                <ul class="divide-y divide-slate-100">
                                    @foreach($module['materials'] as $material)
                                    <li class="p-4 pl-16 hover:bg-slate-100/50 transition-colors flex items-center justify-between group">
                                        <div class="flex items-center gap-3">
                                            @if($material['type'] === 'Video')
                                                 <div class="p-2 bg-red-100 text-red-600 rounded-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                </div>
                                            @elseif($material['type'] === 'Pdf')
                                                <div class="p-2 bg-blue-100 text-blue-600 rounded-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                </div>
                                            @else
                                                <div class="p-2 bg-slate-100 text-slate-600 rounded-lg">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </div>
                                            @endif
                                            
                                            <div>
                                                <h5 class="text-sm font-bold text-slate-800">{{ $material['title'] }}</h5>
                                                <p class="text-xs text-slate-500">{{ $material['students_access'] }} Siswa Mengakses • {{ ucfirst($material['type']) }}</p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2 group-hover:opacity-100 transition-opacity">
                                            <a href="{{ route('sensei.materials.lessons.edit', $material['id']) }}" class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors" title="Edit">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                             <form action="{{ route('sensei.materials.lessons.destroy', $material['id']) }}" method="POST" onsubmit="return confirm('Hapus materi ini?');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors" title="Delete">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                             </form>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            @else
                                <div class="p-8 text-center text-slate-400 text-sm italic">
                                    Belum ada materi di modul ini.
                                </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="bg-white rounded-3xl border border-dashed border-slate-300 p-16 text-center">
                        <p class="text-slate-500">Belum ada modul yang Anda buat.</p>
                        <button @click="showModuleModal = true" class="mt-4 px-6 py-2 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all text-sm shadow-sm">
                            Buat Modul Pertama
                        </button>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                 <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sticky top-24">
                    <h3 class="font-bold text-slate-900 mb-4">Aksi Cepat</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('sensei.materials.lessons.create') }}" class="w-full p-4 rounded-xl border border-slate-200 hover:border-red-200 hover:bg-red-50/50 transition-all flex items-center gap-3 group text-left">
                            <div class="w-10 h-10 rounded-lg bg-red-100 text-red-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm group-hover:text-red-700">Tambah Materi Baru</h4>
                                <p class="text-[10px] text-slate-500">Video, PDF, atau Teks</p>
                            </div>
                        </a>

                         <button @click="showModuleModal = true" class="w-full p-4 rounded-xl border border-slate-200 hover:border-purple-200 hover:bg-purple-50/50 transition-all flex items-center gap-3 group text-left">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm group-hover:text-purple-700">Susun Modul Baru</h4>
                                <p class="text-[10px] text-slate-500">Kelompokkan Materi Anda</p>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Module Modal -->
        <div x-show="showModuleModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak style="display: none;">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div @click="showModuleModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

                <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden animate-in fade-in zoom-in duration-200">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-slate-900">Buat Modul Baru</h3>
                        <button @click="showModuleModal = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l18 18"></path></svg>
                        </button>
                    </div>

                    <form action="{{ route('sensei.materials.modules.store') }}" method="POST" class="p-6 space-y-4">
                        @csrf
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Pilih Kursus <span class="text-red-500">*</span></label>
                            @php $courses = \App\Models\Course::where('instructor_id', Auth::guard('sensei')->id())->get(); @endphp
                            <select name="course_id" required class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500">
                                @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->title }} ({{ $course->level }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Judul Modul <span class="text-red-500">*</span></label>
                            <input type="text" name="title" required placeholder="Contoh: Bab 1: Dasar Hiragana"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Deskripsi Singkat</label>
                            <textarea name="description" rows="3" 
                                class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500"
                                placeholder="Jelaskan isi modul ini..."></textarea>
                        </div>

                        <div class="pt-4 flex justify-end gap-3">
                            <button type="button" @click="showModuleModal = false" class="px-6 py-2.5 text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">Batal</button>
                            <button type="submit" class="px-8 py-2.5 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 transition-all text-sm">Simpan Modul</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Module Modal -->
        <div x-show="showEditModuleModal" class="fixed inset-0 z-50 overflow-y-auto" x-cloak style="display: none;">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div @click="showEditModuleModal = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

                <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden animate-in fade-in zoom-in duration-200">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                        <h3 class="text-xl font-bold text-slate-900">Edit Modul</h3>
                        <button @click="showEditModuleModal = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form :action="'{{ url('sensei/materials/modules') }}/' + editingModule.id" method="POST" class="p-6 space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Judul Modul <span class="text-red-500">*</span></label>
                            <input type="text" name="title" x-model="editingModule.title" required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700">Deskripsi Singkat</label>
                            <textarea name="description" rows="3" x-model="editingModule.description"
                                class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500"
                                placeholder="Jelaskan isi modul ini..."></textarea>
                        </div>

                        <div class="pt-4 flex justify-end gap-3">
                            <button type="button" @click="showEditModuleModal = false" class="px-6 py-2.5 text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">Batal</button>
                            <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-600/20 hover:bg-blue-700 transition-all text-sm">Update Modul</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-sensei-layout>
