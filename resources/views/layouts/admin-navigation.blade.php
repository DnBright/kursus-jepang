@php
$navItems = [
    [
        'label' => 'Dashboard',
        'route' => 'admin.dashboard',
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>',
        'active' => request()->routeIs('admin.dashboard'),
    ],
    [
        'label' => 'Validasi Pendaftaran',
        'route' => 'admin.validations.index', 
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>',
        'active' => request()->routeIs('admin.validations.index'),
        'badge' => 12, // Mock notification badge
    ],
    [
        'label' => 'Manajemen User',
        'route' => 'admin.users.index',
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>',
        'active' => request()->routeIs('admin.users.index'),
    ],
    [
        'label' => 'Kelas & Program',
        'route' => 'admin.classes.index',
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>',
        'active' => request()->routeIs('admin.classes.index'),
    ],
    [
        'label' => 'Materi & Konten',
        'route' => 'admin.materials.index', 
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>',
        'active' => request()->routeIs('admin.materials.index'),
    ],
    [
        'label' => 'Pembayaran',
        'route' => 'admin.payments.index', 
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>',
        'active' => request()->routeIs('admin.payments.index'),
    ],
    [
        'label' => 'Sertifikat',
        'route' => 'admin.certificates.index', 
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>',
        'active' => request()->routeIs('admin.certificates.index'),
    ],
    [
        'label' => 'Laporan & Statistik',
        'route' => 'admin.reports.index', 
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>',
        'active' => request()->routeIs('admin.reports.index'),
    ],
];
@endphp

@foreach($navItems as $item)
<a href="{{ $item['route'] == '#' ? '#' : route($item['route']) }}" 
   class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group
          {{ $item['active'] 
             ? 'bg-red-600 text-white shadow-lg shadow-red-600/20' 
             : 'text-slate-400 hover:text-white hover:bg-slate-800' 
          }}">
    
    <div class="{{ $item['active'] ? 'text-white' : 'text-slate-400 group-hover:text-white' }}">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            {!! $item['icon'] !!}
        </svg>
    </div>
    
    <span class="text-sm font-medium">{{ $item['label'] }}</span>

    @if(isset($item['badge']) && $item['badge'] > 0)
        <span class="ml-auto flex items-center justify-center min-w-[1.25rem] h-5 px-1.5 rounded-full text-[10px] font-bold bg-red-500 text-white border border-slate-900">
            {{ $item['badge'] }}
        </span>
    @endif
</a>
@endforeach

    <div class="mt-8 px-3">
    <p class="px-2 text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">System</p>
    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all duration-200 group {{ request()->routeIs('admin.settings.index') ? 'bg-red-600 text-white shadow-lg shadow-red-600/20' : 'text-slate-400 hover:text-white hover:bg-slate-800' }}">
        <div class="{{ request()->routeIs('admin.settings.index') ? 'text-white' : 'text-slate-400 group-hover:text-white' }}">
             <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
        </div>
        <span class="text-sm font-medium">Pengaturan Sistem</span>
    </a>
</div>
