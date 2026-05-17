@extends('layouts.admin')

@section('content')
<main class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-4 md:py-10 mb-20 lg:mb-4">
    
    {{-- HEADER UTAMA --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 md:mb-12 gap-4 px-2 sm:px-0">
        <div>
            <h1 class="text-2xl md:text-4xl font-black text-slate-900 tracking-tight uppercase">
                Panel <span class="text-rose-600">Kendali</span>
            </h1>
            <p class="mt-1 text-slate-500 font-bold uppercase tracking-[0.1em] md:tracking-[0.2em] text-[9px] md:text-[10px]">Validasi Pembayaran & Pantauan Masakan</p>
        </div>
        
        <div class="flex items-center justify-between sm:justify-end space-x-4">
            <div class="flex items-center space-x-2 md:space-x-3 bg-white px-4 py-2 md:px-6 md:py-3 rounded-xl md:rounded-2xl shadow-sm border border-slate-100">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span class="text-[9px] md:text-xs font-black text-slate-600 uppercase tracking-widest">Sistem Aktif</span>
            </div>
            <button onclick="window.location.reload()" class="bg-slate-900 text-white p-2 md:p-3 rounded-xl hover:bg-rose-600 transition-colors shadow-lg active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
            </button>
        </div>
    </div>

    {{-- BAGIAN 1: KONFIRMASI KASIR (Tahap Awal) --}}
    <div class="mb-8 md:mb-16">
        <div class="flex items-center gap-3 md:gap-4 mb-4 md:mb-8 px-2 sm:px-0">
            <h2 class="text-lg md:text-2xl font-black text-slate-800 uppercase tracking-tighter">1. Konfirmasi <span class="text-rose-600">Bayar</span></h2>
            <div class="h-px flex-1 bg-gradient-to-r from-rose-200 to-transparent"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-10">
            @forelse($orders as $groupId => $items)
                @php 
                    $firstItem = $items->first(); 
                    $totalBayar = $items->sum('total_price');
                @endphp
                
                <div class="bg-white rounded-[1.8rem] md:rounded-[3rem] shadow-xl shadow-slate-100 border-2 border-white overflow-hidden transform transition-all">
                    <div class="bg-rose-600 p-4 md:p-6 flex justify-between items-center text-white">
                        <div class="flex items-center space-x-2.5 md:space-x-3 min-w-0 flex-1">
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-white/20 rounded-xl flex items-center justify-center font-black text-sm flex-shrink-0">
                                {{ $firstItem->table_number }}
                            </div>
                            <span class="font-black text-xs uppercase tracking-widest truncate">{{ $firstItem->customer_name }}</span>
                        </div>
                        <span class="text-[9px] md:text-[10px] font-bold opacity-80 uppercase bg-black/10 px-2 py-1 rounded-full ml-2 flex-shrink-0">{{ $firstItem->created_at->format('H:i') }}</span>
                    </div>
                    
                    <div class="p-4 md:p-8">
                        <div class="space-y-2 mb-4 md:mb-6">
                            @foreach($items as $item)
                            <div class="flex justify-between items-center bg-slate-50 border border-slate-100 p-2.5 rounded-xl gap-2">
                                <span class="font-black text-xs text-slate-900 uppercase tracking-tight break-words flex-1">
                                    {{ $item->product_name }} 
                                    <span class="text-rose-600 ml-1 font-black">x{{ $item->quantity }}</span>
                                </span>
                                <span class="text-slate-500 font-bold text-[11px] shrink-0">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>

                        <div class="bg-slate-900 p-3 md:p-4 rounded-xl md:rounded-2xl mb-4 md:mb-8 flex justify-between items-center text-white">
                            <span class="text-[8px] md:text-[9px] font-black uppercase text-slate-400">Total Tagihan</span>
                            <span class="text-base md:text-xl font-black text-white tracking-tighter">Rp {{ number_format($totalBayar, 0, ',', '.') }}</span>
                        </div>

                        <form action="{{ route('cashier.approve') }}" method="POST" class="m-0">
                            @csrf
                            <input type="hidden" name="order_group_id" value="{{ $groupId }}">
                            <button type="submit" class="w-full bg-slate-900 hover:bg-rose-600 text-white py-3.5 md:py-5 rounded-xl md:rounded-[2rem] font-black uppercase text-[10px] tracking-[0.15em] md:tracking-[0.2em] transition-all shadow-lg active:scale-95">
                                Terima Uang & Masak
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-10 md:py-20 text-center bg-white/50 rounded-2xl md:rounded-[4rem] border-4 border-dashed border-white px-4">
                    <p class="text-slate-400 font-black uppercase tracking-[0.2em] md:tracking-[0.3em] text-xs md:text-sm italic">Menunggu pesanan baru...</p>
                </div>
            @endforelse
        </div>
    </div>

    {{-- BAGIAN 2: PANTAUAN DAPUR (Proses Masak) --}}
    <div class="mb-8 md:mb-20">
        <div class="flex items-center gap-3 md:gap-4 mb-4 md:mb-8 px-2 sm:px-0">
            <h2 class="text-lg md:text-2xl font-black text-slate-800 uppercase tracking-tighter">2. Pantauan <span class="text-blue-600">Dapur</span></h2>
            <div class="h-px flex-1 bg-gradient-to-r from-blue-200 to-transparent"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-10">
            @forelse($kitchenOrders ?? [] as $groupId => $items)
                @php $firstItem = $items->first(); @endphp
                <div class="bg-white rounded-[1.8rem] md:rounded-[3rem] shadow-xl shadow-blue-50 border-2 border-white overflow-hidden transform transition-all">
                    <div class="bg-slate-900 p-4 md:p-6 flex justify-between items-center text-white">
                        <div class="flex items-center space-x-2.5 md:space-x-3 min-w-0 flex-1">
                            <div class="w-8 h-8 md:w-10 md:h-10 bg-blue-600 rounded-xl flex items-center justify-center font-black text-sm shadow-lg flex-shrink-0">
                                {{ $firstItem->table_number }}
                            </div>
                            <div class="min-w-0 flex-1">
                                <span class="font-black text-xs uppercase tracking-widest block truncate">{{ $firstItem->customer_name }}</span>
                                <span class="text-blue-400 text-[8px] font-bold uppercase block mt-0.5">Meja {{ $firstItem->table_number }}</span>
                            </div>
                        </div>
                        <span class="text-slate-400 text-[9px] md:text-[10px] font-black bg-white/5 px-2 py-1 rounded-full ml-2 flex-shrink-0">{{ $firstItem->created_at->format('H:i') }}</span>
                    </div>
                    
                    <div class="p-4 md:p-8">
                        <div class="space-y-2 md:space-y-4 mb-4 md:mb-8">
                            @foreach($items as $item)
                            <div class="flex justify-between items-center border-b border-slate-100 pb-2 md:pb-4 gap-4">
                                <p class="font-black text-slate-800 text-xs md:text-sm uppercase break-words flex-1">{{ $item->product_name }}</p>
                                <span class="text-base md:text-xl font-black text-blue-600 italic shrink-0">x{{ $item->quantity }}</span>
                            </div>
                            @endforeach
                        </div>

                        <form action="{{ route('kitchen.done.group') }}" method="POST" class="m-0">
                            @csrf
                            <input type="hidden" name="order_group_id" value="{{ $groupId }}">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-green-600 text-white py-3.5 md:py-5 rounded-xl md:rounded-[2rem] font-black uppercase text-[10px] tracking-widest transition-all shadow-xl active:scale-95">
                                Makanan Sudah Siap
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-10 md:py-16 text-center bg-blue-50/30 rounded-2xl md:rounded-[4rem] border-4 border-dashed border-white text-blue-300 font-black uppercase tracking-[0.2em] md:tracking-[0.3em] text-xs md:text-sm px-4">
                    Belum ada yang perlu dimasak
                </div>
            @endforelse
        </div>
    </div>

    {{-- BAGIAN 3: TABEL RIWAYAT SELESAI --}}
    <div class="mt-6 md:mt-12 bg-white rounded-[1.8rem] md:rounded-[3rem] shadow-xl shadow-slate-100 border-2 border-white overflow-hidden">
        <div class="p-4 md:p-10">
            <div class="flex items-center justify-between mb-4 md:mb-8 gap-3 px-2 sm:px-0">
                <h2 class="text-lg md:text-2xl font-black text-slate-800 uppercase tracking-tighter">3. Riwayat <span class="text-green-600">Selesai</span></h2>
                <span class="text-[8px] md:text-[10px] font-black bg-green-50 text-green-600 px-3 py-1.5 rounded-full uppercase tracking-widest flex-shrink-0">Hari Ini</span>
            </div>

            {{-- 3.A TAMPILAN MOBILE: Berupa List Card Vertikal --}}
            <div class="block md:hidden space-y-4">
                @forelse($completedOrders as $groupId => $items)
                    @php $firstItem = $items->first(); @endphp
                    <div class="bg-white rounded-2xl p-4 border border-slate-200 shadow-sm flex flex-col gap-3">
                        <div class="flex justify-between items-center border-b border-slate-200 pb-2.5">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 bg-slate-900 text-white rounded-md flex items-center justify-center text-[10px] font-black">{{ $firstItem->table_number }}</span>
                                <span class="font-black text-xs text-slate-800 uppercase tracking-tight truncate max-w-[150px]">{{ $firstItem->customer_name }}</span>
                            </div>
                            <span class="text-[10px] font-bold text-slate-400">{{ $firstItem->updated_at->format('H:i') }}</span>
                        </div>
                        
                        <div class="flex flex-wrap gap-1.5">
                            @foreach($items as $item)
                                <span class="text-[10px] font-bold bg-slate-50 border border-slate-200 text-slate-600 px-2.5 py-1 rounded-md uppercase">
                                    {{ $item->product_name }} <b class="text-slate-900 font-black">x{{ $item->quantity }}</b>
                                </span>
                            @endforeach
                        </div>
                        
                        <div class="text-right">
                            <span class="inline-block text-[8px] font-black text-green-600 bg-green-50 border border-green-200 px-2 py-0.5 rounded uppercase tracking-wider">Ready</span>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center text-slate-400 font-bold uppercase text-[10px] tracking-widest italic bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                        Belum ada transaksi selesai
                    </div>
                @endforelse
            </div>

            {{-- 3.B TAMPILAN DESKTOP: Berupa Tabel Utuh (REVISI: Ditambah border-b pembatas baris pesanan biar kelihatan) --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b-2 border-slate-200 bg-slate-50/50">
                            <th class="py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap pr-4 pl-4">Jam</th>
                            <th class="py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap pr-4">Meja</th>
                            <th class="py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap pr-4">Pelanggan</th>
                            <th class="py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest whitespace-nowrap pr-4">Pesanan</th>
                            <th class="py-4 text-[11px] font-black text-slate-400 uppercase tracking-widest text-right whitespace-nowrap pr-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200"> {{-- REVISI: Mengganti divide-slate-100 menjadi divide-slate-200 agar pembatas baris antar-nota tebal --}}
                        @forelse($completedOrders as $groupId => $items)
                            @php $firstItem = $items->first(); @endphp
                            {{-- REVISI: Menggunakan even:bg-slate-50/40 untuk membuat efek stripe belang agar pembacaan baris rapi --}}
                            <tr class="hover:bg-orange-50/30 transition-colors even:bg-slate-50/40">
                                <td class="py-5 md:py-6 text-sm font-bold text-slate-500 whitespace-nowrap pr-4 pl-4">{{ $firstItem->updated_at->format('H:i') }}</td>
                                <td class="py-5 md:py-6 pr-4">
                                    <span class="w-8 h-8 bg-slate-900 text-white rounded-lg flex items-center justify-center text-xs font-black shadow-sm">{{ $firstItem->table_number }}</span>
                                </td>
                                <td class="py-5 md:py-6 text-sm font-black text-slate-800 uppercase whitespace-nowrap pr-4">{{ $firstItem->customer_name }}</td>
                                <td class="py-5 md:py-6 pr-4 min-w-[200px]">
                                    <div class="flex flex-wrap gap-1.5">
                                        @foreach($items as $item)
                                            <span class="text-[10px] font-bold bg-slate-100 text-slate-700 px-2.5 py-1 rounded-full uppercase border border-slate-200/60 whitespace-nowrap">
                                                {{ $item->product_name }} <b class="text-slate-900 font-black">x{{ $item->quantity }}</b>
                                            </span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="py-5 md:py-6 text-right whitespace-nowrap pr-4">
                                    <span class="text-[9px] font-black text-green-600 bg-green-50 border border-green-200 px-2.5 py-1 rounded-lg uppercase tracking-tighter">Ready</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-20 text-center text-slate-400 font-bold uppercase text-[11px] tracking-widest italic">Belum ada transaksi selesai hari ini</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</main>
@endsection