<x-sensei-layout>
    <div class="max-w-5xl mx-auto space-y-8" x-data="{ 
        showAddModal: false, 
        showEditModal: false,
        editingStep: { id: '', type: 'module', content_id: '', title: '', order: 0 },
        openEditModal(step) {
            this.editingStep = {
                id: step.id,
                type: step.content_type,
                content_id: step.content_id,
                title: step.title || '',
                order: step.order
            };
            this.showEditModal = true;
        }
    }">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <nav class="flex mb-2" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3 text-xs font-bold uppercase tracking-widest">
                        <li class="inline-flex items-center">
                            <a href="{{ route('sensei.quizzes.index') }}" class="text-slate-400 hover:text-red-600 transition-colors">Program</a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-3 h-3 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="text-slate-600">Kelola Roadmap</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Roadmap <span class="text-red-600">{{ $course->title }}</span></h2>
                <p class="text-slate-500 font-bold mt-1 uppercase text-[10px] tracking-[0.2em]">{{ $course->level }} • {{ $course->roadmapSteps->count() }} Langkah Tersusun</p>
            </div>
            
            <div class="flex items-center gap-3">
                <button @click="showAddModal = true" class="px-5 py-2.5 bg-red-600 text-white font-bold rounded-xl shadow-lg shadow-red-600/20 hover:bg-red-700 transition-all text-xs flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg> Tambah Langkah Baru
                </button>
            </div>
        </div>

        <!-- Roadmap Content -->
        <div class="relative">
            <!-- Vertical Line -->
            <div class="absolute left-8 top-0 bottom-0 w-1 bg-slate-100 rounded-full"></div>

            <div class="space-y-12 pb-12">
                @forelse($course->roadmapSteps as $index => $step)
                @php $item = $step->content; @endphp
                @if($item)
                <div class="relative pl-20 group">
                    <!-- Dot -->
                    <div class="absolute left-[26px] top-4 w-4 h-4 rounded-full border-4 border-white shadow-sm transition-all duration-500
                        {{ $step->content_type === 'module' ? 'bg-blue-600 scale-125' : ($step->content_type === 'quiz' ? 'bg-red-600' : 'bg-green-500') }}">
                    </div>

                    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm group-hover:shadow-md group-hover:border-slate-300 transition-all relative">
                         <!-- Actions -->
                         <div class="absolute -right-3 -top-3 opacity-0 group-hover:opacity-100 transition-all flex gap-2">
                            <button type="button" @click="openEditModal({{ json_encode($step) }})" class="w-8 h-8 bg-white border border-slate-200 text-slate-400 hover:text-blue-600 hover:border-blue-100 rounded-full shadow-sm flex items-center justify-center transition-all">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            </button>
                            <form action="{{ route('sensei.programs.roadmap.destroy', $step->id) }}" method="POST" onsubmit="return confirm('Hapus langkah ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 bg-white border border-slate-200 text-slate-400 hover:text-red-600 hover:border-red-100 rounded-full shadow-sm flex items-center justify-center transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </form>
                        </div>

                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <span class="text-[10px] font-black uppercase tracking-widest px-2 py-0.5 rounded-md
                                        {{ $step->content_type === 'module' ? 'bg-blue-50 text-blue-600' : ($step->content_type === 'quiz' ? 'bg-red-50 text-red-600' : 'bg-green-50 text-green-600') }}">
                                        Step {{ $index + 1 }}: {{ ucfirst($step->content_type) }}
                                    </span>
                                </div>
                                <h4 class="text-xl font-black text-slate-900 group-hover:text-red-600 transition-colors">{{ $step->title ?: $item->title }}</h4>
                                
                                @if($step->content_type === 'module')
                                    <div class="mt-4 flex items-center gap-4 text-xs font-bold text-slate-500 uppercase tracking-widest">
                                        {{ $item->lessons->count() }} Materi • {{ $item->description ?: 'Roadmap Belajar' }}
                                    </div>
                                @elseif($step->content_type === 'quiz')
                                    <div class="mt-4 flex items-center gap-4 text-xs font-bold text-slate-500 uppercase tracking-widest">
                                         {{ $item->questions->count() }} Soal • {{ $item->type }}
                                    </div>
                                @else
                                    <div class="mt-4 flex items-center gap-4 text-xs font-bold text-slate-500 uppercase tracking-widest">
                                        Tipe: {{ $item->type }} • Video / Link Tutorial
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @empty
                <div class="relative pl-20 py-20 text-center">
                    <div class="p-8 bg-slate-50 rounded-3xl border border-dashed border-slate-200">
                        <h3 class="text-lg font-bold text-slate-900 mb-2">Roadmap Kosong</h3>
                        <p class="text-slate-500 text-sm mb-6 max-w-xs mx-auto">Mulai susun langkah belajar siswa dengan menekan tombol "Tambah Langkah Baru" di atas.</p>
                        <button @click="showAddModal = true" class="px-6 py-2 bg-slate-900 text-white font-bold rounded-xl text-xs">Mulai Sekarang</button>
                    </div>
                </div>
                @endforelse

                <!-- Ending Node -->
                <div class="relative pl-20">
                    <div class="absolute left-[26px] top-4 w-4 h-4 rounded-full bg-slate-200 border-4 border-white shadow-sm"></div>
                    <div class="p-6 text-slate-400 font-bold uppercase text-xs tracking-widest">
                        🏁 Akhir Roadmap
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Step Modal -->
        <div x-show="showAddModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak style="display: none;">
            <div @click.away="showAddModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden border border-slate-200">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Tambah <span class="text-red-600">Langkah.</span></h3>
                        <button @click="showAddModal = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form action="{{ route('sensei.programs.roadmap.store', $course->id) }}" method="POST" class="space-y-6" x-data="{ type: 'module' }">
                        @csrf
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2 block">Pilih Tipe Konten</label>
                            <div class="grid grid-cols-3 gap-3">
                                <button type="button" @click="type = 'module'" :class="type === 'module' ? 'border-red-600 bg-red-50 text-red-600' : 'border-slate-200 text-slate-500'" class="py-3 px-4 rounded-xl border-2 text-xs font-bold transition-all">Modul</button>
                                <button type="button" @click="type = 'quiz'" :class="type === 'quiz' ? 'border-red-600 bg-red-50 text-red-600' : 'border-slate-200 text-slate-500'" class="py-3 px-4 rounded-xl border-2 text-xs font-bold transition-all">Quiz</button>
                                <button type="button" @click="type = 'lesson'" :class="type === 'lesson' ? 'border-red-600 bg-red-50 text-red-600' : 'border-slate-200 text-slate-500'" class="py-3 px-4 rounded-xl border-2 text-xs font-bold transition-all">Video/Link</button>
                                <input type="hidden" name="content_type" :value="type">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2 block">Pilih Item</label>
                            <select x-show="type === 'module'" :name="type === 'module' ? 'content_id' : ''" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold">
                                <option value="">Pilih Modul...</option>
                                @foreach($course->modules as $mod)
                                    <option value="{{ $mod->id }}">{{ $mod->title }}</option>
                                @endforeach
                            </select>
                            <select x-show="type === 'quiz'" :name="type === 'quiz' ? 'content_id' : ''" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold" style="display: none;">
                                <option value="">Pilih Quiz...</option>
                                @foreach($course->quizzes as $qz)
                                    <option value="{{ $qz->id }}">{{ $qz->title }}</option>
                                @endforeach
                            </select>
                            <select x-show="type === 'lesson'" :name="type === 'lesson' ? 'content_id' : ''" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold" style="display: none;">
                                <option value="">Pilih Video/Link...</option>
                                @foreach($availableLessons as $ls)
                                    <option value="{{ $ls->id }}">{{ $ls->title }} ({{ $ls->type }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2 block">Judul Custom (Opsional)</label>
                            <input type="text" name="title" placeholder="Contoh: Belajar Hiragana Dasar" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold">
                        </div>

                        <button type="submit" class="w-full py-4 bg-slate-900 text-white font-black uppercase tracking-widest text-xs rounded-2xl hover:bg-red-600 transition-all">Simpan ke Roadmap</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Step Modal -->
        <div x-show="showEditModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak style="display: none;">
            <div @click.away="showEditModal = false" class="bg-white rounded-3xl shadow-2xl w-full max-w-lg overflow-hidden border border-slate-200">
                <div class="p-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-black text-slate-900 tracking-tight">Edit <span class="text-blue-600">Langkah.</span></h3>
                        <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form :action="'{{ url('sensei/programs/roadmap-steps') }}/' + editingStep.id" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2 block">Tipe Konten</label>
                            <div class="grid grid-cols-3 gap-3">
                                <button type="button" @click="editingStep.type = 'module'" :class="editingStep.type === 'module' ? 'border-blue-600 bg-blue-50 text-blue-600' : 'border-slate-200 text-slate-500'" class="py-3 px-4 rounded-xl border-2 text-xs font-bold transition-all">Modul</button>
                                <button type="button" @click="editingStep.type = 'quiz'" :class="editingStep.type === 'quiz' ? 'border-blue-600 bg-blue-50 text-blue-600' : 'border-slate-200 text-slate-500'" class="py-3 px-4 rounded-xl border-2 text-xs font-bold transition-all">Quiz</button>
                                <button type="button" @click="editingStep.type = 'lesson'" :class="editingStep.type === 'lesson' ? 'border-blue-600 bg-blue-50 text-blue-600' : 'border-slate-200 text-slate-500'" class="py-3 px-4 rounded-xl border-2 text-xs font-bold transition-all">Video/Link</button>
                                <input type="hidden" name="content_type" :value="editingStep.type">
                            </div>
                        </div>

                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2 block">Pilih Item</label>
                            <select x-show="editingStep.type === 'module'" :name="editingStep.type === 'module' ? 'content_id' : ''" x-model="editingStep.content_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold">
                                @foreach($course->modules as $mod)
                                    <option value="{{ $mod->id }}">{{ $mod->title }}</option>
                                @endforeach
                            </select>
                            <select x-show="editingStep.type === 'quiz'" :name="editingStep.type === 'quiz' ? 'content_id' : ''" x-model="editingStep.content_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold" style="display: none;">
                                @foreach($course->quizzes as $qz)
                                    <option value="{{ $qz->id }}">{{ $qz->title }}</option>
                                @endforeach
                            </select>
                            <select x-show="editingStep.type === 'lesson'" :name="editingStep.type === 'lesson' ? 'content_id' : ''" x-model="editingStep.content_id" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold" style="display: none;">
                                @foreach($availableLessons as $ls)
                                    <option value="{{ $ls->id }}">{{ $ls->title }} ({{ $ls->type }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2 block">Judul Custom</label>
                            <input type="text" name="title" x-model="editingStep.title" placeholder="Judul khusus langkah ini" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold">
                        </div>

                        <div>
                            <label class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-2 block">Urutan (Order)</label>
                            <input type="number" name="order" x-model="editingStep.order" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold">
                        </div>

                        <button type="submit" class="w-full py-4 bg-slate-900 text-white font-black uppercase tracking-widest text-xs rounded-2xl hover:bg-blue-600 transition-all shadow-xl">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-sensei-layout>
