<x-app-layout>
    <x-slot name="header">
        Ringkasan Keuangan
    </x-slot>

    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-10 gap-6">
        <div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Selamat Datang, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h1>
            <p class="text-slate-500 mt-1 font-medium italic">"Kelola keuanganmu dengan bijak untuk masa depan yang cerah."</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3">
            <form method="GET" action="{{ route('dashboard') }}" class="flex items-center bg-white p-1.5 rounded-2xl shadow-sm border border-slate-200/60 focus-within:ring-2 focus-within:ring-indigo-500/20 transition-all">
                <div class="pl-3 pr-1 text-slate-400">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                </div>
                <select name="filter" onchange="this.form.submit()" class="border-0 bg-transparent text-xs font-black uppercase tracking-widest text-slate-700 focus:ring-0 cursor-pointer py-2 pl-2 pr-8">
                    <option value="day" {{ $filter == 'day' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Bulan Ini</option>
                    <option value="year" {{ $filter == 'year' ? 'selected' : '' }}>Tahun Ini</option>
                </select>
            </form>

            <a href="{{ route('reports.index') }}" class="px-5 py-3 bg-slate-900 text-white rounded-2xl text-xs font-bold uppercase tracking-widest hover:bg-indigo-600 transition-all shadow-lg shadow-slate-900/10 hover:shadow-indigo-600/20 active:scale-95 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 2v-6m-8 13h12a2 2 0 002-2V5a2 2 0 00-2-2H9a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Detail Laporan
            </a>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <!-- Pemasukan -->
        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-8 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 p-6 opacity-10 transform translate-x-4 -translate-y-4 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-24 h-24 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L4.5 20.29l.71.71L12 18l6.79 3 .71-.71z"/></svg>
            </div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Pemasukan</h3>
                    <div class="text-3xl font-black text-slate-900">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
                    @if($filter == 'month')
                        <div class="flex items-center gap-1.5 mt-3">
                            <span class="flex items-center {{ $incomeGrowth >= 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} px-2 py-0.5 rounded-full text-[10px] font-bold">
                                {!! $incomeGrowth >= 0 ? '&#9650;' : '&#9660;' !!} {{ abs(round($incomeGrowth, 1)) }}%
                            </span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">vs bln lalu</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Pengeluaran -->
        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-8 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="absolute top-0 right-0 p-6 opacity-10 transform translate-x-4 -translate-y-4 group-hover:scale-110 transition-transform duration-500">
                <svg class="w-24 h-24 text-rose-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 22l7.5-18.29-.71-.71L12 6l-6.79-3-.71.71z"/></svg>
            </div>
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Pengeluaran</h3>
                    <div class="text-3xl font-black text-slate-900">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
                    @if($filter == 'month')
                        <div class="flex items-center gap-1.5 mt-3">
                            <span class="flex items-center {{ $expenseGrowth <= 0 ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} px-2 py-0.5 rounded-full text-[10px] font-bold">
                                {!! $expenseGrowth >= 0 ? '&#9650;' : '&#9660;' !!} {{ abs(round($expenseGrowth, 1)) }}%
                            </span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">vs bln lalu</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Saldo -->
        <div class="bg-indigo-600 rounded-[2rem] shadow-xl shadow-indigo-600/20 p-8 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300 border border-indigo-500 ring-4 ring-indigo-50">
            <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:bg-white/20 transition-all duration-500"></div>
            <div class="relative z-10">
                <h3 class="text-[10px] font-black text-indigo-200 uppercase tracking-[0.2em] mb-2">Sisa Saldo</h3>
                <div class="text-3xl font-black text-white">Rp {{ number_format($currentBalance, 0, ',', '.') }}</div>
                <div class="mt-4 text-[10px] text-indigo-100 font-bold uppercase tracking-widest flex items-center gap-2">
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                    Aktif & Siap Digunakan
                </div>
            </div>
        </div>

        <!-- Rata-rata -->
        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-8 relative overflow-hidden group hover:-translate-y-1 transition-all duration-300">
            <div class="flex justify-between items-start relative z-10">
                <div>
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Rata-rata/Bulan</h3>
                    <div class="text-3xl font-black text-slate-900">Rp {{ number_format($avgIncomePerMonth, 0, ',', '.') }}</div>
                    <div class="mt-4 text-[10px] text-slate-400 font-bold uppercase tracking-widest">Berdasarkan histori profil</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
        <div class="lg:col-span-2 bg-white rounded-[2.5rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Analisis Arus Kas</h3>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Histori 6 Bulan Terakhir</p>
                </div>
            </div>
            <div class="relative h-[320px] w-full">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
        
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-10 flex flex-col items-center">
            <div class="w-full mb-8">
                <h3 class="text-xl font-black text-slate-900 tracking-tight">Distribusi Biaya</h3>
                <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Berdasarkan Kategori</p>
            </div>
            <div class="relative h-[240px] w-full flex justify-center mb-6">
                <canvas id="expenseChart"></canvas>
            </div>
            <div class="w-full mt-auto space-y-3">
                @foreach(collect($pieLabels)->take(3) as $index => $label)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                             <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ ['#6366F1', '#F43F5E', '#10B981'][$index] ?? '#94A3B8' }}"></span>
                             <span class="text-xs font-bold text-slate-600">{{ $label }}</span>
                        </div>
                        <span class="text-xs font-black text-slate-900">Rp {{ number_format($pieData[$index], 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8 mb-10">
        <!-- Recent Transactions -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Transaksi Terakhir</h3>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Aktivitas keuangan terupdate</p>
                </div>
                <a href="{{ route('expenses.index') }}" class="text-xs font-black text-indigo-600 uppercase tracking-[0.2em] hover:text-indigo-700 transition-colors">Lihat Semua</a>
            </div>
            <div class="space-y-6">
                @forelse($recentTransactions as $tx)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl {{ $tx->type == 'income' ? 'bg-emerald-50 text-emerald-600' : 'bg-rose-50 text-rose-600' }} flex items-center justify-center transform group-hover:rotate-12 transition-transform shadow-sm">
                                <svg class="w-6 h-6 leading-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($tx->type == 'income')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />
                                    @endif
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">{{ $tx->description ?: 'Tanpa keterangan' }}</h4>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $tx->category->name }} • {{ \Carbon\Carbon::parse($tx->date)->format('d M Y') }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-sm font-black {{ $tx->type == 'income' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $tx->type == 'income' ? '+' : '-' }} Rp {{ number_format($tx->amount, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center">
                        <p class="text-slate-400 font-bold text-xs uppercase tracking-widest">Belum ada transaksi</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Savings Progress -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-900/5 border border-slate-100 p-10">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-xl font-black text-slate-900 tracking-tight">Progres Tabungan</h3>
                    <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Impian yang sedang dikejar</p>
                </div>
                <a href="{{ route('savings-targets.index') }}" class="text-xs font-black text-indigo-600 uppercase tracking-[0.2em] hover:text-indigo-700 transition-colors">Kelola Target</a>
            </div>
            <div class="space-y-10 mt-4">
                @forelse($savingsTargets as $target)
                    @php 
                        $percentage = ($target->current_amount / $target->target_amount) * 100;
                        $percentage = min($percentage, 100);
                    @endphp
                    <div>
                        <div class="flex justify-between items-end mb-3">
                            <div>
                                <h4 class="text-sm font-bold text-slate-900">{{ $target->name }}</h4>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Target: Rp {{ number_format($target->target_amount, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right font-black text-indigo-600 text-sm">
                                {{ round($percentage) }}%
                            </div>
                        </div>
                        <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden p-0.5 border border-slate-200/50">
                            <div class="h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-400 rounded-full transition-all duration-1000 ease-out shadow-sm" style="width: {{ $percentage }}%"></div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 flex flex-col items-center text-center">
                        <div class="w-16 h-16 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0l2.77-.693a9 9 0 016.208.682l.108.054a9 9 0 006.086.71l3.114-.732a48.524 48.524 0 01-.005-10.499l-3.15.743a9 9 0 01-6.085-.711l-.108-.054a9 9 0 00-6.208-.682L3 4.5M3 15V4.5" /></svg>
                        </div>
                        <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mb-4">Belum ada rencana tabungan</p>
                        <a href="{{ route('savings-targets.create') }}" class="px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-[10px] font-bold uppercase tracking-widest hover:bg-indigo-600 hover:text-white transition-all transform hover:-translate-y-0.5 active:translate-y-0">Mulai Menabung</a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.defaults.font.family = "'Outfit', sans-serif";
            Chart.defaults.color = '#94a3b8';
            Chart.defaults.plugins.tooltip.boxPadding = 6;

            // Trend Chart
            const ctxTrend = document.getElementById('trendChart').getContext('2d');
            const gradientInc = ctxTrend.createLinearGradient(0, 0, 0, 400);
            gradientInc.addColorStop(0, 'rgba(16, 185, 129, 0.2)');
            gradientInc.addColorStop(1, 'rgba(16, 185, 129, 0)');
            
            const gradientExp = ctxTrend.createLinearGradient(0, 0, 0, 400);
            gradientExp.addColorStop(0, 'rgba(244, 63, 94, 0.2)');
            gradientExp.addColorStop(1, 'rgba(244, 63, 94, 0)');

            new Chart(ctxTrend, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartMonths) !!},
                    datasets: [
                        {
                            label: 'Pemasukan',
                            data: {!! json_encode($chartIncome) !!},
                            borderColor: '#10B981',
                            backgroundColor: gradientInc,
                            borderWidth: 4,
                            fill: true,
                            tension: 0.45,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#10B981',
                            pointBorderWidth: 3,
                            pointRadius: 5,
                            pointHoverRadius: 8,
                            pointHoverBorderWidth: 4
                        },
                        {
                            label: 'Pengeluaran',
                            data: {!! json_encode($chartExpense) !!},
                            borderColor: '#F43F5E',
                            backgroundColor: gradientExp,
                            borderWidth: 4,
                            fill: true,
                            tension: 0.45,
                            pointBackgroundColor: '#ffffff',
                            pointBorderColor: '#F43F5E',
                            pointBorderWidth: 3,
                            pointRadius: 5,
                            pointHoverRadius: 8,
                            pointHoverBorderWidth: 4
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: { mode: 'index', intersect: false },
                    plugins: {
                        legend: { 
                            position: 'top', 
                            align: 'end',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 25,
                                font: { size: 11, weight: '700', textTransform: 'uppercase' }
                            }
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { size: 13, weight: '800' },
                            bodyFont: { size: 13, weight: '600' },
                            padding: 16,
                            displayColors: true,
                            cornerRadius: 16,
                            callbacks: {
                                label: function(context) {
                                    let val = context.parsed.y;
                                    return ' ' + context.dataset.label + ': ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val);
                                }
                            }
                        }
                    },
                    scales: {
                        x: { grid: { display: false }, ticks: { font: { weight: '600' } } },
                        y: { 
                            beginAtZero: true,
                            border: { display: false, dash: [4, 4] },
                            grid: { color: '#f1f5f9' },
                            ticks: { 
                                font: { weight: '600' },
                                callback: value => 'Rp ' + (value >= 1000000 ? (value / 1000000) + 'jt' : (value / 1000) + 'rb')
                            }
                        }
                    }
                }
            });

            // Expense Category Chart
            const ctxExpense = document.getElementById('expenseChart').getContext('2d');
            new Chart(ctxExpense, {
                type: 'doughnut',
                data: {
                    labels: {!! json_encode($pieLabels) !!},
                    datasets: [{
                        data: {!! json_encode($pieData) !!},
                        backgroundColor: ['#6366F1', '#F43F5E', '#10B981', '#F59E0B', '#8B5CF6', '#0EA5E9', '#94A3B8'],
                        borderWidth: 0,
                        hoverOffset: 15,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '82%',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            padding: 16,
                            cornerRadius: 16,
                            callbacks: {
                                label: function(context) {
                                    return ' ' + context.label + ': Rp ' + new Intl.NumberFormat('id-ID', { minimumFractionDigits: 0 }).format(context.parsed);
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
ut>