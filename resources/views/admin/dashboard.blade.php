@extends('layouts.admin')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 mb-20 md:mb-4">
    
    {{-- HEADER KASIR --}}
    <div class="mb-8 md:mb-12 flex flex-col md:flex-row justify-between md:items-end gap-6">
        <div>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 tracking-tighter uppercase leading-none">
                Kasir <span class="text-rose-600 border-b-4 border-rose-600 md:border-none">On-Duty</span>
            </h1>
            <p class="mt-3 text-slate-500 font-bold uppercase tracking-[0.1em] md:tracking-[0.2em] text-[10px] md:text-xs">
                Pantauan Operasional Meja & Pesanan
            </p>
        </div>
        <div class="bg-white px-5 py-3 md:px-6 md:py-4 rounded-2xl md:rounded-3xl shadow-xl shadow-slate-100 border border-slate-50 flex md:block items-center justify-between">
            <p class="text-slate-400 font-black text-[9px] md:text-[10px] uppercase tracking-widest md:mb-1">Status Server</p>
            <div class="flex items-center md:justify-end gap-3">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
                </span>
                <p class="text-slate-900 font-black text-xs md:text-sm uppercase tracking-tighter">{{ date('d M Y | H:i') }}</p>
            </div>
        </div>
    </div>

    {{-- KASIR QUICK STATS --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-8">
        
        {{-- CARD 1: ANTRIAN BAYAR --}}
        <div class="bg-white p-6 md:p-8 rounded-[2.5rem] md:rounded-[3rem] shadow-xl md:shadow-2xl shadow-rose-100 border-2 border-white group hover:border-rose-200 transition-all duration-500">
            <div class="w-12 h-12 md:w-16 md:h-16 bg-rose-50 rounded-xl md:rounded-2xl flex items-center justify-center mb-6 md:mb-8 group-hover:rotate-12 transition-transform shadow-inner">
                <svg class="w-6 h-6 md:w-8 md:h-8 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
            </div>
            <h3 class="text-slate-400 font-black text-[10px] md:text-xs uppercase tracking-widest">Perlu Konfirmasi</h3>
            <div class="flex items-baseline gap-2 mt-2 md:mt-4">
                <p class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter">{{ str_pad($pendingOrdersCount, 2, '0', STR_PAD_LEFT) }}</p>
                <span class="text-xs md:text-sm font-bold text-rose-600 uppercase">Nota</span>
            </div>
            <a href="{{ route('cashier.index') }}" class="mt-6 md:mt-8 flex items-center gap-2 text-[10px] font-black text-rose-600 uppercase tracking-widest hover:gap-4 transition-all">
                Proses Sekarang <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

        {{-- CARD 2: MEJA TERISI --}}
        <div class="bg-white p-6 md:p-8 rounded-[2.5rem] md:rounded-[3rem] shadow-xl md:shadow-2xl shadow-slate-100 border-2 border-white group hover:border-slate-300 transition-all duration-500">
            <div class="w-12 h-12 md:w-16 md:h-16 bg-slate-100 rounded-xl md:rounded-2xl flex items-center justify-center mb-6 md:mb-8 group-hover:scale-110 transition-transform shadow-inner">
                <svg class="w-6 h-6 md:w-8 md:h-8 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H9a2 2 0 00-2 2v16m12 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h3 class="text-slate-400 font-black text-[10px] md:text-xs uppercase tracking-widest">Meja Sedang Aktif</h3>
            <div class="flex items-baseline gap-2 mt-2 md:mt-4">
                <p class="text-5xl md:text-6xl font-black text-slate-900 tracking-tighter">{{ str_pad($activeTablesCount, 2, '0', STR_PAD_LEFT) }}</p>
                <span class="text-xs md:text-sm font-bold text-slate-400 uppercase">/ {{ $totalTables }} Meja</span>
            </div>
            <p class="mt-6 md:mt-8 text-[9px] md:text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pantauan Kapasitas Toko</p>
        </div>

        {{-- CARD 3: STATUS DAPUR --}}
        <div class="bg-slate-900 p-6 md:p-8 rounded-[2.5rem] md:rounded-[3rem] shadow-xl md:shadow-2xl shadow-slate-300 transition-all duration-500 relative overflow-hidden group">
            <div class="relative z-10 h-full flex flex-col justify-between">
                <div>
                    <h3 class="text-rose-400 font-black text-[10px] md:text-xs uppercase tracking-widest">Proses Dapur</h3>
                    <p class="text-3xl md:text-4xl font-black mt-3 md:mt-5 text-white tracking-tight leading-tight uppercase italic">
                        {{ $waitingOrdersCount }} Pesanan<br><span class="text-rose-600 text-2xl md:text-4xl">Sedang Dimasak</span>
                    </p>
                </div>
                <a href="{{ route('cashier.index') }}" class="mt-6 md:mt-0 w-full bg-rose-600 hover:bg-rose-700 text-white text-center py-3 md:py-4 rounded-xl md:rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] transition-all shadow-lg active:scale-95">
                    Monitor Dapur
                </a>
            </div>
            <div class="absolute -right-12 -bottom-12 w-32 h-32 md:w-48 md:h-48 bg-rose-600/10 rounded-full blur-3xl group-hover:bg-rose-600/20 transition-all"></div>
        </div>
    </div>

    {{-- BOTTOM SECTION: RECENT ACTIVITY --}}
    <div class="mt-8 md:mt-12 bg-white rounded-[2.5rem] md:rounded-[3.5rem] p-6 md:p-10 border-2 border-white shadow-2xl shadow-slate-200">
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 md:mb-10 gap-4">
            <div class="flex items-center space-x-4">
                <div class="w-1.5 h-6 md:w-2 md:h-8 bg-rose-600 rounded-full"></div>
                <h2 class="text-2xl md:text-3xl font-black text-slate-900 tracking-tight italic uppercase">Aktivitas Terbaru</h2>
            </div>
            <button onclick="window.location.reload()" class="w-max text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest hover:text-rose-600 transition-colors bg-slate-50 px-4 py-2 rounded-full md:bg-transparent md:p-0">
                Perbarui Data
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @forelse($recentOrders as $order)
            <div class="group flex items-center justify-between p-4 md:p-6 bg-slate-50 rounded-[2rem] md:rounded-[2.5rem] border border-transparent hover:border-rose-200 hover:bg-white transition-all duration-300">
                <div class="flex items-center gap-4 md:gap-5">
                    <div class="w-12 h-12 md:w-14 md:h-14 bg-white rounded-xl md:rounded-2xl flex items-center justify-center font-black text-lg md:text-xl text-rose-600 shadow-sm border border-slate-100 group-hover:bg-rose-600 group-hover:text-white transition-all">
                        {{ $order->table_number }}
                    </div>
                    <div>
                        <p class="text-xs md:text-sm font-black text-slate-800 uppercase tracking-tighter truncate max-w-[100px] md:max-w-none">{{ $order->customer_name }}</p>
                        <p class="text-[8px] md:text-[10px] text-slate-400 font-bold uppercase mt-0.5">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <div class="text-right">
                    <p class="text-xs md:text-sm font-black text-slate-900 italic">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    <span class="inline-block mt-1 text-[7px] md:text-[8px] font-black uppercase px-2 md:px-3 py-1 bg-rose-100 text-rose-600 rounded-full">
                        {{ $order->status }}
                    </span>
                </div>
            </div>
            @empty
            <div class="col-span-full py-12 md:py-20 text-center">
                <div class="w-16 h-16 md:w-24 md:h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6 border-2 border-dashed border-slate-200">
                    <svg class="w-8 h-8 md:w-10 md:h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <p class="text-slate-400 font-black text-[10px] md:text-xs uppercase tracking-[0.2em] md:tracking-[0.3em] px-4">Tenang, Belum ada aktivitas baru</p>
            </div>
            @endforelse
        </div>
    </div>
</main>
@endsection