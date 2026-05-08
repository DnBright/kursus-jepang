@extends('layouts.app')

@section('content')
<div class="p-8">
    <div class="mb-8">
        <h2 class="text-3xl font-black text-slate-900">Roadmap Management</h2>
        <p class="text-slate-500">Pilih program untuk mengelola jalur pembelajaran siswa.</p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
        @foreach($courses as $course)
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden hover:shadow-lg transition-all group">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <span class="px-3 py-1 bg-red-50 text-red-600 text-[10px] font-black uppercase tracking-widest rounded-lg border border-red-100">{{ $course->level }}</span>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $course->roadmapSteps->count() }} Langkah</span>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-red-600 transition-colors">{{ $course->title }}</h3>
                    <p class="text-slate-500 text-sm mb-6 line-clamp-2">{{ $course->description }}</p>
                    
                    <a href="{{ route('admin.roadmap.manage', $course->id) }}" class="block w-full py-3 bg-slate-900 text-white text-center text-xs font-black uppercase tracking-widest rounded-xl hover:bg-red-600 transition-all">
                        Kelola Roadmap
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
