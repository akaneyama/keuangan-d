<x-app-layout>
    <x-slot name="header">
        Target Tabungan
    </x-slot>

    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-10 gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Impian & Tabungan</h2>
            <p class="text-sm text-slate-500 mt-1 font-medium italic">"Wujudkan rencana masa depanmu dengan menabung secara konsisten."</p>
        </div>
        <a href="{{ route('savings-targets.create') }}" class="group inline-flex items-center justify-center px-6 py-3.5 bg-indigo-600 border border-transparent rounded-[1.2rem] font-bold text-xs text-white transition-all hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/20 shadow-xl shadow-indigo-600/20 active:scale-95 uppercase tracking-widest">
            <svg class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Buat Target Baru
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-6 mb-10">
        <form method="GET" action="{{ route('savings-targets.index') }}" class="flex flex-col md:flex-row gap-4 items-center">
            <div class="relative flex-1 w-full">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama impian..." class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent rounded-2xl text-sm font-semibold text-slate-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder:text-slate-400">
            </div>

            <div class="w-full md:w-56">
                <select name="status" class="block w-full px-4 py-3.5 bg-slate-50 border-transparent rounded-2xl text-sm font-bold uppercase tracking-widest text-slate-700 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Sedang Berjalan</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>

            <div class="flex items-center gap-2 w-full md:w-auto">
                <button type="submit" class="flex-1 md:flex-none px-8 py-3.5 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg active:scale-95">
                    Cari
                </button>
                @if(request()->hasAny(['search', 'status']))
                    <a href="{{ route('savings-targets.index') }}" class="p-3.5 bg-slate-100 text-slate-500 rounded-2xl hover:bg-rose-50 hover:text-rose-600 transition-all group" title="Hapus Filter">
                        <svg class="h-5 w-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($targets as $target)
            @php
                $percentage = $target->target_amount > 0 ? min(100, ($target->current_amount / $target->target_amount) * 100) : 0;
                $isCompleted = $target->status == 'completed';
            @endphp
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-8 flex flex-col group hover:-translate-y-2 transition-all duration-300 relative overflow-hidden">
                @if($isCompleted)
                    <div class="absolute -right-10 -top-10 w-32 h-32 bg-emerald-50 rounded-full flex items-end justify-center pb-6 transform rotate-45 border border-emerald-100">
                        <svg class="w-6 h-6 text-emerald-500 -rotate-45" fill="currentColor" viewBox="0 0 24 24"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg>
                    </div>
                @endif

                <div class="flex justify-between items-start mb-6">
                    <div class="p-4 rounded-2xl {{ $isCompleted ? 'bg-emerald-50 text-emerald-600' : 'bg-indigo-50 text-indigo-600' }} shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $isCompleted ? 'bg-emerald-100 text-emerald-700' : 'bg-indigo-100 text-indigo-700' }}">
                        {{ $isCompleted ? 'Tuntas' : 'Berjalan' }}
                    </span>
                </div>

                <h4 class="text-xl font-black text-slate-900 mb-2 group-hover:text-indigo-600 transition-colors uppercase tracking-tight">{{ $target->name }}</h4>
                <div class="flex items-center gap-2 mb-6">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    <span class="text-[10px] text-slate-400 font-bold uppercase tracking-widest italic">
                        {{ $target->deadline ? 'Deadline: ' . $target->deadline->format('d M Y') : 'Tanpa Batas Waktu' }}
                    </span>
                </div>

                <div class="space-y-4 mb-8">
                    <div class="flex justify-between items-end">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Terkumpul</span>
                        <div class="text-right">
                            <span class="text-xs font-black text-slate-900">Rp {{ number_format($target->current_amount, 0, ',', '.') }}</span>
                            <span class="text-[10px] text-slate-400 font-bold mx-1">/</span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Rp {{ number_format($target->target_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    
                    <div class="w-full h-3.5 bg-slate-50 rounded-full overflow-hidden p-0.5 border border-slate-100 shadow-inner">
                        <div class="h-full rounded-full transition-all duration-1000 ease-out {{ $isCompleted ? 'bg-emerald-500 shadow-lg shadow-emerald-500/20' : 'bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-400 shadow-lg shadow-indigo-500/20' }} relative" style="width: {{ $percentage }}%">
                            <div class="absolute inset-0 bg-white/20 animate-shimmer"></div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-[10px] font-black text-slate-600">{{ number_format($percentage, 1) }}% Tercapai</span>
                        <span class="text-[10px] font-bold text-slate-400 italic">Rp {{ number_format($target->target_amount - $target->current_amount, 0, ',', '.') }} lagi</span>
                    </div>
                </div>
                
                <div class="mt-auto">
                    <a href="{{ route('savings-targets.show', $target) }}" class="flex items-center justify-center gap-2 w-full py-4 bg-slate-900 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-indigo-600 transition-all shadow-lg active:scale-[0.98] group-hover:shadow-indigo-600/20 group/btn">
                        Detail & Setor
                        <svg class="w-3 h-3 transform group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6" /></svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 bg-white rounded-[2.5rem] shadow-xl shadow-slate-900/5 border border-slate-100 flex flex-col items-center text-center">
                <div class="w-24 h-24 bg-slate-50 text-indigo-100 rounded-full flex items-center justify-center mb-6 shadow-inner animate-pulse">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                </div>
                <h3 class="text-xl font-black text-slate-900 mb-2">Mulai Langkah Pertamamu</h3>
                <p class="text-sm text-slate-500 mb-10 max-w-sm font-medium italic">"Masa depan dimulai dari apa yang kamu tabung hari ini. Buat target impianmu sekarang!"</p>
                <a href="{{ route('savings-targets.create') }}" class="px-8 py-4 bg-indigo-600 text-white rounded-[1.2rem] text-xs font-black uppercase tracking-widest hover:bg-slate-900 transition-all shadow-xl shadow-indigo-600/20 active:scale-95">Buat Target Pertama</a>
            </div>
        @endforelse
    </div>

    <div class="mt-10">
        {{ $targets->links() }}
    </div>

    <style>
        @keyframes shimmer {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .animate-shimmer {
            animation: shimmer 2s infinite ease-in-out;
        }
    </style>
</x-app-layout>
