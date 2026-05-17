@extends('layouts.admin')

@section('content')
<main class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-4 md:py-10 mb-20 lg:mb-4">

    {{-- HEADER UTAMA & FILTER TANGGAL --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 md:mb-12 gap-6 px-2 sm:px-0">
        <div>
            <h1 class="text-2xl md:text-4xl font-black text-slate-900 tracking-tight uppercase">
                Owner <span class="text-amber-500">Analytics</span>
            </h1>
            <p class="mt-1 md:mt-2 text-slate-500 font-bold uppercase tracking-[0.15em] md:tracking-[0.2em] text-[9px] md:text-[10px]">
                Laporan: {{ date('d M', strtotime($startDate)) }} - {{ date('d M Y', strtotime($endDate)) }}
            </p>
        </div>

        {{-- Form Filter Tanggal --}}
        <div class="w-full lg:w-auto">
            <form action="{{ route('owner.dashboard') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 bg-white p-3 rounded-2xl md:rounded-3xl shadow-sm border border-slate-100 m-0">
                <div class="flex-1 px-4 py-1 sm:py-0 border-b sm:border-b-0 sm:border-r border-slate-100">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Dari</p>
                    <input type="date" name="start_date" value="{{ $startDate }}" class="w-full text-xs font-bold text-slate-700 outline-none bg-transparent mt-0.5">
                </div>
                <div class="flex-1 px-4 py-1 sm:py-0">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Sampai</p>
                    <input type="date" name="end_date" value="{{ $endDate }}" class="w-full text-xs font-bold text-slate-700 outline-none bg-transparent mt-0.5">
                </div>
                <button type="submit" class="bg-slate-900 text-white py-3.5 sm:py-3 px-5 rounded-xl md:rounded-2xl hover:bg-amber-500 transition-all active:scale-95 shadow-lg shadow-slate-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    {{-- STATS SECTION 1 (FINANSIAL & PRODUK) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 mb-4 md:mb-8 px-2 sm:px-0">
        <div class="bg-slate-900 rounded-[1.8rem] md:rounded-[2.5rem] p-6 md:p-8 text-white relative overflow-hidden shadow-2xl col-span-1 sm:col-span-2 lg:col-span-1">
            <p class="text-[9px] md:text-[10px] font-black text-amber-400 uppercase tracking-widest mb-1 md:mb-2">Total Pendapatan</p>
            <h3 class="text-2xl md:text-3xl font-black italic tracking-tighter text-amber-500">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </h3>
        </div>

        <div class="bg-white rounded-[1.8rem] md:rounded-[2.5rem] p-6 md:p-8 border border-slate-100 shadow-xl">
            <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 md:mb-2">Total Produk Terjual</p>
            <h3 class="text-2xl md:text-3xl font-black text-slate-900 italic tracking-tighter">
                {{ $orderCount }} <span class="text-xs md:text-sm font-normal text-slate-400/80 uppercase">Porsi</span>
            </h3>
        </div>

        <div class="bg-white rounded-[1.8rem] md:rounded-[2.5rem] p-6 md:p-8 border border-slate-100 shadow-xl">
            <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 md:mb-2">Average Order Value</p>
            <h3 class="text-2xl md:text-3xl font-black italic tracking-tighter text-amber-600">
                Rp {{ number_format($avgSpend, 0, ',', '.') }}
            </h3>
        </div>
    </div>

    {{-- STATS SECTION 2 (OPERASIONAL DAPUR) --}}
    <div class="grid grid-cols-1 gap-4 mb-8 md:mb-12 px-2 sm:px-0">
        <div class="bg-white rounded-[1.8rem] md:rounded-[2.5rem] p-6 md:p-8 border border-slate-100 shadow-xl flex flex-row items-center justify-between gap-4">
            <div>
                <p class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 md:mb-2">Kecepatan Pelayanan (Dapur)</p>
                <h3 class="text-2xl md:text-4xl font-black text-blue-600 italic tracking-tighter">
                    {{ round($avgProcessingTime) }} <span class="text-xs md:text-sm font-normal text-slate-400/80 uppercase">Menit</span>
                </h3>
            </div>
            <div class="text-right flex-shrink-0">
                <p class="text-[8px] md:text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1.5">Performa</p>
                <span class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-full text-[8px] md:text-[10px] font-black uppercase tracking-tight whitespace-nowrap">
                    {{ $avgProcessingTime <= 15 ? 'Sangat Cepat' : 'Perlu Evaluasi' }}
                </span>
            </div>
        </div>
    </div>

    {{-- DETAIL TABLES --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-10 px-2 sm:px-0">
        
        {{-- MENU TERLARIS --}}
        <div class="bg-white rounded-[1.8rem] md:rounded-[3rem] p-6 md:p-10 shadow-2xl border border-slate-100">
            <h2 class="text-lg md:text-xl font-black text-slate-900 mb-6 md:mb-8 uppercase tracking-tighter">
                Menu <span class="text-amber-500">Terlaris</span>
            </h2>
            <div class="space-y-4 md:space-y-6">
                @forelse($topMenus as $menu)
                <div class="flex items-center justify-between border-b border-slate-50 pb-3 last:border-0 last:pb-0 gap-4">
                    <div class="flex items-center space-x-3 md:space-x-4 min-w-0 flex-1">
                        <div class="w-10 h-10 md:w-12 md:h-12 bg-slate-100 rounded-xl md:rounded-2xl flex items-center justify-center font-black text-slate-500 flex-shrink-0 text-xs md:text-sm">
                            {{ $loop->iteration }}
                        </div>
                        <div class="min-w-0 flex-1">
                            <p class="font-black text-slate-800 text-xs md:text-sm uppercase truncate">{{ $menu->product_name }}</p>
                            <p class="text-[9px] md:text-[10px] text-slate-400 font-bold mt-0.5">{{ $menu->total_qty }} Kali Dipesan</p>
                        </div>
                    </div>
                    <span class="text-xs md:text-sm font-black text-slate-900 flex-shrink-0 whitespace-nowrap">
                        Rp {{ number_format($menu->total_sales, 0, ',', '.') }}
                    </span>
                </div>
                @empty
                <p class="text-center text-slate-400 py-10 text-xs italic">Belum ada data penjualan.</p>
                {{-- FIX REVISI UTAMA: Mengganti @endforeach menjadi @endforelse agar sinkron dengan @forelse di atas --}}
                @endforelse
            </div>
        </div>

        {{-- AKTIVITAS TERAKHIR --}}
        <div class="bg-slate-900 rounded-[1.8rem] md:rounded-[3rem] p-6 md:p-10 shadow-2xl text-white">
            <h2 class="text-lg md:text-xl font-black mb-6 md:mb-8 uppercase tracking-tighter">
                Aktivitas <span class="text-rose-500">Terakhir</span>
            </h2>
            <div class="space-y-4 max-h-[350px] md:max-h-[400px] overflow-y-auto pr-2 custom-scrollbar">
                @forelse($recentTransactions ?? [] as $order)
                <div class="border-b border-white/5 pb-3.5 last:border-0 last:pb-0">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-[8px] md:text-[9px] font-black text-rose-400 uppercase tracking-wider">Meja {{ $order->table_number }}</span>
                        <span class="text-[8px] md:text-[9px] text-slate-500 font-medium">{{ $order->updated_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-xs md:text-sm font-bold text-white uppercase tracking-tight">{{ $order->customer_name }} Selesai Bayar</p>
                    <p class="text-[10px] md:text-[11px] text-slate-400 mt-1 font-black">
                        <span class="text-amber-500">Rp</span> {{ number_format($order->total_price, 0, ',', '.') }}
                    </p>
                </div>
                @empty
                <p class="text-center text-slate-500 py-10 text-xs italic">Belum ada aktivitas transaksi.</p>
                @endforelse
            </div>
        </div>

    </div>
</main>
@endsection