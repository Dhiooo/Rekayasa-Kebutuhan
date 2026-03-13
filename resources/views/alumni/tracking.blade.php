@extends('layouts.app')

@section('content')
<div class="mb-10">
    <h1 class="text-3xl font-bold font-outfit text-white">Antrean Pelacakan</h1>
    <p class="text-slate-400 mt-2 font-medium">Monitoring proses validasi data alumni secara real-time.</p>
</div>

<!-- Tracking Stats Summary -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
    <div class="bg-slate-900/50 p-6 rounded-2xl border border-slate-800 backdrop-blur-sm">
        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Total Queue</p>
        <h4 class="text-2xl font-bold text-white">{{ count($alumnis) }}</h4>
    </div>
    <div class="bg-amber-500/5 p-6 rounded-2xl border border-amber-500/10 backdrop-blur-sm">
        <p class="text-[10px] font-bold text-amber-500/60 uppercase tracking-widest mb-2">Butuh Review</p>
        <h4 class="text-2xl font-bold text-amber-400">{{ count($alumnis->where('status', 'Perlu Verifikasi Manual')) }}</h4>
    </div>
    <div class="bg-emerald-500/5 p-6 rounded-2xl border border-emerald-500/10 backdrop-blur-sm">
        <p class="text-[10px] font-bold text-emerald-500/60 uppercase tracking-widest mb-2">Tervalidasi</p>
        <h4 class="text-2xl font-bold text-emerald-400">{{ count($alumnis->whereIn('status', ['Teridentifikasi (Scholar/Web)', 'Teridentifikasi (Professional Social Media)'])) }}</h4>
    </div>
    <div class="bg-slate-800/20 p-6 rounded-2xl border border-slate-700/50 backdrop-blur-sm">
        <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-2">Belum Dilacak</p>
        <h4 class="text-2xl font-bold text-slate-400">{{ count($alumnis->where('status', 'Belum Dilacak')) }}</h4>
    </div>
</div>

<div class="bg-slate-900/50 rounded-2xl border border-slate-800 overflow-hidden backdrop-blur-md">
    <div class="p-6 border-b border-slate-800 bg-slate-900/40 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse shadow-[0_0_8px_rgba(99,102,241,0.6)]"></div>
            <h3 class="text-sm font-bold text-slate-300 uppercase tracking-widest">Daftar Antrean</h3>
        </div>
        <form action="{{ route('alumni.trackAll') }}" method="POST">
            @csrf
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg font-bold text-xs shadow-lg shadow-indigo-600/20 transition-all flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <span>Lacak Semua</span>
            </button>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-900/80">
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] border-b border-slate-800">Alumni</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] border-b border-slate-800">Status</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] border-b border-slate-800 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50">
                @forelse ($alumnis as $alumni)
                    <tr class="hover:bg-slate-800/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-800 flex items-center justify-center text-[11px] font-bold text-slate-500 border border-slate-700 group-hover:border-indigo-500/50 transition-colors group-hover:text-indigo-400">
                                    {{ substr($alumni->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-white group-hover:text-indigo-400 transition-colors">{{ $alumni->name }}</p>
                                    <p class="text-[9px] text-slate-600 font-bold uppercase tracking-widest mt-0.5">{{ $alumni->study_program }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($alumni->status == 'Teridentifikasi (Scholar/Web)' || $alumni->status == 'Teridentifikasi (Professional Social Media)')
                                <span class="text-emerald-400 text-[10px] font-bold uppercase border border-emerald-500/20 bg-emerald-500/5 px-2.5 py-1 rounded-lg flex items-center w-fit space-x-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                                    <span>Tervalidasi</span>
                                </span>
                            @elseif($alumni->status == 'Perlu Verifikasi Manual')
                                <span class="text-amber-400 text-[10px] font-bold uppercase border border-amber-500/20 bg-amber-500/5 px-2.5 py-1 rounded-lg flex items-center w-fit space-x-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.5)]"></span>
                                    <span>Review</span>
                                </span>
                            @elseif($alumni->status == 'Gagal Lacak')
                                <span class="text-rose-400 text-[10px] font-bold uppercase border border-rose-500/20 bg-rose-500/5 px-2.5 py-1 rounded-lg flex items-center w-fit space-x-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                    <span>Gagal</span>
                                </span>
                            @else
                                <span class="text-slate-500 text-[10px] font-bold uppercase border border-slate-800 bg-slate-800/30 px-2.5 py-1 rounded-lg flex items-center w-fit space-x-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-700 animate-pulse"></span>
                                    <span>{{ $alumni->status }}</span>
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <form action="{{ route('alumni.track', $alumni->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-[10px] font-bold px-4 py-2 rounded-lg transition-all shadow-lg shadow-indigo-600/10 active:translate-y-0">
                                        Lacak
                                    </button>
                                </form>
                                @if($alumni->status == 'Perlu Verifikasi Manual')
                                    <form action="{{ route('alumni.verify', $alumni->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" name="decision" value="valid" class="text-emerald-500 bg-emerald-500/10 hover:bg-emerald-500/20 p-2 rounded-lg" title="Verifikasi">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-600 text-sm font-medium italic">
                            Belum ada data di antrean pelacakan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
