<x-sensei-layout>
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Buat Tugas Baru</h2>
                <p class="text-slate-500 text-sm mt-1">Berikan tugas essay atau project untuk siswa Anda.</p>
            </div>
            <a href="{{ route('sensei.quizzes.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden" x-data="{ courseId: '' }">
            <form action="{{ route('sensei.assignments.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2 space-y-2">
                        <label for="title" class="text-sm font-bold text-slate-700">Judul Tugas <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" required value="{{ old('title') }}" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium"
                            placeholder="Contoh: Essay Pengalaman Belajar Bahasa Jepang">
                    </div>

                    <!-- Course Selection -->
                    <div class="space-y-2">
                        <label for="course_id" class="text-sm font-bold text-slate-700">Pilih Kursus <span class="text-red-500">*</span></label>
                        <select name="course_id" id="course_id" required x-model="courseId"
                            @change="fetchModules()"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium appearance-none">
                            <option value="">Pilih Kursus</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Module Selection -->
                    <div class="space-y-2 shadow-sm rounded-xl">
                        <label for="module_id" class="text-sm font-bold text-slate-700">Pilih Modul <span class="text-red-500">*</span></label>
                        <select name="module_id" id="module_id" required 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium appearance-none">
                            <option value="">Pilih Modul Terlebih Dahulu</option>
                        </select>
                    </div>

                    <!-- Assignment Type -->
                    <div class="space-y-2">
                        <label for="assignment_type" class="text-sm font-bold text-slate-700">Tipe Tugas <span class="text-red-500">*</span></label>
                        <select name="assignment_type" id="assignment_type" required 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium appearance-none">
                            <option value="writing">Writing / Menulis</option>
                            <option value="speaking">Speaking / Berbicara</option>
                            <option value="reading">Reading / Membaca</option>
                            <option value="listening">Listening / Mendengar</option>
                            <option value="project">Project / Tugas Akhir</option>
                        </select>
                    </div>

                    <!-- Max Score -->
                    <div class="space-y-2">
                        <label for="max_score" class="text-sm font-bold text-slate-700">Skor Maksimal <span class="text-red-500">*</span></label>
                        <input type="number" name="max_score" id="max_score" required value="100" min="1"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium">
                    </div>

                    <!-- Due Date -->
                    <div class="space-y-2">
                        <label for="due_date" class="text-sm font-bold text-slate-700">Deadline Pengumpulan</label>
                        <input type="datetime-local" name="due_date" id="due_date" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium">
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2 space-y-2">
                        <label for="description" class="text-sm font-bold text-slate-700">Instruksi Tugas <span class="text-red-500">*</span></label>
                        <textarea name="description" id="description" rows="5" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium"
                            placeholder="Tuliskan instruksi lengkap untuk dikerjakan siswa..."></textarea>
                    </div>

                    <!-- Is Required -->
                    <div class="md:col-span-2 flex items-center gap-3 p-4 bg-blue-50 rounded-xl border border-blue-100">
                        <input type="checkbox" name="is_required" id="is_required" value="1" checked
                            class="w-5 h-5 text-blue-600 rounded border-slate-300 focus:ring-blue-500">
                        <label for="is_required" class="text-sm font-bold text-blue-900">Tugas ini wajib dikerjakan</label>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <button type="submit" class="px-8 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 transition-all">
                        Simpan Tugas
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function fetchModules() {
            const courseId = document.getElementById('course_id').value;
            const moduleSelect = document.getElementById('module_id');
            
            if (!courseId) {
                moduleSelect.innerHTML = '<option value="">Pilih Kursus Terlebih Dahulu</option>';
                return;
            }

            moduleSelect.innerHTML = '<option value="">Loading...</option>';

            fetch(`/sensei/api/courses/${courseId}/modules`)
                .then(response => response.json())
                .then(data => {
                    moduleSelect.innerHTML = '<option value="">Pilih Modul</option>';
                    data.forEach(module => {
                        const option = document.createElement('option');
                        option.value = module.id;
                        option.textContent = module.title;
                        moduleSelect.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error fetching modules:', error);
                    moduleSelect.innerHTML = '<option value="">Error load data</option>';
                });
        }
    </script>
</x-sensei-layout>
