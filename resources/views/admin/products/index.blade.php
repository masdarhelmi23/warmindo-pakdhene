@extends('layouts.admin')

@section('content')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .gradient-orange {
        background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    }
</style>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">
                Manajemen <span class="bg-gradient-to-r from-orange-500 to-orange-600 bg-clip-text text-transparent" style="-webkit-background-clip: text; -webkit-text-fill-color: transparent;">Menu</span>
            </h1>
            <p class="mt-2 text-slate-500 font-medium italic">Kelola daftar hidangan, harga, dan ketersediaan stok Warmindo.</p>
        </div>
        
        <a href="{{ route('products.create') }}" 
           class="inline-flex items-center px-8 py-4 bg-slate-900 hover:bg-orange-600 text-white font-bold rounded-2xl shadow-xl shadow-slate-200 transition-all duration-300 transform hover:-translate-y-1">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Menu Baru
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm border-l-4 border-l-orange-500">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Produk</p>
            <p class="text-2xl font-black text-slate-800">{{ $products->count() }} <span class="text-sm font-medium text-slate-400 italic">Item</span></p>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/50 overflow-hidden border border-slate-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest">Detail Produk</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-center">Kategori</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-center">Stok</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-center">Harga Jual</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                        <th class="px-8 py-6 text-xs font-black text-slate-400 uppercase tracking-widest text-right">Kelola</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($products as $p)
                    <tr class="hover:bg-orange-50/30 transition-all duration-200 group">
                        <td class="px-8 py-6">
                            <div class="flex items-center">
                                <div class="w-16 h-16 rounded-2xl overflow-hidden shadow-lg shadow-orange-100 mr-4 group-hover:scale-105 transition-transform bg-slate-50 border-2 border-white">
                                    @if($p->image)
                                        <img src="{{ asset('storage/' . $p->image) }}" class="w-full h-full object-cover" alt="{{ $p->name }}">
                                    @else
                                        <div class="w-full h-full gradient-orange flex items-center justify-center text-white font-black text-xl">
                                            {{ substr($p->name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <span class="block font-black text-slate-800 text-lg leading-tight uppercase tracking-tight">{{ $p->name }}</span>
                                    <span class="block text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">ID: #PROD-0{{ $p->id }}</span>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-6 text-center">
                            <span class="px-4 py-2 bg-slate-900 text-white text-[10px] font-black rounded-xl uppercase tracking-widest border border-slate-800 shadow-sm">
                                {{ $p->category->name ?? '-' }}
                            </span>
                        </td>

                        <td class="px-8 py-6 text-center">
                            <div class="flex flex-col items-center">
                                <span class="text-lg font-black {{ $p->stock <= 5 ? 'text-red-600' : 'text-slate-800' }}">
                                    {{ $p->stock }}
                                </span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Pcs Tersisa</span>
                            </div>
                        </td>

                        <td class="px-8 py-6 text-center">
                            <span class="text-lg font-black text-slate-900 tracking-tighter">
                                <span class="text-orange-500 text-sm font-bold">Rp</span> {{ number_format($p->price, 0, ',', '.') }}
                            </span>
                        </td>

                        <td class="px-8 py-6">
                            <div class="flex justify-center">
                                {{-- Logika Baru: Jika stok > 0 maka otomatis Tersedia --}}
                                @if($p->stock > 0)
                                    <span class="inline-flex items-center px-4 py-1.5 bg-green-500 text-white text-[10px] font-black rounded-full shadow-lg shadow-green-100 uppercase tracking-widest">
                                        <span class="w-1.5 h-1.5 bg-white rounded-full mr-2 animate-pulse"></span>
                                        Tersedia
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-4 py-1.5 bg-slate-200 text-slate-500 text-[10px] font-black rounded-full uppercase tracking-widest">
                                        Habis
                                    </span>
                                @endif
                            </div>
                        </td>

                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end space-x-3">
                                <a href="{{ route('products.edit', $p->id) }}" 
                                   class="p-3 bg-blue-600 text-white rounded-2xl hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </a>
                                
                                <form action="{{ route('products.destroy', $p->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-3 bg-red-600 text-white rounded-2xl hover:bg-red-700 transition-all shadow-lg shadow-red-200 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        @if($products->isEmpty())
        <div class="py-32 text-center">
            <div class="bg-slate-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6 border-2 border-dashed border-slate-200">
                <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0V9a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2"></path>
                </svg>
            </div>
            <p class="text-slate-400 font-bold text-xl uppercase tracking-widest">Belum ada data menu</p>
            <p class="text-slate-300 mt-2 italic">Klik tombol "Tambah Menu Baru" untuk memulai operasional.</p>
        </div>
        @endif
    </div>
</main>
@endsection