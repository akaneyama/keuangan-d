<x-app-layout>
    <x-slot name="header">
        Edit Pemasukan: {{ $income->description ?: 'Tanpa Deskripsi' }}
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-3xl p-8 shadow-xl border border-slate-100 relative overflow-hidden">
             <!-- Decor -->
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-emerald-50 rounded-full blur-3xl opacity-50"></div>

            <form action="{{ route('incomes.update', $income) }}" method="POST" enctype="multipart/form-data" class="space-y-6 relative z-10">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kategori</label>
                        <select name="category_id" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" required>
                            <option value="">-- Pilih --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $income->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id') <p class="mt-1 text-[10px] text-rose-500 font-bold ml-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Pindahkan Ke Dompet</label>
                        <select name="account_id" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" required>
                            <option value="">-- Pilih --</option>
                            @foreach($accounts as $acc)
                                <option value="{{ $acc->id }}" {{ old('account_id', $income->account_id) == $acc->id ? 'selected' : '' }}>
                                    {{ $acc->name }} (Rp {{ number_format($acc->balance, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </select>
                        @error('account_id') <p class="mt-1 text-[10px] text-rose-500 font-bold ml-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Jumlah Pemasukan</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 font-black text-slate-400">Rp</span>
                        <input type="number" name="amount" value="{{ old('amount', (float)$income->amount) }}" 
                               class="w-full pl-14 pr-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" 
                               placeholder="0" required>
                    </div>
                    @error('amount') <p class="mt-1 text-[10px] text-rose-500 font-bold ml-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tanggal</label>
                    <input type="date" name="date" value="{{ old('date', $income->date->format('Y-m-d')) }}" 
                           class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" required>
                    @error('date') <p class="mt-1 text-[10px] text-rose-500 font-bold ml-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Catatan (Opsional)</label>
                    <textarea name="description" rows="3" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" placeholder="Tulis catatan di sini...">{{ old('description', $income->description) }}</textarea>
                    @error('description') <p class="mt-1 text-[10px] text-rose-500 font-bold ml-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Lampiran Struk (Opsional)</label>
                    <div class="space-y-4">
                        <input type="file" name="receipt" accept="image/*" 
                               class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner">
                        
                        @if($income->receipt)
                            <div class="p-4 bg-indigo-50 rounded-2xl border border-indigo-100 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 rounded-xl bg-white flex items-center justify-center text-indigo-600 shadow-sm">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Struk Saat Ini</p>
                                        <a href="{{ asset('storage/' . $income->receipt) }}" target="_blank" class="text-xs font-bold text-indigo-600 hover:underline">Lihat Lampiran</a>
                                    </div>
                                </div>
                                <p class="text-[9px] font-bold text-indigo-400 italic">* Upload file baru untuk mengganti.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <a href="{{ route('incomes.index') }}" class="flex-1 px-6 py-4 border border-slate-200 text-slate-500 font-bold rounded-2xl hover:bg-slate-50 transition-all text-center text-xs uppercase tracking-widest">
                        Batal
                    </a>
                    <button type="submit" class="flex-[2] px-6 py-4 bg-emerald-600 text-white font-black rounded-2xl hover:bg-emerald-700 transition-all shadow-lg shadow-emerald-600/20 active:scale-95 text-xs uppercase tracking-widest">
                        Perbarui Pemasukan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
