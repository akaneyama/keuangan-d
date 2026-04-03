<x-app-layout>
    <x-slot name="header">
        Manajemen Kategori
    </x-slot>

    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-10 gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Kategori Transaksi</h2>
            <p class="text-sm text-slate-500 mt-1 font-medium italic">"Kelola pengelompokan keuanganmu agar lebih teratur."</p>
        </div>
        <a href="{{ route('categories.create') }}" class="group inline-flex items-center justify-center px-6 py-3.5 bg-indigo-600 border border-transparent rounded-[1.2rem] font-bold text-xs text-white transition-all hover:bg-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-500/20 shadow-xl shadow-indigo-600/20 active:scale-95 uppercase tracking-widest">
            <svg class="w-4 h-4 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Tambah Kategori Baru
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-6 mb-8">
        <form method="GET" action="{{ route('categories.index') }}" class="flex flex-col md:flex-row gap-4 items-center">
            <div class="relative flex-1 w-full">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama kategori..." class="block w-full pl-11 pr-4 py-3.5 bg-slate-50 border-transparent rounded-2xl text-sm font-semibold text-slate-900 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all placeholder:text-slate-400">
            </div>

            <div class="w-full md:w-48">
                <select name="type" class="block w-full px-4 py-3.5 bg-slate-50 border-transparent rounded-2xl text-sm font-bold uppercase tracking-widest text-slate-700 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all cursor-pointer">
                    <option value="">Semua Tipe</option>
                    <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                </select>
            </div>

            <div class="flex items-center gap-2 w-full md:w-auto">
                <button type="submit" class="flex-1 md:flex-none px-6 py-3.5 bg-slate-900 text-white rounded-2xl text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg active:scale-95">
                    Filter
                </button>
                @if(request()->hasAny(['search', 'type']))
                    <a href="{{ route('categories.index') }}" class="p-3.5 bg-slate-100 text-slate-500 rounded-2xl hover:bg-rose-50 hover:text-rose-600 transition-all group" title="Hapus Filter">
                        <svg class="h-5 w-5 group-hover:rotate-90 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-900/5 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100/50 italic">Nama Kategori</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100/50 italic">Tipe Transaksi</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] border-b border-slate-100/50 text-right italic">Aksi Manajemen</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/50">
                    @forelse($categories as $category)
                    <tr class="hover:bg-indigo-50/30 transition-all duration-300 group">
                        <td class="px-8 py-5">
                            <div class="flex items-center">
                                <div class="w-11 h-11 rounded-2xl flex items-center justify-center mr-4 transform group-hover:scale-110 group-hover:rotate-3 transition-transform duration-500 {{ $category->type == 'income' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100 shadow-sm shadow-emerald-500/5' : 'bg-rose-50 text-rose-600 border border-rose-100 shadow-sm shadow-rose-500/5' }}">
                                    @if($category->type == 'income')
                                        <svg class="w-5 h-5 leading-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                                    @else
                                        <svg class="w-5 h-5 leading-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"></path></svg>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-sm font-black text-slate-900 group-hover:text-indigo-600 transition-colors">{{ $category->name }}</h4>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">Dibuat {{ $category->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-8 py-5">
                            <span class="inline-flex items-center px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest border {{ $category->type == 'income' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-rose-50 text-rose-700 border-rose-200' }} animate-pulse-slow">
                                <span class="w-1.5 h-1.5 rounded-full mr-2 {{ $category->type == 'income' ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                {{ $category->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                            </span>
                        </td>
                        
                        <td class="px-8 py-5 text-right">
                            <div class="flex justify-end gap-3 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-all transform translate-x-2 sm:group-hover:translate-x-0 duration-300">
                                <a href="{{ route('categories.edit', $category) }}" class="w-9 h-9 flex items-center justify-center text-slate-400 hover:text-indigo-600 hover:bg-white border border-transparent hover:border-indigo-100 rounded-xl transition-all shadow-none hover:shadow-lg hover:shadow-indigo-500/10" title="Edit Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path></svg>
                                </a>
                                <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Data pemasukan/pengeluaran sebelumnya akan tetap ada namun kategori menjadi anonim.');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="w-9 h-9 flex items-center justify-center text-slate-400 hover:text-rose-600 hover:bg-white border border-transparent hover:border-rose-100 rounded-xl transition-all shadow-none hover:shadow-lg hover:shadow-rose-500/10" title="Hapus Permanen">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-8 py-20 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-24 h-24 bg-slate-50 text-indigo-100 rounded-full flex items-center justify-center mb-6 shadow-inner animate-pulse">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <h3 class="text-lg font-black text-slate-900 mb-1">Data Tidak Ditemukan</h3>
                                <p class="text-sm text-slate-500 mb-8 font-medium italic">"Mungkin kunci pencarianmu kurang tepat?"</p>
                                <a href="{{ route('categories.index') }}" class="px-6 py-3 bg-indigo-50 text-indigo-600 rounded-2xl text-[10px] font-bold uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all shadow-sm">Reset Filter</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($categories->hasPages())
        <div class="px-8 py-6 border-t border-slate-100/50 bg-slate-50/30">
            {{ $categories->links() }}
        </div>
        @endif
    </div>

    <style>
        .animate-pulse-slow {
            animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
    </style>
</x-app-layout>