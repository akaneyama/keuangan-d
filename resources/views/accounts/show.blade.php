<x-app-layout>
    <x-slot name="header">
        Detail Dompet: {{ $account->name }}
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8">
        <!-- Account Card Header -->
        <div class="bg-white rounded-[3rem] p-10 shadow-2xl border border-slate-100 relative overflow-hidden group">
            <div class="absolute -right-20 -top-20 w-80 h-80 bg-indigo-50 rounded-full blur-[100px] opacity-70 group-hover:scale-125 transition-transform duration-700"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row gap-10 items-center justify-between">
                <div class="flex items-center gap-6">
                    <div class="w-24 h-24 rounded-[2rem] {{ $account->type == 'bank' ? 'bg-blue-600 shadow-blue-600/30' : ($account->type == 'e-wallet' ? 'bg-purple-600 shadow-purple-600/30' : 'bg-emerald-600 shadow-emerald-600/30') }} flex items-center justify-center text-white shadow-xl">
                        @if($account->type == 'bank')
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                        @elseif($account->type == 'e-wallet')
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                        @else
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        @endif
                    </div>
                    <div>
                        <h2 class="text-4xl font-black text-slate-900 tracking-tight capitalize">{{ $account->name }}</h2>
                        <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest {{ $account->type == 'bank' ? 'bg-blue-50 text-blue-600' : ($account->type == 'e-wallet' ? 'bg-purple-50 text-purple-600' : 'bg-emerald-50 text-emerald-600') }} mt-2">
                            {{ $account->type }}
                        </span>
                    </div>
                </div>

                <div class="text-center md:text-right">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mb-2 italic">Saldo Saat Ini</p>
                    <div class="text-5xl font-black text-slate-900 tracking-tighter">
                        <span class="text-2xl text-slate-300 font-bold mr-1">Rp</span>{{ number_format($account->balance, 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Summary & Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="bg-slate-900 rounded-[2.5rem] p-10 text-white shadow-xl shadow-slate-900/10 relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-indigo-600/20 rounded-full blur-3xl"></div>
                <h3 class="text-lg font-black tracking-tight mb-6">Kelola Keuangan</h3>
                <p class="text-slate-400 text-sm mb-8 leading-relaxed font-medium">Lacak setiap transaksi yang berhubungan dengan dompet ini secara rinci di menu laporan.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="{{ route('accounts.edit', $account) }}" class="px-6 py-4 bg-white/10 hover:bg-white/20 border border-white/10 rounded-2xl text-xs font-bold uppercase tracking-widest transition-all">
                        Edit Dompet
                    </a>
                    <form action="{{ route('accounts.destroy', $account) }}" method="POST" onsubmit="return confirm('Hapus dompet ini? Semua riwayat tetap ada tapi referensi akan hilang.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="px-6 py-4 bg-rose-600/10 hover:bg-rose-600/20 border border-rose-600/20 text-rose-500 rounded-2xl text-xs font-bold uppercase tracking-widest transition-all">
                            Hapus Permanen
                        </button>
                    </form>
                </div>
            </div>

            <div class="bg-indigo-600 rounded-[2.5rem] p-10 text-white shadow-xl shadow-indigo-600/20 relative overflow-hidden">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
                <h3 class="text-lg font-black tracking-tight mb-6 mt-1 flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                    Statistik Singkat
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center py-3 border-b border-white/10">
                        <span class="text-xs font-medium text-indigo-100">Dibuat Pada</span>
                        <span class="text-xs font-black">{{ $account->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3 border-b border-white/10">
                        <span class="text-xs font-medium text-indigo-100">Update Terakhir</span>
                        <span class="text-xs font-black">{{ $account->updated_at->diffForHumans() }}</span>
                    </div>
                    <div class="flex justify-between items-center py-3">
                        <span class="text-xs font-medium text-indigo-100">Status</span>
                        <span class="px-3 py-1 bg-white/20 rounded-lg text-[10px] font-black uppercase tracking-widest">Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="bg-white rounded-[2.5rem] p-8 border-2 border-dashed border-slate-200 text-center">
            <h3 class="text-xl font-black text-slate-900 mb-2">Ingin melihat daftar transaksi?</h3>
            <p class="text-slate-500 text-sm mb-6">Anda dapat menyaring transaksi berdasarkan dompet ini di menu laporan.</p>
            <a href="{{ route('reports.index') }}" class="inline-flex items-center text-indigo-600 font-bold hover:underline">
                Buka Laporan
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
            </a>
        </div>
    </div>
</x-app-layout>
