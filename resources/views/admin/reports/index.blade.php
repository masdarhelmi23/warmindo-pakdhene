@extends('layouts.admin')

@section('content')
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
{{-- Library untuk Export Excel --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<main class="max-w-7xl mx-auto px-4 py-10" x-data="{ showModal: false, detailPesanan: {}, bukaDetail(data) { this.detailPesanan = data; this.showModal = true; } }">
    
    {{-- HEADER & FILTER --}}
    <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-black text-slate-900 uppercase">Laporan Penjualan</h1>
        </div>
        
        <form action="{{ route('reports.index') }}" method="GET" class="flex flex-wrap gap-2 items-center bg-white p-2 rounded-2xl border shadow-sm">
            <select name="filter" onchange="this.form.submit()" class="text-[10px] font-black p-3 outline-none rounded-xl uppercase">
                <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>Minggu Ini</option>
                <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Bulan Ini</option>
            </select>
            
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama..." class="text-[10px] font-bold p-3 outline-none rounded-xl w-32 border">
            
            <button type="submit" class="bg-slate-900 text-white px-4 py-3 rounded-xl text-[10px] font-black">FILTER</button>
            
            {{-- TOMBOL EXCEL --}}
            <button type="button" onclick="exportExcel()" class="bg-emerald-600 text-white px-6 py-3 rounded-xl font-black text-[10px] uppercase hover:bg-emerald-700 transition">
                Download Excel
            </button>
        </form>
    </div>

    {{-- STATISTIK --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-slate-900 p-6 rounded-[2rem] text-white shadow-lg"><p class="text-[9px] text-red-400 font-black uppercase">Cuan Lunas</p><h3 class="text-lg font-black">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3></div>
        <div class="bg-white p-6 rounded-[2rem] shadow border"><p class="text-[9px] text-slate-400 font-black uppercase">Transaksi</p><h3 class="text-lg font-black">{{ $totalTransactions }}</h3></div>
        <div class="bg-white p-6 rounded-[2rem] shadow border"><p class="text-[9px] text-orange-500 font-black uppercase">Belum Jadi</p><h3 class="text-lg font-black">{{ $pendingOrders }}</h3></div>
        <div class="bg-white p-6 rounded-[2rem] shadow border"><p class="text-[9px] text-slate-400 font-black uppercase">Total Porsi</p><h3 class="text-lg font-black">{{ $totalItems }}</h3></div>
    </div>

    {{-- TABEL --}}
    <div class="bg-white rounded-[2rem] shadow-xl overflow-hidden border">
        <table class="w-full text-left" id="reportTable">
            <thead class="bg-slate-50 text-[9px] text-slate-400 uppercase tracking-widest border-b">
                <tr>
                    <th class="px-6 py-4">Waktu</th>
                    <th class="px-6 py-4">Meja</th>
                    <th class="px-6 py-4">Menu</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Harga</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($history as $h)
                <tr class="hover:bg-red-50/50 transition cursor-pointer" @click="bukaDetail({invoice: '{{ $h->order_group_id }}', menu: '{{ $h->product_name }}', qty: '{{ $h->quantity }}', harga: '{{ number_format($h->total_price, 0, ',', '.') }}'})">
                    <td class="px-6 py-4 text-[11px] font-bold">{{ $h->created_at->format('d M H:i') }}</td>
                    <td class="px-6 py-4 text-[11px] font-black">MEJA {{ $h->table_number }}</td>
                    <td class="px-6 py-4 text-[11px] font-bold uppercase">{{ $h->product_name }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="px-2 py-1 rounded-full text-[9px] font-black {{ $h->status == 'done' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">
                            {{ strtoupper($h->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-[11px] font-black">Rp {{ number_format($h->total_price, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="py-10 text-center text-xs font-bold text-slate-400 uppercase">Belum ada data</td></tr>
                @endforelse
                
                {{-- BARIS TOTAL UNTUK EXCEL --}}
                <tr class="bg-slate-900 text-white">
                    <td colspan="4" class="px-6 py-4 text-right font-black uppercase text-[10px]">Total Pendapatan</td>
                    <td class="px-6 py-4 text-right font-black text-[11px]">Rp {{ number_format($totalIncome, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</main>

<script>
    function exportExcel() {
        var table = document.getElementById("reportTable");
        var wb = XLSX.utils.table_to_book(table, {sheet: "Laporan"});
        XLSX.writeFile(wb, "Laporan_Penjualan_Warmindo.xlsx");
    }
</script>
@endsection