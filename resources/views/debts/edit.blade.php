<x-app-layout>
    <x-slot name="header">
        Edit Catatan Hutang/Piutang
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-[2.5rem] p-10 shadow-xl border border-slate-100 italic">
            <form action="{{ route('debts.update', $debt) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tipe Transaksi</label>
                        <select name="type" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" required>
                            <option value="debt" {{ $debt->type == 'debt' ? 'selected' : '' }}>Saya Meminjam (Hutang)</option>
                            <option value="receivable" {{ $debt->type == 'receivable' ? 'selected' : '' }}>Orang Lain Meminjam (Piutang)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Orang/Entitas</label>
                        <input type="text" name="name" value="{{ old('name', $debt->name) }}"
                               class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner"
                               placeholder="Misal: Andi, Bank BRI, dll" required>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Jumlah Nominal</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 font-black text-slate-400">Rp</span>
                        <input type="number" name="amount" value="{{ old('amount', $debt->amount) }}"
                               class="w-full pl-14 pr-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner"
                               placeholder="0" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Pilih Status</label>
                        <select name="status" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" required>
                            <option value="unpaid" {{ $debt->status == 'unpaid' ? 'selected' : '' }}>Belum Lunas (Pending)</option>
                            <option value="paid" {{ $debt->status == 'paid' ? 'selected' : '' }}>Selesai (Lunas)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Jatuh Tempo</label>
                        <input type="date" name="due_date" value="{{ old('due_date', $debt->due_date ? $debt->due_date->format('Y-m-d') : '') }}"
                               class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Catatan Tambahan (Opsional)</label>
                    <textarea name="note" rows="3" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" placeholder="Pesan singkat jika perlu">{{ old('note', $debt->note) }}</textarea>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <a href="{{ route('debts.index') }}" class="flex-1 px-6 py-4 border border-slate-200 text-slate-500 font-bold rounded-2xl hover:bg-slate-50 transition-all text-center uppercase tracking-widest text-xs">
                        Batal
                    </a>
                    <button type="submit" class="flex-[2] px-6 py-4 bg-indigo-600 text-white font-black uppercase tracking-widest text-xs rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-600/20 active:scale-95">
                        Perbarui Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
