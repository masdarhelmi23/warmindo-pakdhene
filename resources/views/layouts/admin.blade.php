<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WARMINDO PAKDHENE - Administrator</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(135deg, #fff5f5 0%, #fed7d7 100%);
            background-attachment: fixed;
        }
        
        .main-overlay {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: rgba(255, 0, 0, 0.02); 
        }
        
        .navbar-warmindo {
            background-color: #e53e3e; 
            border-bottom: 4px solid #c53030;
        }

        .gradient-text-white {
            background: linear-gradient(135deg, #ffffff 0%, #fecaca 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .active-link {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 0.75rem;
            color: #ffffff !important;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }
    </style>
</head>
<body class="text-slate-800 antialiased">

    <div class="main-overlay">
        
        {{-- TOP NAVBAR (DESKTOP VERSION) --}}
        <nav class="sticky top-0 z-50 navbar-warmindo shadow-xl">
            <div class="max-w-[95%] mx-auto px-4"> 
                <div class="flex justify-between h-20">
                    
                    <div class="flex items-center flex-1"> 
                        {{-- LOGO --}}
                        <div class="flex-shrink-0 flex items-center lg:border-r lg:border-white/20 lg:pr-6 lg:mr-6">
                            <span class="flex flex-col lg:flex-row lg:items-center text-left tracking-tighter text-white uppercase leading-none">
                                <span class="text-xl lg:text-2xl font-black">Warmindo</span>
                                <span class="gradient-text-white font-extrabold text-[11px] lg:text-2xl lg:ml-1 mt-0.5 lg:mt-0 tracking-widest lg:tracking-tighter">PAKDHENE</span>
                            </span>
                        </div>
                        
                        {{-- MENU DESKTOP --}}
                        <div class="hidden lg:flex lg:space-x-1 items-center">
                            
                            {{-- SINKRONISASI: MENU KHUSUS ADMIN KASIR (ROLE: KASIR) --}}
                            @if(Auth::check() && Auth::user()->role == 'kasir')
                                <a href="{{ route('dashboard') }}" 
                                   class="nav-link text-sm font-bold {{ request()->is('dashboard') ? 'active-link' : '' }}">
                                     Dashboard
                                </a>

                                <a href="{{ route('cashier.index') }}" 
                                   class="nav-link text-sm font-bold {{ request()->is('cashier*') ? 'active-link' : '' }}">
                                    <span class="flex items-center">
                                        Antrean Kasir
                                        <span class="ml-2 flex h-2 w-2 relative">
                                            <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-yellow-300 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-yellow-400"></span>
                                        </span>
                                    </span>
                                </a>

                                <a href="{{ route('products.index') }}" 
                                   class="nav-link text-sm font-bold {{ request()->is('products*') ? 'active-link' : '' }}">
                                    Daftar Hidangan
                                </a>

                                <a href="{{ route('tables.index') }}" 
                                   class="nav-link text-sm font-bold {{ request()->is('tables*') ? 'active-link' : '' }}">
                                    Pengaturan Meja & QR
                                </a>
                            @endif

                            {{-- MENU KHUSUS OWNER --}}
                            @if(Auth::check() && Auth::user()->role == 'owner')
                                <a href="{{ route('owner.dashboard') }}" 
                                   class="nav-link text-sm font-bold {{ request()->is('owner*') ? 'active-link' : '' }}">
                                   <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                       <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                   </svg>
                                   Analitik Owner
                                </a>

                                <a href="{{ route('reports.index') }}" 
                                   class="nav-link text-sm font-bold {{ request()->is('reports*') ? 'active-link' : '' }}">
                                    Laporan Penjualan
                                </a>
                            @endif

                        </div>
                    </div>

                    {{-- USER INFO & LOGOUT --}}
                    <div class="flex items-center justify-end space-x-3 md:space-x-4">
                        @if(Auth::check())
                            <div class="hidden sm:flex flex-col text-right pr-4 border-r border-white/20">
                                <span class="text-[10px] font-black text-red-200 uppercase tracking-widest leading-none mb-1">
                                    {{ strtoupper(Auth::user()->role) }}
                                </span>
                                <span class="text-sm font-bold text-white leading-none">{{ Auth::user()->name ?? 'Kasir' }}</span>
                            </div>

                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" 
                                        class="bg-white hover:bg-red-50 text-red-600 px-4 py-2 md:px-5 md:py-2 rounded-xl text-[11px] md:text-xs font-black transition shadow-lg active:scale-95 uppercase tracking-wider">
                                    Keluar
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            </div>
        </nav>

        {{-- MOBILE NAVIGATION BOTTOM BAR --}}
        <div class="lg:hidden fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-slate-200 shadow-[0_-8px_30px_rgb(0,0,0,0.08)] px-2 py-2 flex justify-around items-center rounded-t-[2rem]">
            
            {{-- SINKRONISASI: Navigasi Cepat Admin Kasir (ROLE: KASIR) --}}
            @if(Auth::check() && Auth::user()->role == 'kasir')
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center gap-1 p-2 {{ request()->is('dashboard') ? 'text-rose-600' : 'text-slate-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"/></svg>
                    <span class="text-[10px] font-black uppercase tracking-tighter">Utama</span>
                </a>

                <a href="{{ route('cashier.index') }}" class="flex flex-col items-center gap-1 p-2 relative {{ request()->is('cashier*') ? 'text-rose-600' : 'text-slate-400' }}">
                    <span class="absolute top-1 right-2 flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                    </span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span class="text-[10px] font-black uppercase tracking-tighter">Kasir</span>
                </a>
            @endif

            {{-- Navigasi Cepat Owner --}}
            @if(Auth::check() && Auth::user()->role == 'owner')
                <a href="{{ route('owner.dashboard') }}" class="flex flex-col items-center gap-1 p-2 {{ request()->is('owner*') ? 'text-rose-600' : 'text-slate-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    <span class="text-[10px] font-black uppercase tracking-tighter">Analitik</span>
                </a>
            @endif

            {{-- TRIGGER BUTTON LACI MENU BAWAH MOBILE --}}
            <div x-data="{ mobileMenuOpen: false }">
                <button @click="mobileMenuOpen = true" class="flex flex-col items-center gap-1 p-2 {{ request()->is('products*') || request()->is('tables*') || request()->is('reports*') ? 'text-rose-600' : 'text-slate-400' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <span class="text-[10px] font-black uppercase tracking-tighter">Menu</span>
                </button>

                <div x-show="mobileMenuOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 z-50" style="display: none;" @click="mobileMenuOpen = false"></div>
                <div x-show="mobileMenuOpen" 
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="translate-y-full"
                     x-transition:enter-end="translate-y-0"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="translate-y-0"
                     x-transition:leave-end="translate-y-full"
                     style="display: none;"
                     class="fixed bottom-0 left-0 right-0 bg-white z-50 rounded-t-[3rem] p-6 pb-10 shadow-2xl max-h-[80vh] overflow-y-auto">
                    
                    <div class="w-12 h-1.5 bg-slate-200 rounded-full mx-auto mb-6"></div>
                    <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4 text-center">Navigasi Lanjutan</h3>
                    
                    <div class="grid grid-cols-1 gap-2">
                        {{-- OPSI LACI LINK KHUSUS OWNER --}}
                        @if(Auth::check() && Auth::user()->role == 'owner')
                            <a href="{{ route('owner.dashboard') }}" class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl text-sm font-black text-slate-800 uppercase tracking-tight hover:bg-rose-50 hover:text-rose-600 transition-colors">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-rose-600 shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg></div>
                                Analitik Owner
                            </a>
                            <a href="{{ route('reports.index') }}" class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl text-sm font-black text-slate-800 uppercase tracking-tight hover:bg-rose-50 hover:text-rose-600 transition-colors">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-500 shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2m3.268-9.043A6 6 0 1121.732 15M12 3v1m0 8v.01M12 16v.01"/></svg></div>
                                Laporan Penjualan
                            </a>
                        @endif

                        {{-- SINKRONISASI OPSI LACI MOBILE: Daftar Hidangan & Meja (ROLE: KASIR) --}}
                        @if(Auth::check() && Auth::user()->role == 'kasir')
                            <a href="{{ route('products.index') }}" class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl text-sm font-black text-slate-800 uppercase tracking-tight hover:bg-rose-50 hover:text-rose-600 transition-colors">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-500 shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg></div>
                                Daftar Hidangan
                            </a>

                            <a href="{{ route('tables.index') }}" class="flex items-center gap-4 p-4 bg-slate-50 rounded-2xl text-sm font-black text-slate-800 uppercase tracking-tight hover:bg-rose-50 hover:text-rose-600 transition-colors">
                                <div class="w-10 h-10 bg-white rounded-xl flex items-center justify-center text-slate-500 shadow-sm"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 4v1m-3.322-.106l-3.682-1.071m10.682 1.071l3.682-1.071m-7.364 2.142l-3.682 5.318m7.364-5.318l3.682 5.318M12 17v4m-3.322-.106l-3.682 1.071m10.682-1.071l3.682 1.071"/></svg></div>
                                Pengaturan Meja & QR
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT AREA --}}
        <div class="flex-grow py-6 md:py-8 mb-20 lg:mb-0">
            <div class="max-w-[95%] mx-auto px-2 md:px-4"> 
                @yield('content')
            </div>
        </div>

        {{-- FOOTER --}}
        <footer class="w-full py-8 hidden lg:block">
            <div class="max-w-[95%] mx-auto px-4 border-t border-red-200 pt-8">
                <p class="text-center text-red-400 text-xs font-black uppercase tracking-[0.3em]">
                    &copy; {{ date('Y') }} <span class="text-red-600">Warmindo PAKDHENE</span> Digital System.
                </p>
            </div>
        </footer>
        
    </div> 
</body>
</html>