@php
    $prefix = $type === 'edit' ? 'editQuestion' : 'newQuestion';
@endphp

<input type="hidden" name="question_type" x-model="questionType">

<div class="space-y-2">
    <label class="text-sm font-bold text-slate-700">Teks Pertanyaan</label>
    <textarea name="question_text" required rows="3" 
        x-model="{{ $prefix }}.question_text"
        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium"
        placeholder="Contoh: Jelaskan perbedaan antara Hiragana dan Katakana!"></textarea>
</div>

<!-- Multiple Choice Options -->
<div class="space-y-3" x-show="questionType === 'multiple_choice'">
    <label class="text-sm font-bold text-slate-700 block">Pilihan Jawaban</label>
    <div class="grid grid-cols-1 gap-3">
        @foreach(['A', 'B', 'C', 'D'] as $index => $letter)
        <div class="flex items-center gap-3">
            <span class="font-bold text-slate-400">{{ $letter }}</span>
            <input type="text" name="options[]" :required="questionType === 'multiple_choice'" 
                x-model="{{ $prefix }}.options[{{ $index }}]"
                class="flex-1 px-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500"
                placeholder="Pilihan {{ $letter }}">
            <input type="radio" name="correct_answer_radio" value="{{ $index }}" 
                :checked="{{ $prefix }}.correct_answer === {{ $prefix }}.options[{{ $index }}]"
                @change="{{ $prefix }}.correct_answer = {{ $prefix }}.options[{{ $index }}]"
                class="w-4 h-4 text-red-600 focus:ring-red-500">
        </div>
        @endforeach
    </div>
    <p class="text-[10px] text-slate-500 font-medium">* Pilih salah satu sebagai jawaban benar menggunakan tombol radio.</p>
</div>

<!-- Essay Answer Reference -->
<div class="space-y-3" x-show="questionType === 'essay'">
    <label class="text-sm font-bold text-slate-700">Referensi Jawaban (Kunci Jawaban)</label>
    <textarea name="essay_correct_answer" 
        x-model="{{ $prefix }}.correct_answer"
        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium text-sm"
        placeholder="Masukkan contoh jawaban atau poin-poin penting yang harus ada..."></textarea>
</div>

<!-- Handwriting Section -->
<div class="space-y-3" x-show="questionType === 'handwriting'">
    <label class="text-sm font-bold text-slate-700">Target Karakter / Kalimat yang Harus Ditulis</label>
    <input type="text" name="handwriting_correct_answer" 
        x-model="{{ $prefix }}.correct_answer"
        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-red-500 focus:ring-4 focus:ring-red-500/10 transition-all font-medium text-lg text-center"
        placeholder="Contoh: あいうえお atau 漢字">
</div>

<input type="hidden" name="correct_answer" x-model="{{ $prefix }}.correct_answer">

<div class="grid grid-cols-2 gap-4">
    <div class="space-y-2">
        <label class="text-sm font-bold text-slate-700">Point</label>
        <input type="number" name="points" min="1" required
            x-model="{{ $prefix }}.points"
            class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500">
    </div>
    <div class="space-y-2">
        <label class="text-sm font-bold text-slate-700">Urutan (Optional)</label>
        <input type="number" name="order" 
            x-model="{{ $prefix }}.order"
            class="w-full px-4 py-2 border border-slate-200 rounded-lg text-sm focus:ring-2 focus:ring-red-500">
    </div>
</div>

<div class="pt-4 flex justify-end gap-3">
    <button type="button" @click="{{ $type === 'edit' ? 'showEditModal = false' : 'showAddModal = false' }}" class="px-6 py-2.5 text-slate-600 font-bold rounded-xl hover:bg-slate-50 transition-all text-sm">Batal</button>
    <button type="submit" class="px-8 py-2.5 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all text-sm shadow-lg shadow-red-600/20">
        {{ $type === 'edit' ? 'Simpan Perubahan' : 'Simpan Pertanyaan' }}
    </button>
</div>
