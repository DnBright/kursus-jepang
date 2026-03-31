<x-sensei-layout>
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Ubah Jadwal</h2>
                <p class="text-slate-500 text-sm mt-1">Update detail sesi pengajaran Anda.</p>
            </div>
            <a href="{{ route('sensei.schedule.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <form action="{{ route('sensei.schedule.update', $session->id) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2 space-y-2">
                        <label for="title" class="text-sm font-bold text-slate-700">Judul Sesi <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $session->title) }}" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Status -->
                    <div class="md:col-span-2 space-y-2">
                        <label for="status" class="text-sm font-bold text-slate-700">Status Sesi <span class="text-red-500">*</span></label>
                        <select name="status" id="status" required 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium appearance-none">
                            <option value="scheduled" {{ old('status', $session->status) == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                            <option value="ongoing" {{ old('status', $session->status) == 'ongoing' ? 'selected' : '' }}>Sedang Berlangsung</option>
                            <option value="completed" {{ old('status', $session->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                            <option value="cancelled" {{ old('status', $session->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Course -->
                    <div class="space-y-2">
                        <label for="course_id" class="text-sm font-bold text-slate-700">Pilih Kursus <span class="text-red-500">*</span></label>
                        <select name="course_id" id="course_id" required 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium appearance-none">
                            <option value="">-- Pilih Kursus --</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ old('course_id', $session->course_id) == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
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
                            @foreach($modules as $module)
                                <option value="{{ $module->id }}" {{ old('module_id', $session->module_id) == $module->id ? 'selected' : '' }}>{{ $module->title }}</option>
                            @endforeach
                        </select>
                        @error('module_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Scheduled At -->
                    <div class="space-y-2">
                        <label for="scheduled_at" class="text-sm font-bold text-slate-700">Waktu Mulai <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="scheduled_at" id="scheduled_at" required value="{{ old('scheduled_at', $session->scheduled_at->format('Y-m-d\TH:i')) }}" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                        @error('scheduled_at') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Duration -->
                    <div class="space-y-2">
                        <label for="duration" class="text-sm font-bold text-slate-700">Durasi (Menit) <span class="text-red-500">*</span></label>
                        <input type="number" name="duration" id="duration" required value="{{ old('duration', $session->duration) }}" min="15"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                        @error('duration') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Zoom Link -->
                    <div class="md:col-span-2 space-y-2">
                        <label for="zoom_link" class="text-sm font-bold text-slate-700">Link Pertemuan (Zoom/Meet)</label>
                        <input type="url" name="zoom_link" id="zoom_link" value="{{ old('zoom_link', $session->zoom_link) }}" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                        @error('zoom_link') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <button type="submit" class="px-8 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 transition-all">Simpan Perubahan</button>
                </div>
            </form>
        </div>

        <!-- Danger Zone: Delete Session -->
        <div class="bg-red-50 rounded-2xl border border-red-100 p-8 flex items-center justify-between gap-6">
            <div>
                <h3 class="text-red-900 font-bold">Hapus Jadwal</h3>
                <p class="text-red-600 text-sm mt-1">Tindakan ini tidak dapat dibatalkan. Jadwal akan dihapus secara permanen dari sistem.</p>
            </div>
            <form action="{{ route('sensei.schedule.destroy', $session->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-white border border-red-200 text-red-600 font-bold rounded-xl hover:bg-red-600 hover:text-white hover:border-red-600 transition-all">Hapus Permanen</button>
            </form>
        </div>
    </div>
</x-sensei-layout>
