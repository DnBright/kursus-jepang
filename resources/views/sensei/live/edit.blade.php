<x-sensei-layout>
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Edit Jadwal Live Class</h2>
                <p class="text-slate-500 text-sm mt-1">Ubah detail sesi Zoom Anda.</p>
            </div>
            <a href="{{ route('sensei.live.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <form action="{{ route('sensei.live.update', $session->id) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-sm font-bold text-slate-700">Judul Sesi <span class="text-red-500">*</span></label>
                        <input type="text" name="title" required value="{{ old('title', $session->title) }}" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2 space-y-2">
                        <label class="text-sm font-bold text-slate-700">Topik / Deskripsi</label>
                        <textarea name="description" rows="3" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">{{ $session->description }}</textarea>
                    </div>

                    <!-- Course Selection (Disabled for Edit usually) -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700">Kursus</label>
                        <input type="text" disabled value="{{ $session->course->title }}" class="w-full px-4 py-3 rounded-xl border border-slate-100 bg-slate-50 text-slate-500 font-medium cursor-not-allowed">
                    </div>

                    <!-- Scheduled At -->
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-slate-700">Waktu Mulai <span class="text-red-500">*</span></label>
                        <input type="datetime-local" name="scheduled_at" required value="{{ $session->scheduled_at->format('Y-m-d\TH:i') }}"
                            class="w-full px-4 py-3 rounded-xl border border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                    </div>

                    <!-- Zoom URL -->
                    <div class="md:col-span-2 space-y-2 border-t border-slate-100 pt-6">
                        <label class="text-sm font-bold text-slate-700">Join Link (Zoom) <span class="text-red-500">*</span></label>
                        <input type="url" name="zoom_link" required value="{{ $session->zoom_link }}"
                            class="w-full px-4 py-3 rounded-xl border border-blue-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 transition-all font-medium">
                    </div>
                </div>

                <div class="pt-8 border-t border-slate-100 flex justify-end gap-3">
                    <button type="submit" class="px-10 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 transition-all">
                        Update Jadwal
                    </button>
                </div>
            </form>
        </div>

        <!-- Danger Zone -->
        <div class="bg-red-50 rounded-2xl border border-red-100 p-8 flex items-center justify-between">
            <div>
                <h3 class="text-red-900 font-bold text-lg">Batalkan Sesi</h3>
                <p class="text-red-600/70 text-sm mt-1">Sesi akan dihapus secara permanen dari jadwal.</p>
            </div>
            <form action="{{ route('sensei.live.destroy', $session->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-white border border-red-200 text-red-600 font-bold rounded-xl hover:bg-red-600 hover:text-white transition-all text-sm shadow-sm">Hapus Sesi</button>
            </form>
        </div>
    </div>
</x-sensei-layout>
