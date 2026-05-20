@extends('layouts.admin')

@section('content')
<main class="max-w-7xl mx-auto py-10 px-4">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
        <h1 class="text-2xl font-black uppercase tracking-tight">Data Transaksi</h1>
        
        {{-- FORM FILTER & SEARCH --}}
        <form method="GET" action="{{ route('transactions.index') }}" class="flex flex-wrap gap-2 items-center">
            
            {{-- Filter Hari/Minggu --}}
            <select name="filter" onchange="this.form.submit()" class="p-3 rounded-xl border font-black text-xs uppercase outline-none shadow-sm">
                <option value="today" {{ $filter == 'today' ? 'selected' : '' }}>Hari Ini</option>
                <option value="week" {{ $filter == 'week' ? 'selected' : '' }}>Minggu Ini</option>
            </select>

            {{-- Pencarian Nama --}}
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari Nama Pelanggan..." 
                   class="p-3 rounded-xl border font-bold text-xs outline-none shadow-sm w-48">
            
            <button type="submit" class="bg-slate-900 text-white px-6 py-3 rounded-xl font-black text-[10px] uppercase hover:bg-red-600 transition">
                Cari
            </button>
            
            
        </form>
    </div>

    <div class="bg-white rounded-[2rem] shadow-xl overflow-hidden border border-slate-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-[10px] uppercase tracking-widest text-slate-400">
                    <tr>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Pesanan</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y text-xs font-bold">
                    @forelse($transactions as $t)
                    <tr class="hover:bg-red-50/50 transition-colors">
                        <td class="px-6 py-4 text-slate-600">{{ $t->created_at->format('d M H:i') }}</td>
                        <td class="px-6 py-4 text-slate-800">{{ $t->customer_name }}</td>
                        <td class="px-6 py-4 text-slate-800">{{ $t->product_name }} <span class="text-red-500">(x{{ $t->quantity }})</span></td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full text-[9px] font-black {{ $t->status == 'done' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                {{ strtoupper($t->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-slate-900">Rp {{ number_format($t->total_price, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-16 text-center font-black uppercase text-slate-400 tracking-widest">
                            Tidak ada transaksi ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</main>
@endsection