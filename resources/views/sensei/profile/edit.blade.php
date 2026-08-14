<x-sensei-layout>
    <div class="space-y-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Pengaturan Profil</h1>
            <p class="text-slate-500 text-sm mt-1">Perbarui informasi akun dan keamanan Anda.</p>
        </div>

        @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm font-medium">
            {{ session('success') }}
        </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Informasi Pribadi</h3>
                <form method="POST" action="{{ route('sensei.profile.update') }}" class="space-y-4" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    
                    <div class="flex items-center gap-4 mb-6">
                        <div class="relative w-20 h-20 rounded-full overflow-hidden bg-slate-100 border-2 border-slate-200">
                            @if($user->avatar_url)
                                <img src="{{ Storage::url($user->avatar_url) }}" alt="Avatar" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-400 text-2xl font-bold bg-slate-200">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <x-input-label for="avatar" value="Foto Profil (Maks 2MB)" />
                            <input id="avatar" name="avatar" type="file" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200" accept="image/jpeg,image/png,image/jpg" />
                            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                        </div>
                    </div>
                    
                    <div>
                        <x-input-label for="name" value="Nama Lengkap" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>
                    
                    <div>
                        <x-input-label for="email" value="Alamat Email" />
                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="title" value="Gelar / Spesialisasi (Opsional)" />
                        <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $user->title)" />
                        <x-input-error class="mt-2" :messages="$errors->get('title')" />
                    </div>

                    <div>
                        <x-input-label for="bio" value="Bio Singkat (Opsional)" />
                        <textarea id="bio" name="bio" rows="4" class="mt-1 block w-full border-slate-300 focus:border-red-500 focus:ring-red-500 rounded-xl shadow-sm">{{ old('bio', $user->bio) }}</textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="bg-slate-900 text-white px-4 py-2 rounded-xl font-bold hover:bg-slate-800 transition-colors">Simpan Profil</button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200 p-6">
                <h3 class="text-lg font-bold text-slate-900 mb-4">Ubah Password</h3>
                <form method="POST" action="{{ route('sensei.profile.password') }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <x-input-label for="current_password" value="Password Saat Ini" />
                        <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
                    </div>

                    <div>
                        <x-input-label for="password" value="Password Baru" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" value="Konfirmasi Password Baru" />
                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-xl font-bold hover:bg-red-700 transition-colors">Perbarui Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-sensei-layout>
