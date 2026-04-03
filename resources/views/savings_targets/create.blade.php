<x-app-layout>
    <x-slot name="header">
        {{ isset($savingsTarget) ? 'Edit Target Impian' : 'Buat Target Impian Baru' }}
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-[2.5rem] p-10 shadow-xl border border-slate-100 relative overflow-hidden">
            <!-- Decor -->
            <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-50 rounded-full blur-3xl opacity-50"></div>

            <form action="{{ isset($savingsTarget) ? route('savings-targets.update', $savingsTarget) : route('savings-targets.store') }}" method="POST" class="space-y-8 relative z-10">
                @csrf
                @if(isset($savingsTarget)) @method('PUT') @endif
                
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Nama Impian</label>
                    <input type="text" name="name" value="{{ old('name', $savingsTarget->name ?? '') }}"
                           class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:ring-0 focus:border-indigo-500 font-bold text-slate-900 placeholder:text-slate-300 transition-all shadow-inner"
                           placeholder="Misal: Beli MacBook, Liburan ke Jepang..." required autofocus>
                    @error('name') <p class="mt-2 text-xs font-bold text-rose-500 ml-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Nominal Target</label>
                    <div class="relative">
                        <span class="absolute left-6 top-1/2 -translate-y-1/2 font-black text-slate-400">Rp</span>
                        <input type="number" name="target_amount" value="{{ old('target_amount', isset($savingsTarget) ? (float)$savingsTarget->target_amount : '') }}"
                               class="w-full pl-16 pr-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:ring-0 focus:border-indigo-500 font-bold text-slate-900 shadow-inner"
                               placeholder="0" required>
                    </div>
                    @error('target_amount') <p class="mt-2 text-xs font-bold text-rose-500 ml-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Tenggat Waktu (Opsional)</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-6 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <input type="date" name="deadline" value="{{ old('deadline', isset($savingsTarget) && $savingsTarget->deadline ? $savingsTarget->deadline->format('Y-m-d') : '') }}"
                               class="w-full pl-16 pr-6 py-4 bg-slate-50 border-2 border-transparent rounded-[1.5rem] focus:ring-0 focus:border-indigo-500 font-bold text-slate-700 shadow-inner">
                    </div>
                </div>

                <div class="pt-6 flex flex-col sm:flex-row items-center gap-4">
                    <a href="{{ route('savings-targets.index') }}" class="w-full sm:flex-1 px-8 py-4 border-2 border-slate-100 text-slate-400 font-black uppercase tracking-widest text-[10px] rounded-[1.2rem] hover:bg-slate-50 hover:text-slate-600 transition-all text-center">
                        Batal
                    </a>
                    <button type="submit" class="w-full sm:flex-[2] px-8 py-4 bg-indigo-600 text-white font-black uppercase tracking-widest text-[10px] rounded-[1.2rem] hover:bg-indigo-700 transition-all shadow-xl shadow-indigo-600/20 active:scale-95 group flex items-center justify-center gap-2">
                        {{ isset($savingsTarget) ? 'Perbarui Target' : 'Simpan Target Impian' }}
                        <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
