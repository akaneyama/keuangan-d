<x-app-layout>
    <x-slot name="header">
        Laporan Keuangan
    </x-slot>

    @php
        $monthNames = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
    @endphp

    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-10 gap-6">
        <div>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight">Analisis Laporan</h2>
            <p class="text-sm text-slate-500 mt-1 font-medium italic">"Tinjau performa keuanganmu di bulan {{ $monthNames[(int)$month] ?? '...' }} {{ $year }}."</p>
        </div>
        
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('reports.pdf', request()->all()) }}" target="_blank" class="group px-5 py-3.5 bg-rose-50 text-rose-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-rose-600 hover:text-white transition-all shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                Export PDF
            </a>
            <a href="{{ route('reports.excel', request()->all()) }}" target="_blank" class="group px-5 py-3.5 bg-emerald-50 text-emerald-600 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 2v-6m-8 13h12a2 2 0 002-2V5a2 2 0 00-2-2H9a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                Export Excel
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-8 mb-10">
        <form method="GET" action="{{ route('reports.index') }}" class="flex flex-col md:flex-row gap-6 items-end">
            <div class="w-full md:w-64">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Pilih Bulan</label>
                <select name="month" class="block w-full px-4 py-3.5 bg-slate-50 border-transparent rounded-2xl text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all cursor-pointer">
                    @foreach($monthNames as $num => $name)
                        <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="w-full md:w-48">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Pilih Tahun</label>
                <select name="year" class="block w-full px-4 py-3.5 bg-slate-50 border-transparent rounded-2xl text-sm font-bold text-slate-700 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all cursor-pointer">
                    @for($i = date('Y') - 5; $i <= date('Y') + 1; $i++)
                        <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <button type="submit" class="w-full md:w-auto px-10 py-3.5 bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg active:scale-95">
                Tampilkan Laporan
            </button>
        </form>
    </div>

    <!-- Summary Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-6 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-emerald-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
            <div class="relative z-10">
                <h3 class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Pemasukan</h3>
                <div class="text-xl font-black text-emerald-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
            </div>
        </div>
        
        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-6 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-rose-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
            <div class="relative z-10">
                <h3 class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Total Pengeluaran</h3>
                <div class="text-xl font-black text-rose-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-indigo-900/5 border border-indigo-100 p-6 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-indigo-50 rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
            <div class="relative z-10">
                <h3 class="text-[9px] font-black text-indigo-400 uppercase tracking-[0.2em] mb-2">Hutang & Piutang</h3>
                <div class="flex flex-col gap-1">
                    <div class="text-xs font-bold text-rose-500">H: Rp {{ number_format($unpaidDebts, 0, ',', '.') }}</div>
                    <div class="text-xs font-bold text-emerald-500">P: Rp {{ number_format($unpaidReceivables, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
        
        <div class="bg-indigo-600 rounded-[2rem] shadow-xl shadow-indigo-600/20 p-6 relative overflow-hidden group border border-indigo-500">
            <div class="absolute -right-4 -top-4 w-16 h-16 bg-white/10 rounded-full group-hover:scale-110 transition-transform"></div>
            <div class="relative z-10 text-white">
                <h3 class="text-[9px] font-black text-indigo-200 uppercase tracking-[0.2em] mb-2">Saldo Bersih</h3>
                <div class="text-xl font-black">Rp {{ number_format($netBalance, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>

    <!-- Combined Transaction List -->
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-900/5 border border-slate-100 overflow-hidden">
        <div class="px-10 py-8 border-b border-slate-50 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-black text-slate-900 tracking-tight">Rincian Transaksi</h3>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Gabungan pemasukan dan pengeluaran</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic">Tanggal</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] italic">Kategori & Deskripsi</th>
                        <th class="px-10 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right italic">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/50">
                    @php
                        $allTransactions = collect()
                            ->concat($incomes->map(fn($i) => [...$i->toArray(), 'type' => 'income', 'category' => $i->category]))
                            ->concat($expenses->map(fn($e) => [...$e->toArray(), 'type' => 'expense', 'category' => $e->category]))
                            ->sortByDesc('date');
                    @endphp

                    @forelse($allTransactions as $tx)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-10 py-5 text-sm font-bold text-slate-600">
                                {{ \Carbon\Carbon::parse($tx['date'])->format('d M Y') }}
                            </td>
                            <td class="px-10 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-2 h-2 rounded-full {{ $tx['type'] == 'income' ? 'bg-emerald-500' : 'bg-rose-500' }}"></div>
                                    <div>
                                        <div class="text-sm font-black text-slate-900">{{ $tx['category']['name'] ?? 'Uncategorized' }}</div>
                                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $tx['description'] ?: '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-5 text-right font-black {{ $tx['type'] == 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $tx['type'] == 'income' ? '+' : '-' }} Rp {{ number_format($tx['amount'], 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-10 py-20 text-center text-slate-400 font-bold uppercase tracking-widest text-xs italic">
                                Belum ada data transaksi untuk periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
