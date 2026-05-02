<x-sensei-layout>
    <div class="max-w-4xl mx-auto">
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Buat Quiz Baru</h2>
                <p class="text-slate-500 text-sm mt-1">Langkah pertama: Tentukan wadah (Kursus) dan detail quiz.</p>
            </div>
            <a href="{{ route('sensei.quizzes.index') }}" class="text-sm font-bold text-slate-500 hover:text-slate-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7 7-7"></path></svg>
                Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <form action="{{ route('sensei.quizzes.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2 space-y-2">
                        <label for="title" class="text-sm font-bold text-slate-700">Judul Quiz <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" required value="{{ old('title') }}" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium"
                            placeholder="Contoh: Kuis Kosakata Bab 1 (N5)">
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Wadah Selection (Course) -->
                    <div class="md:col-span-2 space-y-2">
                        <label for="course_id" class="text-sm font-bold text-slate-700">Pilih Kursus / Wadah Kuis <span class="text-red-500">*</span></label>
                        <select name="course_id" id="course_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 transition-all font-medium appearance-none">
                            <option value="">Pilih Kursus</option>
                            @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                            @endforeach
                        </select>
                        @error('course_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Type -->
                    <div class="space-y-2">
                        <label for="type" class="text-sm font-bold text-slate-700">Tipe Quiz <span class="text-red-500">*</span></label>
                        <select name="type" id="type" required 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium appearance-none">
                            <option value="daily" {{ old('type') == 'daily' ? 'selected' : '' }}>Harian</option>
                            <option value="weekly" {{ old('type') == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                            <option value="module_test" {{ old('type') == 'module_test' ? 'selected' : '' }}>Tes Modul</option>
                            <option value="mock_jlpt" {{ old('type') == 'mock_jlpt' ? 'selected' : '' }}>Mock JLPT</option>
                        </select>
                    </div>

                    <!-- Difficulty -->
                    <div class="space-y-2">
                        <label for="difficulty" class="text-sm font-bold text-slate-700">Level Kesulitan <span class="text-red-500">*</span></label>
                        <select name="difficulty" id="difficulty" required 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium appearance-none">
                            <option value="beginner" {{ old('difficulty') == 'beginner' ? 'selected' : '' }}>Beginner (N5)</option>
                            <option value="intermediate" {{ old('difficulty') == 'intermediate' ? 'selected' : '' }}>Intermediate (N4)</option>
                            <option value="advanced" {{ old('difficulty') == 'advanced' ? 'selected' : '' }}>Advanced (N3+)</option>
                        </select>
                    </div>

                    <!-- Time Limit -->
                    <div class="space-y-2">
                        <label for="time_limit" class="text-sm font-bold text-slate-700">Durasi (Menit, Kosongkan jika tidak ada limit)</label>
                        <input type="number" name="time_limit" id="time_limit" value="{{ old('time_limit') }}" min="1"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium"
                            placeholder="Contoh: 30">
                    </div>

                    <!-- Passing Score -->
                    <div class="space-y-2">
                        <label for="passing_score" class="text-sm font-bold text-slate-700">Skor Kelulusan (%) <span class="text-red-500">*</span></label>
                        <input type="number" name="passing_score" id="passing_score" required value="{{ old('passing_score', 70) }}" min="0" max="100"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium">
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2 space-y-2">
                        <label for="description" class="text-sm font-bold text-slate-700">Deskripsi/Instruksi</label>
                        <textarea name="description" id="description" rows="3" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium"
                            placeholder="Berikan instruksi singkat untuk siswa...">{{ old('description') }}</textarea>
                    </div>

                    <!-- Is Active -->
                    <div class="md:col-span-2 flex items-center gap-3 p-4 bg-slate-50 rounded-xl border border-slate-200">
                        <input type="checkbox" name="is_active" id="is_active" value="1" checked
                            class="w-5 h-5 text-red-600 rounded border-slate-300 focus:ring-red-500">
                        <label for="is_active" class="text-sm font-bold text-slate-700">Aktifkan Quiz segera setelah dibuat</label>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-100 flex justify-end gap-3">
                    <button type="submit" class="px-8 py-3 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 transition-all">
                        Lanjut: Tambah Soal
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-sensei-layout>
