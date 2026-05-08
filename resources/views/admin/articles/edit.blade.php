<x-admin-layout>
    <div class="max-w-[1400px] mx-auto space-y-6 pb-20 text-left">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-900">Edit Post</h1>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-bold text-slate-900 uppercase tracking-tight">Admin User</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Administrator</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-red-50 flex items-center justify-center text-red-600 font-bold border border-red-100">A</div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.articles.update', $article->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            @csrf
            @method('PUT')
            
            <!-- Main Content (Left) -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Title Input -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <input type="text" name="title" required value="{{ old('title', $article->title) }}" placeholder="Enter title here" class="w-full px-6 py-4 text-xl font-medium border-none focus:ring-0 placeholder-slate-300">
                    @error('title') <p class="text-red-500 text-xs px-6 pb-2">{{ $message }}</p> @enderror
                </div>

                <!-- Add Media Button -->
                <div class="flex">
                    <button type="button" onclick="document.getElementById('media-input').click()" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 transition-colors shadow-sm">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002-2z"></path></svg>
                        Add Media
                    </button>
                    <input type="file" id="media-input" class="hidden" accept="image/*" onchange="uploadMedia(this)">
                </div>

                <!-- Editor Container -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <textarea name="content" id="editor" class="w-full h-[600px]">{{ old('content', $article->content) }}</textarea>
                    @error('content') <p class="text-red-500 text-xs px-6 py-2">{{ $message }}</p> @enderror
                </div>

                <!-- Excerpt Box -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50">
                        <h2 class="font-bold text-slate-900 text-sm">Excerpt</h2>
                    </div>
                    <div class="p-6">
                        <textarea name="excerpt" rows="4" placeholder="Write a short summary..." class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-500/10 focus:border-red-500 transition-all font-medium">{{ old('excerpt', $article->excerpt) }}</textarea>
                        <p class="text-slate-400 text-[10px] mt-2 italic font-medium">Excerpts are optional hand-crafted summaries of your content.</p>
                        @error('excerpt') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Sidebar (Right) -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Publish Card -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h2 class="font-bold text-slate-900 text-sm">Publish</h2>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <button type="submit" name="is_published" value="0" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-bold text-blue-600 hover:bg-slate-100 transition-colors">Save Draft</button>
                            <button type="button" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-500 hover:bg-slate-50 transition-colors">Preview</button>
                        </div>
                        
                        <div class="space-y-3 pt-2">
                            <div class="flex items-center gap-2 text-xs font-medium text-slate-600">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Status: <span class="font-bold text-slate-900">{{ $article->is_published ? 'published' : 'draft' }}</span></span>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2 text-xs font-medium text-slate-600">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                    <span>Member Only</span>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="is_member_only" value="1" {{ old('is_member_only', $article->is_member_only) ? 'checked' : '' }} class="sr-only peer">
                                    <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-red-600"></div>
                                </label>
                            </div>
                            <div class="flex items-center gap-2 text-xs font-medium text-slate-600">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2-2v12a2 2 0 002 2z"></path></svg>
                                <span>Updated at: <span class="font-bold text-slate-900">{{ $article->updated_at->format('d M Y') }}</span></span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <form action="{{ route('admin.articles.destroy', $article->id) }}" method="POST" onsubmit="return confirm('Move to trash?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs font-bold text-red-600 hover:underline">Move to Trash</button>
                            </form>
                            <button type="submit" name="is_published" value="1" class="px-6 py-2 bg-blue-600 text-white font-bold rounded-lg text-xs hover:bg-blue-700 transition-colors shadow-lg shadow-blue-200">Update Post</button>
                        </div>
                    </div>
                </div>

                <!-- Categories Card -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h2 class="font-bold text-slate-900 text-sm">Categories</h2>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="p-6">
                        <div class="space-y-3 h-48 overflow-y-auto custom-scrollbar p-1">
                            @php
                                $categories = ['Berita', 'Budaya', 'Karir', 'Pelatihan', 'testt', 'Tips'];
                            @endphp
                            @foreach($categories as $cat)
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="radio" name="category" value="{{ $cat }}" {{ old('category', $article->category) == $cat ? 'checked' : '' }} class="w-4 h-4 text-red-600 focus:ring-red-500 border-slate-300 rounded-full">
                                <span class="text-sm font-medium text-slate-600 group-hover:text-slate-900 transition-colors">{{ $cat }}</span>
                            </label>
                            @endforeach
                        </div>

                        <div class="mt-6 pt-6 border-t border-slate-100 space-y-4">
                            <p class="text-[11px] font-bold text-blue-600 hover:underline cursor-pointer">+ Add New Category</p>
                            <input type="text" placeholder="Contoh: Jurnal Internal" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-red-500/10 focus:border-red-500 transition-all font-medium">
                            <p class="text-slate-400 text-[10px] italic">Isi ini jika kategori belum tersedia.</p>
                        </div>
                    </div>
                </div>

                <!-- Featured Image Card -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                        <h2 class="font-bold text-slate-900 text-sm">Featured Image</h2>
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                    <div class="p-6 space-y-4">
                        <div class="aspect-video w-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl flex flex-col items-center justify-center gap-3 group hover:border-red-500 transition-all cursor-pointer relative overflow-hidden" onclick="document.getElementById('image-input').click()">
                            <img id="image-preview" src="{{ $article->image ? Storage::url($article->image) : '' }}" class="absolute inset-0 w-full h-full object-cover {{ $article->image ? '' : 'hidden' }}">
                            <svg class="w-10 h-10 text-slate-300 group-hover:text-red-500 transition-colors {{ $article->image ? 'hidden' : '' }}" id="image-placeholder-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002-2z"></path></svg>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest group-hover:text-red-500 transition-colors {{ $article->image ? 'hidden' : '' }}" id="image-placeholder-text">Click to select image</p>
                            <input type="file" name="image" id="image-input" class="hidden" onchange="previewImage(this)">
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider block mb-2">Paste Image URL</label>
                            <input type="text" name="image_url" value="{{ old('image_url', (str_starts_with($article->image, 'http') ? $article->image : '')) }}" placeholder="https://example.com/image.jpg" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg text-xs focus:outline-none focus:ring-2 focus:ring-red-500/10 focus:border-red-500 transition-all font-medium">
                        </div>
                        @error('image') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- CKEditor 5 -->
    <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>
    <script>
        let editorInstance;
        ClassicEditor
            .create(document.querySelector('#editor'), {
                ckfinder: {
                    uploadUrl: '{{ route("admin.media.upload", ["_token" => csrf_token()]) }}'
                },
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'strikethrough', 'underline', '|',
                        'bulletedList', 'numberedList', '|',
                        'outdent', 'indent', '|',
                        'undo', 'redo', '|',
                        'link', 'uploadImage', 'blockQuote', 'insertTable', 'mediaEmbed', '|',
                        'undo', 'redo'
                    ]
                }
            })
            .then(editor => {
                editorInstance = editor;
                editor.model.document.on('change:data', () => {
                    document.querySelector('#editor').value = editor.getData();
                });
            })
            .catch(error => {
                console.error(error);
            });

        function uploadMedia(input) {
            if (input.files && input.files[0]) {
                const formData = new FormData();
                formData.append('image', input.files[0]);
                formData.append('_token', '{{ csrf_token() }}');

                fetch('{{ route("admin.media.upload") }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.url) {
                        const content = `<img src="${data.url}" alt="Media Image" />`;
                        const viewFragment = editorInstance.data.processor.toView(content);
                        const modelFragment = editorInstance.data.toModel(viewFragment);
                        editorInstance.model.insertContent(modelFragment);
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('image-preview').src = e.target.result;
                    document.getElementById('image-preview').classList.remove('hidden');
                    document.getElementById('image-placeholder-icon').classList.add('hidden');
                    document.getElementById('image-placeholder-text').classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    <style>
        .ck-editor__editable {
            min-height: 500px;
            border: none !important;
            box-shadow: none !important;
        }
        .ck-toolbar {
            border: none !important;
            border-bottom: 1px solid #f1f5f9 !important;
            background: #f8fafc !important;
        }
        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
            border-color: transparent !important;
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</x-admin-layout>
