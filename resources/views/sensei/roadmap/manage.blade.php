<x-sensei-layout>
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('sensei.roadmap.index') }}" class="p-2 bg-white rounded-xl shadow-sm border border-slate-100 text-slate-400 hover:text-red-600 transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <div>
            <h2 class="text-3xl font-black text-slate-900">Kelola Roadmap: {{ $course->title }}</h2>
            <p class="text-slate-500">Susun langkah-langkah pembelajaran secara berurutan.</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-8">
        <!-- Sidebar: Add Step -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-24">
                <h3 class="text-lg font-bold text-slate-900 mb-6">Tambah Langkah Baru</h3>
                
                <form action="{{ route('sensei.roadmap.store', $course->id) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Jenis Konten</label>
                            <select name="content_type" id="content_type" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-red-500 focus:border-red-500" required>
                                <option value="module">Modul Utama</option>
                                <option value="quiz">Quiz / Ujian</option>
                            </select>
                        </div>

                        <div id="content_selector_container">
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Pilih Konten</label>
                            <select name="content_id" id="content_id" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-red-500 focus:border-red-500" required>
                                @foreach($modules as $module)
                                    <option value="{{ $module->id }}" data-type="module">{{ $module->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Judul Tampilan (Opsional)</label>
                            <input type="text" name="title" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-red-500 focus:border-red-500" placeholder="Contoh: Pengenalan Hiragana">
                        </div>

                        <input type="hidden" name="order" value="{{ ($roadmapSteps->max('order') ?? 0) + 1 }}">

                        <button type="submit" class="w-full py-4 bg-red-600 text-white font-black uppercase tracking-widest rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 transition-all">
                            Simpan Langkah
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Main: Roadmap List -->
        <div class="lg:col-span-2">
            <div id="roadmap-sortable" class="space-y-4">
                @forelse($roadmapSteps as $step)
                    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center justify-between group cursor-move roadmap-item" data-id="{{ $step->id }}">
                        <div class="flex items-center gap-6">
                            <div class="flex items-center gap-4">
                                <div class="text-slate-300 group-hover:text-red-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 8h16M4 16h16"></path></svg>
                                </div>
                                <div class="w-10 h-10 rounded-xl bg-slate-50 flex items-center justify-center font-black text-slate-400 text-lg border border-slate-100 step-number">
                                    {{ $step->order }}
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center gap-3 mb-1">
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[8px] font-black uppercase tracking-wider rounded">{{ $step->content_type }}</span>
                                    <h4 class="text-lg font-bold text-slate-900">{{ $step->title ?: ($step->content->title ?? 'Untitled Content') }}</h4>
                                </div>
                                <p class="text-xs text-slate-400">ID Konten: {{ $step->content_id }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity" x-data="{ openEdit: false }">
                            <button @click="openEdit = true" class="p-2 text-slate-300 hover:text-blue-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>

                            <!-- Edit Modal -->
                            <div x-show="openEdit" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-sm" x-cloak>
                                <div @click.away="openEdit = false" class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden">
                                    <div class="p-6 border-b border-slate-100">
                                        <h3 class="text-xl font-bold text-slate-900">Edit Langkah</h3>
                                    </div>
                                    <form action="{{ route('sensei.roadmap.update', $step->id) }}" method="POST" class="p-6 space-y-4" x-data="{ type: '{{ $step->content_type }}' }">
                                        @csrf
                                        @method('PATCH')
                                        
                                        <div>
                                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Jenis Konten</label>
                                            <select name="content_type" x-model="type" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-red-500 focus:border-red-500" required>
                                                <option value="module">Modul Utama</option>
                                                <option value="quiz">Quiz / Ujian</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Pilih Konten</label>
                                            <select name="content_id" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-red-500 focus:border-red-500" required>
                                                <template x-if="type === 'module'">
                                                    @foreach($modules as $module)
                                                        <option value="{{ $module->id }}" {{ $step->content_id == $module->id ? 'selected' : '' }}>{{ $module->title }}</option>
                                                    @endforeach
                                                </template>
                                                <template x-if="type === 'quiz'">
                                                    @foreach($quizzes as $quiz)
                                                        <option value="{{ $quiz->id }}" {{ $step->content_id == $quiz->id ? 'selected' : '' }}>{{ $quiz->title }}</option>
                                                    @endforeach
                                                </template>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-black text-slate-500 uppercase tracking-widest mb-2">Judul Tampilan</label>
                                            <input type="text" name="title" value="{{ $step->title }}" class="w-full bg-slate-50 border-slate-200 rounded-xl text-sm focus:ring-red-500 focus:border-red-500">
                                        </div>
                                        <div class="flex gap-3 pt-4">
                                            <button type="button" @click="openEdit = false" class="flex-1 py-3 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all text-sm">Batal</button>
                                            <button type="submit" class="flex-1 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-all text-sm shadow-lg shadow-red-600/20">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <form action="{{ route('sensei.roadmap.destroy', $step->id) }}" method="POST" onsubmit="return confirm('Hapus langkah ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-300 hover:text-red-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20 bg-white rounded-2xl border-2 border-dashed border-slate-100">
                        <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">Belum ada langkah roadmap.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Content Type Selector Logic
    document.getElementById('content_type').addEventListener('change', function() {
        const type = this.value;
        const selector = document.getElementById('content_id');
        selector.innerHTML = ''; // Clear options

        if (type === 'module') {
            @foreach($modules as $module)
                selector.add(new Option('{{ $module->title }}', '{{ $module->id }}'));
            @endforeach
        } else if (type === 'quiz') {
            @foreach($quizzes as $quiz)
                selector.add(new Option('{{ $quiz->title }}', '{{ $quiz->id }}'));
            @endforeach
        }
    });

    // Drag & Drop Sorting Logic
    const el = document.getElementById('roadmap-sortable');
    if (el) {
        Sortable.create(el, {
            animation: 150,
            ghostClass: 'bg-red-50',
            onEnd: function() {
                const steps = [];
                const items = el.querySelectorAll('.roadmap-item');
                
                items.forEach((item, index) => {
                    const newOrder = index + 1;
                    steps.push({
                        id: item.getAttribute('data-id'),
                        order: newOrder
                    });
                    // Update visible order number
                    item.querySelector('.step-number').innerText = newOrder;
                });

                // Send to server
                fetch('{{ route("sensei.roadmap.reorder") }}', {
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
                    alert('Terjadi kesalahan saat menyimpan urutan.');
                });
            }
        });
    }
</script>
</x-sensei-layout>
