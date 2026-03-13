@extends('layouts.app')

@section('content')
<div class="mb-10 flex items-center justify-between">
    <div>
        <a href="{{ route('alumni.master') }}" class="text-slate-500 hover:text-white text-xs font-bold flex items-center space-x-2 mb-4 transition-colors group">
            <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali ke Master Data</span>
        </a>
        <h1 class="text-3xl font-bold font-outfit text-white">Profil Alumni</h1>
    </div>
    <div class="flex items-center space-x-3">
        <a href="{{ route('alumni.edit', $alumni->id) }}" class="bg-slate-800 hover:bg-slate-700 text-slate-200 px-6 py-2.5 rounded-xl font-bold text-sm border border-slate-700 transition-all">
            Edit Profil
        </a>
        <form action="{{ route('alumni.track', $alumni->id) }}" method="POST">
            @csrf
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-indigo-600/20 transition-all flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <span>Lacak Ulang</span>
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Info -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Profile Overview -->
        <div class="bg-slate-900/50 rounded-2xl border border-slate-800 p-8 shadow-premium backdrop-blur-sm">
            <div class="flex items-center space-x-6 mb-8 pb-8 border-b border-slate-800/50">
                <div class="w-20 h-20 bg-indigo-500/10 rounded-2xl border border-indigo-500/20 flex items-center justify-center text-3xl font-bold text-indigo-400">
                    {{ substr($alumni->name, 0, 1) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-white mb-1">{{ $alumni->name }}</h2>
                    <p class="text-slate-400 font-medium">Lulusan {{ $alumni->study_program }} • Angkatan {{ $alumni->graduation_year }}</p>
                </div>
            </div>
            
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-[0.2em] mb-8">Informasi Akademik</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                <div>
                    <label class="text-[10px] font-bold text-slate-600 uppercase tracking-widest block mb-2">Pendidikan Terakhir</label>
                    <p class="text-sm font-bold text-white">S1 {{ $alumni->study_program }}</p>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-600 uppercase tracking-widest block mb-2">Nomor Induk / ID</label>
                    <p class="text-sm font-bold text-slate-300">#{{ str_pad($alumni->id, 8, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-600 uppercase tracking-widest block mb-2">Universitas</label>
                    <p class="text-sm font-bold text-slate-300">Universitas Muhammadiyah Malang</p>
                </div>
                <div>
                    <label class="text-[10px] font-bold text-slate-600 uppercase tracking-widest block mb-2">Tahun Kelulusan</label>
                    <p class="text-sm font-bold text-slate-300">Tahun {{ $alumni->graduation_year }}</p>
                </div>
            </div>
        </div>

        <div class="bg-slate-900/50 rounded-2xl border border-slate-800 p-8 shadow-premium backdrop-blur-sm">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-[0.2em] mb-6">Bukti Jejak Publik</h3>
            @if($alumni->best_link)
                <div class="bg-slate-800/50 rounded-xl p-6 border border-slate-700/50">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[10px] font-bold text-indigo-400 bg-indigo-500/10 px-3 py-1 rounded-full border border-indigo-500/20 uppercase tracking-widest">Primary Source</span>
                        <span class="text-[10px] font-bold text-slate-500 uppercase">Tracked at: {{ $alumni->tracked_at ? $alumni->tracked_at->format('d M Y, H:i') : '-' }}</span>
                    </div>
                    <p class="text-slate-300 text-sm mb-4 leading-relaxed line-clamp-2 italic">
                        "{{ $alumni->metadata['snippet'] ?? 'Dokumentasi keterkaitan alumni ditemukan pada platform profesional/akademik publik.' }}"
                    </p>
                    <a href="{{ $alumni->best_link }}" target="_blank" class="inline-flex items-center text-indigo-400 hover:text-white text-sm font-bold transition-colors group">
                        <span>Lihat Sumber Validasi</span>
                        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                        </svg>
                    </a>
                </div>
            @else
                <div class="text-center py-12 bg-slate-800/20 rounded-xl border border-dashed border-slate-700">
                    <svg class="w-12 h-12 text-slate-700 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 9.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-slate-500 text-sm font-medium">Belum ada jejak publik yang teridentifikasi secara otomatis.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Status Sidebar -->
    <div class="space-y-8">
        <div class="bg-slate-900/50 rounded-2xl border border-slate-800 p-8 shadow-premium backdrop-blur-sm">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-[0.2em] mb-6">Integritas Data</h3>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-slate-800/40 rounded-lg border border-slate-700/50">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Status Tracking</span>
                    <span class="text-[10px] font-bold text-white uppercase">{{ $alumni->status }}</span>
                </div>
                <div class="flex items-center justify-between p-3 bg-slate-800/40 rounded-lg border border-slate-700/50">
                    <span class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">Source Authenticity</span>
                    <span class="text-[10px] font-bold text-emerald-400 uppercase">Verified</span>
                </div>
            </div>
        </div>

        <div class="bg-indigo-600/10 rounded-2xl border border-indigo-500/20 p-8 backdrop-blur-sm">
            <h3 class="text-sm font-bold text-indigo-400 mb-4 font-outfit">Catatan Sistem</h3>
            <p class="text-slate-400 text-xs leading-relaxed font-medium">
                Data divalidasi dengan algoritma berbasis LLM untuk memastikan kecocokan identitas dengan profil publik yang ditemukan.
            </p>
        </div>
    </div>
</div>
@endsection
