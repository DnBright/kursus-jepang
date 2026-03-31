<x-sensei-layout>
    <div class="max-w-4xl mx-auto" x-data="{ courseId: '' }">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Jadwalkan Live Class</h2>
                <p class="text-slate-500 text-sm mt-1">Buat sesi Zoom interaktif untuk kursus Anda.</p>
            </div>
            <a href="{{ route('sensei.live.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <form action="{{ route('sensei.live.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-sm font-bold text-slate-700">Judul Sesi <span class="text-red-500">*</span></label>
                        <input type="text" name="title" required value="{{ old('title') }}" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium"
                            placeholder="Contoh: Bunpou Practice: Conditional Forms">
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-sm font-bold text-slate-700">Topik / Deskripsi</label>
                        <textarea name="description" rows="3" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium"
                            placeholder="Detail apa yang akan dipelajari dalam sesi ini..."></textarea>
                    </div>

                    <!-- Course Selection -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700">Pilih Kursus <span class="text-red-500">*</span></label>
                        <select name="course_id" required x-model="courseId" @change="fetchModules()"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium appearance-none">
                            <option value="">Pilih Kursus</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->title }} ({{ $course->level }})</option>
                            @endforeach
                        </select>
                    </div>

                     <!-- Module Selection (Optional) -->
                    <div class="space-y-2 shadow-sm rounded-xl">
                        <label class="text-sm font-bold text-slate-700">Pilih Modul (Opsional)</label>
                        <select name="module_id" id="module_id"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium appearance-none">
                            <option value="">Pilih Modul Terlebih Dahulu</option>
                        </select>
                    </div>

                    <!-- Scheduled At -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700">Waktu Mulai <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="scheduled_at" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                    </div>

                    <!-- Duration -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700">Durasi (Menit) <span class="text-red-500">*</span></label>
                        <input type="number" name="duration" value="90" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                    </div>

                    <!-- Zoom URL -->
                    <div class="md:col-span-2 space-y-2 border-t border-slate-100 pt-6">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg></span>
                            <h4 class="font-bold text-slate-900">Zoom Integration</h4>
                        </div>
                        <label class="text-sm font-bold text-slate-700">Join Link (Zoom) <span class="text-red-500">*</span></label>
                        <input type="url" name="zoom_link" required 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium"
                            placeholder="https://zoom.us/j/...">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700">Meeting ID (Opsional)</label>
                        <input type="text" name="meeting_id"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-slate-500 transition-all font-medium">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700">Passcode (Opsional)</label>
                        <input type="text" name="meeting_password"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-slate-500 transition-all font-medium">
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-100 flex justify-end gap-3">
                    <button type="submit" class="px-10 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 transition-all">
                        Simpan Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function fetchModules() {
            const courseId = document.getElementById('course_id').value;
            const moduleSelect = document.getElementById('module_id');
            if (!courseId) return;
            fetch(`/sensei/api/courses/${courseId}/modules`)
                .then(r => r.json())
                .then(data => {
                    moduleSelect.innerHTML = '<option value="">Pilih Modul</option>';
                    data.forEach(m => {
                        moduleSelect.innerHTML += `<option value="${m.id}">${m.title}</option>`;
                    });
                });
        }
    </script>
</x-sensei-layout>
