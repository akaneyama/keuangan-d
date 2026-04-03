<x-app-layout>
    <x-slot name="header">
        Ringkasan Keuangan
    </x-slot>

    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-10 gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Halo, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h1>
            <p class="text-slate-500 mt-1 font-medium italic">"Pantau setiap rupiah, bangun masa depan lebih cerah."</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            <form method="GET" action="{{ route('dashboard') }}" class="flex items-center bg-white p-1.5 rounded-2xl shadow-sm border border-slate-200/60 focus-within:ring-2 focus-within:ring-indigo-500/20 transition-all">
                <select name="filter" onchange="this.form.submit()" class="border-0 bg-transparent text-xs font-black uppercase tracking-widest text-slate-700 focus:ring-0 cursor-pointer py-2 pl-4 pr-10">
                    <option value="day" {{ $filter == 'day' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="year" {{ $filter == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                </select>
            </form>

            <a href="{{ route('reports.index') }}" class="px-6 py-3 bg-slate-900 text-white rounded-2xl text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg shadow-slate-900/10 hover:shadow-indigo-600/20 active:scale-95 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 2v-6m-8 13h12a2 2 0 002-2V5a2 2 0 00-2-2H9a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Detail Laporan
            </a>
        </div>
    </div>

    <!-- Top Stats & Wallets -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-10">
        <!-- Main Stats -->
        <div class="lg:col-span-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-emerald-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-emerald-600/20 relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all"></div>
                <h3 class="text-[10px] font-black text-emerald-100 uppercase tracking-widest mb-2">Total Pemasukan</h3>
                <div class="text-2xl font-black mb-4">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
                <div class="text-[10px] font-bold text-emerald-100/70 uppercase tracking-widest border-t border-white/10 pt-4 flex justify-between">
                    <span>{{ ucfirst($filter) }}</span>
                    @if($filter == 'month')
                        <span class="{{ $incomeGrowth >= 0 ? 'text-white' : 'text-rose-200' }}">
                            {!! $incomeGrowth >= 0 ? '▲' : '▼' !!} {{ abs(round($incomeGrowth, 1)) }}%
                        </span>
                    @endif
                </div>
            </div>

            <div class="bg-rose-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-rose-600/20 relative overflow-hidden group">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all"></div>
                <h3 class="text-[10px] font-black text-rose-100 uppercase tracking-widest mb-2">Total Pengeluaran</h3>
                <div class="text-2xl font-black mb-4">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
                <div class="text-[10px] font-bold text-rose-100/70 uppercase tracking-widest border-t border-white/10 pt-4 flex justify-between">
                    <span>{{ ucfirst($filter) }}</span>
                    @if($filter == 'month')
                        <span class="{{ $expenseGrowth <= 0 ? 'text-white' : 'text-emerald-200' }}">
                            {!! $expenseGrowth >= 0 ? '▲' : '▼' !!} {{ abs(round($expenseGrowth, 1)) }}%
                        </span>
                    @endif
                </div>
            </div>

            <div class="bg-indigo-600 rounded-[2.5rem] p-8 text-white shadow-xl shadow-indigo-600/20 relative overflow-hidden group ring-4 ring-indigo-50">
                <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all"></div>
                <h3 class="text-[10px] font-black text-indigo-100 uppercase tracking-widest mb-2">Total Saldo Dompet</h3>
                <div class="text-2xl font-black mb-4">Rp {{ number_format($currentBalance, 0, ',', '.') }}</div>
                <div class="text-[10px] font-bold text-indigo-100/70 uppercase tracking-widest border-t border-white/10 pt-4">
                    Aktif & Siap Pakai
                </div>
            </div>
        </div>

        <!-- Wallet List -->
        <div class="lg:col-span-4 flex flex-col">
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-8 h-full">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Dompet Teratas</h3>
                    <a href="{{ route('accounts.index') }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline">Lihat Semua</a>
                </div>
                <div class="space-y-4">
                    @forelse($accounts as $acc)
                        <div class="flex items-center justify-between group">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl {{ $acc->type == 'bank' ? 'bg-blue-50 text-blue-600' : 'bg-emerald-50 text-emerald-600' }} flex items-center justify-center">
                                    @if($acc->type == 'bank') <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    @else <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg> @endif
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-900">{{ $acc->name }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $acc->type }}</p>
                                </div>
                            </div>
                            <div class="text-xs font-black text-slate-900">
                                Rp {{ number_format($acc->balance, 0, ',', '.') }}
                            </div>
                        </div>
                    @empty
                        <p class="text-[10px] text-slate-400 font-bold uppercase text-center py-4">Belum ada dompet</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Budgets -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-10">
        <!-- Main Chart -->
        <div class="lg:col-span-8 bg-white rounded-[2.5rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-10 h-min">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Analisis Arus Kas</h3>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Histori 6 Bulan Terakhir</p>
                </div>
            </div>
            <div class="relative h-[360px] w-full">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        <!-- Account Budgets -->
        <div class="lg:col-span-4 flex flex-col gap-8">
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-10">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h3 class="text-lg font-black text-slate-900 tracking-tight">Status Anggaran</h3>
                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Bulan Ini</p>
                    </div>
                    <a href="{{ route('budgets.index') }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:underline">Atur</a>
                </div>
                <div class="space-y-6">
                    @forelse($budgets as $b)
                        @php
                            $perc = $b->amount > 0 ? min(($b->actual / $b->amount) * 100, 100) : 0;
                            $color = $b->actual > $b->amount ? 'rose' : ($perc > 80 ? 'amber' : 'emerald');
                        @endphp
                        <div>
                            <div class="flex justify-between items-end mb-2">
                                <span class="text-xs font-bold text-slate-700">{{ $b->category->name }}</span>
                                <span class="text-[10px] font-black {{ $b->actual > $b->amount ? 'text-rose-500' : 'text-slate-500' }}">
                                    {{ round($perc) }}%
                                </span>
                            </div>
                            <div class="h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-{{ $color }}-500 rounded-full transition-all duration-1000 shadow-sm" style="width: {{ $perc }}%"></div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6">
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Tidak ada anggaran</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Savings Mini Widget -->
            <div class="bg-slate-900 rounded-[2.5rem] shadow-xl shadow-slate-900/20 p-10 text-white relative overflow-hidden">
                <div class="absolute -right-4 -bottom-4 w-32 h-32 bg-indigo-500/10 rounded-full blur-3xl"></div>
                <div class="relative z-10">
                    <h3 class="text-lg font-black tracking-tight mb-6">Target Terdekat</h3>
                    @forelse($savingsTargets as $target)
                        @php $perc = ($target->current_amount / $target->target_amount) * 100; @endphp
                        <div class="mb-6 last:mb-0">
                            <div class="flex justify-between text-xs mb-2">
                                <span class="font-bold">{{ $target->name }}</span>
                                <span class="font-black text-indigo-400">{{ round($perc) }}%</span>
                            </div>
                            <div class="h-1.5 bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-indigo-500 rounded-full" style="width: {{ $perc }}%"></div>
                            </div>
                        </div>
                    @empty
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest text-center py-4">Belum ada target</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Summary -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-10">
        <div class="lg:col-span-12 bg-white rounded-[2.5rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-10">
            <div class="flex justify-between items-center mb-10">
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Transaksi Terakhir</h3>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Aktivitas keuangan terupdate</p>
                </div>
                <a href="{{ route('expenses.index') }}" class="px-5 py-2.5 bg-slate-50 text-slate-900 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-100 transition-all border border-slate-200">Lihat Semua</a>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left">
                            <th class="pb-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Deskripsi</th>
                            <th class="pb-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kategori</th>
                            <th class="pb-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Dompet</th>
                            <th class="pb-6 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                            <th class="pb-6 text-right text-[10px] font-black text-slate-400 uppercase tracking-widest">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($recentTransactions as $tx)
                            <tr class="group hover:bg-slate-50/50 transition-colors">
                                <td class="py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl {{ $tx->type == 'income' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} flex items-center justify-center font-bold text-lg">
                                            {{ $tx->type == 'income' ? '+' : '-' }}
                                        </div>
                                        <span class="text-sm font-bold text-slate-900">{{ $tx->description ?: 'Transaksi Tanpa Nama' }}</span>
                                    </div>
                                </td>
                                <td class="py-5">
                                    <span class="px-3 py-1 bg-slate-100 text-slate-500 rounded-lg text-[10px] font-bold uppercase tracking-widest">
                                        {{ $tx->category->name }}
                                    </span>
                                </td>
                                <td class="py-5">
                                    <span class="text-xs font-bold text-slate-500">{{ $tx->account->name ?? '-' }}</span>
                                </td>
                                <td class="py-5">
                                    <span class="text-xs font-bold text-slate-400">{{ \Carbon\Carbon::parse($tx->date)->format('d M Y') }}</span>
                                </td>
                                <td class="py-5 text-right">
                                    <span class="text-sm font-black {{ $tx->type == 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        Rp {{ number_format($tx->amount, 0, ',', '.') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.font.family = "'Outfit', sans-serif";
            Chart.defaults.color = '#94a3b8';

            const ctxTrend = document.getElementById('trendChart').getContext('2d');
            const gInc = ctxTrend.createLinearGradient(0, 0, 0, 400);
            gInc.addColorStop(0, 'rgba(16, 185, 129, 0.15)');
            gInc.addColorStop(1, 'rgba(16, 185, 129, 0)');
            
            const gExp = ctxTrend.createLinearGradient(0, 0, 0, 400);
            gExp.addColorStop(0, 'rgba(244, 63, 94, 0.15)');
            gExp.addColorStop(1, 'rgba(244, 63, 94, 0)');

            new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartMonths) !!},
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: {!! json_encode($chartIncome) !!},
                            borderColor: '#10B981',
                            backgroundColor: gInc,
                            borderWidth: 4,
                            fill: true,
                            tension: 0.45,
                            pointRadius: 0,
                            pointHoverRadius: 6,
                            pointHoverBackgroundColor: '#10B981',
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 3
                        },
                        {
                            label: 'Pengeluaran',
                            data: {!! json_encode($chartExpense) !!},
                            borderColor: '#F43F5E',
                            backgroundColor: gExp,
                            borderWidth: 4,
                            fill: true,
                            tension: 0.45,
                            pointRadius: 0,
                            pointHoverRadius: 6,
                            pointHoverBackgroundColor: '#F43F5E',
                            pointHoverBorderColor: '#fff',
                            pointHoverBorderWidth: 3
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            position: 'top', 
                            align: 'end',
                            labels: { usePointStyle: true, font: { size: 10, weight: '700' } }
                        },
                        tooltip: { backgroundColor: '#1e293b', padding: 12, cornerRadius: 12 }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { weight: '600' } } },
                        y: { 
                            beginAtZero: true,
                            grid: { color: '#f1f5f9' },
                            border: { display: false },
                            ticks: { 
                                font: { weight: '600' },
                                callback: v => 'Rp ' + (v >= 1000000 ? (v/1000000) + 'jt' : (v/1000) + 'k')
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>