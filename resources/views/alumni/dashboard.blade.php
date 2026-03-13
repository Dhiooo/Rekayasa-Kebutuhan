@extends('layouts.app')

@section('content')
<div class="mb-10">
    <h1 class="text-3xl font-bold font-outfit text-white">Dashboard Statistik</h1>
    <p class="text-slate-400 mt-2">Gambaran umum integritas data alumni Universitas Muhammadiyah.</p>
</div>

<!-- Statistics Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
    <!-- Total Alumni -->
    <div class="bg-slate-900/50 p-8 rounded-2xl border border-slate-800 backdrop-blur-sm shadow-premium group hover:border-slate-700 transition-all">
        <div class="flex items-center justify-between mb-6">
            <div class="w-14 h-14 bg-indigo-500/10 text-indigo-400 rounded-2xl flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all border border-indigo-500/20">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Data Terdaftar</span>
        </div>
        <h3 class="text-4xl font-bold font-outfit text-white">{{ $stats['total'] }}</h3>
        <p class="text-slate-500 text-sm mt-1 font-medium italic">Total Entri Database</p>
    </div>

    <!-- Tracked Successfully -->
    <div class="bg-slate-900/50 p-8 rounded-2xl border border-slate-800 backdrop-blur-sm shadow-premium group hover:border-slate-700 transition-all">
        <div class="flex items-center justify-between mb-6">
            <div class="w-14 h-14 bg-emerald-500/10 text-emerald-400 rounded-2xl flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition-all border border-emerald-500/20">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Teridentifikasi</span>
        </div>
        <h3 class="text-4xl font-bold font-outfit text-emerald-400">{{ $stats['tracked'] }}</h3>
        <p class="text-slate-500 text-sm mt-1 font-medium italic">Sesuai Jejak Publik</p>
    </div>

    <!-- Need Verification -->
    <div class="bg-slate-900/50 p-8 rounded-2xl border border-slate-800 backdrop-blur-sm shadow-premium group hover:border-slate-700 transition-all">
        <div class="flex items-center justify-between mb-6">
            <div class="w-14 h-14 bg-amber-500/10 text-amber-400 rounded-2xl flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-all border border-amber-500/20">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Butuh Review</span>
        </div>
        <h3 class="text-4xl font-bold font-outfit text-amber-400">{{ $stats['need_verification'] }}</h3>
        <p class="text-slate-500 text-sm mt-1 font-medium italic">Dalam Antrian Verifikasi</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- System Status -->
    <div class="bg-slate-900 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden border border-slate-800">
        <div class="relative z-10">
            <h3 class="text-lg font-bold font-outfit mb-4">Sistem Pelacakan Aktif</h3>
            <p class="text-slate-400 text-sm mb-8 leading-relaxed">
                Sistem saat ini menggunakan integrasi **Serper.dev Web Search** dan **Google Gemini Flash 3.1** untuk melakukan validasi otomatis terhadap data alumni yang terdaftar.
            </p>
            <div class="flex items-center space-x-6">
                <div>
                    <div class="text-[10px] text-slate-500 uppercase font-bold mb-1">Queue Status</div>
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></div>
                        <span class="text-sm font-bold text-white">{{ $stats['untracked'] }} Tunggu Lacak</span>
                    </div>
                </div>
                <div class="w-px h-8 bg-slate-800"></div>
                <a href="{{ route('alumni.tracking') }}" class="text-indigo-400 hover:text-white text-sm font-bold flex items-center space-x-2 transition-all group">
                    <span>Kelola Pelacakan</span>
                    <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
        <div class="absolute -right-8 -bottom-8 opacity-[0.03]">
            <svg class="w-64 h-64 text-white" fill="currentColor" viewBox="0 0 24 24">
                 <path d="M13 10V3L4 14h7v7l9-11h-7z"></path>
            </svg>
        </div>
    </div>

    <!-- Quick Access -->
    <div class="bg-slate-900/30 rounded-2xl p-8 border border-slate-800 flex flex-col justify-center backdrop-blur-sm">
        <h3 class="text-slate-300 font-bold mb-6 text-sm uppercase tracking-widest">Akses Cepat Manajemen</h3>
        <div class="grid grid-cols-2 gap-4">
            <a href="{{ route('alumni.create') }}" class="p-5 bg-slate-800/40 rounded-xl hover:bg-slate-800 transition-all border border-slate-700/50 group">
                <div class="w-10 h-10 bg-slate-900 rounded-lg flex items-center justify-center text-slate-500 mb-3 group-hover:text-indigo-400 shadow-sm border border-slate-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-400 group-hover:text-white tracking-wide">Registrasi Alumni</span>
            </a>
            <a href="{{ route('alumni.master') }}" class="p-5 bg-slate-800/40 rounded-xl hover:bg-slate-800 transition-all border border-slate-700/50 group">
                <div class="w-10 h-10 bg-slate-900 rounded-lg flex items-center justify-center text-slate-500 mb-3 group-hover:text-emerald-400 shadow-sm border border-slate-800">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                    </svg>
                </div>
                <span class="text-xs font-bold text-slate-400 group-hover:text-white tracking-wide">Lihat Data Master</span>
            </a>
        </div>
    </div>
</div>
@endsection
