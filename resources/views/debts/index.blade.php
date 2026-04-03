<x-app-layout>
    <x-slot name="header">
        Hutang & Piutang
    </x-slot>

    <div class="mb-10 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Summary Cards -->
        <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-rose-600/5 border border-rose-100/50 flex items-center gap-6">
            <div class="w-16 h-16 rounded-[1.5rem] bg-rose-50 text-rose-600 flex items-center justify-center shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" /></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Hutang Kita</p>
                <p class="text-3xl font-black text-slate-900">Rp {{ number_format($totalDebt, 0, ',', '.') }}</p>
            </div>
        </div>
        
        <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-emerald-600/5 border border-emerald-100/50 flex items-center gap-6">
            <div class="w-16 h-16 rounded-[1.5rem] bg-emerald-50 text-emerald-600 flex items-center justify-center shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Piutang (Uang di Orang)</p>
                <p class="text-3xl font-black text-slate-900">Rp {{ number_format($totalReceivable, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="flex flex-col xl:flex-row justify-between items-start xl:items-center mb-8 gap-6">
        <div>
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Catatan</h2>
            <p class="text-sm text-slate-500 font-medium italic">"Jangan biarkan hutang merusak silaturahmi, catat dan lunasi."</p>
        </div>
        <a href="{{ route('debts.create') }}" class="inline-flex items-center justify-center px-6 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-600/20 active:scale-95 uppercase tracking-widest text-xs">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
            Tambah Catatan
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-900/5 border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Orang / Entitas</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Tipe</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Jumlah</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Jatuh Tempo</th>
                        <th class="px-8 py-6 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Status</th>
                        <th class="px-8 py-6 text-right text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($debts as $debt)
                        <tr class="group hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-6">
                                <div class="font-bold text-slate-900">{{ $debt->name }}</div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $debt->note ?: '-' }}</div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="inline-flex px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $debt->type == 'debt' ? 'bg-rose-50 text-rose-600 border border-rose-100' : 'bg-emerald-50 text-emerald-600 border border-emerald-100' }}">
                                    {{ $debt->type == 'debt' ? 'Hutang Kita' : 'Piutang Kita' }}
                                </span>
                            </td>
                            <td class="px-8 py-6">
                                <div class="font-black text-slate-900">Rp {{ number_format($debt->amount, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-8 py-6">
                                <div class="text-xs font-bold {{ $debt->due_date && $debt->due_date->isPast() && $debt->status == 'unpaid' ? 'text-rose-500' : 'text-slate-500' }}">
                                    {{ $debt->due_date ? $debt->due_date->format('d M Y') : 'Tanpa Batas' }}
                                    @if($debt->due_date && $debt->due_date->isPast() && $debt->status == 'unpaid')
                                        <span class="block text-[8px] font-black uppercase tracking-tighter">Terlambat!</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-8 py-6">
                                <span class="inline-flex px-3 py-1 rounded-xl text-[10px] font-black uppercase tracking-widest {{ $debt->status == 'paid' ? 'bg-emerald-500 text-white' : 'bg-slate-100 text-slate-400' }}">
                                    {{ $debt->status == 'paid' ? 'LUNAS' : 'PENDING' }}
                                </span>
                            </td>
                            <td class="px-8 py-6 text-right">
                                <div class="flex justify-end items-center gap-3">
                                    @if($debt->status == 'unpaid')
                                        <form action="{{ route('debts.mark-as-paid', $debt) }}" method="POST">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="px-3 py-2 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-600 hover:text-white transition-all">Lunas</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('debts.edit', $debt) }}" class="p-2 text-slate-300 hover:text-indigo-600 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2-2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                    </a>
                                    <form action="{{ route('debts.destroy', $debt) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2 text-slate-300 hover:text-rose-600 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-8 py-24 text-center">
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Belum ada catatan hutang atau piutang.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($debts->hasPages())
            <div class="px-8 py-6 border-t border-slate-50 bg-slate-50/30">
                {{ $debts->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
