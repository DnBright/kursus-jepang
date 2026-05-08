<x-admin-layout>
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Pengelolaan Artikel</h1>
                <p class="text-slate-500 text-sm mt-1">Kelola berita, informasi, dan artikel seputar bahasa Jepang.</p>
            </div>
            
            <a href="{{ route('admin.articles.create') }}" class="px-4 py-2 bg-red-600 text-white font-bold rounded-xl hover:bg-red-700 transition-colors text-sm flex items-center gap-2 shadow-lg shadow-red-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Tulis Artikel Baru
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">
            {{ session('success') }}
        </div>
        @endif

        <!-- Articles Table -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden text-left">
            <div class="overflow-x-auto">
                 <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Judul Artikel</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                            <th class="p-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($articles as $article)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    @if($article->image)
                                    <img src="{{ Storage::url($article->image) }}" alt="" class="w-10 h-10 rounded-lg object-cover">
                                    @else
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002-2z"></path></svg>
                                    </div>
                                    @endif
                                    <div>
                                        <div class="font-bold text-slate-900 text-sm">{{ $article->title }}</div>
                                        <div class="text-xs text-slate-500">{{ $article->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="p-4">
                                @if($article->is_published)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-green-50 text-green-700 border border-green-100">Published</span>
                                @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 text-slate-500 border border-slate-200">Draft</span>
                                @endif
                            </td>
                            <td class="p-4 text-sm text-slate-500">
                                {{ $article->created_at->format('d M Y') }}
                            </td>
                            <td class="p-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                     <a href="{{ route('admin.articles.edit', $article->id) }}" class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors" title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-12 text-center text-slate-400 text-sm">Belum ada artikel yang dibuat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
