<x-guest-layout>
    <div class="flex min-h-screen bg-slate-50 font-outfit selection:bg-indigo-100 selection:text-indigo-900">
        <!-- Left Side: Visual Experience (HIDDEN ON MOBILE) -->
        <div class="relative hidden lg:flex lg:w-3/5 xl:w-[65%] h-screen overflow-hidden bg-indigo-900">
            <img class="absolute inset-0 object-cover w-full h-full scale-105" 
                 src="{{ asset('images/auth-bg.png') }}" 
                 alt="Background Keuangan Modern">
            
            <!-- Glass Overlay Content -->
            <div class="absolute inset-0 bg-gradient-to-tr from-indigo-950/80 via-transparent to-transparent backdrop-blur-[2px]"></div>
            
            <div class="absolute bottom-16 left-16 right-16 z-20">
                <div class="max-w-xl">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-indigo-100 text-xs font-bold uppercase tracking-[0.2em] mb-8">
                        <span class="w-2 h-2 rounded-full bg-indigo-400 animate-pulse mr-3"></span>
                        Premium Financial Experience
                    </div>
                    <h1 class="text-6xl font-black text-white leading-[1.1] tracking-tight mb-6">
                        Kelola <span class="text-indigo-400">Aset</span> Masa Depan <br>Dengan Cerdas.
                    </h1>
                    <p class="text-lg text-indigo-100/70 font-medium leading-relaxed max-w-lg italic">
                        "Kendalikan setiap riwayat keuangan Anda, wujudkan impian tabungan, dan capai kebebasan finansial melalui data yang akurat."
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side: The Form -->
        <div class="flex flex-col justify-center w-full lg:w-2/5 xl:w-[35%] px-8 sm:px-12 lg:px-20 bg-white shadow-2xl relative z-10 transition-all">
            <div class="w-full max-w-md mx-auto">
                <!-- Mobile Branding -->
                <div class="lg:hidden mb-12 flex flex-col items-center">
                    <div class="w-16 h-16 bg-gradient-to-tr from-indigo-600 to-violet-600 rounded-3xl flex items-center justify-center shadow-xl shadow-indigo-600/20 mb-4 rotate-3">
                        <span class="text-white text-3xl font-black tracking-tighter">F</span>
                    </div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">FinanceApp</h2>
                </div>

                <div class="text-left mb-10">
                    <h2 class="text-4xl font-black text-slate-900 tracking-tight mb-3">Selamat Datang!</h2>
                    <p class="text-base text-slate-400 font-medium italic">Silakan masuk untuk melanjutkan navigasi finansial Anda.</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-8">
                    @csrf

                    <!-- Email Address -->
                    <div class="relative group">
                        <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2.5 ml-1 transition-colors group-focus-within:text-indigo-600">Alamat Email</label>
                        <div class="relative">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                                   placeholder="nama@domain.com"
                                   class="block w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-800 placeholder-slate-300 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300 outline-none" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2.5 px-1" />
                    </div>

                    <!-- Password -->
                    <div class="relative group">
                        <div class="flex items-center justify-between mb-2.5">
                            <label for="password" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1 transition-colors group-focus-within:text-indigo-600">Kata Sandi</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[10px] font-black text-indigo-400 uppercase tracking-widest hover:text-indigo-600 hover:underline transition-all underline-offset-4">
                                    Lupa Sandi?
                                </a>
                            @endif
                        </div>
                        <div class="relative">
                            <input id="password" type="password" name="password" required 
                                   placeholder="••••••••"
                                   class="block w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-800 placeholder-slate-300 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300 outline-none" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2.5 px-1" />
                    </div>

                    <div class="flex items-center justify-between pt-2">
                        <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                            <input id="remember_me" type="checkbox" name="remember" 
                                   class="rounded-lg bg-slate-100 border-slate-200 text-indigo-600 focus:ring-indigo-500 transition-all cursor-pointer w-5 h-5 shadow-sm">
                            <span class="ml-3 text-xs font-bold text-slate-500 group-hover:text-slate-800 transition-colors uppercase tracking-widest">Ingat Saya</span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full h-16 flex items-center justify-center bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-[0.3em] hover:bg-indigo-600 hover:shadow-2xl hover:shadow-indigo-500/20 active:scale-[0.98] transition-all transform duration-300">
                            Masuk Sekarang
                        </button>
                    </div>
                </form>

                <div class="mt-12 text-center">
                    <p class="text-sm font-bold text-slate-400">
                        Belum Memiliki Akun? 
                        <a href="{{ route('register') }}" class="ml-2 text-indigo-600 hover:text-indigo-800 transition-colors underline underline-offset-8 decoration-2 decoration-indigo-600/20 hover:decoration-indigo-600/100">
                            Registrasi Akun Baru
                        </a>
                    </p>
                </div>
            </div>
            
            <!-- Minimalist Footer -->
            <div class="absolute bottom-10 left-0 right-0 px-20">
                <div class="flex justify-between items-center text-[10px] text-slate-300 font-bold uppercase tracking-widest border-t border-slate-50 pt-8">
                    <span>&copy; {{ date('Y') }} FinanceApp</span>
                    <div class="flex gap-4">
                        <span class="hover:text-indigo-400 cursor-pointer transition-colors">Privacy</span>
                        <span class="hover:text-indigo-400 cursor-pointer transition-colors">Terms</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>