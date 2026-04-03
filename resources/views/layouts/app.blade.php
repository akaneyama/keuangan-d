<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'FinanceApp') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: rgba(255, 255, 255, 0.2); }
    </style>
</head>
<body class="antialiased text-slate-900 bg-[#f8fafc]">
    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex overflow-hidden">
        
        <!-- Mobile Sidebar Overlay -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-md z-40 md:hidden" 
             @click="sidebarOpen = false" 
             style="display: none;">
        </div>

        <!-- Sidebar -->
        <aside :class="{'translate-x-0': sidebarOpen, '-translate-x-full': !sidebarOpen}" 
               class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 border-r border-slate-800 transform transition-transform duration-300 ease-in-out md:relative md:translate-x-0 flex flex-col shadow-2xl md:shadow-none bg-gradient-to-b from-slate-900 via-slate-900 to-indigo-950/20">
            
            <div class="h-20 flex items-center justify-between px-6 border-b border-slate-800/50">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-500 via-purple-500 to-indigo-400 flex items-center justify-center shadow-lg shadow-indigo-500/40 text-white transform rotate-3">
                        <svg class="w-6 h-6 transform -rotate-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-2xl font-extrabold text-white tracking-tight italic">My<span class="text-indigo-400 not-italic">Finance</span></span>
                </div>
                <button @click="sidebarOpen = false" class="md:hidden text-slate-400 hover:text-white transition-colors focus:outline-none">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scrollbar">
                
                <a href="{{ route('dashboard') }}" class="group flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('dashboard') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-indigo-300' }}">
                    <div class="p-1.5 rounded-lg mr-3 {{ request()->routeIs('dashboard') ? 'bg-indigo-500 shadow-inner' : 'bg-slate-800 group-hover:bg-slate-700' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                    </div>
                    <span class="font-semibold tracking-wide">Ringkasan</span>
                </a>

                <div class="px-4 pt-6 pb-2">
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">Manajemen</span>
                </div>

                <a href="{{ route('categories.index') }}" class="group flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('categories.*') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-indigo-300' }}">
                    <div class="p-1.5 rounded-lg mr-3 {{ request()->routeIs('categories.*') ? 'bg-indigo-500 shadow-inner' : 'bg-slate-800 group-hover:bg-slate-700' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                        </svg>
                    </div>
                    <span class="font-semibold tracking-wide">Kategori</span>
                </a>

                <a href="{{ route('incomes.index') }}" class="group flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('incomes.*') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-indigo-300' }}">
                    <div class="p-1.5 rounded-lg mr-3 {{ request()->routeIs('incomes.*') ? 'bg-indigo-500 shadow-inner' : 'bg-slate-800 group-hover:bg-slate-700' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <span class="font-semibold tracking-wide">Pemasukan</span>
                </a>

                <a href="{{ route('expenses.index') }}" class="group flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('expenses.*') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-indigo-300' }}">
                    <div class="p-1.5 rounded-lg mr-3 {{ request()->routeIs('expenses.*') ? 'bg-indigo-500 shadow-inner' : 'bg-slate-800 group-hover:bg-slate-700' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6" />
                        </svg>
                    </div>
                    <span class="font-semibold tracking-wide">Pengeluaran</span>
                </a>

                <a href="{{ route('accounts.index') }}" class="group flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('accounts.*') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-indigo-300' }}">
                    <div class="p-1.5 rounded-lg mr-3 {{ request()->routeIs('accounts.*') ? 'bg-indigo-500 shadow-inner' : 'bg-slate-800 group-hover:bg-slate-700' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                        </svg>
                    </div>
                    <span class="font-semibold tracking-wide">Dompet Saya</span>
                </a>

                <a href="{{ route('budgets.index') }}" class="group flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('budgets.*') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-indigo-300' }}">
                    <div class="p-1.5 rounded-lg mr-3 {{ request()->routeIs('budgets.*') ? 'bg-indigo-500 shadow-inner' : 'bg-slate-800 group-hover:bg-slate-700' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <span class="font-semibold tracking-wide">Anggaran Kita</span>
                </a>

                <a href="{{ route('savings-targets.index') }}" class="group flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('savings-targets.*') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-indigo-300' }}">
                    <div class="p-1.5 rounded-lg mr-3 {{ request()->routeIs('savings-targets.*') ? 'bg-indigo-500 shadow-inner' : 'bg-slate-800 group-hover:bg-slate-700' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold tracking-wide">Tabungan</span>
                </a>

                <a href="{{ route('debts.index') }}" class="group flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('debts.*') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-indigo-300' }}">
                    <div class="p-1.5 rounded-lg mr-3 {{ request()->routeIs('debts.*') ? 'bg-indigo-500 shadow-inner' : 'bg-slate-800 group-hover:bg-slate-700' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="font-semibold tracking-wide">Hutang & Piutang</span>
                </a>

                <div class="px-4 pt-6 pb-2">
                    <span class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-500">Lainnya</span>
                </div>

                <a href="{{ route('reports.index') }}" class="group flex items-center px-4 py-3.5 rounded-2xl transition-all duration-300 {{ request()->routeIs('reports.*') ? 'bg-indigo-600 text-white shadow-xl shadow-indigo-600/30' : 'text-slate-400 hover:bg-slate-800/50 hover:text-indigo-300' }}">
                    <div class="p-1.5 rounded-lg mr-3 {{ request()->routeIs('reports.*') ? 'bg-indigo-500 shadow-inner' : 'bg-slate-800 group-hover:bg-slate-700' }} transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 2v-6m-8 13h12a2 2 0 002-2V5a2 2 0 00-2-2H9a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <span class="font-semibold tracking-wide">Laporan Lanjutan</span>
                </a>
            </nav>

            
        </aside>

        <div class="flex-1 flex flex-col h-screen overflow-hidden">
            
            <header class="h-20 bg-white/70 backdrop-blur-xl border-b border-slate-200/60 flex items-center justify-between px-4 sm:px-10 sticky top-0 z-10 shadow-sm">
                <div class="flex items-center">
                    <button @click="sidebarOpen = true" class="md:hidden p-3 mr-4 rounded-2xl text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all active:scale-95">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Finance Manager v1.0</p>
                        <h2 class="font-black text-2xl text-slate-900 tracking-tight leading-tight">
                            {{ $header ?? 'Dashboard' }}
                        </h2>
                    </div>
                </div>
                
                <div class="flex items-center gap-4">
                    <button class="p-2.5 bg-slate-100 text-slate-500 rounded-2xl hover:bg-indigo-50 hover:text-indigo-600 transition-all group hidden sm:block">
                        <svg class="w-6 h-6 group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>

                    <div class="h-8 w-px bg-slate-200 hidden sm:block"></div>

                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="flex items-center gap-2 group focus:outline-none">
                                <div class="flex flex-col items-end mr-1 hidden sm:flex">
                                    <span class="text-sm font-bold text-slate-900 group-hover:text-indigo-600 transition-colors">{{ Auth::user()->name }}</span>
                                    <span class="text-[10px] text-slate-500 uppercase font-black tracking-widest">Personal User</span>
                                </div>
                                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-slate-200 to-slate-100 p-0.5 group-hover:rotate-6 transition-all duration-300 ring-2 ring-transparent group-hover:ring-indigo-100">
                                    <div class="w-full h-full rounded-[14px] bg-white flex items-center justify-center font-bold text-indigo-600 shadow-sm overflow-hidden text-lg">
                                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                    </div>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Identitas Akun</p>
                                <p class="text-sm font-bold text-slate-900 truncate mb-0.5">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <div class="p-1">
                                <x-dropdown-link :href="route('profile.edit')" class="rounded-xl font-medium !py-2.5 transition-all hover:translate-x-1">
                                    <div class="flex items-center gap-3 text-slate-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                                        {{ __('Profil Saya') }}
                                    </div>
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('profile.edit')" class="rounded-xl font-medium !py-2.5 transition-all hover:translate-x-1">
                                    <div class="flex items-center gap-3 text-slate-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                        {{ __('Pengaturan') }}
                                    </div>
                                </x-dropdown-link>
                            </div>
                            <div class="p-1 mt-1 border-t border-slate-100">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();" 
                                            class="rounded-xl font-bold !py-2.5 text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition-all group">
                                        <div class="flex items-center gap-3">
                                            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                                            {{ __('Keluar') }}
                                        </div>
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-4 sm:p-10 custom-scrollbar relative">
                <!-- Background decoration -->
                <div class="absolute top-0 right-0 -z-10 w-full h-96 bg-gradient-to-b from-indigo-50/50 to-transparent"></div>
                
                @if (session('success'))
                    <div class="mb-8 bg-white border-l-[6px] border-emerald-500 rounded-2xl shadow-xl shadow-emerald-900/5 p-5 animate-slide-in-right transform hover:translate-x-1 transition-transform" x-data="{ show: true }" x-show="show">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600 shadow-inner">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Transaksi Berhasil</h3>
                                    <p class="text-sm text-slate-600 font-medium mt-0.5">{{ session('success') }}</p>
                                </div>
                            </div>
                            <button @click="show = false" class="text-slate-300 hover:text-slate-900 transition-colors p-1">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-8 bg-white border-l-[6px] border-rose-500 rounded-2xl shadow-xl shadow-rose-900/5 p-5 animate-slide-in-right transform hover:translate-x-1 transition-transform" x-data="{ show: true }" x-show="show">
                        <div class="flex justify-between items-start">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-rose-50 rounded-2xl flex items-center justify-center text-rose-600 shadow-inner">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest">Terjadi Kesalahan</h3>
                                    <p class="text-sm text-slate-600 font-medium mt-0.5">{{ session('error') }}</p>
                                </div>
                            </div>
                            <button @click="show = false" class="text-slate-300 hover:text-slate-900 transition-colors p-1">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>
                @endif
                
                <div class="max-w-[1400px] mx-auto">
                    {{ $slot }}
                </div>
                
            </main>
        </div>
    </div>

    <style>
        @keyframes slide-in-right {
            from { transform: translateX(20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .animate-slide-in-right {
            animation: slide-in-right 0.4s ease-out forwards;
        }
    </style>
</body>
</html>