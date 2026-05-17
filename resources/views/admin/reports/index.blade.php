@extends('layouts.admin')

@section('content')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<main class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-4 md:py-10 mb-20 lg:mb-4" x-data={{ "{ " }}
    showModal: false, 
    detailPesanan: {},
    bukaDetail(data) {
        this.detailPesanan = data;
        this.showModal = true;
    }
{{ "}" }}>
    
    {{-- HEADER UTAMA & FILTER TANGGAL KEMBAR (REVISI MODEL SEBELUMNYA) --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 md:mb-12 gap-6 px-2 sm:px-0">
        <div>
            <h1 class="text-2xl md:text-4xl font-black text-slate-900 tracking-tight uppercase">
                Laporan <span class="text-red-600">Penjualan</span>
            </h1>
            <p class="mt-1 md:mt-2 text-slate-500 font-bold uppercase tracking-[0.15em] text-[9px] md:text-[10px]">Monitoring Arus Kas Warmindo PRO</p>
        </div>

        {{-- Form Filter Tanggal Model Kembar: Responsif Stack di Mobile, Row di Desktop --}}
        <div class="w-full lg:w-auto">
            <form action="{{ route('reports.index') }}" method="GET" class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 bg-white p-3 rounded-2xl md:rounded-3xl shadow-xl shadow-red-100/50 border border-white m-0">
                <div class="flex-1 px-4 py-1 sm:py-0 border-b sm:border-b-0 sm:border-r border-slate-100">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Dari</p>
                    <input type="date" name="start_date" value="{{ $startDate ?? $date }}" class="w-full text-xs font-bold text-slate-700 outline-none bg-transparent mt-0.5">
                </div>
                <div class="flex-1 px-4 py-1 sm:py-0">
                    <p class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Sampai</p>
                    <input type="date" name="end_date" value="{{ $endDate ?? $date }}" class="w-full text-xs font-bold text-slate-700 outline-none bg-transparent mt-0.5">
                </div>
                <button type="submit" class="bg-slate-900 text-white py-3.5 sm:py-3 px-5 rounded-xl md:rounded-2xl hover:bg-red-600 transition-all active:scale-95 shadow-lg shadow-slate-200 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-5 md:w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </form>
        </div>
    </div>

    {{-- KARTU RINGKASAN STATISTIK --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-6 mb-8 md:mb-12 px-2 sm:px-0">
        {{-- Cuan Lunas --}}
        <div class="bg-slate-900 p-4 md:p-6 rounded-[1.8rem] md:rounded-[2.5rem] shadow-2xl relative overflow-hidden col-span-2 sm:col-span-1 flex flex-col justify-center min-w-0">
            <p class="text-red-400 font-black text-[9px] md:text-[10px] uppercase tracking-[0.2em] mb-2 md:mb-3 text-center">Cuan Lunas</p>
            <h3 class="text-xl md:text-2xl font-black text-white text-center tracking-tighter truncate">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
        </div>

        {{-- Total Transaksi --}}
        <div class="bg-white p-4 md:p-6 rounded-[1.8rem] md:rounded-[2.5rem] shadow-xl border border-slate-100 flex flex-col justify-center min-w-0">
            <p class="text-slate-400 font-black text-[9px] md:text-[10px] uppercase tracking-[0.2em] mb-2 md:mb-3 text-center">Total Transaksi</p>
            <h3 class="text-xl md:text-3xl font-black text-slate-900 text-center tracking-tighter truncate">{{ $totalTransactions }} <span class="text-[9px] md:text-[10px] text-slate-400 uppercase font-bold">Struk</span></h3>
        </div>

        {{-- Belum Jadi --}}
        <div class="bg-white p-4 md:p-6 rounded-[1.8rem] md:rounded-[2.5rem] shadow-xl border border-slate-100 relative flex flex-col justify-center min-w-0">
            <p class="text-orange-500 font-black text-[9px] md:text-[10px] uppercase tracking-[0.2em] mb-2 md:mb-3 text-center">Belum Jadi</p>
            <h3 class="text-xl md:text-3xl font-black text-slate-900 text-center tracking-tighter truncate">{{ $pendingOrders }} <span class="text-[9px] md:text-[10px] text-slate-400 uppercase font-bold">Menu</span></h3>
        </div>

        {{-- Item Keluar --}}
        <div class="bg-white p-4 md:p-6 rounded-[1.8rem] md:rounded-[2.5rem] shadow-xl border border-slate-100 flex flex-col justify-center min-w-0">
            <p class="text-slate-400 font-black text-[9px] md:text-[10px] uppercase tracking-[0.2em] mb-2 md:mb-3 text-center">Item Keluar</p>
            <h3 class="text-xl md:text-3xl font-black text-slate-900 text-center tracking-tighter truncate">{{ $totalItems }} <span class="text-[9px] md:text-[10px] text-slate-400 uppercase font-bold">Porsi</span></h3>
        </div>
    </div>

    {{-- KONTEN UTAMA: DATA TABEL LAPORAN PENJUALAN --}}
    <div class="bg-white rounded-[2rem] md:rounded-[3.5rem] shadow-xl shadow-red-100/50 overflow-hidden border border-slate-100 mx-2 sm:mx-0">
        <div class="overflow-x-auto overflow-y-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] md:tracking-[0.2em] border-b border-slate-100">
                        <th class="px-4 md:px-10 py-4 md:py-6 whitespace-nowrap">Waktu</th>
                        <th class="px-4 md:px-10 py-4 md:py-6 whitespace-nowrap">Meja</th>
                        <th class="px-4 md:px-10 py-4 md:py-6 whitespace-nowrap">Menu</th>
                        <th class="px-4 md:px-10 py-4 md:py-6 text-center whitespace-nowrap">Status</th>
                        <th class="px-4 md:px-10 py-4 md:py-6 text-center whitespace-nowrap">Qty</th>
                        <th class="px-4 md:px-10 py-4 md:py-6 text-right whitespace-nowrap">Total Harga</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($history as $h)
                    <tr class="hover:bg-red-50/40 transition-colors select-none" 
                        @dblclick="bukaDetail({
                            waktu: '{{ $h->created_at->format('H:i') }}',
                            meja: '{{ $h->table_number }}',
                            menu: '{{ $h->product_name }}',
                            qty: '{{ $h->quantity }}',
                            harga: '{{ number_format($h->total_price, 0, ',', '.') }}',
                            status: '{{ $h->status }}',
                            invoice: '{{ $h->order_group_id }}'
                        })"
                        @click="if (window.innerWidth < 768) { bukaDetail({
                            waktu: '{{ $h->created_at->format('H:i') }}',
                            meja: '{{ $h->table_number }}',
                            menu: '{{ $h->product_name }}',
                            qty: '{{ $h->quantity }}',
                            harga: '{{ number_format($h->total_price, 0, ',', '.') }}',
                            status: '{{ $h->status }}',
                            invoice: '{{ $h->order_group_id }}'
                        }) }">
                        
                        <td class="px-4 md:px-10 py-4 md:py-6 font-bold text-slate-500 text-xs md:text-sm italic underline decoration-red-100 underline-offset-4 whitespace-nowrap">
                            {{ $h->created_at->format('H:i') }}
                        </td>
                        <td class="px-4 md:px-10 py-4 md:py-6 whitespace-nowrap">
                            <span class="w-7 h-7 md:w-8 md:h-8 bg-slate-100 text-slate-700 rounded-lg flex items-center justify-center font-black text-[10px]">
                                {{ $h->table_number }}
                            </span>
                        </td>
                        <td class="px-4 md:px-10 py-4 md:py-6 font-black text-slate-800 uppercase text-xs md:text-sm min-w-[150px] max-w-[240px] truncate">
                            {{ $h->product_name }}
                        </td>
                        <td class="px-4 md:px-10 py-4 md:py-6 text-center whitespace-nowrap">
                            @if($h->status == 'done')
                                <span class="px-2.5 py-1 bg-green-500 text-white text-[8px] font-black rounded-full uppercase tracking-wider">Selesai</span>
                            @elif($h->status == 'waiting')
                                <span class="px-2.5 py-1 bg-yellow-500 text-white text-[8px] font-black rounded-full uppercase tracking-wider">Dapur</span>
                            @else
                                <span class="px-2.5 py-1 bg-orange-500 text-white text-[8px] font-black rounded-full uppercase tracking-wider">Pending</span>
                            @endif
                        </td>
                        <td class="px-4 md:px-10 py-4 md:py-6 text-center font-black text-red-600 italic whitespace-nowrap text-xs md:text-sm">x{{ $h->quantity }}</td>
                        <td class="px-4 md:px-10 py-4 md:py-6 text-right font-black text-slate-900 text-xs md:text-sm whitespace-nowrap">
                            Rp {{ number_format($h->total_price, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-16 md:py-24 text-center font-black uppercase text-slate-300 tracking-widest text-xs md:text-sm italic">Belum ada transaksi laporan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- INTERFACE MODAL POPUP RINCIAN DETAIL --}}
    <template x-if="showModal">
        <div class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" @click.self="showModal = false">
            <div class="bg-white w-full max-w-sm md:max-w-md rounded-[2.2rem] md:rounded-[3rem] shadow-2xl overflow-hidden animate-item">
                <div class="bg-red-600 p-6 md:p-8 text-white flex justify-between items-center">
                    <h2 class="font-black uppercase tracking-widest text-xs md:text-sm">Rincian Pesanan</h2>
                    <button @click="showModal = false" class="text-white hover:rotate-90 transition-all">
                        <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="p-6 md:p-10 space-y-4 md:space-y-6">
                    <div class="flex justify-between border-b border-slate-100 pb-3 md:pb-4">
                        <span class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest">Invoice ID</span>
                        <span class="font-bold text-slate-800 text-xs truncate max-w-[180px]" x-text="detailPesanan.invoice"></span>
                    </div>
                    <div class="flex justify-between border-b border-slate-100 pb-3 md:pb-4">
                        <span class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest">Menu</span>
                        <span class="font-black text-red-600 text-xs md:text-sm uppercase truncate max-w-[180px]" x-text="detailPesanan.menu"></span>
                    </div>
                    <div class="flex justify-between border-b border-slate-100 pb-3 md:pb-4">
                        <span class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest">Jumlah</span>
                        <span class="font-black text-slate-800 text-xs md:text-sm" x-text="detailPesanan.qty + ' Porsi'"></span>
                    </div>
                    <div class="flex justify-between border-b border-slate-100 pb-3 md:pb-4">
                        <span class="text-[9px] md:text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Bayar</span>
                        <span class="font-black text-slate-900 text-lg md:text-xl tracking-tighter" x-text="'Rp ' + detailPesanan.harga"></span>
                    </div>
                    <div class="pt-2 md:pt-4">
                        <button @click="showModal = false" class="w-full bg-slate-900 text-white py-4 md:py-5 rounded-2xl font-black uppercase text-[9px] md:text-[10px] tracking-widest shadow-xl hover:bg-red-600 transition-all active:scale-95">
                            Tutup Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>

</main>

<style>
    .animate-item { animation: fadeIn 0.25s ease forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
</style>
@endsection