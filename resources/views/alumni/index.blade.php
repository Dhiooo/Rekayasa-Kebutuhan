@extends('layouts.app')

@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="text-2xl font-bold font-outfit text-white">Master Data Alumni</h1>
        <p class="text-slate-400 text-sm mt-1 font-medium italic">Pusat pengelolaan identitas alumni yang terdaftar di sistem.</p>
    </div>
    <div class="flex items-center space-x-3">
        <form action="{{ route('alumni.master') }}" method="GET" class="relative group">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau prodi..." class="bg-slate-900 border border-slate-800 text-slate-200 text-xs rounded-lg pl-9 pr-4 py-2.5 w-64 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none transition-all placeholder:text-slate-600 font-medium">
            <div class="absolute left-3 top-2.5 text-slate-600 group-focus-within:text-indigo-400 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </form>
        <a href="{{ route('alumni.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg font-bold text-sm shadow-lg shadow-indigo-600/20 transition-all flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            <span>Tambah Alumni</span>
        </a>
    </div>
</div>

<div class="bg-slate-900/50 rounded-xl shadow-premium border border-slate-800 overflow-hidden backdrop-blur-md">
    <div class="p-6 border-b border-slate-800 flex items-center justify-between bg-slate-900/40">
        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">Tabel Database Alumni</h3>
        <div class="flex items-center text-[10px] text-slate-600 font-bold uppercase tracking-widest">
            <span>Total: {{ count($alumnis) }} Entri</span>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-900/80">
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] border-b border-slate-800">Alumni</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] border-b border-slate-800">Program Studi</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] border-b border-slate-800 text-center">Tahun Lulus</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] border-b border-slate-800">Status Terakhir</th>
                    <th class="px-6 py-4 text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em] border-b border-slate-800 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-800/50">
                @forelse ($alumnis as $alumni)
                    <tr class="hover:bg-slate-800/30 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-xl bg-slate-800 flex items-center justify-center text-[11px] font-bold text-slate-400 border border-slate-700 group-hover:border-indigo-500/50 transition-colors group-hover:text-indigo-400">
                                    {{ substr($alumni->name, 0, 1) }}
                                </div>
                                <div>
                                    <a href="{{ route('alumni.show', $alumni->id) }}" class="text-sm font-bold text-slate-200 hover:text-indigo-400 transition-colors">
                                        {{ $alumni->name }}
                                    </a>
                                    <p class="text-[9px] text-slate-600 font-bold uppercase mt-0.5 tracking-tighter">ID #{{ str_pad($alumni->id, 5, '0', STR_PAD_LEFT) }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-slate-400">
                            {{ $alumni->study_program }}
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-slate-500 text-center">
                            {{ $alumni->graduation_year }}
                        </td>
                        <td class="px-6 py-4 text-xs font-bold uppercase tracking-wider">
                            @if($alumni->status == 'Teridentifikasi (Scholar/Web)' || $alumni->status == 'Teridentifikasi (Professional Social Media)')
                                <span class="bg-emerald-500/10 text-emerald-400 px-3 py-1 rounded-lg border border-emerald-500/20 flex items-center w-fit space-x-1.5 backdrop-blur-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shadow-[0_0_8px_rgba(16,185,129,0.5)]"></span>
                                    <span>Tervalidasi</span>
                                </span>
                            @elseif($alumni->status == 'Perlu Verifikasi Manual')
                                <span class="bg-amber-500/10 text-amber-400 px-3 py-1 rounded-lg border border-amber-500/20 flex items-center w-fit space-x-1.5 backdrop-blur-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 shadow-[0_0_8px_rgba(245,158,11,0.5)]"></span>
                                    <span>Butuh Review</span>
                                </span>
                            @else
                                <span class="bg-slate-800/50 text-slate-500 px-3 py-1 rounded-lg border border-slate-700 flex items-center w-fit space-x-1.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-slate-600"></span>
                                    <span>{{ $alumni->status }}</span>
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end space-x-1">
                                <form action="{{ route('alumni.track', $alumni->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="p-2 text-slate-500 hover:text-indigo-400 transition-all hover:bg-slate-800 rounded-lg" title="Lacak Sekarang">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </button>
                                </form>
                                <a href="{{ route('alumni.show', $alumni->id) }}" class="p-2 text-slate-500 hover:text-indigo-400 transition-all hover:bg-slate-800 rounded-lg" title="Lihat Profil">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('alumni.edit', $alumni->id) }}" class="p-2 text-slate-500 hover:text-blue-400 transition-all hover:bg-slate-800 rounded-lg" title="Edit Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>
                                <form action="{{ route('alumni.destroy', $alumni->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data alumni: {{ $alumni->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-500 hover:text-red-400 transition-all hover:bg-slate-800 rounded-lg" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-600 text-sm font-medium italic">
                            Belum ada data alumni yang terdaftar.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
