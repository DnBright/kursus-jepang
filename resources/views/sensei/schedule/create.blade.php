<x-sensei-layout>
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Tambah Jadwal Baru</h2>
                <p class="text-slate-500 text-sm mt-1">Jadwalkan Live Class atau sesi baru untuk siswa Anda.</p>
            </div>
            <a href="{{ route('sensei.schedule.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <form action="{{ route('sensei.schedule.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2 space-y-2">
                        <label for="title" class="text-sm font-bold text-slate-700">Judul Sesi <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" required value="{{ old('title') }}" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium"
                            placeholder="Contoh: Sesi Live JLPT N5 - Kanji Bab 1">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Course -->
                    <div class="space-y-2">
                        <label for="course_id" class="text-sm font-bold text-slate-700">Pilih Kursus <span class="text-red-500">*</span></label>
                        <select name="course_id" id="course_id" required 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium appearance-none">
                            <option value="">-- Pilih Kursus --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }} ({{ $course->level }})</option>
                            @endforeach
                        </select>
                        @error('course_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Module (Optional) -->
                    <div class="space-y-2">
                        <label for="module_id" class="text-sm font-bold text-slate-700">Pilih Modul (Opsional)</label>
                        <select name="module_id" id="module_id" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium appearance-none">
                            <option value="">-- Pilih Modul --</option>
                        </select>
                        @error('module_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Scheduled At -->
                    <div class="space-y-2">
                        <label for="scheduled_at" class="text-sm font-bold text-slate-700">Waktu Mulai <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="scheduled_at" id="scheduled_at" required value="{{ old('scheduled_at', request('date') ? request('date').'T09:00' : '') }}" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                        @error('scheduled_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Duration -->
                    <div class="space-y-2">
                        <label for="duration" class="text-sm font-bold text-slate-700">Durasi (Menit) <span class="text-red-500">*</span></label>
                        <input type="number" name="duration" id="duration" required value="{{ old('duration', 90) }}" min="15"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                        @error('duration') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Zoom Link -->
                    <div class="md:col-span-2 space-y-2">
                        <label for="zoom_link" class="text-sm font-bold text-slate-700">Link Pertemuan (Zoom/Meet)</label>
                        <input type="url" name="zoom_link" id="zoom_link" value="{{ old('zoom_link') }}" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium"
                            placeholder="https://zoom.us/j/...">
                        @error('zoom_link') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2 space-y-2">
                        <label for="description" class="text-sm font-bold text-slate-700">Deskripsi/Catatan</label>
                        <textarea name="description" id="description" rows="3" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium"
                            placeholder="Apa yang akan dipelajari di sesi ini?">{{ old('description') }}</textarea>
                        @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <button type="reset" class="px-6 py-3 border border-slate-200 text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-all">Reset</button>
                    <button type="submit" class="px-8 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 transition-all">Simpan Jadwal</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('course_id').addEventListener('change', function() {
            const courseId = this.value;
            const moduleSelect = document.getElementById('module_id');
            moduleSelect.innerHTML = '<option value="">-- Pilih Modul --</option>';
            
            if (courseId) {
                fetch(`/sensei/api/courses/${courseId}/modules`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(module => {
                            const option = document.createElement('option');
                            option.value = module.id;
                            option.textContent = module.title;
                            moduleSelect.appendChild(option);
                        });
                    });
            }
        });
    </script>
    @endpush
</x-sensei-layout>
