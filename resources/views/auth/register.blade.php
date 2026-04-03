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
                        Start Your Journey
                    </div>
                    <h1 class="text-6xl font-black text-white leading-[1.1] tracking-tight mb-6 text-balance">
                        Bangun <span class="text-indigo-400">Fondasi</span> Keuangan Yang Kokoh.
                    </h1>
                    <p class="text-lg text-indigo-100/70 font-medium leading-relaxed max-w-lg italic">
                        "Bergabunglah dengan ribuan pengguna yang telah mempercayakan pengelolaan aset mereka kepada kami. Mudah, aman, dan transparan."
                    </p>
                </div>
            </div>
        </div>

        <!-- Right Side: The Form -->
        <div class="flex flex-col justify-center w-full lg:w-2/5 xl:w-[35%] px-8 sm:px-12 lg:px-20 bg-white shadow-2xl relative z-10 transition-all overflow-y-auto">
            <div class="w-full max-w-md mx-auto py-12">
                <!-- Mobile Branding -->
                <div class="lg:hidden mb-12 flex flex-col items-center">
                    <div class="w-16 h-16 bg-gradient-to-tr from-indigo-600 to-violet-600 rounded-3xl flex items-center justify-center shadow-xl shadow-indigo-600/20 mb-4 rotate-3">
                        <span class="text-white text-3xl font-black tracking-tighter">F</span>
                    </div>
                    <h2 class="text-2xl font-black text-slate-800 tracking-tight">FinanceApp</h2>
                </div>

                <div class="text-left mb-10">
                    <h2 class="text-4xl font-black text-slate-900 tracking-tight mb-3">Registrasi Akun</h2>
                    <p class="text-base text-slate-400 font-medium italic">Lengkapi detail di bawah untuk memulai pengelolaan aset Anda.</p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <!-- Name -->
                    <div class="relative group">
                        <label for="name" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2.5 ml-1 transition-colors group-focus-within:text-indigo-600">Nama Lengkap</label>
                        <div class="relative">
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" 
                                   placeholder="Nama Lengkap Anda"
                                   class="block w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-800 placeholder-slate-300 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300 outline-none" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2.5 px-1" />
                    </div>

                    <!-- Email Address -->
                    <div class="relative group">
                        <label for="email" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2.5 ml-1 transition-colors group-focus-within:text-indigo-600">Alamat Email</label>
                        <div class="relative">
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" 
                                   placeholder="nama@domain.com"
                                   class="block w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-800 placeholder-slate-300 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300 outline-none" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2.5 px-1" />
                    </div>

                    <!-- Password -->
                    <div class="relative group">
                        <label for="password" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2.5 ml-1 transition-colors group-focus-within:text-indigo-600">Kata Sandi</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                   placeholder="••••••••"
                                   class="block w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-800 placeholder-slate-300 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300 outline-none" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2.5 px-1" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="relative group">
                        <label for="password_confirmation" class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2.5 ml-1 transition-colors group-focus-within:text-indigo-600">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                   placeholder="••••••••"
                                   class="block w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl text-sm font-bold text-slate-800 placeholder-slate-300 focus:bg-white focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all duration-300 outline-none" />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2.5 px-1" />
                    </div>

                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full h-16 flex items-center justify-center bg-slate-900 text-white rounded-2xl text-xs font-black uppercase tracking-[0.3em] hover:bg-indigo-600 hover:shadow-2xl hover:shadow-indigo-500/20 active:scale-[0.98] transition-all transform duration-300">
                            Daftar Sekarang
                        </button>
                    </div>
                </form>

                <div class="mt-12 text-center">
                    <p class="text-sm font-bold text-slate-400">
                        Sudah Memiliki Akun? 
                        <a href="{{ route('login') }}" class="ml-2 text-indigo-600 hover:text-indigo-800 transition-colors underline underline-offset-8 decoration-2 decoration-indigo-600/20 hover:decoration-indigo-600/100">
                            Masuk Kembali
                        </a>
                    </p>
                </div>
            </div>
            
            <!-- Minimalist Footer -->
            <div class="mt-auto px-20 pb-10">
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