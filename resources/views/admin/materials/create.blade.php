<x-admin-layout>
    <div x-data="{ 
        courses: {{ json_encode($courses) }},
        selectedCourse: '',
        filteredModules: [],
        updateModules() {
            if (!this.selectedCourse) {
                this.filteredModules = [];
                return;
            }
            const course = this.courses.find(c => c.id == this.selectedCourse);
            this.filteredModules = course ? course.modules : [];
        }
    }" class="max-w-4xl mx-auto space-y-6 pb-20">
        
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.materials.index') }}" class="inline-flex items-center text-sm font-bold text-red-600 hover:text-red-700 mb-2 group">
                    <svg class="w-4 h-4 mr-1 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali ke Manajemen Materi
                </a>
                <h1 class="text-2xl font-bold text-slate-900">Tambah Materi Baru</h1>
                <p class="text-slate-500 text-sm mt-1">Buat pelajaran baru dalam modul dan kelas yang dipilih.</p>
            </div>
        </div>

        <form action="{{ route('admin.materials.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden text-left">
                <div class="p-6 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                    </div>
                    <h2 class="font-bold text-slate-900">Penempatan Materi</h2>
                </div>
                
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pilih Kelas / Program</label>
                        <select x-model="selectedCourse" @change="updateModules()" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium cursor-pointer">
                            <option value="">Pilih Kelas</option>
                            <template x-for="course in courses" :key="course.id">
                                <option :value="course.id" x-text="course.title"></option>
                            </template>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pilih Modul</label>
                        <select name="module_id" required :disabled="!selectedCourse" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                            <option value="">Pilih Modul</option>
                            <template x-for="module in filteredModules" :key="module.id">
                                <option :value="module.id" x-text="module.title"></option>
                            </template>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden text-left">
                <div class="p-6 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h2 class="font-bold text-slate-900">Detail Konten</h2>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Judul Materi</label>
                        <input type="text" name="title" required placeholder="Contoh: Pengenalan Hiragana & Katakana" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tipe Materi</label>
                            <select name="type" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium cursor-pointer">
                                <option value="video">Video</option>
                                <option value="text">Teks / Artikel</option>
                                <option value="audio">Audio</option>
                                <option value="pdf">File PDF / Modul</option>
                            </select>
                        </div>
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Urutan (Order)</label>
                            <input type="number" name="order" required value="1" min="1" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pilih Sensei Pengajar</label>
                        <select name="instructor_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium cursor-pointer">
                            <option value="">Pilih Sensei</option>
                            @foreach($instructors as $instructor)
                                <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Isi Materi / URL Video</label>
                        <textarea name="content" required rows="6" placeholder="Masukkan URL Video YouTube atau isi materi teks di sini..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                        <div class="space-y-2">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Durasi (Opsional)</label>
                            <input type="text" name="duration" placeholder="Contoh: 15:30 atau 10 Halaman" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">
                        </div>
                        <div class="flex items-center gap-2 bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <input type="checkbox" name="is_free" value="1" class="w-4 h-4 text-red-600 focus:ring-red-500 border-slate-300 rounded cursor-pointer">
                            <label class="text-sm font-bold text-slate-700 cursor-pointer">Setel sebagai materi gratis (Preview)</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('admin.materials.index') }}" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                    Batal
                </a>
                <button type="submit" class="px-8 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all text-sm shadow-lg shadow-red-200">
                    Simpan Materi Baru
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
