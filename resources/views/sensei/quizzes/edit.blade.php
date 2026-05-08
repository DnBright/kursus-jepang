<x-sensei-layout>
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Edit Quiz</h2>
                <p class="text-slate-500 text-sm mt-1">Ubah detail dan peraturan kuis.</p>
            </div>
            <a href="{{ route('sensei.quizzes.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mb-8">
            <form action="{{ route('sensei.quizzes.update', $quiz->id) }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2 space-y-2">
                        <label for="title" class="text-sm font-bold text-slate-700">Judul Quiz <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $quiz->title) }}" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <input type="hidden" name="type" value="{{ $quiz->type }}">
                    <input type="hidden" name="difficulty" value="{{ $quiz->difficulty }}">

                    <!-- Time Limit -->
                    <div class="space-y-2">
                        <label for="time_limit" class="text-sm font-bold text-slate-700">Durasi (Menit)</label>
                        <input type="number" name="time_limit" id="time_limit" value="{{ old('time_limit', $quiz->time_limit) }}" min="1"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                    </div>

                    <!-- Passing Score -->
                    <div class="space-y-2">
                        <label for="passing_score" class="text-sm font-bold text-slate-700">Skor Kelulusan (%) <span class="text-red-500">*</span></label>
                        <input type="number" name="passing_score" id="passing_score" required value="{{ old('passing_score', $quiz->passing_score) }}" min="0" max="100"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2 space-y-2">
                        <label for="description" class="text-sm font-bold text-slate-700">Deskripsi/Instruksi</label>
                        <textarea name="description" id="description" rows="3" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">{{ old('description', $quiz->description) }}</textarea>
                    </div>

                    <!-- Is Active -->
                    <div class="md:col-span-2 flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ $quiz->is_active ? 'checked' : '' }}
                            class="w-5 h-5 text-red-600 rounded border-slate-300 focus:ring-red-500">
                        <label for="is_active" class="text-sm font-bold text-slate-700">Quiz Aktif (Terlihat oleh siswa)</label>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex items-center justify-between">
                    <a href="{{ route('sensei.quizzes.questions', $quiz->id) }}" class="flex items-center gap-2 text-red-600 font-bold hover:underline">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Kelola Butir Soal ({{ $quiz->questions->count() }})
                    </a>
                    <div class="flex gap-3">
                        <button type="submit" class="px-8 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 transition-all">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>

         <!-- Danger Zone -->
         <div class="bg-red-50 rounded-2xl border border-red-100 p-8 flex items-center justify-between gap-6">
            <div>
                <h3 class="text-red-900 font-bold">Hapus Quiz</h3>
                <p class="text-red-600 text-sm mt-1">Seluruh data kuis, pertanyaan, dan hasil siswa akan dihapus secara permanen.</p>
            </div>
            <form action="{{ route('sensei.quizzes.destroy', $quiz->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kuis ini secara permanen?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-3 bg-white border border-red-200 text-red-600 font-bold rounded-xl hover:bg-red-600 hover:text-white hover:border-red-600 transition-all text-sm">Hapus Permanen</button>
            </form>
        </div>
    </div>
</x-sensei-layout>
