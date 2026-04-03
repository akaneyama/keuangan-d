<x-app-layout>
    <x-slot name="header">
        Dompet Saya
    </x-slot>

    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <p class="text-slate-500 font-medium">Kelola saldo di berbagai rekening atau dompet Anda.</p>
        </div>
        <a href="{{ route('accounts.create') }}" class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-600/20 active:scale-95">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Dompet
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($accounts as $account)
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 hover:shadow-xl transition-all group relative overflow-hidden">
                <!-- Decor -->
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-50 rounded-full opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 rounded-2xl {{ $account->type == 'bank' ? 'bg-blue-50 text-blue-600' : ($account->type == 'e-wallet' ? 'bg-purple-50 text-purple-600' : 'bg-emerald-50 text-emerald-600') }}">
                            @if($account->type == 'bank')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                            @elseif($account->type == 'e-wallet')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('accounts.show', $account) }}" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors" title="Lihat Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <a href="{{ route('accounts.edit', $account) }}" class="p-2 text-slate-400 hover:text-indigo-600 transition-colors" title="Edit Dompet">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </a>
                            <form action="{{ route('accounts.destroy', $account) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus dompet ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 transition-colors" title="Hapus Permanen">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold text-slate-900 mb-1 capitalize">{{ $account->name }}</h3>
                    <p class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">{{ $account->type }}</p>
                    
                    <div class="pt-4 border-t border-slate-50">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Saldo Saat Ini</p>
                        <p class="text-2xl font-black text-slate-900">
                            Rp {{ number_format($account->balance, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach

        @if($accounts->isEmpty())
            <div class="col-span-full bg-white rounded-3xl p-12 text-center border-2 border-dashed border-slate-200">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900 mb-2">Belum ada dompet</h3>
                <p class="text-slate-500 mb-6">Mulai dengan menambahkan dompet pertama Anda (misal: Tunai atau BCA).</p>
                <a href="{{ route('accounts.create') }}" class="inline-flex items-center text-indigo-600 font-bold hover:underline">
                    Tambah Dompet Sekarang
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>
        @endif
    </div>
</x-app-layout>
