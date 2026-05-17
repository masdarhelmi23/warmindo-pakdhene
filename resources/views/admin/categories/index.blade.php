@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 py-6 md:py-10" x-data="{ editModalOpen: false, editId: '', editName: '' }">
    
    {{-- HEADER & FORM INPUT (CREATE) --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 md:mb-12 gap-6 px-2 sm:px-0">
        <div>
            <h1 class="text-3xl md:text-4xl font-black text-slate-900 tracking-tight uppercase">
                Management <span class="text-rose-600">Kategori</span>
            </h1>
            <p class="mt-1 md:mt-2 text-slate-500 font-bold uppercase tracking-[0.15em] text-[9px] md:text-[10px]">Atur klasifikasi menu hidangan Warmindo</p>
        </div>
        
        {{-- Form Tambah Kategori Baru --}}
        <form action="{{ route('categories.store') }}" method="POST" class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto m-0">
            @csrf
            <input type="text" name="name" placeholder="Nama Kategori Baru..." 
                class="w-full sm:w-72 px-6 py-4 bg-white border-2 border-slate-100 rounded-2xl focus:ring-0 focus:border-rose-500 outline-none font-bold text-slate-700 shadow-sm transition-all text-sm" required>
            <button type="submit" class="bg-slate-900 hover:bg-rose-600 text-white px-8 py-4 rounded-2xl font-black uppercase text-xs tracking-widest shadow-xl transition-all active:scale-95">
                Tambah Kategori
            </button>
        </form>
    </div>

    {{-- ALERT INTERNAL LARAVEL VIA SWEETALERT2 --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#3085d6',
                customClass: { popup: 'rounded-[2rem]' }
            });
        </script>
    @endif

    @if(session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#e53e3e',
                customClass: { popup: 'rounded-[2rem]' }
            });
        </script>
    @endif

    {{-- GRID CARD KATEGORI (READ, UPDATE, DELETE) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-8 px-2 sm:px-0">
        @forelse($categories as $c)
        <div class="bg-white rounded-[1.8rem] md:rounded-[2.5rem] shadow-xl shadow-red-100/50 border border-slate-100 p-6 md:p-8 group relative overflow-hidden transition-all hover:scale-[1.01]">
            
            <div class="flex justify-between items-center mb-5 md:mb-6">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-rose-50 rounded-xl md:rounded-2xl flex items-center justify-center text-rose-600 shadow-inner group-hover:bg-rose-600 group-hover:text-white transition-colors">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <span class="bg-slate-100 text-slate-500 text-[9px] md:text-[10px] font-black px-3 py-1.5 rounded-full uppercase tracking-wider">
                    {{ $c->products_count ?? $c->products->count() }} Produk
                </span>
            </div>

            <h3 class="text-xl md:text-2xl font-black text-slate-800 uppercase tracking-tight mb-6 md:mb-8 truncate pr-6">{{ $c->name }}</h3>

            {{-- ACTION BUTTONS GROUP --}}
            <div class="flex justify-end gap-2 relative z-10">
                {{-- REVISI: Tombol Edit (Memasukkan data ke modal AlpineJS) --}}
                <button type="button" @click="editModalOpen = true; editId = '{{ $c->id }}'; editName = '{{ $c->name }}'"
                        class="p-2 md:p-3 bg-blue-50 hover:bg-blue-600 text-blue-500 hover:text-white rounded-xl transition-all shadow-sm active:scale-95">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                </button>

                {{-- Tombol Hapus Terintegrasi SweetAlert2 --}}
                <form id="delete-form-{{ $c->id }}" action="{{ route('categories.destroy', $c->id) }}" method="POST" class="m-0">
                    @csrf 
                    @method('DELETE')
                    <button type="button" onclick="confirmDelete('{{ $c->id }}', '{{ $c->name }}')" 
                            class="p-2 md:p-3 bg-red-50 hover:bg-red-600 text-red-400 hover:text-white rounded-xl transition-all shadow-sm active:scale-95">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </button>
                </form>
            </div>
            
            {{-- Watermark Background --}}
            <div class="absolute -right-4 -bottom-4 text-slate-100 opacity-30 lg:opacity-10 transform rotate-12 group-hover:scale-110 transition-transform pointer-events-none">
                <svg class="w-20 h-20 md:w-24 md:h-24" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 md:py-25 text-center bg-white/50 rounded-2xl md:rounded-[3rem] border-4 border-dashed border-white px-4">
            <p class="text-slate-400 font-black uppercase tracking-widest text-xs md:text-sm italic">Belum ada kategori terdaftar</p>
        </div>
        @endforelse
    </div>

    {{-- REVISI: MODAL UPDATE KATEGORI (POPUP EDIT MEWAH) --}}
    <div x-show="editModalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-x-hidden overflow-y-auto" style="display: none;">
        {{-- Overlay Latar Belakang Gelap --}}
        <div class="fixed inset-0 bg-slate-900/60 transition-opacity" @click="editModalOpen = false"></div>

        {{-- Isi Konten Card Modal --}}
        <div x-show="editModalOpen" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="relative bg-white rounded-[2rem] shadow-2xl max-w-md w-full p-6 md:p-8 border border-slate-100 z-10">
            
            <div class="mb-6">
                <h3 class="text-xl font-black text-slate-900 uppercase tracking-tight">Edit Kategori</h3>
                <p class="text-xs text-slate-400 mt-1 font-bold uppercase tracking-wider">Ubah nama klasifikasi hidangan menu</p>
            </div>

            {{-- Form Action diubah dinamis lewat JavaScript AlpineJS berdasarkan rute 'categories.update' --}}
            <form :action="'/categories/' + editId" method="POST" class="m-0">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Nama Kategori</label>
                    <input type="text" name="name" x-model="editName"
                        class="w-full px-5 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-0 focus:border-rose-500 outline-none font-bold text-slate-800 shadow-inner transition-all text-sm" required>
                </div>

                <div class="flex justify-end gap-3">
                    <button type="button" @click="editModalOpen = false"
                            class="px-5 py-3 bg-slate-100 hover:bg-slate-200 text-slate-500 font-bold rounded-xl text-xs uppercase tracking-widest transition-all">
                        Batal
                    </button>
                    <button type="submit"
                            class="px-6 py-3 bg-slate-900 hover:bg-rose-600 text-white font-black rounded-xl text-xs uppercase tracking-widest shadow-lg shadow-slate-200 transition-all">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</main>

{{-- SCRIPT DIALOG HAPUS --}}
<script>
function confirmDelete(id, name) {
    Swal.fire({
        title: 'Hapus Kategori?',
        html: `Apakah kamu yakin ingin menghapus kategori <b class="text-red-600 uppercase">"${name}"</b>?<br><span class="text-xs text-slate-400 italic">Menu yang terikat kategori ini mungkin akan kehilangan relasinya.</span>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e53e3e',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
        background: '#ffffff',
        reverseButtons: true,
        customClass: {
            title: 'font-black text-slate-800 uppercase tracking-tight',
            popup: 'rounded-[2rem] p-6 md:p-8 shadow-2xl'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`delete-form-${id}`).submit();
        }
    });
}
</script>
@endsection