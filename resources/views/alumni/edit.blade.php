@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold font-outfit text-slate-800">Edit Alumni</h1>
            <p class="text-slate-400 mt-1">Perbarui informasi data master alumni.</p>
        </div>
        <a href="{{ route('alumni.master') }}" class="p-2 text-slate-400 hover:text-indigo-600 transition-all flex items-center space-x-2 font-bold text-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span>Kembali</span>
        </a>
    </div>

    <div class="bg-white rounded-[2rem] shadow-premium border border-slate-100 p-10">
        <form action="{{ route('alumni.update', $alumni->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Nama -->
                <div class="group">
                    <label for="name" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 transition-colors group-focus-within:text-indigo-600">Nama Lengkap Alumni</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $alumni->name) }}" 
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-slate-800 font-medium placeholder:text-slate-300"
                        placeholder="Contoh: Mochammad Eriza Anwar" required>
                    @error('name')
                        <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Program Studi -->
                <div class="group">
                    <label for="study_program" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 transition-colors group-focus-within:text-indigo-600">Program Studi</label>
                    <input type="text" name="study_program" id="study_program" value="{{ old('study_program', $alumni->study_program) }}" 
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-slate-800 font-medium placeholder:text-slate-300"
                        placeholder="Contoh: Informatika" required>
                    @error('study_program')
                        <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tahun Lulus -->
                <div class="group">
                    <label for="graduation_year" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2 transition-colors group-focus-within:text-indigo-600">Tahun Kelulusan</label>
                    <input type="number" name="graduation_year" id="graduation_year" value="{{ old('graduation_year', $alumni->graduation_year) }}" 
                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all text-slate-800 font-medium"
                        required>
                    @error('graduation_year')
                        <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="pt-4 flex items-center space-x-4">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-4 rounded-2xl font-bold text-lg shadow-lg shadow-indigo-600/30 transition-all flex items-center justify-center space-x-3 group">
                    <span>Simpan Perubahan</span>
                    <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
