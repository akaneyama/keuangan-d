<x-app-layout>
    <x-slot name="header">
        Tambah Dompet
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-3xl p-8 shadow-xl border border-slate-100">
            <form action="{{ route('accounts.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-sm font-black text-slate-400 uppercase tracking-widest mb-2">Nama Dompet</label>
                    <input type="text" name="name" 
                           class="w-full px-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 placeholder:text-slate-300 transition-all shadow-inner"
                           placeholder="Misal: BCA, Tunai, GoPay..." required autofocus>
                </div>

                <div>
                    <label class="block text-sm font-black text-slate-400 uppercase tracking-widest mb-2">Tipe</label>
                    <div class="grid grid-cols-3 gap-4">
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="type" value="cash" class="sr-only peer" checked>
                            <div class="p-4 bg-slate-50 rounded-2xl border-2 border-transparent peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all text-center group-hover:bg-slate-100">
                                <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center mx-auto mb-2 text-indigo-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                </div>
                                <span class="text-xs font-bold text-slate-600">Tunai</span>
                            </div>
                        </label>
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="type" value="bank" class="sr-only peer">
                            <div class="p-4 bg-slate-50 rounded-2xl border-2 border-transparent peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all text-center group-hover:bg-slate-100">
                                <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center mx-auto mb-2 text-indigo-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                </div>
                                <span class="text-xs font-bold text-slate-600">Bank</span>
                            </div>
                        </label>
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="type" value="e-wallet" class="sr-only peer">
                            <div class="p-4 bg-slate-50 rounded-2xl border-2 border-transparent peer-checked:border-indigo-500 peer-checked:bg-indigo-50 transition-all text-center group-hover:bg-slate-100">
                                <div class="w-10 h-10 bg-white rounded-xl shadow-sm flex items-center justify-center mx-auto mb-2 text-indigo-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                </div>
                                <span class="text-xs font-bold text-slate-600">E-Wallet</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-black text-slate-400 uppercase tracking-widest mb-2">Saldo Awal (Opsional)</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 font-black text-slate-400">Rp</span>
                        <input type="number" name="balance" 
                               class="w-full pl-14 pr-5 py-4 bg-slate-50 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 font-bold text-slate-900 placeholder:text-slate-300 transition-all shadow-inner"
                               placeholder="0" value="0">
                    </div>
                </div>

                <div class="pt-4 flex items-center gap-4">
                    <a href="{{ route('accounts.index') }}" class="flex-1 px-6 py-4 border border-slate-200 text-slate-500 font-bold rounded-2xl hover:bg-slate-50 transition-all text-center">
                        Batal
                    </a>
                    <button type="submit" class="flex-[2] px-6 py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-600/20 active:scale-95">
                        Simpan Dompet
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
