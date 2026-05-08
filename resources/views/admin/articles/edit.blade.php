<x-admin-layout>
    <div class="max-w-4xl mx-auto space-y-6 pb-20 text-left">
        <!-- Header -->
        <div>
            <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center text-sm font-bold text-red-600 hover:text-red-700 mb-2 group">
                <svg class="w-4 h-4 mr-1 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Kembali ke Manajemen Artikel
            </a>
            <h1 class="text-2xl font-bold text-slate-900">Edit Artikel</h1>
            <p class="text-slate-500 text-sm mt-1">Perbarui konten artikel Anda.</p>
        </div>

        <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <h2 class="font-bold text-slate-900">Detail Konten</h2>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Judul Artikel</label>
                        <input type="text" name="title" required value="{{ old('title', $article->title) }}" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Ringkasan (Excerpt)</label>
                        <textarea name="excerpt" rows="3" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">{{ old('excerpt', $article->excerpt) }}</textarea>
                        @error('excerpt') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Gambar Utama</label>
                        @if($article->image)
                        <div class="mb-3">
                            <img src="{{ Storage::url($article->image) }}" alt="" class="w-32 h-32 rounded-xl object-cover border border-slate-200">
                            <p class="text-[10px] text-slate-400 mt-1">Gambar saat ini</p>
                        </div>
                        @endif
                        <input type="file" name="image" class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">
                        <p class="text-slate-400 text-[10px]">Biarkan kosong jika tidak ingin mengubah gambar. Format: JPG, PNG, GIF. Maks: 2MB.</p>
                        @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Isi Artikel</label>
                        <textarea name="content" required rows="15" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">{{ old('content', $article->content) }}</textarea>
                        @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex items-center gap-2 bg-slate-50 p-4 rounded-xl border border-slate-200">
                        <input type="checkbox" name="is_published" value="1" {{ old('is_published', $article->is_published) ? 'checked' : '' }} class="w-4 h-4 text-red-600 focus:ring-red-500 border-slate-300 rounded cursor-pointer">
                        <label class="text-sm font-bold text-slate-700 cursor-pointer">Publikasikan artikel ini sekarang</label>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('admin.articles.index') }}" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                    Batal
                </a>
                <button type="submit" class="px-8 py-2.5 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-all text-sm shadow-lg shadow-blue-200">
                    Perbarui Artikel
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
