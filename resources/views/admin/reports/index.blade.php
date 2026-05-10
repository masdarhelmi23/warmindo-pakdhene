@extends('layouts.admin')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">
                Laporan <span class="text-red-600">Penjualan</span>
            </h1>
            <p class="mt-2 text-slate-500 font-bold uppercase tracking-widest text-[10px]">Monitoring Arus Kas Warmindo PRO</p>
        </div>

        <form action="{{ route('reports.index') }}" method="GET" class="flex items-center gap-3 bg-white p-2 rounded-3xl shadow-xl shadow-red-100 border border-white">
            <input type="date" name="date" value="{{ $date }}" 
                class="px-6 py-3 bg-slate-50 border-none rounded-2xl font-bold text-slate-700 focus:ring-2 focus:ring-red-500 outline-none">
            <button type="submit" class="bg-slate-900 text-white px-8 py-3 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-red-600 transition-all">
                Filter
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
        <div class="bg-slate-900 p-6 rounded-[2.5rem] shadow-2xl relative overflow-hidden">
            <p class="text-red-400 font-black text-[10px] uppercase tracking-[0.2em] mb-3 text-center">Cuan Lunas</p>
            <h3 class="text-2xl font-black text-white text-center tracking-tighter">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
            <div class="absolute -right-8 -bottom-8 w-20 h-20 bg-red-600 opacity-20 rounded-full blur-2xl"></div>
        </div>

        <div class="bg-white p-6 rounded-[2.5rem] shadow-2xl shadow-red-100 border border-white">
            <p class="text-slate-400 font-black text-[10px] uppercase tracking-[0.2em] mb-3 text-center">Total Transaksi</p>
            <h3 class="text-3xl font-black text-slate-900 text-center tracking-tighter">{{ $totalTransactions }} <span class="text-[10px] text-slate-300 uppercase">Struk</span></h3>
        </div>

        <div class="bg-white p-6 rounded-[2.5rem] shadow-2xl shadow-red-100 border border-white relative">
            <p class="text-orange-500 font-black text-[10px] uppercase tracking-[0.2em] mb-3 text-center">Belum Jadi</p>
            <h3 class="text-3xl font-black text-slate-900 text-center tracking-tighter">{{ $pendingOrders }} <span class="text-[10px] text-slate-300 uppercase">Menu</span></h3>
            @if($pendingOrders > 0)
                <span class="absolute top-4 right-6 w-2 h-2 bg-orange-500 rounded-full animate-ping"></span>
            @endif
        </div>

        <div class="bg-white p-6 rounded-[2.5rem] shadow-2xl shadow-red-100 border border-white">
            <p class="text-slate-400 font-black text-[10px] uppercase tracking-[0.2em] mb-3 text-center">Item Keluar</p>
            <h3 class="text-3xl font-black text-slate-900 text-center tracking-tighter">{{ $totalItems }} <span class="text-[10px] text-slate-300 uppercase">Porsi</span></h3>
        </div>
    </div>

    <div class="bg-white rounded-[3.5rem] shadow-2xl shadow-red-100 overflow-hidden border border-white">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">
                        <th class="px-10 py-6">Waktu</th>
                        <th class="px-10 py-6">Meja</th>
                        <th class="px-10 py-6">Menu</th>
                        <th class="px-10 py-6 text-center">Status</th>
                        <th class="px-10 py-6 text-center">Qty</th>
                        <th class="px-10 py-6 text-right">Total Harga</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($history as $h)
                    <tr class="hover:bg-red-50/30 transition-all">
                        <td class="px-10 py-6 font-bold text-slate-500 text-sm">
                            {{ $h->created_at->format('H:i') }}
                        </td>
                        <td class="px-10 py-6">
                            <span class="w-8 h-8 bg-slate-100 text-slate-700 rounded-lg flex items-center justify-center font-black text-[10px]">
                                {{ $h->table_number }}
                            </span>
                        </td>
                        <td class="px-10 py-6 font-black text-slate-800 uppercase text-xs">{{ $h->product_name }}</td>
                        <td class="px-10 py-6 text-center">
                            @if($h->status == 'lunas')
                                <span class="px-3 py-1 bg-green-500 text-white text-[8px] font-black rounded-full uppercase tracking-widest">Lunas</span>
                            @else
                                <span class="px-3 py-1 bg-orange-500 text-white text-[8px] font-black rounded-full uppercase tracking-widest">Pending</span>
                            @endif
                        </td>
                        <td class="px-10 py-6 text-center font-black text-red-600 italic">x{{ $h->quantity }}</td>
                        <td class="px-10 py-6 text-right font-black text-slate-900 text-sm">
                            Rp {{ number_format($h->total_price, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="py-20 text-center font-black uppercase text-slate-300">Belum ada transaksi</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection