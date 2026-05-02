<x-admin-layout>
    <div class="max-w-4xl mx-auto space-y-6 pb-20">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.materials.index') }}" class="inline-flex items-center text-sm font-bold text-red-600 hover:text-red-700 mb-2 group">
                    <svg class="w-4 h-4 mr-1 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali ke Materi
                </a>
                <h1 class="text-2xl font-bold text-slate-900">Edit Materi</h1>
                <p class="text-slate-500 text-sm mt-1">Perbarui informasi materi pembelajaran.</p>
            </div>
        </div>

        <form action="{{ route('admin.materials.update', $material->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h2 class="font-bold text-slate-900">Informasi Materi</h2>
                </div>
                
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                    <div class="space-y-2 col-span-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Judul Materi</label>
                        <input type="text" name="title" required value="{{ old('title', $material->title) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tipe Materi</label>
                        <select name="type" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium cursor-pointer">
                            <option value="video" {{ $material->type == 'video' ? 'selected' : '' }}>Video</option>
                            <option value="text" {{ $material->type == 'text' ? 'selected' : '' }}>Teks</option>
                            <option value="audio" {{ $material->type == 'audio' ? 'selected' : '' }}>Audio</option>
                            <option value="pdf" {{ $material->type == 'pdf' ? 'selected' : '' }}>PDF</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Kelas / Program</label>
                        <select name="module_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium cursor-pointer">
                            <option value="">Pilih Kelas</option>
                            @foreach($courses as $course)
                                <optgroup label="{{ $course->title }}">
                                    @foreach($course->modules as $module)
                                        <option value="{{ $module->id }}" {{ $material->module_id == $module->id ? 'selected' : '' }}>
                                            {{ $module->title }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2 col-span-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pilih Sensei (Instruktur)</label>
                        <select name="instructor_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium cursor-pointer">
                            <option value="">Pilih Sensei</option>
                            @foreach($instructors as $instructor)
                                <option value="{{ $instructor->id }}" {{ $material->instructor_id == $instructor->id ? 'selected' : '' }}>
                                    {{ $instructor->name }} ({{ $instructor->specialization }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Urutan</label>
                        <input type="number" name="order" required value="{{ old('order', $material->order) }}" min="1" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Durasi (Opsional)</label>
                        <input type="text" name="duration" value="{{ old('duration', $material->duration) }}" placeholder="Contoh: 15 menit" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">
                    </div>

                    <div class="space-y-2 col-span-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Konten Materi</label>
                        <textarea name="content" rows="6" required placeholder="Masukkan konten materi..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">{{ old('content', $material->content) }}</textarea>
                    </div>

                    <div class="space-y-2 col-span-2">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_free" value="1" {{ $material->is_free ? 'checked' : '' }} class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded">
                            <span class="text-sm font-medium text-slate-700">Gratis (Bisa diakses tanpa login)</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('admin.materials.index') }}" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                    Batal
                </a>
                <button type="submit" class="px-8 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all text-sm shadow-lg shadow-red-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
