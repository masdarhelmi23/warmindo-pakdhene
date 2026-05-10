@extends('layouts.admin')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
    
    <div class="mb-12">
        <h1 class="text-5xl font-black text-slate-900 tracking-tighter">
            Ringkasan <span class="text-red-600">Bisnis</span>
        </h1>
        <p class="mt-2 text-slate-500 font-bold uppercase tracking-[0.2em] text-xs">Real-time Analytics Dashboard</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="bg-white p-8 rounded-[3rem] shadow-2xl shadow-red-100 border border-white hover:shadow-red-200 transition-all duration-500 group">
            <div class="w-16 h-16 bg-red-50 rounded-2xl flex items-center justify-center mb-8 group-hover:rotate-6 transition-transform shadow-inner">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 118 0m-4 5v2m-8 0v2m-4-2H6m-4 0v2m4-2V9m4 0v2m4 0V9m4 0v2m-4 5h4m-4 0h-4m4 0v2m0-2V7"></path>
                </svg>
            </div>
            <h3 class="text-slate-400 font-black text-xs uppercase tracking-widest">Total Menu Hidangan</h3>
            <p class="text-6xl font-black mt-4 text-slate-900 tracking-tighter">
                {{ str_pad($totalProducts, 2, '0', STR_PAD_LEFT) }} 
                <span class="text-xl text-green-500 font-black ml-1">Live</span>
            </p>
        </div>

        <div class="bg-white p-8 rounded-[3rem] shadow-2xl shadow-red-100 border-b-8 border-red-600 hover:shadow-red-200 transition-all duration-500 group">
            <div class="w-16 h-16 bg-orange-50 rounded-2xl flex items-center justify-center mb-8 group-hover:scale-110 transition-transform shadow-inner">
                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <h3 class="text-slate-400 font-black text-xs uppercase tracking-widest">Meja Aktif / Total</h3>
            <p class="text-6xl font-black mt-4 text-slate-900 tracking-tighter">
                {{ str_pad($totalTables, 2, '0', STR_PAD_LEFT) }} <span class="text-xl text-slate-400 font-bold ml-1 tracking-normal">Unit</span>
            </p>
        </div>

        <div class="bg-slate-900 p-8 rounded-[3rem] shadow-2xl shadow-red-200 transition-all duration-500 relative overflow-hidden group">
            <div class="relative z-10">
                <h3 class="text-red-400 font-black text-xs uppercase tracking-widest">Pendapatan Hari Ini</h3>
                <p class="text-4xl font-black mt-5 text-white tracking-tight">Rp {{ number_format($incomeToday, 0, ',', '.') }}</p>
                
            </div>
            <div class="absolute -right-12 -bottom-12 w-48 h-48 bg-red-600/20 rounded-full blur-3xl"></div>
        </div>
    </div>

    <div class="mt-12 bg-white rounded-[3.5rem] p-12 border border-white shadow-2xl shadow-red-100">
        <div class="flex items-center justify-between mb-12">
            <div class="flex items-center space-x-4">
                <div class="w-3 h-10 bg-red-600 rounded-full shadow-lg shadow-red-200"></div>
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Aktivitas Terkini</h2>
            </div>
            <button class="bg-slate-50 text-red-600 font-black text-xs px-6 py-3 rounded-2xl hover:bg-red-600 hover:text-white transition-all uppercase tracking-widest border border-red-100">
                Lihat Semua History
            </button>
        </div>
        
        <div class="text-center py-24 bg-red-50/30 rounded-[2.5rem] border-4 border-dashed border-red-50">
            <div class="bg-white w-28 h-28 rounded-[2rem] shadow-xl flex items-center justify-center mx-auto mb-8 transform -rotate-6 hover:rotate-0 transition-transform border border-red-50">
                <svg class="w-14 h-14 text-red-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0V9a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2"></path>
                </svg>
            </div>
            <p class="text-slate-400 font-black text-xl uppercase tracking-[0.2em]">Menunggu Pesanan...</p>
            <p class="text-red-300 font-bold mt-2">Sistem siap menerima order dari Meja Pelanggan.</p>
        </div>
    </div>
</main>
@endsection