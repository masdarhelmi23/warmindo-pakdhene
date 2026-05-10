@extends('layouts.admin')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-4">
        <div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight uppercase">
                Kitchen <span class="text-red-600">Monitor</span>
            </h1>
            <p class="mt-2 text-slate-500 font-bold uppercase tracking-[0.2em] text-[10px]">Antrean Masak Real-Time</p>
        </div>
        
        <div class="flex items-center space-x-3 bg-white px-6 py-3 rounded-2xl shadow-sm border border-slate-100">
            <span class="relative flex h-3 w-3">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
            </span>
            <span class="text-xs font-black text-slate-600 uppercase tracking-widest">Sistem Online</span>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
        @forelse($orders as $o)
        <div class="bg-white rounded-[3rem] shadow-2xl shadow-red-100 border-2 border-white overflow-hidden transform transition-all hover:scale-[1.02]">
            <div class="bg-slate-900 p-6 flex justify-between items-center">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center text-white font-black shadow-lg shadow-red-900/50">
                        {{ $o->table_number }}
                    </div>
                    <span class="text-white font-black text-xs uppercase tracking-widest">Meja {{ $o->table_number }}</span>
                </div>
                <span class="text-slate-400 text-[9px] font-bold uppercase">{{ $o->created_at->diffForHumans() }}</span>
            </div>
            
            <div class="p-8">
                <div class="space-y-6 mb-10">
                    <div class="flex justify-between items-center border-b border-slate-50 pb-4">
                        <div class="flex-1">
                            <p class="text-xl font-black text-slate-800 leading-tight uppercase">{{ $o->product_name }}</p>
                            <p class="text-[10px] text-slate-400 font-bold mt-1 uppercase tracking-tighter">Status: Sedang Disiapkan</p>
                        </div>
                        <div class="ml-4">
                            <span class="text-3xl font-black text-red-600 italic">x{{ $o->quantity }}</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('kitchen.done', $o->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full bg-slate-100 hover:bg-green-600 hover:text-white text-slate-500 py-5 rounded-[2rem] font-black uppercase text-[10px] tracking-[0.2em] transition-all duration-300 shadow-inner group">
                        <span class="group-hover:tracking-[0.3em] transition-all">Tandai Selesai</span>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-40 text-center bg-white/50 rounded-[4rem] border-4 border-dashed border-white">
            <div class="bg-white w-24 h-24 rounded-full shadow-sm flex items-center justify-center mx-auto mb-6">
                <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <p class="text-slate-400 font-black uppercase tracking-[0.3em] text-sm">Belum Ada Antrean Masak</p>
            <p class="text-slate-300 text-[10px] mt-2 font-bold uppercase">Pesanan dari meja pelanggan akan muncul di sini</p>
        </div>
        @endforelse
    </div>
</main>
@endsection