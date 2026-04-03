<x-app-layout>
    <x-slot name="header">
        Detail Target: {{ $savingsTarget->name }}
    </x-slot>

    @php
        $percentage = $savingsTarget->target_amount > 0 ? min(100, ($savingsTarget->current_amount / $savingsTarget->target_amount) * 100) : 0;
        $isCompleted = $savingsTarget->status == 'completed';
        $accentColor = $isCompleted ? 'emerald' : 'indigo';
    @endphp

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Target Info Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-8 sticky top-24 overflow-hidden relative group">
                <div class="absolute -right-6 -top-6 w-32 h-32 bg-{{ $accentColor }}-50 rounded-full opacity-50 group-hover:scale-150 transition-all duration-700"></div>
                
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-8">
                        <div class="p-3 bg-{{ $accentColor }}-50 text-{{ $accentColor }}-600 rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <a href="{{ route('savings-targets.edit', $savingsTarget) }}" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2-2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                    </div>

                    <div class="space-y-6">
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Target</p>
                            <span class="inline-flex px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest {{ $isCompleted ? 'bg-emerald-100 text-emerald-600' : 'bg-indigo-100 text-indigo-600' }}">
                                {{ $savingsTarget->status }}
                            </span>
                        </div>

                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Terkumpul</p>
                            <p class="text-3xl font-black text-slate-900">Rp {{ number_format($savingsTarget->current_amount, 0, ',', '.') }}</p>
                            <p class="text-[10px] font-bold text-slate-400 mt-1 italic">Dari target Rp {{ number_format($savingsTarget->target_amount, 0, ',', '.') }}</p>
                        </div>

                        <div class="pt-4 border-t border-slate-50">
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">{{ round($percentage, 1) }}% Tercapai</span>
                                <span class="text-[10px] font-black text-{{ $accentColor }}-600 uppercase tracking-[0.2em]">Sisa Rp {{ number_format(max(0, $savingsTarget->target_amount - $savingsTarget->current_amount), 0, ',', '.') }}</span>
                            </div>
                            <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden p-0.5">
                                <div class="h-full bg-{{ $accentColor }}-500 rounded-full transition-all duration-1000 shadow-sm" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>

                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tenggat Waktu</p>
                            <p class="text-sm font-bold text-slate-700">{{ $savingsTarget->deadline ? $savingsTarget->deadline->format('d F Y') : 'Kapanpun Bisa' }}</p>
                        </div>
                    </div>

                    <div class="mt-10 pt-6 border-t border-slate-50">
                        <form action="{{ route('savings-targets.destroy', $savingsTarget) }}" method="POST" onsubmit="return confirm('Hapus target ini beserta semua riwayat setorannya?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full py-4 text-[10px] font-black uppercase tracking-widest text-rose-300 hover:text-rose-600 hover:bg-rose-50 rounded-2xl transition-all">Hapus Rencana Target</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Transactions Section -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Deposit Form -->
            @if(!$isCompleted)
                <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-10">
                    <h3 class="text-xl font-black text-slate-900 mb-8 flex items-center">
                        <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center mr-3 text-sm italic">+</span>
                        Setor Tabungan
                    </h3>
                    <form action="{{ route('savings-transactions.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="savings_target_id" value="{{ $savingsTarget->id }}">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Ambil Dari Dompet</label>
                                <select name="account_id" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" required>
                                    @foreach($accounts as $acc)
                                        <option value="{{ $acc->id }}">{{ $acc->name }} (Rp {{ number_format($acc->balance, 0, ',', '.') }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tanggal</label>
                                <input type="date" name="date" value="{{ date('Y-m-d') }}" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nominal Setoran</label>
                            <div class="relative">
                                <span class="absolute left-5 top-1/2 -translate-y-1/2 font-black text-slate-400">Rp</span>
                                <input type="number" name="amount" class="w-full pl-14 pr-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" placeholder="0" required>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Catatan (Opsional)</label>
                            <input type="text" name="note" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" placeholder="Misal: Sisa uang jajan">
                        </div>

                        <button type="submit" class="w-full py-4 bg-indigo-600 text-white font-black uppercase tracking-widest rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-600/20 active:scale-95">Setorkan Sekarang</button>
                    </form>
                </div>
            @endif

            <!-- History -->
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-10">
                <h3 class="text-xl font-black text-slate-900 mb-8">Riwayat Setoran</h3>
                
                <div class="space-y-6">
                    @forelse($savingsTarget->transactions as $trx)
                        <div class="flex items-center justify-between group">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                                    +
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-900">{{ $trx->note ?: 'Setoran Tabungan' }}</h4>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                                        {{ $trx->date->format('d M Y') }} • {{ $trx->account->name ?? 'Default' }}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-6">
                                <div class="text-right">
                                    <p class="text-sm font-black text-emerald-600">Rp {{ number_format($trx->amount, 0, ',', '.') }}</p>
                                </div>
                                <form action="{{ route('savings-transactions.destroy', $trx) }}" method="POST" onsubmit="return confirm('Batalkan setoran ini?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-300 hover:text-rose-500 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest italic">Belum ada setoran masuk</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
