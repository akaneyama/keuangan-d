<x-app-layout>
    <x-slot name="header">
        Tambah Catatan Hutang/Piutang
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-[2.5rem] p-10 shadow-xl border border-slate-100 relative overflow-hidden">
            <!-- Decor -->
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>

            <form action="{{ route('debts.store') }}" method="POST" class="space-y-8 relative z-10">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Tipe Transaksi</label>
                        <select name="type" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:ring-0 focus:border-indigo-500 font-bold text-slate-900 shadow-inner cursor-pointer appearance-none" required>
                            <option value="debt">Hutang (Saya Meminjam)</option>
                            <option value="receivable">Piutang (Orang Meminjam)</option>
                        </select>
                        @error('type') <p class="mt-2 text-xs font-bold text-rose-500 ml-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Nama Orang/Entitas</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:ring-0 focus:border-indigo-500 font-bold text-slate-900 placeholder:text-slate-300 transition-all shadow-inner"
                               placeholder="Misal: Andi, Bank BRI..." required autofocus>
                        @error('name') <p class="mt-2 text-xs font-bold text-rose-500 ml-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Jumlah Nominal</label>
                    <div class="relative">
                        <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-slate-400">Rp</span>
                        <input type="number" name="amount" value="{{ old('amount') }}"
                               class="w-full pl-16 pr-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:ring-0 focus:border-indigo-500 font-bold text-slate-900 shadow-inner"
                               placeholder="0" required>
                    </div>
                    @error('amount') <p class="mt-2 text-xs font-bold text-rose-500 ml-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Jatuh Tempo (Opsional)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <input type="date" name="due_date" value="{{ old('due_date') }}"
                               class="w-full pl-16 pr-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:ring-0 focus:border-indigo-500 font-bold text-slate-700 shadow-inner">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Catatan Tambahan (Opsional)</label>
                    <textarea name="note" rows="3" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:ring-0 focus:border-indigo-500 font-bold text-slate-900 placeholder:text-slate-300 transition-all shadow-inner" placeholder="Pesan singkat atau alasan peminjaman...">{{ old('note') }}</textarea>
                </div>

                <div class="pt-6 flex flex-col sm:flex-row items-center gap-4">
                    <a href="{{ route('debts.index') }}" class="w-full sm:flex-1 px-8 py-4 border-2 border-slate-100 text-slate-400 font-black uppercase tracking-widest text-[10px] rounded-[1.2rem] hover:bg-slate-50 hover:text-slate-600 transition-all text-center">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:flex-[2] px-8 py-4 bg-slate-900 text-white font-black uppercase tracking-widest text-[10px] rounded-[1.2rem] hover:bg-indigo-600 transition-all shadow-xl shadow-slate-900/10 active:scale-95 group flex items-center justify-center gap-2">
                        Simpan Catatan
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
