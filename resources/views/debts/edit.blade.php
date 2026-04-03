<x-app-layout>
    <x-slot name="header">
        Edit Catatan: {{ $debt->name }}
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-[1.5rem] md:rounded-[2.5rem] p-6 md:p-10 shadow-xl border border-slate-100 relative overflow-hidden">
            <!-- Decor -->
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>

            <form action="{{ route('debts.update', $debt) }}" method="POST" class="space-y-6 md:space-y-8 relative z-10">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.1em] mb-3 ml-1">Tipe Transaksi</label>
                        <select name="type" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.2rem] md:rounded-[1.5rem] focus:ring-0 focus:border-indigo-500 font-bold text-slate-900 shadow-inner cursor-pointer appearance-none" required>
                            <option value="debt" {{ $debt->type == 'debt' ? 'selected' : '' }}>Hutang (Saya Meminjam)</option>
                            <option value="receivable" {{ $debt->type == 'receivable' ? 'selected' : '' }}>Piutang (Orang Meminjam)</option>
                        </select>
                        @error('type') <p class="mt-2 text-xs font-bold text-rose-500 ml-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.1em] mb-3 ml-1">Nama Orang/Entitas</label>
                        <input type="text" name="name" value="{{ old('name', $debt->name) }}"
                               class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.2rem] md:rounded-[1.5rem] focus:ring-0 focus:border-indigo-500 font-bold text-slate-900 placeholder:text-slate-300 transition-all shadow-inner"
                               placeholder="Misal: Andi, Bank BRI..." required>
                        @error('name') <p class="mt-2 text-xs font-bold text-rose-500 ml-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.1em] mb-3 ml-1">Jumlah Nominal</label>
                    <div class="relative">
                        <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-slate-400">Rp</span>
                        <input type="number" name="amount" value="{{ old('amount', (float)$debt->amount) }}"
                               class="w-full pl-16 pr-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.2rem] md:rounded-[1.5rem] focus:ring-0 focus:border-indigo-500 font-bold text-slate-900 shadow-inner"
                               placeholder="0" required>
                    </div>
                    @error('amount') <p class="mt-2 text-xs font-bold text-rose-500 ml-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.1em] mb-3 ml-1">Status Pembayaran</label>
                        <div class="flex gap-2">
                            <label class="flex-1 cursor-pointer group">
                                <input type="radio" name="status" value="unpaid" class="sr-only peer" {{ old('status', $debt->status) == 'unpaid' ? 'checked' : '' }}>
                                <div class="py-3 bg-slate-50 rounded-xl border-2 border-transparent peer-checked:border-amber-500 peer-checked:bg-amber-50 text-center transition-all">
                                    <span class="text-[10px] font-black uppercase text-slate-500 peer-checked:text-amber-600">Terbuka</span>
                                </div>
                            </label>
                            <label class="flex-1 cursor-pointer group">
                                <input type="radio" name="status" value="paid" class="sr-only peer" {{ old('status', $debt->status) == 'paid' ? 'checked' : '' }}>
                                <div class="py-3 bg-slate-50 rounded-xl border-2 border-transparent peer-checked:border-emerald-500 peer-checked:bg-emerald-50 text-center transition-all">
                                    <span class="text-[10px] font-black uppercase text-slate-500 peer-checked:text-emerald-600">Lunas</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.1em] mb-3 ml-1">Jatuh Tempo</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none">
                                <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                            <input type="date" name="due_date" value="{{ old('due_date', $debt->due_date ? $debt->due_date->format('Y-m-d') : '') }}"
                                   class="w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.2rem] md:rounded-[1.5rem] focus:ring-0 focus:border-indigo-500 font-bold text-slate-700 shadow-inner">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.1em] mb-3 ml-1">Catatan Tambahan (Opsional)</label>
                    <textarea name="note" rows="3" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.2rem] md:rounded-[1.5rem] focus:ring-0 focus:border-indigo-500 font-bold text-slate-900 placeholder:text-slate-300 transition-all shadow-inner" placeholder="Pesan singkat jika diperlukan...">{{ old('note', $debt->note) }}</textarea>
                </div>

                <div class="pt-6 flex flex-col sm:flex-row items-center gap-4">
                    <a href="{{ route('debts.index') }}" class="w-full sm:flex-1 px-8 py-4 border-2 border-slate-100 text-slate-400 font-black uppercase tracking-widest text-[10px] rounded-[1.2rem] hover:bg-slate-50 hover:text-slate-600 transition-all text-center">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:flex-[2] px-8 py-4 bg-indigo-600 text-white font-black uppercase tracking-widest text-[10px] rounded-[1.2rem] hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/20 active:scale-95 group flex items-center justify-center gap-2">
                        Perbarui Catatan
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
