@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">
                Management <span class="text-red-600">Kategori</span>
            </h1>
            <p class="mt-2 text-slate-500 font-medium uppercase tracking-widest text-[10px]">Atur klasifikasi menu hidangan Warmindo</p>
        </div>
        
        <form action="{{ route('categories.store') }}" method="POST" class="flex gap-2">
            @csrf
            <input type="text" name="name" placeholder="Nama Kategori Baru..." 
                class="px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:border-red-500 outline-none font-bold text-slate-700 shadow-sm transition-all" required>
            <button type="submit" class="bg-slate-900 hover:bg-red-600 text-white px-8 py-4 rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl transition-all">
                Tambah
            </button>
        </form>
    </div>

    @if(session('error'))
        <script>Swal.fire('Gagal!', "{{ session('error') }}", 'error');</script>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($categories as $c)
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-red-100 border border-white p-8 group relative overflow-hidden transition-all hover:scale-[1.02]">
            <div class="flex justify-between items-center mb-6">
                <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-red-600 shadow-inner group-hover:bg-red-600 group-hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <span class="bg-slate-100 text-slate-400 text-[10px] font-black px-3 py-1 rounded-full uppercase">{{ $c->products_count }} Produk</span>
            </div>

            <h3 class="text-2xl font-black text-slate-800 uppercase tracking-tight mb-8">{{ $c->name }}</h3>

            <div class="flex justify-end">
                <form action="{{ route('categories.destroy', $c->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-red-200 hover:text-red-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
            
            <div class="absolute -right-4 -bottom-4 text-slate-50 opacity-10 transform rotate-12 group-hover:scale-110 transition-transform">
                <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 24 24"><path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
        </div>
        @empty
        <div class="col-span-full py-20 text-center bg-white/50 rounded-[3rem] border-4 border-dashed border-white">
            <p class="text-slate-400 font-black uppercase tracking-widest text-sm">Belum ada kategori terdaftar</p>
        </div>
        @endforelse
    </div>
</main>
@endsection