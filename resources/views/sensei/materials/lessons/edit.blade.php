<x-sensei-layout>
    <div class="max-w-4xl mx-auto" x-data="{ type: '{{ $lesson->type }}' }">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Edit Materi</h2>
                <p class="text-slate-500 text-sm mt-1">Perbarui konten pembelajaran Anda.</p>
            </div>
            <a href="{{ route('sensei.materials.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <form action="{{ route('sensei.materials.lessons.update', $lesson->id) }}" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2 space-y-2">
                        <label for="title" class="text-sm font-bold text-slate-700">Judul Materi <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $lesson->title) }}" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                    </div>

                    <!-- Module Selection -->
                    <div class="space-y-2">
                        <label for="module_id" class="text-sm font-bold text-slate-700">Pilih Modul <span class="text-red-500">*</span></label>
                        <select name="module_id" id="module_id" required 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium appearance-none">
                            @foreach($modules as $module)
                            <option value="{{ $module->id }}" {{ $lesson->module_id == $module->id ? 'selected' : '' }}>{{ $module->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Material Type -->
                    <div class="space-y-2">
                        <label for="type" class="text-sm font-bold text-slate-700">Tipe Materi <span class="text-red-500">*</span></label>
                        <select name="type" id="type" required x-model="type"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium appearance-none">
                            <option value="video" {{ $lesson->type == 'video' ? 'selected' : '' }}>Video (URL YouTube/Vimeo)</option>
                            <option value="pdf" {{ $lesson->type == 'pdf' ? 'selected' : '' }}>Dokumen PDF</option>
                            <option value="text" {{ $lesson->type == 'text' ? 'selected' : '' }}>Artikel / Teks</option>
                        </select>
                    </div>

                    <!-- Dynamic Content: Video -->
                    <div class="md:col-span-2 space-y-2" x-show="type === 'video'">
                        <label for="content_video" class="text-sm font-bold text-slate-700">Link Video URL <span class="text-red-500">*</span></label>
                        <input type="url" name="content_video" id="content_video" value="{{ $lesson->type == 'video' ? $lesson->content : '' }}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                    </div>

                    <!-- Dynamic Content: PDF -->
                    <div class="md:col-span-2 space-y-2" x-show="type === 'pdf'">
                        <label for="content_pdf" class="text-sm font-bold text-slate-700">Upload File PDF (Biarkan kosong jika tidak ingin mengubah)</label>
                        <div class="flex items-center gap-4">
                             <input type="file" name="content_pdf" id="content_pdf" accept=".pdf"
                                class="flex-1 px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium text-sm">
                             @if($lesson->type == 'pdf' && $lesson->content)
                                <a href="{{ Storage::url($lesson->content) }}" target="_blank" class="text-red-600 font-bold text-xs hover:underline">Lihat PDF Skr</a>
                             @endif
                        </div>
                    </div>

                    <!-- Dynamic Content: Text -->
                    <div class="md:col-span-2 space-y-2" x-show="type === 'text'">
                        <label for="content_text" class="text-sm font-bold text-slate-700">Isi Artikel / Pelajaran <span class="text-red-500">*</span></label>
                        <textarea name="content_text" id="content_text" rows="10" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">{{ $lesson->type == 'text' ? $lesson->content : '' }}</textarea>
                    </div>

                    <!-- Duration & Settings -->
                    <div class="space-y-2">
                        <label for="duration" class="text-sm font-bold text-slate-700">Estimasi Durasi (Menit)</label>
                        <input type="number" name="duration" id="duration" value="{{ $lesson->duration }}" min="1"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                    </div>

                    <div class="flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-100 self-end">
                        <input type="checkbox" name="is_free" id="is_free" value="1" {{ $lesson->is_free ? 'checked' : '' }}
                            class="w-5 h-5 text-red-600 rounded border-slate-300 focus:ring-red-500">
                        <label for="is_free" class="text-sm font-bold text-slate-700">Materi Gratis (Pratinjau)</label>
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-100 flex justify-end gap-3">
                    <button type="submit" class="px-10 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-sensei-layout>
