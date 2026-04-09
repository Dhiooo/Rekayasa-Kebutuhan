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

@if($alumni->status == 'Perlu Verifikasi Manual')
    <!-- Verification Alert Banner -->
    <div class="mb-8 p-6 bg-indigo-600/10 border border-indigo-500/30 rounded-2xl backdrop-blur-sm flex flex-col md:flex-row items-center justify-between shadow-2xl shadow-indigo-500/5 animate-fade-in">
        <div class="flex items-center space-x-5 mb-4 md:mb-0">
            <div class="w-12 h-12 bg-indigo-500/20 rounded-xl flex items-center justify-center text-indigo-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <h4 class="text-white font-bold">Verifikasi Identitas Diperlukan</h4>
                <p class="text-indigo-400/80 text-xs font-medium">Algoritma telah menemukan jejak digital, mohon tinjau data di bawah sebelum memvalidasi.</p>
            </div>
        </div>
        <div class="flex items-center space-x-3 w-full md:w-auto">
            <form action="{{ route('alumni.verify', $alumni->id) }}" method="POST" class="flex-1 md:flex-initial">
                @csrf
                <input type="hidden" name="action" value="valid">
                <button type="submit" class="w-full bg-emerald-500 hover:bg-emerald-600 text-white px-8 py-2.5 rounded-xl font-bold text-sm shadow-lg shadow-emerald-500/20 transition-all flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>ACC Data</span>
                </button>
            </form>
            <form action="{{ route('alumni.verify', $alumni->id) }}" method="POST" class="flex-1 md:flex-initial">
                @csrf
                <input type="hidden" name="action" value="reject">
                <button type="submit" class="w-full bg-rose-500/10 hover:bg-rose-500 text-rose-500 hover:text-white px-8 py-2.5 rounded-xl font-bold text-sm border border-rose-500/20 transition-all">
                    Tolak
                </button>
            </form>
        </div>
    </div>
