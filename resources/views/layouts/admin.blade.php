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
        
        <nav class="sticky top-0 z-50 navbar-warmindo shadow-xl">
            <div class="max-w-[95%] mx-auto px-4"> 
                <div class="flex justify-between h-20">
                    <div class="flex items-center flex-1"> 
                        <div class="flex-shrink-0 flex items-center lg:border-r lg:border-white/20 lg:pr-6 lg:mr-6">
                            <span class="flex flex-col lg:flex-row lg:items-center text-left tracking-tighter text-white uppercase leading-none">
                                <span class="text-xl lg:text-2xl font-black">Warmindo</span>
                                <span class="gradient-text-white font-extrabold text-[11px] lg:text-2xl lg:ml-1 mt-0.5 lg:mt-0 tracking-widest lg:tracking-tighter">PAKDHENE</span>
                            </span>
                        </div>
                        
                        <div class="hidden lg:flex lg:space-x-1 items-center">
                            @if(Auth::check())
                                @if(Auth::user()->role == 'kasir')
                                    <a href="{{ route('dashboard') }}" class="nav-link text-sm font-bold {{ request()->is('dashboard') ? 'active-link' : '' }}">Dashboard</a>
                                    <a href="{{ route('cashier.index') }}" class="nav-link text-sm font-bold {{ request()->is('cashier*') ? 'active-link' : '' }}">Antrean Kasir</a>
                                    <a href="{{ route('transactions.index') }}" class="nav-link text-sm font-bold {{ request()->is('transactions*') ? 'active-link' : '' }}">Transaksi</a>
                                    <a href="{{ route('products.index') }}" class="nav-link text-sm font-bold {{ request()->is('products*') ? 'active-link' : '' }}">Daftar Hidangan</a>
                                    <a href="{{ route('tables.index') }}" class="nav-link text-sm font-bold {{ request()->is('tables*') ? 'active-link' : '' }}">Pengaturan Meja & QR</a>
                                @endif

                                @if(Auth::user()->role == 'owner')
                                    <a href="{{ route('owner.dashboard') }}" class="nav-link text-sm font-bold {{ request()->is('owner*') ? 'active-link' : '' }}">Analitik Owner</a>
                                    <a href="{{ route('reports.index') }}" class="nav-link text-sm font-bold {{ request()->is('reports*') ? 'active-link' : '' }}">Laporan Penjualan</a>
                                   <a href="{{ route('users.index') }}" class="nav-link text-sm font-bold {{ request()->is('users*') ? 'active-link' : '' }}">Manajemen User</a>
                                @endif
                            @endif
                        </div>
                    </div>

                    <div class="flex items-center justify-end space-x-3 md:space-x-4">
                        @if(Auth::check())
                            <div class="hidden sm:flex flex-col text-right pr-4 border-r border-white/20">
                                <span class="text-[10px] font-black text-red-200 uppercase tracking-widest leading-none mb-1">{{ strtoupper(Auth::user()->role) }}</span>
                                <span class="text-sm font-bold text-white leading-none">{{ Auth::user()->name }}</span>
                            </div>
                            <form action="{{ route('logout') }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="bg-white hover:bg-red-50 text-red-600 px-4 py-2 md:px-5 md:py-2 rounded-xl text-[11px] md:text-xs font-black transition shadow-lg active:scale-95 uppercase tracking-wider">Keluar</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        {{-- MOBILE NAVIGATION BOTTOM BAR --}}
        <div class="lg:hidden fixed bottom-0 left-0 right-0 z-50 bg-white border-t border-slate-200 shadow-[0_-8px_30px_rgb(0,0,0,0.08)] px-2 py-2 flex justify-around items-center rounded-t-[2rem]">
            @if(Auth::check())
                @if(Auth::user()->role == 'kasir')
                    <a href="{{ route('dashboard') }}" class="flex flex-col items-center p-2 {{ request()->is('dashboard') ? 'text-rose-600' : 'text-slate-400' }}"><span class="text-[10px] font-black uppercase">Utama</span></a>
                    <a href="{{ route('transactions.index') }}" class="flex flex-col items-center p-2 {{ request()->is('transactions*') ? 'text-rose-600' : 'text-slate-400' }}"><span class="text-[10px] font-black uppercase">Transaksi</span></a>
                @endif
                @if(Auth::user()->role == 'owner')
                    <a href="{{ route('reports.index') }}" class="flex flex-col items-center p-2 {{ request()->is('reports*') ? 'text-rose-600' : 'text-slate-400' }}"><span class="text-[10px] font-black uppercase">Laporan</span></a>
                    <a href="{{ route('transactions.index') }}" class="flex flex-col items-center p-2 {{ request()->is('transactions*') ? 'text-rose-600' : 'text-slate-400' }}"><span class="text-[10px] font-black uppercase">Transaksi</span></a>
                @endif
            @endif
        </div>

        <div class="flex-grow py-6 md:py-8 mb-20 lg:mb-0">
            <div class="max-w-[95%] mx-auto px-2 md:px-4"> 
                @yield('content')
            </div>
        </div>

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