<x-sensei-layout>
    <div class="max-w-4xl mx-auto" x-data="{ type: 'video' }">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Buat Materi Baru</h2>
                <p class="text-slate-500 text-sm mt-1">Tambahkan konten pembelajaran ke modul Anda.</p>
            </div>
            <a href="{{ route('sensei.materials.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <form action="{{ route('sensei.materials.lessons.store') }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2 space-y-2">
                        <label for="title" class="text-sm font-bold text-slate-700">Judul Materi <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" required value="{{ old('title') }}" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium"
                            placeholder="Contoh: Pengenalan Partikel WA & GA">
                    </div>

                    <!-- Course Selection -->
                    <div class="space-y-2">
                        <label for="course_id" class="text-sm font-bold text-slate-700">Pilih Kursus <span class="text-red-500">*</span></label>
                        <select name="course_id" id="course_id" required onchange="loadModules(this.value)"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium appearance-none">
                            <option value="">Pilih Kursus</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }} ({{ $course->level }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Module Selection -->
                    <div class="space-y-2">
                        <label for="module_id" class="text-sm font-bold text-slate-700">Pilih Modul <span class="text-red-500">*</span></label>
                        <select name="module_id" id="module_id" required 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium appearance-none">
                            <option value="">Pilih Kursus Terlebih Dahulu</option>
                        </select>
                    </div>

                    <!-- Material Type -->
                    <div class="space-y-2">
                        <label for="type" class="text-sm font-bold text-slate-700">Tipe Materi <span class="text-red-500">*</span></label>
                        <select name="type" id="type" required x-model="type"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium appearance-none">
                            <option value="video">Video (URL YouTube/Vimeo)</option>
                            <option value="pdf">Dokumen PDF</option>
                            <option value="text">Artikel / Teks</option>
                        </select>
                    </div>

                    <!-- Dynamic Content: Video -->
                    <div class="md:col-span-2 space-y-2" x-show="type === 'video'">
                        <label for="content_video" class="text-sm font-bold text-slate-700">Link Video URL <span class="text-red-500">*</span></label>
                        <input type="url" name="content_video" id="content_video" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium"
                            placeholder="https://www.youtube.com/watch?v=...">
                        <p class="text-[10px] text-slate-500 italic">Masukkan link video YouTube, Vimeo, atau sumber lainnya.</p>
                    </div>

                    <!-- Dynamic Content: PDF -->
                    <div class="md:col-span-2 space-y-2" x-show="type === 'pdf'">
                        <label for="content_pdf" class="text-sm font-bold text-slate-700">Upload File PDF <span class="text-red-500">*</span></label>
                        <input type="file" name="content_pdf" id="content_pdf" accept=".pdf"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                        <p class="text-[10px] text-slate-500 italic">Maksimal ukuran file 10MB.</p>
                    </div>

                    <!-- Dynamic Content: Text -->
                    <div class="md:col-span-2 space-y-2" x-show="type === 'text'">
                        <label for="content_text" class="text-sm font-bold text-slate-700">Isi Artikel / Pelajaran <span class="text-red-500">*</span></label>
                        <textarea name="content_text" id="content_text" rows="10" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium"
                            placeholder="Tuliskan materi pelajaran di sini..."></textarea>
                    </div>

                    <!-- Duration & Settings -->
                    <div class="space-y-2">
                        <label for="duration" class="text-sm font-bold text-slate-700">Estimasi Durasi (Menit)</label>
                        <input type="number" name="duration" id="duration" value="10" min="1"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                    </div>

                    <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-100 self-end">
                        <input type="checkbox" name="is_free" id="is_free" value="1"
                            class="w-5 h-5 text-red-600 rounded border-slate-300 focus:ring-red-500">
                        <label for="is_free" class="text-sm font-bold text-slate-700">Materi Gratis (Pratinjau)</label>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-100 flex justify-end gap-3">
                    <button type="submit" class="px-10 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 transition-all">
                        Simpan Materi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function loadModules(courseId) {
            if (!courseId) return;

            const moduleSelect = document.getElementById('module_id');
            moduleSelect.innerHTML = '<option value="">Memuat modul...</option>';

            fetch(`/sensei/api/courses/${courseId}/modules`)
                .then(response => response.json())
                .then(modules => {
                    moduleSelect.innerHTML = '<option value="">Pilih Modul</option>';
                    modules.forEach(module => {
                        const option = document.createElement('option');
                        option.value = module.id;
                        option.textContent = module.title;
                        moduleSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading modules:', error);
                    moduleSelect.innerHTML = '<option value="">Gagal memuat modul</option>';
                });
        }
    </script>
</x-sensei-layout>
