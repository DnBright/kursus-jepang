<x-admin-layout>
    <div class="mb-8">
        <a href="{{ route('admin.senseis.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-400 hover:text-red-600 transition-colors mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
        <h1 class="text-2xl font-bold text-slate-900">Edit Data Sensei</h1>
        <p class="text-slate-500 text-sm mt-1">Perbarui informasi untuk pengajar: <span class="font-bold text-slate-900">{{ $sensei->name }}</span></p>
    </div>

    <div class="max-w-4xl">
        <form action="{{ route('admin.senseis.update', $sensei->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <!-- Basic Information -->
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
                <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Informasi Dasar</h2>
                
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="name" class="text-sm font-bold text-slate-700">Nama Lengkap</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $sensei->name) }}" required
                            class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-red-100 focus:border-red-600 transition-all placeholder-slate-400">
                        @error('name') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="text-sm font-bold text-slate-700">Alamat Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $sensei->email) }}" required
                            class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-red-100 focus:border-red-600 transition-all placeholder-slate-400">
                        @error('email') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="title" class="text-sm font-bold text-slate-700">Gelar / Jabatan</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $sensei->title) }}"
                            class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-red-100 focus:border-red-600 transition-all placeholder-slate-400">
                        @error('title') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="specialization" class="text-sm font-bold text-slate-700">Bidang Spesialisasi</label>
                        <input type="text" name="specialization" id="specialization" value="{{ old('specialization', $sensei->specialization) }}"
                            class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-red-100 focus:border-red-600 transition-all placeholder-slate-400">
                        @error('specialization') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="phone_number" class="text-sm font-bold text-slate-700">Nomor Telepon/WA</label>
                        <input type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $sensei->phone_number) }}"
                            class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-red-100 focus:border-red-600 transition-all placeholder-slate-400">
                        @error('phone_number') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="status" class="text-sm font-bold text-slate-700">Status Akun</label>
                        <select name="status" id="status" required
                            class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm font-bold text-slate-700 focus:ring-2 focus:ring-red-100 focus:border-red-600 transition-all">
                            <option value="active" {{ old('status', $sensei->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ old('status', $sensei->status) === 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                            <option value="suspended" {{ old('status', $sensei->status) === 'suspended' ? 'selected' : '' }}>Ditangguhkan (Suspended)</option>
                        </select>
                        @error('status') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Security Section -->
            <div class="bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xs font-black text-slate-400 uppercase tracking-widest">Ubah Security (Opsional)</h2>
                    <span class="text-[9px] font-black bg-slate-100 text-slate-400 px-2 py-0.5 rounded uppercase tracking-widest">Kosongkan jika tidak diubah</span>
                </div>
                <div class="grid md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label for="password" class="text-sm font-bold text-slate-700">Password Baru</label>
                        <input type="password" name="password" id="password"
                            class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-red-100 focus:border-red-600 transition-all placeholder-slate-400"
                            placeholder="••••••••">
                        @error('password') <p class="text-red-600 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-sm font-bold text-slate-700">Konfirmasi Password Baru</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full bg-slate-50 border-slate-200 rounded-xl px-4 py-3 text-sm font-medium focus:ring-2 focus:ring-red-100 focus:border-red-600 transition-all placeholder-slate-400"
                            placeholder="••••••••">
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4">
                <a href="{{ route('admin.senseis.index') }}" class="px-6 py-3 text-sm font-bold text-slate-400 hover:text-slate-600 transition-colors uppercase tracking-widest">Batal</a>
                <button type="submit" class="px-10 py-3.5 bg-slate-900 text-white text-sm font-black rounded-xl hover:bg-slate-800 shadow-lg transition-all transform hover:-translate-y-1 uppercase tracking-widest">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-admin-layout>
