<x-guest-layout>
    <div class="min-h-screen bg-slate-50 font-outfit flex flex-col justify-center py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <!-- Branding -->
            <div class="mb-8 flex flex-col items-center">
                <div class="w-16 h-16 bg-gradient-to-tr from-indigo-600 to-violet-600 rounded-3xl flex items-center justify-center shadow-xl shadow-indigo-600/20 mb-4 rotate-3">
                    <span class="text-white text-3xl font-black tracking-tighter">F</span>
                </div>
                <h2 class="text-2xl font-black text-slate-800 tracking-tight">FinanceApp</h2>
            </div>

            <div class="bg-white py-10 px-6 shadow-2xl shadow-slate-200 rounded-[2.5rem] sm:px-12 border border-slate-100">
                <div class="mb-8">
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight mb-3">Lupa Kata Sandi?</h2>
                    <p class="text-sm text-slate-400 font-medium italic leading-relaxed">
                        Jangan khawatir. Masukkan alamat email Anda dan kami akan mengirimkan tautan untuk mengatur ulang kata sandi Anda.
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-6" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="space-y-8">
                    @csrf

                    <!-- Email Address -->
                    <div class="relative group">
                        <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2.5 ml-1 transition-colors group-focus-within:text-indigo-600">Alamat Email</label>
                        <div class="relative">
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                                   placeholder="nama@domain.com"
                                   class="block w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-800 placeholder-slate-300 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300 outline-none" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2.5 px-1" />
                    </div>

                    <div>
                        <button type="submit" 
                                class="w-full h-16 flex items-center justify-center bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-[0.3em] hover:bg-indigo-600 hover:shadow-2xl hover:shadow-indigo-500/20 active:scale-[0.98] transition-all transform duration-300">
                            Kirim Tautan Reset
                        </button>
                    </div>
                </form>

                <div class="mt-10 text-center">
                    <a href="{{ route('login') }}" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors flex items-center justify-center gap-2 group">
                        <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" /></svg>
                        Kembali ke Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
