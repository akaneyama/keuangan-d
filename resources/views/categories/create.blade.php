<x-app-layout>
    <x-slot name="header">
        Tambah Kategori baru
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-[2.5rem] p-10 shadow-xl border border-slate-100 relative overflow-hidden">
            <!-- Decor -->
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>

            <form action="{{ route('categories.store') }}" method="POST" class="space-y-8 relative z-10">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Nama Kategori</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                           class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:ring-0 focus:border-indigo-500 font-bold text-slate-900 placeholder:text-slate-300 transition-all shadow-inner"
                           placeholder="Misal: Makanan, Gaji, Transportasi..." required autofocus>
                    @error('name') <p class="mt-2 text-xs font-bold text-rose-500 ml-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Tipe Kategori</label>
                    <div class="grid grid-cols-2 gap-6">
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="type" value="income" class="sr-only peer" {{ old('type') == 'income' ? 'checked' : '' }}>
                            <div class="p-6 bg-slate-50 rounded-[1.8rem] border-2 border-transparent peer-checked:border-emerald-500 peer-checked:bg-emerald-50/50 transition-all text-center group-hover:bg-slate-100 shadow-sm">
                                <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-3 text-emerald-600 group-hover:scale-110 transition-transform">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" /></svg>
                                </div>
                                <span class="text-xs font-black uppercase tracking-widest text-slate-600">Pemasukan</span>
                            </div>
                        </label>

                        <label class="relative cursor-pointer group">
                            <input type="radio" name="type" value="expense" class="sr-only peer" {{ old('type', 'expense') == 'expense' ? 'checked' : '' }}>
                            <div class="p-6 bg-slate-50 rounded-[1.8rem] border-2 border-transparent peer-checked:border-rose-500 peer-checked:bg-rose-50/50 transition-all text-center group-hover:bg-slate-100 shadow-sm">
                                <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-3 text-rose-600 group-hover:scale-110 transition-transform">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4" /></svg>
                                </div>
                                <span class="text-xs font-black uppercase tracking-widest text-slate-600">Pengeluaran</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="pt-6 flex flex-col sm:flex-row items-center gap-4">
                    <a href="{{ route('categories.index') }}" class="w-full sm:flex-1 px-8 py-4 border-2 border-slate-100 text-slate-400 font-black uppercase tracking-widest text-[10px] rounded-[1.2rem] hover:bg-slate-50 hover:text-slate-600 transition-all text-center">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:flex-[2] px-8 py-4 bg-indigo-600 text-white font-black uppercase tracking-widest text-[10px] rounded-[1.2rem] hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/20 active:scale-95 group flex items-center justify-center gap-2">
                        Simpan Kategori
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
