<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WARMINDO PRO - Administrator</title>
    
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
            items-center;
        }

        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        /* Styling Dropdown Item */
        .dropdown-item {
            display: block;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            font-weight: 700;
            color: #1e293b;
            transition: all 0.2s;
        }
        .dropdown-item:hover {
            background-color: #fef2f2;
            color: #e53e3e;
        }
    </style>
</head>
<body class="text-slate-800 antialiased">

    <div class="main-overlay">
        
        <nav class="sticky top-0 z-50 navbar-warmindo shadow-xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center border-r border-white/20 pr-6 mr-6">
                            <span class="text-2xl font-black tracking-tighter text-white uppercase">
                                Warmindo<span class="gradient-text-white font-extrabold ml-1">PRO</span>
                            </span>
                        </div>
                        
                        <div class="hidden sm:flex sm:space-x-2 h-full items-center">
                            <a href="{{ route('dashboard') }}" 
                               class="nav-link text-sm font-bold {{ request()->is('dashboard') ? 'active-link' : '' }}">
                                Dashboard
                            </a>

                            <div class="relative" x-data="{ open: false }" @click.away="open = false">
                                <button @click="open = !open" 
                                   class="nav-link text-sm font-bold flex items-center {{ request()->is('products*') || request()->is('categories*') ? 'active-link' : '' }}">
                                    <span>Manajemen Menu</span>
                                    <svg class="w-4 h-4 ml-1 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>

                                <div x-show="open" 
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     class="absolute left-0 mt-2 w-48 bg-white rounded-2xl shadow-2xl py-2 z-50 border border-slate-100 overflow-hidden">
                                    <a href="{{ route('products.index') }}" class="dropdown-item">
                                        Daftar Hidangan
                                    </a>
                                    <a href="{{ route('categories.index') }}" class="dropdown-item border-t border-slate-50">
                                        Kategori Menu
                                    </a>
                                </div>
                            </div>

                            <a href="{{ url('/tables') }}" 
                               class="nav-link text-sm font-bold {{ request()->is('tables*') ? 'active-link' : '' }}">
                                Daftar Meja (QR)
                            </a>
                            <a href="{{ url('/reports') }}" 
                               class="nav-link text-sm font-bold {{ request()->is('reports*') ? 'active-link' : '' }}">
                                Laporan Penjualan
                            </a>
                        </div>
                    </div>

                    <div class="flex items-center space-x-6">
                        <div class="hidden md:flex flex-col text-right pr-4 border-r border-white/20">
                            <span class="text-[10px] font-black text-red-200 uppercase tracking-widest leading-none mb-1">Administrator</span>
                            <span class="text-sm font-bold text-white leading-none">{{ Auth::user()->name ?? 'Admin' }}</span>
                        </div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="bg-white hover:bg-red-50 text-red-600 px-6 py-2.5 rounded-xl text-sm font-black transition shadow-lg active:scale-95 uppercase tracking-wider">
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex-grow py-8">
            @yield('content')
        </div>

        <footer class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div class="border-t border-red-200 pt-8">
                <p class="text-center text-red-400 text-xs font-black uppercase tracking-[0.3em]">
                    &copy; {{ date('Y') }} <span class="text-red-600">Warmindo PRO</span> Digital System.
                </p>
            </div>
        </footer>
        
    </div> </body>
</html>