@endif

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
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-[0.2em] mb-8">Jejak Digital & Profesional</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Contact & Socials -->
                <div class="space-y-6">
                    <div>
                        <label class="text-[10px] font-bold text-slate-600 uppercase tracking-widest block mb-3">Media Sosial</label>
                        <div class="flex flex-wrap gap-3">
                            @if($alumni->linkedin_url)
                                <a href="{{ $alumni->linkedin_url }}" target="_blank" class="w-10 h-10 bg-blue-500/10 border border-blue-500/20 rounded-xl flex items-center justify-center text-blue-400 hover:bg-blue-500 hover:text-white transition-all shadow-lg shadow-blue-500/10" title="LinkedIn">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.238 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                                </a>
                            @endif
                            @if($alumni->instagram_url)
                                <a href="{{ $alumni->instagram_url }}" target="_blank" class="w-10 h-10 bg-pink-500/10 border border-pink-500/20 rounded-xl flex items-center justify-center text-pink-400 hover:bg-pink-500 hover:text-white transition-all shadow-lg shadow-pink-500/10" title="Instagram">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="2" width="20" h="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                                </a>
                            @endif
                            @if($alumni->facebook_url)
                                <a href="{{ $alumni->facebook_url }}" target="_blank" class="w-10 h-10 bg-blue-600/10 border border-blue-600/20 rounded-xl flex items-center justify-center text-blue-500 hover:bg-blue-600 hover:text-white transition-all shadow-lg shadow-blue-600/10" title="Facebook">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path></svg>
                                </a>
                            @endif
                            @if($alumni->tiktok_url)
                                <a href="{{ $alumni->tiktok_url }}" target="_blank" class="w-10 h-10 bg-slate-200/10 border border-slate-200/20 rounded-xl flex items-center justify-center text-white hover:bg-white hover:text-black transition-all" title="TikTok">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.17-2.89-.6-4.13-1.47-.13-.08-.24-.17-.35-.25v4.51c.01 1.52-.17 3.07-.85 4.42-1.37 2.77-4.53 4.36-7.53 3.94-3.01-.42-5.46-2.91-5.91-5.91-.45-3.02 1.17-6.2 3.95-7.53 1.35-.65 2.89-.83 4.37-.82V8.4c-1.39-.14-2.88.24-3.92 1.25-.97 1.01-1.32 2.54-.92 3.86.4 1.33 1.53 2.37 2.87 2.72 1.36.36 2.88-.13 3.73-1.25.68-.88.89-2.06.88-3.17V.02z"/></svg>
                                </a>
                            @endif
                            @if($alumni->youtube_url)
                                <a href="{{ $alumni->youtube_url }}" target="_blank" class="w-10 h-10 bg-rose-600/10 border border-rose-600/20 rounded-xl flex items-center justify-center text-rose-500 hover:bg-rose-600 hover:text-white transition-all shadow-lg shadow-rose-600/10" title="YouTube">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="text-[10px] font-bold text-slate-600 uppercase tracking-widest block mb-1">Email</label>
                            <p class="text-sm font-bold text-white">{{ $alumni->email ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <label class="text-[10px] font-bold text-slate-600 uppercase tracking-widest block mb-1">No. WhatsApp / HP</label>
                            <p class="text-sm font-bold text-white">{{ $alumni->phone ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Career Info -->
                <div class="space-y-6">
                    <div class="p-5 bg-indigo-500/5 border border-indigo-500/10 rounded-2xl">
                        <label class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest block mb-4">Informasi Karir</label>
                        <div class="space-y-4">
                            <div>
                                <label class="text-[9px] font-bold text-slate-600 uppercase block mb-1">Tempat Bekerja</label>
                                <p class="text-sm font-bold text-white leading-tight">{{ $alumni->workplace ?? 'Belum terdeteksi' }}</p>
                            </div>
                            <div>
                                <label class="text-[9px] font-bold text-slate-600 uppercase block mb-1">Posisi / Jabatan</label>
                                <p class="text-sm font-medium text-slate-300">{{ $alumni->job_position ?? '-' }}</p>
                            </div>
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <label class="text-[9px] font-bold text-slate-600 uppercase block mb-1">Status Pekerjaan</label>
                                    <span class="inline-block px-2 py-0.5 bg-slate-800 text-[10px] font-bold text-slate-400 rounded border border-slate-700">
                                        {{ $alumni->employment_type ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Digital Evidence Section -->
            <div class="mt-8 pt-8 border-t border-slate-800/50">
                <label class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest block mb-4">Bukti Jejak Digital (Postingan/Video Mentions)</label>
                @if($alumni->social_evidence && count($alumni->social_evidence) > 0)
                    <div class="space-y-3">
                        @foreach($alumni->social_evidence as $evidence)
                            <div class="flex items-center justify-between p-3 bg-slate-800/20 rounded-xl border border-slate-700/20 hover:border-indigo-500/30 transition-all group">
                                <div class="flex items-center space-x-3 overflow-hidden">
                                    <div class="w-8 h-8 rounded-lg bg-slate-700/50 flex items-center justify-center flex-shrink-0">
                                        @if(Str::contains($evidence, 'instagram.com'))
                                            <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        @elseif(Str::contains($evidence, 'youtube.com') || Str::contains($evidence, 'youtu.be'))
                                            <svg class="w-4 h-4 text-rose-500" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                        @else
                                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                        @endif
                                    </div>
                                    <span class="text-[10px] font-medium text-slate-400 truncate">{{ $evidence }}</span>
                                </div>
                                <a href="{{ $evidence }}" target="_blank" class="text-indigo-400 hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-xs text-slate-600 italic">Tidak ada postingan atau video spesifik yang terekam sebagai bukti pendukung.</p>
                @endif
            </div>

            <div class="mt-8 pt-8 border-t border-slate-800/50">
                <label class="text-[10px] font-bold text-slate-600 uppercase tracking-widest block mb-3">Sumber Validasi Utama</label>
                @if($alumni->best_link)
                    <div class="flex items-center justify-between p-4 bg-slate-800/30 rounded-xl border border-slate-700/30">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-slate-700/50 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                </svg>
                            </div>
                            <span class="text-xs font-bold text-slate-300 truncate max-w-[200px] md:max-w-md">{{ $alumni->best_link }}</span>
                        </div>
                        <a href="{{ $alumni->best_link }}" target="_blank" class="text-indigo-400 hover:text-white transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                    </div>
                @else
                    <p class="text-xs text-slate-600 italic">Belum ada link sumber publik yang diverifikasi.</p>
                @endif
            </div>
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
