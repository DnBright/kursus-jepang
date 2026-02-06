<x-app-layout>
    <div class="space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">Kursus Saya</h2>
                <p class="text-slate-500 text-sm mt-1">Lanjutkan pembelajaran Anda dari tempat terakhir Anda meninggalkannya.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-sm font-medium text-slate-500">Filter:</span>
                <select class="text-sm border-slate-200 rounded-lg focus:ring-red-500 focus:border-red-500 text-slate-700">
                    <option>Semua Kursus</option>
                    <option>Sedang Berjalan</option>
                    <option>Selesai</option>
                </select>
            </div>
        </div>

        <!-- Course Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($courses as $course)
            @php
                // Check status. For now assuming all are 'active' if they are in this list, 
                // or we can check again against user's packages
                // $status = Auth::user()->hasActivePackage($course->level) ? 'Aktif' : 'Terkunci';
                $isActive = Auth::user()->hasActivePackage($course->level);
            @endphp
            <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:shadow-lg transition-all group {{ !$isActive ? 'opacity-75' : '' }}">
                <!-- Cover Image/Icon Area -->
                <div class="h-32 bg-slate-50 relative flex items-center justify-center border-b border-slate-100 group-hover:bg-red-50 transition-colors">
                    <div class="text-6xl group-hover:scale-110 transition-transform duration-300">
                        @if($course->level == 'Basic N5') 🇯🇵 @elseif($course->level == 'Intensive N4') 🎎 @else 🎓 @endif
                    </div>
                    <div class="absolute top-4 right-4">
                        @if($isActive)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-700">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span>
                            Aktif
                        </span>
                        @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-500">
                            🔒 Terkunci
                        </span>
                        @endif
                    </div>
                </div>

                <div class="p-6">
                    <!-- Header -->
                    <div class="mb-4">
                        <div class="text-xs font-bold text-red-600 uppercase tracking-wide mb-1">{{ $course->level }}</div>
                        <h3 class="text-lg font-bold text-slate-900 line-clamp-1 group-hover:text-red-600 transition-colors">{{ $course->title }}</h3>
                        <p class="text-slate-500 text-sm mt-2 line-clamp-2">{{ $course->description }}</p>
                    </div>

                    <!-- Progress (Placeholder) -->
                    <div class="mb-6">
                        <div class="flex justify-between text-xs font-bold text-slate-600 mb-2">
                            <span>Progress Belajar</span>
                            <span>0%</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                            <div class="bg-red-600 h-2 rounded-full transition-all duration-1000 ease-out" style="width: 0%"></div>
                        </div>
                    </div>

                    <!-- Meta Info & Action -->
                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-slate-100">
                        <div class="flex items-center text-slate-500 text-xs font-medium">
                            <svg class="w-4 h-4 mr-1.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            {{ $course->modules->count() ?? 0 }} Modul POPO
                        </div>
                        @if($isActive)
                        <a href="{{ route('courses.show', $course->id) }}" class="px-4 py-2 bg-red-600 text-white text-sm font-bold rounded-lg shadow-md shadow-red-600/20 hover:bg-red-700 hover:shadow-red-600/40 transition-all transform hover:-translate-y-0.5 flex items-center gap-2">
                            Lanjut
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </a>
                        @else
                        <a href="{{ route('packages.index') }}" class="px-4 py-2 bg-slate-100 text-slate-500 text-sm font-bold rounded-lg hover:bg-slate-200 transition-all flex items-center gap-2">
                            Beli Paket
                        </a>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12 bg-white rounded-3xl border border-dashed border-slate-300">
                <div class="text-6xl mb-4">📚</div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Belum Ada Kursus</h3>
                <p class="text-slate-500 max-w-sm mx-auto mb-6">Kami sedang menyiapkan materi terbaik untuk Anda.</p>
            </div>
            @endforelse
        </div>
        
        <!-- Empty State (Hidden, just for design ref) -->
        <!-- 
        <div class="text-center py-12 bg-white rounded-3xl border border-dashed border-slate-300">
            <div class="text-6xl mb-4">📚</div>
            <h3 class="text-xl font-bold text-slate-900 mb-2">Belum Ada Kursus</h3>
            <p class="text-slate-500 max-w-sm mx-auto mb-6">Anda belum mendaftar kelas apapun. Yuk mulai belajar sekarang!</p>
            <a href="/#program" class="inline-flex items-center px-6 py-3 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-colors">
                Lihat Katalog Kelas
            </a>
        </div> 
        -->
    </div>
</x-app-layout>
