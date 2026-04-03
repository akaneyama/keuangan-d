<x-app-layout>
    <x-slot name="header">
        Pemasukan
    </x-slot>

    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-10 gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Daftar Pemasukan</h2>
            <p class="text-sm text-slate-500 mt-1 font-medium italic">"Catat setiap sen yang masuk untuk melacak pertumbuhan kekayaanmu."</p>
        </div>
        <a href="{{ route('incomes.create') }}" class="group inline-flex items-center justify-center px-6 py-3.5 bg-emerald-600 border border-transparent rounded-[1.2rem] font-bold text-xs text-white transition-all hover:bg-emerald-700 focus:outline-none focus:ring-4 focus:ring-emerald-500/20 shadow-xl shadow-emerald-600/20 active:scale-95 uppercase tracking-widest">
            <svg class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Catat Pemasukan
        </a>
    </div>

    <!-- Advanced Filter Bar -->
    <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-8 mb-8">
        <form method="GET" action="{{ route('incomes.index') }}" class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="relative w-full">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Pencarian</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Deskripsi atau jumlah..." class="block w-full pl-11 pr-4 py-3 bg-slate-50 border-transparent rounded-2xl text-sm font-semibold text-slate-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Kategori</label>
                    <select name="category_id" class="block w-full px-4 py-3 bg-slate-50 border-transparent rounded-2xl text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all cursor-pointer capitalize">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range -->
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Mulai Tanggal</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="block w-full px-4 py-3 bg-slate-50 border-transparent rounded-2xl text-sm font-semibold text-slate-700 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                </div>
                <div class="md:col-span-1">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Hingga Tanggal</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="block w-full px-4 py-3 bg-slate-50 border-transparent rounded-2xl text-sm font-semibold text-slate-700 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all">
                </div>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center pt-2 gap-4 border-t border-slate-50 mt-2">
                <div class="flex items-center gap-4 w-full md:w-auto">
                    <button type="submit" class="flex-1 md:flex-none px-10 py-3.5 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg active:scale-95">
                        Terapkan Filter
                    </button>
                    @if(request()->hasAny(['search', 'category_id', 'start_date', 'end_date']))
                        <a href="{{ route('incomes.index') }}" class="flex items-center gap-2 px-5 py-3.5 bg-slate-100 text-slate-500 rounded-2xl text-xs font-bold uppercase tracking-widest hover:bg-rose-50 hover:text-rose-600 transition-all group">
                            <svg class="h-4 w-4 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                            Reset
                        </a>
                    @endif
                </div>
                
                <div class="flex gap-4">
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Ditampilkan</span>
                        <span class="text-lg font-black text-emerald-600">Rp {{ number_format($incomes->sum('amount'), 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-900/5 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100/50 italic">Informasi Transaksi</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100/50 italic">Kategori</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100/50 italic">Dompet</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100/50 italic">Jumlah</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100/50 text-right italic">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/50">
                    @forelse($incomes as $income)
                    <tr class="hover:bg-indigo-50/30 transition-all duration-300 group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl bg-slate-50 border border-slate-100 flex flex-col items-center justify-center text-slate-500 group-hover:bg-white group-hover:border-indigo-100 group-hover:text-indigo-600 transition-all shadow-sm">
                                    <span class="text-[10px] font-black uppercase leading-tight tracking-tighter">{{ $income->date->format('M') }}</span>
                                    <span class="text-base font-black leading-tight">{{ $income->date->format('d') }}</span>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $income->description ?: 'Tanpa keterangan' }}</h4>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $income->date->format('Y') }} • {{ $income->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-8 py-6">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest bg-indigo-50 text-indigo-700 border border-indigo-100">
                                {{ $income->category->name }}
                            </span>
                        </td>

                        <td class="px-8 py-6">
                            <span class="text-xs font-bold text-slate-500 italic">{{ $income->account->name ?? 'Default' }}</span>
                        </td>

                        <td class="px-8 py-6">
                            <div class="text-base font-black text-emerald-600">
                                Rp {{ number_format($income->amount, 0, ',', '.') }}
                            </div>
                        </td>
                        
                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-3 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-all transform translate-x-2 sm:group-hover:translate-x-0">
                                <a href="{{ route('incomes.edit', $income) }}" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-white border border-transparent hover:border-indigo-100 rounded-xl transition-all shadow-none hover:shadow-lg hover:shadow-indigo-500/10" title="Edit Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path></svg>
                                </a>
                                <form action="{{ route('incomes.destroy', $income) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus permanen data pemasukan ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-10 h-10 flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-white border border-transparent hover:border-rose-100 rounded-xl transition-all shadow-none hover:shadow-lg hover:shadow-rose-500/10" title="Hapus Permanen">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-8 py-24 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-24 h-24 bg-slate-50 text-indigo-100 rounded-full flex items-center justify-center mb-6 shadow-inner">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <h3 class="text-lg font-black text-slate-900 mb-1">Tidak Ada Pemasukan</h3>
                                <p class="text-sm text-slate-500 mb-8 font-medium italic">"Mungkin perlu menyesuaikan filter pencarianmu?"</p>
                                <a href="{{ route('incomes.index') }}" class="px-6 py-3 bg-indigo-50 text-indigo-600 rounded-2xl text-[10px] font-bold uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all shadow-sm">Reset Filter</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($incomes->hasPages())
        <div class="px-8 py-6 border-t border-slate-100/50 bg-slate-50/30">
            {{ $incomes->links() }}
        </div>
        @endif
    </div>
</x-app-layout>
