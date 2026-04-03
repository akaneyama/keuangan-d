<x-app-layout>
    <x-slot name="header">
        Anggaran Kita
    </x-slot>

    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <p class="text-slate-500 font-medium">Tetapkan batas pengeluaran untuk setiap kategori agar keuangan tetap terkendali.</p>
        </div>
        
        <form action="{{ route('budgets.index') }}" method="GET" class="flex items-center bg-white rounded-2xl p-1 shadow-sm border border-slate-100">
            <select name="month" class="border-none bg-transparent focus:ring-0 font-bold text-slate-700 text-sm">
                @for($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                @endfor
            </select>
            <select name="year" class="border-none bg-transparent focus:ring-0 font-bold text-slate-700 text-sm">
                @for($i = now()->year - 2; $i <= now()->year + 1; $i++)
                    <option value="{{ $i }}" {{ $year == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
            <button type="submit" class="p-2 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Budget Form/List -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-3xl p-8 shadow-xl border border-slate-100 sticky top-24">
                <h3 class="text-xl font-black text-slate-900 mb-6 flex items-center">
                    <span class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center mr-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    </span>
                    Atur Anggaran
                </h3>
                
                <form action="{{ route('budgets.store') }}" method="POST" class="space-y-6">
                    @csrf
                    <input type="hidden" name="month" value="{{ $month }}">
                    <input type="hidden" name="year" value="{{ $year }}">

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Pilih Kategori</label>
                        <select name="category_id" class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Limit Anggaran</label>
                        <div class="relative">
                            <span class="absolute left-5 top-1/2 -translate-y-1/2 font-black text-slate-400">Rp</span>
                            <input type="number" name="amount" class="w-full pl-14 pr-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 shadow-inner" placeholder="0" required>
                        </div>
                    </div>

                    <button type="submit" class="w-full px-6 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-600/20 active:scale-95">
                        Simpan Anggaran
                    </button>
                </form>
            </div>
        </div>

        <!-- Progress Tracking -->
        <div class="lg:col-span-2 space-y-6">
            @foreach($budgets as $budget)
                @php
                    $percentage = $budget->amount > 0 ? min(($budget->actual / $budget->amount) * 100, 100) : 0;
                    $isOver = $budget->actual > $budget->amount;
                    $color = $isOver ? 'rose' : ($percentage > 80 ? 'amber' : 'emerald');
                @endphp
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-md transition-all">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-slate-50 flex items-center justify-center text-slate-600 font-bold">
                                {{ strtoupper(substr($budget->category->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900">{{ $budget->category->name }}</h4>
                                <p class="text-xs font-medium text-slate-500">Bulan {{ date('F', mktime(0,0,0, $budget->month, 1)) }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-black text-slate-900">Rp {{ number_format($budget->actual, 0, ',', '.') }} <span class="text-slate-300 font-medium">/ Rp {{ number_format($budget->amount, 0, ',', '.') }}</span></p>
                            <p class="text-[10px] font-bold uppercase tracking-widest {{ $isOver ? 'text-rose-500' : 'text-slate-400' }}">
                                {{ $isOver ? 'Melebihi Anggaran!' : 'Tersisa Rp ' . number_format(max(0, $budget->amount - $budget->actual), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="relative h-3 bg-slate-100 rounded-full overflow-hidden mb-2">
                        <div class="absolute inset-y-0 left-0 bg-{{ $color }}-500 rounded-full transition-all duration-1000 shadow-[0_0_10px_rgba(var(--tw-color-{{ $color }}-500),0.3)]" style="width: {{ $percentage }}%"></div>
                    </div>
                    
                    <div class="flex justify-between items-center text-[10px] font-bold uppercase tracking-widest text-slate-400">
                        <span>{{ number_format($percentage, 1) }}% Terpakai</span>
                        <form action="{{ route('budgets.destroy', $budget) }}" method="POST" onsubmit="return confirm('Hapus anggaran ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-300 hover:text-rose-500 transition-colors">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach

            @if($budgets->isEmpty())
                <div class="bg-white rounded-3xl p-12 text-center border-2 border-dashed border-slate-200">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-2">Belum ada anggaran</h3>
                    <p class="text-slate-500">Pilih kategori di samping untuk mulai membatasi pengeluaran Anda.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
