<x-admin-layout>
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.roadmap.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-slate-100 text-slate-400 hover:text-red-600 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <div>
                <h2 class="text-2xl lg:text-3xl font-black text-slate-900">Roadmap: {{ $course->title }}</h2>
                <p class="text-slate-500">Atur urutan belajar dengan sangat mudah.</p>
            </div>
        </div>
        
        <button @click="$dispatch('open-add-modal')" class="px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all shadow-lg shadow-red-600/20 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
            <span>Tambah Kotak</span>
        </button>
    </div>

    <!-- Error/Success Messages -->
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-green-700 rounded-xl border border-green-200 font-bold">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 font-bold">
            Terdapat kesalahan pada input Anda.
        </div>
    @endif

    <!-- Roadmap Canvas -->
    <div class="bg-slate-50 rounded-3xl border-2 border-dashed border-slate-200 p-4 lg:p-8 min-h-[400px]">
        <div id="roadmap-sortable" class="max-w-4xl mx-auto space-y-4">
            @forelse($roadmapSteps as $step)
                @php
                    $icon = 'M13 10V3L4 14h7v7l9-11h-7z'; // default module
                    $color = 'bg-slate-100 text-slate-600';
                    if($step->content_type == 'quiz') {
                        $icon = 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4';
                        $color = 'bg-orange-100 text-orange-600';
                    } elseif($step->content_type == 'lesson') {
                        $icon = 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253';
                        $color = 'bg-blue-100 text-blue-600';
                    } elseif($step->content_type == 'live_session') {
                        $icon = 'M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z';
                        $color = 'bg-green-100 text-green-600';
                    }

                    // Prepare edit data
                    $editData = [
                        'id' => $step->id,
                        'title' => $step->title,
                        'block_type' => $step->content_type === 'lesson' ? 'materi' : ($step->content_type === 'live_session' ? 'zoom' : 'quiz'),
                    ];
                    if ($step->content) {
                        if ($step->content_type == 'quiz') {
                            $editData['quiz_type'] = $step->content->question_type;
                            // $editData['url'] = route('admin.quizzes.questions', $step->content->id); // Note: Admin doesn't have quiz question management yet
                        } elseif ($step->content_type == 'lesson') {
                            $editData['materi_type'] = $step->content->type;
                            $editData['video_link'] = $step->content->type === 'video' ? $step->content->content : '';
                        } elseif ($step->content_type == 'live_session') {
                            $editData['zoom_date'] = $step->content->scheduled_at ? $step->content->scheduled_at->format('Y-m-d') : '';
                            $editData['zoom_time'] = $step->content->scheduled_at ? $step->content->scheduled_at->format('H:i') : '';
                            $editData['zoom_link'] = $step->content->zoom_link;
                        }
                    }
                @endphp
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 flex items-center justify-between group cursor-move roadmap-item transition-all hover:shadow-md hover:border-slate-300" data-id="{{ $step->id }}">
                    <div class="flex items-center gap-4 lg:gap-6 w-full" @click="$dispatch('open-edit-modal', {{ json_encode($editData) }})">
                        <div class="flex items-center gap-3">
                            <div class="text-slate-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 8h16M4 16h16"></path></svg>
                            </div>
                            <div class="w-12 h-12 rounded-xl {{ $color }} flex items-center justify-center font-black text-xl border border-white/20 step-number shadow-inner">
                                {{ $step->order }}
                            </div>
                        </div>
                        <div class="flex-1 cursor-pointer">
                            <div class="flex items-center gap-3 mb-1">
                                <div class="p-1.5 rounded-lg {{ $color }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path></svg>
                                </div>
                                <h4 class="text-lg lg:text-xl font-bold text-slate-800">{{ $step->title ?: 'Tanpa Judul' }}</h4>
                            </div>
                            <p class="text-sm text-slate-500 font-medium">Klik untuk mengubah pengaturan kotak ini.</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-2 items-center pl-4 border-l border-slate-100">
                        <!-- Admin currently does not manage quiz questions directly here -->
                        <form action="{{ route('admin.roadmap.destroy', $step->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kotak ini secara permanen?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-3 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-colors" title="Hapus Kotak">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-32">
                    <div class="w-24 h-24 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm border border-slate-100 text-slate-300">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800 mb-2">Roadmap Masih Kosong</h3>
                    <p class="text-slate-500 text-lg mb-8">Mulai bangun alur belajar Anda dengan menekan tombol di bawah.</p>
                    <button @click="$dispatch('open-add-modal')" class="px-8 py-4 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all shadow-lg shadow-red-600/20 text-lg">
                        Tambah Kotak Pertama
                    </button>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Alpine Modal Logic -->
    <div x-data="roadmapForm()" 
         @open-add-modal.window="openAddModal()"
         @open-edit-modal.window="openEditModal($event.detail)"
         class="relative z-50" 
         aria-labelledby="modal-title" 
         role="dialog" 
         aria-modal="true" 
         x-show="isOpen" 
         x-cloak>
        
        <div x-show="isOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm transition-opacity"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div x-show="isOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     @click.away="isOpen = false"
                     class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-xl">
                    
                    <form :action="formAction" method="POST" enctype="multipart/form-data" class="flex flex-col h-full max-h-[90vh]">
                        @csrf
                        <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">
                        <input type="hidden" name="order" value="{{ ($roadmapSteps->max('order') ?? 0) + 1 }}">

                        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100 flex items-center justify-between shrink-0">
                            <h3 class="text-xl font-black text-slate-800" id="modal-title" x-text="isEdit ? 'Ubah Pengaturan Kotak' : 'Tambah Kotak Baru'"></h3>
                            <button type="button" @click="isOpen = false" class="text-slate-400 hover:text-red-500 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>

                        <div class="px-6 py-6 overflow-y-auto flex-1 space-y-6">
                            <!-- Judul -->
                            <div>
                                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Kotak (Judul)</label>
                                <input type="text" name="title" x-model="formData.title" class="w-full bg-white border-2 border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:ring-red-500 focus:border-red-500" placeholder="Misal: Modul 1 - Hiragana" required>
                            </div>

                            <!-- Pilihan Utama -->
                            <div x-show="!isEdit">
                                <label class="block text-sm font-bold text-slate-700 mb-3">Tipe Konten</label>
                                <div class="grid grid-cols-3 gap-3">
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="block_type" value="quiz" x-model="formData.block_type" class="peer sr-only">
                                        <div class="p-4 rounded-xl border-2 border-slate-200 peer-checked:border-orange-500 peer-checked:bg-orange-50 text-center transition-all hover:bg-slate-50">
                                            <svg class="w-8 h-8 mx-auto mb-2 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                            <span class="font-bold text-slate-700 block text-sm">Ujian / Quiz</span>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="block_type" value="materi" x-model="formData.block_type" class="peer sr-only">
                                        <div class="p-4 rounded-xl border-2 border-slate-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 text-center transition-all hover:bg-slate-50">
                                            <svg class="w-8 h-8 mx-auto mb-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                            <span class="font-bold text-slate-700 block text-sm">Materi Teks/Video</span>
                                        </div>
                                    </label>
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="block_type" value="zoom" x-model="formData.block_type" class="peer sr-only">
                                        <div class="p-4 rounded-xl border-2 border-slate-200 peer-checked:border-green-500 peer-checked:bg-green-50 text-center transition-all hover:bg-slate-50">
                                            <svg class="w-8 h-8 mx-auto mb-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            <span class="font-bold text-slate-700 block text-sm">Zoom Live</span>
                                        </div>
                                    </label>
                                </div>
                            </div>
                            
                            <div x-show="isEdit" class="bg-slate-100 p-4 rounded-xl flex items-center gap-3">
                                <span class="font-bold text-slate-600">Tipe Konten Saat Ini:</span>
                                <span class="px-3 py-1 bg-white rounded-lg font-black uppercase text-sm text-slate-800" x-text="formData.block_type"></span>
                            </div>

                            <!-- Opsi Sub untuk Quiz -->
                            <div x-show="formData.block_type === 'quiz'" x-collapse>
                                <div class="p-6 bg-orange-50 rounded-2xl border-2 border-orange-100 space-y-4">
                                    <label class="block text-sm font-bold text-orange-900">Jenis Quiz/Ujian</label>
                                    <select name="quiz_type" x-model="formData.quiz_type" class="w-full bg-white border-2 border-orange-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:ring-orange-500 focus:border-orange-500">
                                        <option value="multiple_choice">Pilihan Ganda</option>
                                        <option value="essay">Essay / Uraian</option>
                                        <option value="handwriting">Tulis Tangan (Upload Foto)</option>
                                    </select>
                                    <p class="text-xs text-orange-700 font-medium">*Setelah kotak ini disimpan, Anda dapat membuat butir-butir soalnya melalui tombol "Atur Soal" di luar.</p>
                                    
                                    <div x-show="isEdit && formData.url" class="mt-4 pt-4 border-t border-orange-200">
                                        <a :href="formData.url" class="block w-full text-center px-4 py-3 bg-orange-500 text-white font-bold rounded-xl hover:bg-orange-600 transition-colors">
                                            Pergi ke Halaman Atur Soal
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Opsi Sub untuk Materi -->
                            <div x-show="formData.block_type === 'materi'" x-collapse>
                                <div class="p-6 bg-blue-50 rounded-2xl border-2 border-blue-100 space-y-4">
                                    <label class="block text-sm font-bold text-blue-900">Format Materi</label>
                                    <select name="materi_type" x-model="formData.materi_type" class="w-full bg-white border-2 border-blue-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="pdf">File PDF / Dokumen</option>
                                        <option value="video">Link YouTube</option>
                                    </select>

                                    <div x-show="formData.materi_type === 'pdf'" class="pt-4 border-t border-blue-200">
                                        <label class="block text-sm font-bold text-blue-900 mb-2">Unggah File PDF</label>
                                        <input type="file" name="materi_file" accept=".pdf" class="w-full text-sm text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-blue-600 file:text-white hover:file:bg-blue-700 transition-all bg-white border-2 border-blue-200 rounded-xl">
                                    </div>

                                    <div x-show="formData.materi_type === 'video'" class="pt-4 border-t border-blue-200">
                                        <label class="block text-sm font-bold text-blue-900 mb-2">Tempel Link YouTube</label>
                                        <input type="url" name="video_link" x-model="formData.video_link" placeholder="Contoh: https://youtube.com/watch?v=..." class="w-full bg-white border-2 border-blue-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>

                            <!-- Opsi Sub untuk Zoom -->
                            <div x-show="formData.block_type === 'zoom'" x-collapse>
                                <div class="p-6 bg-green-50 rounded-2xl border-2 border-green-100 space-y-4">
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-bold text-green-900 mb-2">Tanggal</label>
                                            <input type="date" name="zoom_date" x-model="formData.zoom_date" class="w-full bg-white border-2 border-green-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:ring-green-500 focus:border-green-500">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-green-900 mb-2">Jam</label>
                                            <input type="time" name="zoom_time" x-model="formData.zoom_time" class="w-full bg-white border-2 border-green-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:ring-green-500 focus:border-green-500">
                                        </div>
                                    </div>
                                    <div class="pt-2 border-t border-green-200">
                                        <label class="block text-sm font-bold text-green-900 mb-2">Link Zoom Meeting</label>
                                        <input type="url" name="zoom_link" x-model="formData.zoom_link" placeholder="Contoh: https://zoom.us/j/..." class="w-full bg-white border-2 border-green-200 rounded-xl px-4 py-3 font-bold text-slate-800 focus:ring-green-500 focus:border-green-500">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50 px-6 py-5 border-t border-slate-100 shrink-0">
                            <button type="submit" class="w-full py-4 bg-red-600 text-white font-black text-lg uppercase tracking-widest rounded-xl shadow-lg shadow-red-600/30 hover:bg-red-700 hover:-translate-y-1 transition-all">
                                Simpan Kotak Ini
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('roadmapForm', () => ({
                isOpen: false,
                isEdit: false,
                formAction: '{{ route('admin.roadmap.store', $course->id) }}',
                formData: {
                    title: '',
                    block_type: 'materi',
                    quiz_type: 'multiple_choice',
                    materi_type: 'pdf',
                    video_link: '',
                    zoom_date: '',
                    zoom_time: '',
                    zoom_link: '',
                    url: ''
                },
                openAddModal() {
                    this.isEdit = false;
                    this.formAction = '{{ route('admin.roadmap.store', $course->id) }}';
                    this.formData = {
                        title: '',
                        block_type: 'materi',
                        quiz_type: 'multiple_choice',
                        materi_type: 'pdf',
                        video_link: '',
                        zoom_date: '',
                        zoom_time: '',
                        zoom_link: '',
                        url: ''
                    };
                    this.isOpen = true;
                },
                openEditModal(data) {
                    this.isEdit = true;
                    this.formAction = '/admin/roadmap/steps/' + data.id;
                    this.formData = { ...this.formData, ...data };
                    // Set default empty strings if undefined
                    if(!this.formData.quiz_type) this.formData.quiz_type = 'multiple_choice';
                    if(!this.formData.materi_type) this.formData.materi_type = 'pdf';
                    this.isOpen = true;
                }
            }));
        });

        // Drag & Drop Sorting Logic
        const el = document.getElementById('roadmap-sortable');
        if (el) {
            Sortable.create(el, {
                animation: 200,
                ghostClass: 'opacity-50',
                dragClass: 'shadow-2xl',
                handle: '.cursor-move',
                onEnd: function() {
                    const steps = [];
                    const items = el.querySelectorAll('.roadmap-item');
                    
                    items.forEach((item, index) => {
                        const newOrder = index + 1;
                        steps.push({
                            id: item.getAttribute('data-id'),
                            order: newOrder
                        });
                        item.querySelector('.step-number').innerText = newOrder;
                    });

                    fetch('{{ route("admin.roadmap.reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ steps: steps })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) alert('Gagal menyimpan urutan baru.');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            });
        }
    </script>
</x-admin-layout>
