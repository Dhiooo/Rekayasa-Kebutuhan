<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pelacakan Alumni - Universitas Muhammadiyah Malang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #020617; }
        .font-outfit { font-family: 'Outfit', sans-serif; }
        .glass { background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(12px); border: 1px solid rgba(51, 65, 85, 0.5); }
        .shadow-premium { shadow: 0 10px 40px -10px rgba(0,0,0,0.3); }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #020617; }
        ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #334155; }
    </style>
</head>
<body class="text-slate-200 antialiased">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-slate-900/50 border-r border-slate-800 hidden md:flex flex-col fixed h-full z-50 backdrop-blur-xl">
            <div class="p-8 border-b border-slate-800">
                <div class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-lg shadow-indigo-600/30 group-hover:rotate-6 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-lg font-extrabold font-outfit leading-tight text-white">Alumni<span class="text-indigo-400">Portal</span></h1>
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mt-0.5">Campus Intelligence</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 p-6 space-y-8 overflow-y-auto">
                <!-- Navigasi Utama -->
                <div class="space-y-1">
                    <p class="px-4 text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em] mb-3">Navigasi Utama</p>
                    <a href="{{ route('alumni.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-xl {{ Request::is('/') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20' : 'text-slate-400 hover:bg-slate-800 hover:text-white' }} transition-all group font-medium text-sm">
                        <svg class="w-5 h-5 {{ Request::is('/') ? 'text-white' : 'text-slate-500 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        <span>Dashboard</span>
                    </a>
                </div>

                <!-- Manajemen Data -->
                <div class="space-y-1">
                    <p class="px-4 text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em] mb-3">Manajemen Alumni</p>
                    <a href="{{ route('alumni.master') }}" class="flex items-center px-6 py-3.5 space-x-4 transition-all group {{ request()->routeIs('alumni.master') ? 'bg-indigo-600/10 border-r-4 border-indigo-500 text-indigo-400' : 'text-slate-500 hover:bg-slate-800/50 hover:text-slate-300' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('alumni.master') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                        <span>Data Master Alumni</span>
                    </a>
                    <a href="{{ route('alumni.create') }}" class="flex items-center px-6 py-3.5 space-x-4 transition-all group {{ request()->routeIs('alumni.create') ? 'bg-indigo-600/10 border-r-4 border-indigo-500 text-indigo-400' : 'text-slate-500 hover:bg-slate-800/50 hover:text-slate-300' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('alumni.create') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span>Registrasi Baru</span>
                    </a>
                </div>

                <!-- Pelacakan Profesional -->
                <div class="space-y-1">
                    <p class="px-4 text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em] mb-3">Sistem Intelijen</p>
                    <a href="{{ route('alumni.tracking') }}" class="flex items-center px-6 py-3.5 space-x-4 transition-all group {{ request()->routeIs('alumni.tracking') ? 'bg-indigo-600/10 border-r-4 border-indigo-500 text-indigo-400' : 'text-slate-500 hover:bg-slate-800/50 hover:text-slate-300' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('alumni.tracking') ? 'text-indigo-400' : 'text-slate-500 group-hover:text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Pelacakan Alumni</span>
                    </a>
                </div>
            </nav>

            <div class="p-6 border-t border-slate-800 mt-auto">
                <div class="bg-slate-800/50 rounded-xl p-4 border border-slate-700">
                    <div class="flex items-center space-x-2 mb-2">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></div>
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Active Services</span>
                    </div>
                    <p class="text-[9px] text-slate-500 font-medium">Serper API & Gemini Flash 3.1</p>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 bg-[#020617] min-h-screen flex flex-col">
            <!-- Topbar -->
            <header class="h-16 bg-slate-900/80 border-b border-slate-800 flex items-center justify-between px-8 sticky top-0 z-40 backdrop-blur-md shadow-lg shadow-black/20">
                <div class="flex items-center space-x-4">
                     <span class="text-slate-500 text-xs font-bold uppercase tracking-widest">{{ date('l, d F Y') }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-xs font-bold text-slate-200 leading-none">Admin System</p>
                        <p class="text-[10px] text-emerald-500 font-bold uppercase mt-1 tracking-tighter">Authorized Portal</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-slate-800 border border-slate-700 flex items-center justify-center font-bold text-slate-400">
                        A
                    </div>
                </div>
            </header>

            <!-- Container Content -->
            <div class="p-8 pb-16 flex-1">
                @if(session('success'))
                    <div class="mb-6 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 px-6 py-4 rounded-xl shadow-sm flex items-center justify-between group">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <span class="text-sm font-bold">{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-emerald-500/50 hover:text-emerald-400 px-2 transition-colors">×</button>
                    </div>
                @endif
                
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="p-8 text-center text-slate-700 text-[10px] font-bold uppercase tracking-[0.3em]">
                &copy; {{ date('Y') }} Alumni Intelligence Portal • Universitas Muhammadiyah Malang
            </footer>
        </main>
    </div>
</body>
</html>
