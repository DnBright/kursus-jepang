<x-admin-layout>
    <div class="max-w-4xl mx-auto space-y-6 pb-20">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <a href="{{ route('admin.classes.index') }}" class="inline-flex items-center text-sm font-bold text-red-600 hover:text-red-700 mb-2 group">
                    <svg class="w-4 h-4 mr-1 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    Kembali ke Manajemen Kelas
                </a>
                <h1 class="text-2xl font-bold text-slate-900">Tambah Kelas / Program Baru</h1>
                <p class="text-slate-500 text-sm mt-1">Daftarkan paket kursus atau kelas baru ke dalam sistem.</p>
            </div>
        </div>

        <form action="{{ route('admin.classes.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="p-6 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h2 class="font-bold text-slate-900">Informasi Dasar</h2>
                </div>
                
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                    <div class="space-y-2 col-span-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Judul Kelas / Program</label>
                        <input type="text" name="title" required placeholder="Contoh: Japanese Beginner Intensive" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Level Kursus</label>
                        <select name="level" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium cursor-pointer">
                            <option value="">Pilih Level</option>
                            <option value="N5">N5 (Beginner)</option>
                            <option value="N4">N4 (Elementary)</option>
                            <option value="N3">N3 (Intermediate)</option>
                            <option value="N2">N2 (Upper-Intermediate)</option>
                            <option value="N1">N1 (Advanced)</option>
                            <option value="Conversation">Conversation</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Harga (Rp)</label>
                        <input type="number" name="price" required placeholder="Contoh: 1500000" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">
                    </div>

                    <div class="space-y-2 col-span-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pilih Sensei (Instruktur)</label>
                        <select name="instructor_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium cursor-pointer">
                            <option value="">Pilih Sensei</option>
                            @foreach($instructors as $instructor)
                                <option value="{{ $instructor->id }}">{{ $instructor->name }} ({{ $instructor->specialization }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="space-y-2 col-span-2">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Deskripsi Singkat</label>
                        <textarea name="description" rows="4" placeholder="Jelaskan secara singkat mengenai kelas ini..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium"></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden text-left">
                <div class="p-6 border-b border-slate-100 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-red-50 text-red-600 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h2 class="font-bold text-slate-900">Media & Pengaturan</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div class="space-y-2">
                         <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Thumbnail URL (Placeholder)</label>
                         <input type="text" name="thumbnail" placeholder="https://example.com/image.jpg" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all font-medium">
                         <p class="text-[10px] text-slate-400">Untuk sementara masukkan URL gambar. Fitur upload file akan menyusul.</p>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('admin.classes.index') }}" class="px-6 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">
                    Batal
                </a>
                <button type="submit" class="px-8 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all text-sm shadow-lg shadow-red-200">
                    Simpan Kelas Baru
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
