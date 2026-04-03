<x-app-layout>
    <x-slot name="header">
        {{ isset($expense) ? 'Edit Pengeluaran' : 'Tambah Pengeluaran' }}
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-3xl p-8 shadow-xl border border-slate-100">
            <form action="{{ isset($expense) ? route('expenses.update', $expense) : route('expenses.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @if(isset($expense)) @method('PUT') @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kategori</label>
                        <select name="category_id" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" required>
                            <option value="">-- Pilih --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $expense->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Sumber Dompet</label>
                        <select name="account_id" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" required>
                            <option value="">-- Pilih --</option>
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->id }}" {{ old('account_id', $expense->account_id ?? '') == $acc->id ? 'selected' : '' }}>
                                    {{ $acc->name }} (Rp {{ number_format($acc->balance, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="p-5 bg-indigo-50/50 rounded-2xl border border-indigo-100">
                    <label class="block text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-2 flex items-center">
                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Ambil dari Tabungan? (Opsional)
                    </label>
                    <select name="savings_target_id" class="w-full px-5 py-4 bg-white border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-sm italic">
                        <option value="">-- Tidak ambil dari tabungan --</option>
                        @foreach($savingsTargets as $target)
                            <option value="{{ $target->id }}" {{ old('savings_target_id', $expense->savings_target_id ?? '') == $target->id ? 'selected' : '' }}>
                                {{ $target->name }} (Tersedia: Rp {{ number_format($target->current_amount, 0, ',', '.') }})
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-2 text-[10px] text-indigo-400 font-medium">* Saldo target tabungan akan otomatis berkurang.</p>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Jumlah Pengeluaran</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 font-black text-slate-400">Rp</span>
                        <input type="number" name="amount" value="{{ old('amount', isset($expense) ? (float)$expense->amount : '') }}" 
                               class="w-full pl-14 pr-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" 
                               placeholder="0" required>
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tanggal</label>
                    <input type="date" name="date" value="{{ old('date', isset($expense) ? $expense->date->format('Y-m-d') : date('Y-m-d')) }}" 
                           class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" required>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Catatan (Opsional)</label>
                    <textarea name="description" rows="3" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" placeholder="Tulis catatan di sini...">{{ old('description', $expense->description ?? '') }}</textarea>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Lampiran Struk (Opsional)</label>
                    <input type="file" name="receipt" accept="image/*" 
                           class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner">
                    @if(isset($expense) && $expense->receipt)
                        <div class="mt-2 text-[10px] font-bold text-rose-600">
                            Struk saat ini: <a href="{{ asset('storage/' . $expense->receipt) }}" target="_blank" class="underline">Lihat Gambar</a>
                        </div>
                    @endif
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <a href="{{ route('expenses.index') }}" class="flex-1 px-6 py-4 border border-slate-200 text-slate-500 font-bold rounded-2xl hover:bg-slate-50 transition-all text-center">
                        Batal
                    </a>
                    <button type="submit" class="flex-[2] px-6 py-4 bg-rose-600 text-white font-bold rounded-2xl hover:bg-rose-700 transition-all shadow-lg shadow-rose-600/20 active:scale-95">
                        {{ isset($expense) ? 'Perbarui Pengeluaran' : 'Simpan Pengeluaran' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
