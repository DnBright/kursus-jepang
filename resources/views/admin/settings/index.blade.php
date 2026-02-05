<x-admin-layout>
    <div x-data="{ activeTab: 'general' }" class="flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar Navigation -->
        <div class="w-full lg:w-64 flex-shrink-0">
            <h2 class="text-xl font-bold text-slate-900 mb-6 px-2">Pengaturan Sistem</h2>
            <nav class="space-y-1">
                <button @click="activeTab = 'general'" :class="{ 'bg-red-50 text-red-700 border-l-4 border-red-600': activeTab === 'general', 'text-slate-600 hover:bg-slate-50 hover:text-slate-900': activeTab !== 'general' }" class="w-full flex items-center px-3 py-3 text-sm font-medium rounded-r-lg transition-colors group">
                     <svg class="h-5 w-5 mr-3 flex-shrink-0" :class="{ 'text-red-600': activeTab === 'general', 'text-slate-400 group-hover:text-slate-500': activeTab !== 'general' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Pengaturan Umum
                </button>

                <button @click="activeTab = 'account'" :class="{ 'bg-red-50 text-red-700 border-l-4 border-red-600': activeTab === 'account', 'text-slate-600 hover:bg-slate-50 hover:text-slate-900': activeTab !== 'account' }" class="w-full flex items-center px-3 py-3 text-sm font-medium rounded-r-lg transition-colors group">
                    <svg class="h-5 w-5 mr-3 flex-shrink-0" :class="{ 'text-red-600': activeTab === 'account', 'text-slate-400 group-hover:text-slate-500': activeTab !== 'account' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Akun & Role
                </button>

                 <button @click="activeTab = 'course'" :class="{ 'bg-red-50 text-red-700 border-l-4 border-red-600': activeTab === 'course', 'text-slate-600 hover:bg-slate-50 hover:text-slate-900': activeTab !== 'course' }" class="w-full flex items-center px-3 py-3 text-sm font-medium rounded-r-lg transition-colors group">
                    <svg class="h-5 w-5 mr-3 flex-shrink-0" :class="{ 'text-red-600': activeTab === 'course', 'text-slate-400 group-hover:text-slate-500': activeTab !== 'course' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    Kursus & Materi
                </button>

                 <button @click="activeTab = 'payment'" :class="{ 'bg-red-50 text-red-700 border-l-4 border-red-600': activeTab === 'payment', 'text-slate-600 hover:bg-slate-50 hover:text-slate-900': activeTab !== 'payment' }" class="w-full flex items-center px-3 py-3 text-sm font-medium rounded-r-lg transition-colors group">
                    <svg class="h-5 w-5 mr-3 flex-shrink-0" :class="{ 'text-red-600': activeTab === 'payment', 'text-slate-400 group-hover:text-slate-500': activeTab !== 'payment' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                    Pembayaran
                </button>

                 <button @click="activeTab = 'certificate'" :class="{ 'bg-red-50 text-red-700 border-l-4 border-red-600': activeTab === 'certificate', 'text-slate-600 hover:bg-slate-50 hover:text-slate-900': activeTab !== 'certificate' }" class="w-full flex items-center px-3 py-3 text-sm font-medium rounded-r-lg transition-colors group">
                    <svg class="h-5 w-5 mr-3 flex-shrink-0" :class="{ 'text-red-600': activeTab === 'certificate', 'text-slate-400 group-hover:text-slate-500': activeTab !== 'certificate' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
                    Sertifikat
                </button>
                
                 <button @click="activeTab = 'security'" :class="{ 'bg-red-50 text-red-700 border-l-4 border-red-600': activeTab === 'security', 'text-slate-600 hover:bg-slate-50 hover:text-slate-900': activeTab !== 'security' }" class="w-full flex items-center px-3 py-3 text-sm font-medium rounded-r-lg transition-colors group">
                    <svg class="h-5 w-5 mr-3 flex-shrink-0" :class="{ 'text-red-600': activeTab === 'security', 'text-slate-400 group-hover:text-slate-500': activeTab !== 'security' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Keamanan & Sistem
                </button>
                
                 <button @click="activeTab = 'notification'" :class="{ 'bg-red-50 text-red-700 border-l-4 border-red-600': activeTab === 'notification', 'text-slate-600 hover:bg-slate-50 hover:text-slate-900': activeTab !== 'notification' }" class="w-full flex items-center px-3 py-3 text-sm font-medium rounded-r-lg transition-colors group">
                    <svg class="h-5 w-5 mr-3 flex-shrink-0" :class="{ 'text-red-600': activeTab === 'notification', 'text-slate-400 group-hover:text-slate-500': activeTab !== 'notification' }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    Notifikasi
                </button>

            </nav>
        </div>

        <!-- Content Area -->
        <div class="flex-1 min-w-0">
             <div class="bg-white rounded-2xl shadow-sm border border-slate-200">
                <!-- 1. General Settings -->
                <div x-show="activeTab === 'general'" class="p-6 md:p-8 space-y-6">
                    <div class="flex justify-between items-start border-b border-slate-100 pb-5 mb-5">
                         <div>
                            <h3 class="text-lg font-bold text-slate-900">Pengaturan Umum</h3>
                            <p class="text-sm text-slate-500">Konfigurasi dasar informasi platform.</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                        <div class="sm:col-span-4">
                            <label class="block text-sm font-bold text-slate-700">Nama Platform</label>
                            <input type="text" value="{{ $settings['general']['platform_name'] }}" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-4">
                            <label class="block text-sm font-bold text-slate-700">Email Resmi</label>
                            <input type="email" value="{{ $settings['general']['email'] }}" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>

                        <div class="sm:col-span-3">
                             <label class="block text-sm font-bold text-slate-700">Bahasa Default</label>
                            <select class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                <option>Indonesia</option>
                                <option>English</option>
                                <option>Japanese</option>
                            </select>
                        </div>
                        
                         <div class="sm:col-span-3">
                             <label class="block text-sm font-bold text-slate-700">Zona Waktu</label>
                            <select class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                <option>Asia/Jakarta (WIB)</option>
                                <option>Asia/Makassar (WITA)</option>
                                <option>Asia/Jayapura (WIT)</option>
                            </select>
                        </div>
                        
                         <div class="sm:col-span-6">
                            <label class="block text-sm font-bold text-slate-700">Logo Platform</label>
                            <div class="mt-2 flex items-center space-x-5">
                                <span class="h-12 w-12 overflow-hidden rounded-full bg-slate-100 flex items-center justify-center">
                                    <svg class="h-full w-full text-slate-300" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                                </span>
                                <button type="button" class="rounded-lg border border-slate-300 bg-white py-1.5 px-3 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Ubah</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Account Settings (Mock) -->
                <div x-show="activeTab === 'account'" class="p-6 md:p-8 space-y-6" style="display: none;">
                    <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-5 mb-5">Pengaturan Akun & Role</h3>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                             <span class="flex-grow flex flex-col">
                                <span class="text-sm font-bold text-slate-900">Validasi Manual Pendaftaran</span>
                                <span class="text-sm text-slate-500">Admin harus menyetujui setiap siswa baru yang mendaftar.</span>
                            </span>
                             <button type="button" class="bg-red-600 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2" role="switch" aria-checked="true">
                                <span aria-hidden="true" class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>
                    </div>
                </div>
                
                 <!-- 3. Course Settings (Mock) -->
                <div x-show="activeTab === 'course'" class="p-6 md:p-8 space-y-6" style="display: none;">
                    <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-5 mb-5">Pengaturan Kursus</h3>
                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-6">
                         <div class="sm:col-span-4">
                             <label class="block text-sm font-bold text-slate-700">Minimum Progress Kelulusan (%)</label>
                            <input type="number" value="{{ $settings['course']['min_progress'] }}" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                        </div>
                    </div>
                </div>
                
                <!-- 4. Payment Settings (Mock) -->
                 <div x-show="activeTab === 'payment'" class="p-6 md:p-8 space-y-6" style="display: none;">
                    <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-5 mb-5">Pengaturan Pembayaran</h3>
                     <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-6">
                         <div class="sm:col-span-4">
                             <label class="block text-sm font-bold text-slate-700">Mata Uang Default</label>
                            <select class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                                <option selected>IDR (Rupiah Indonesia)</option>
                                <option>USD (US Dollar)</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <!-- 5. Certificate Settings (Mock) -->
                <div x-show="activeTab === 'certificate'" class="p-6 md:p-8 space-y-6" style="display: none;">
                    <h3 class="text-lg font-bold text-slate-900 border-b border-slate-100 pb-5 mb-5">Pengaturan Sertifikat</h3>
                     <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-6">
                         <div class="sm:col-span-4">
                             <label class="block text-sm font-bold text-slate-700">Format Nomor Sertifikat</label>
                            <input type="text" value="{{ $settings['certificate']['format'] }}" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm">
                            <p class="mt-1 text-xs text-slate-500">Gunakan {YEAR}, {MONTH}, {NUM} untuk penomoran otomatis.</p>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="bg-slate-50 px-4 py-3 text-right sm:px-6 rounded-b-2xl border-t border-slate-200">
                    <button type="button" class="inline-flex justify-center rounded-lg border border-slate-300 bg-white py-2 px-4 text-sm font-medium text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 mr-3">Reset</button>
                    <button type="submit" class="inline-flex justify-center rounded-lg border border-transparent bg-slate-900 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Simpan Perubahan</button>
                </div>

             </div>
        </div>

    </div>
</x-admin-layout>
