<x-app-layout>
    <x-slot name="header">
        Edit Dompet: {{ $account->name }}
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-[2.5rem] p-10 shadow-xl border border-slate-100 relative overflow-hidden">
            <!-- Decorative blur -->
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>
            
            <form action="{{ route('accounts.update', $account) }}" method="POST" class="space-y-8 relative z-10">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Nama Dompet / Rekening</label>
                    <input type="text" name="name" value="{{ old('name', $account->name) }}"
                           class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:ring-0 focus:border-indigo-500 font-bold text-slate-900 placeholder:text-slate-300 transition-all shadow-inner"
                           placeholder="Misal: BCA, Tunai, GoPay..." required autofocus>
                    @error('name') <p class="mt-2 text-xs font-bold text-rose-500 ml-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Tipe Akun</label>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach(['cash' => 'Tunai', 'bank' => 'Bank', 'e-wallet' => 'E-Wallet'] as $value => $label)
                        <label class="relative cursor-pointer group">
                            <input type="radio" name="type" value="{{ $value }}" class="sr-only peer" {{ old('type', $account->type) == $value ? 'checked' : '' }}>
                            <div class="p-5 bg-slate-50 rounded-[1.5rem] border-2 border-transparent peer-checked:border-indigo-500 peer-checked:bg-indigo-50/50 transition-all text-center group-hover:bg-slate-100 shadow-sm">
                                <div class="w-12 h-12 bg-white rounded-2xl shadow-sm flex items-center justify-center mx-auto mb-3 text-indigo-600 group-hover:scale-110 transition-transform">
                                    @if($value == 'cash')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                    @elseif($value == 'bank')
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                    @else
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                                    @endif
                                </div>
                                <span class="text-[10px] font-black uppercase tracking-widest text-slate-600">{{ $label }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="p-6 bg-amber-50 rounded-[1.5rem] border border-amber-100/50">
                    <label class="block text-[10px] font-black text-amber-600 uppercase tracking-[0.2em] mb-3 ml-1">Saldo Saat Ini</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 font-black text-amber-400">Rp</span>
                        <input type="number" name="balance" value="{{ old('balance', $account->balance) }}"
                               class="w-full pl-14 pr-6 py-4 bg-white border-2 border-transparent rounded-2xl focus:ring-0 focus:border-amber-400 font-black text-slate-900 shadow-sm"
                               placeholder="0" required>
                    </div>
                    <p class="mt-2 text-[9px] font-bold text-amber-500 uppercase tracking-tighter italic">* Mengubah saldo di sini akan mengabaikan riwayat transaksi sebelumnya.</p>
                </div>

                <div class="pt-6 flex flex-col sm:flex-row items-center gap-4">
                    <a href="{{ route('accounts.index') }}" class="w-full sm:flex-1 px-8 py-4 border-2 border-slate-100 text-slate-400 font-black uppercase tracking-widest text-[10px] rounded-[1.2rem] hover:bg-slate-50 hover:text-slate-600 transition-all text-center">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:flex-[2] px-8 py-4 bg-indigo-600 text-white font-black uppercase tracking-widest text-[10px] rounded-[1.2rem] hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/20 active:scale-95 group flex items-center justify-center gap-2">
                        Simpan Perubahan
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7-7 7M5 12h16" /></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
