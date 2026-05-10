@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-12 gap-4">
        <div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">
                Manajemen <span class="bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent" style="-webkit-background-clip: text; -webkit-text-fill-color: transparent;">Meja Pelanggan</span>
            </h1>
            <p class="mt-2 text-slate-500 font-bold uppercase tracking-widest text-[10px]">Total Terdaftar: {{ $tables->count() }} Unit Meja</p>
        </div>
        
        <button onclick="addTable()" class="inline-flex items-center px-8 py-4 bg-slate-900 hover:bg-red-600 text-white font-black rounded-2xl shadow-xl transition-all transform hover:-translate-y-1 uppercase tracking-widest text-xs">
            Tambah Meja Baru
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
        @forelse($tables as $t)
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-red-100 border border-white p-8 group relative overflow-hidden transition-all">
            
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-red-600 rounded-xl flex items-center justify-center shadow-lg shadow-red-200">
                        <span class="text-white font-black text-sm">{{ $t->number }}</span>
                    </div>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Meja {{ $t->number }}</span>
                </div>
                <span class="px-3 py-1 {{ $t->status == 'Tersedia' ? 'bg-green-500' : 'bg-red-500' }} text-white text-[8px] font-black rounded-full uppercase">
                    {{ $t->status }}
                </span>
            </div>
            
            <div class="bg-slate-50 rounded-[2rem] p-6 mb-8 flex flex-col items-center justify-center border border-slate-100 group-hover:border-red-500 transition-all duration-500 shadow-inner relative">
                <div class="bg-white p-3 rounded-2xl shadow-sm">
                    {{-- QR Code mengarah ke URL pemesanan --}}
                    {{-- Pastikan variabel $baseUrl dikirim dari Controller --}}
                    {!! QrCode::size(120)->margin(1)->color(229, 62, 62)->generate(($baseUrl ?? url('/order/meja/')) . $t->number) !!}
                </div>
                <div class="mt-4 flex flex-col items-center">
                    <span class="text-[8px] text-slate-400 font-bold uppercase tracking-tighter">Scan to Order</span>
                    <span class="text-[9px] text-red-600 font-black tracking-widest">WARMINDO PRO</span>
                </div>
            </div>

            <div class="flex gap-3">
                <button onclick="window.print()" class="flex-1 py-3 bg-slate-900 hover:bg-red-600 text-white text-[9px] font-black rounded-xl uppercase tracking-[0.2em] transition-all shadow-lg shadow-slate-200 active:scale-95">
                    Cetak QR
                </button>
                
                <form action="{{ route('tables.destroy', $t->id) }}" method="POST" onsubmit="return confirm('Hapus Meja {{ $t->number }}?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="px-4 py-3 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center bg-white/50 rounded-[4rem] border-4 border-dashed border-white shadow-2xl shadow-red-100/50">
            <p class="text-slate-400 font-black uppercase tracking-[0.3em] text-sm">Belum Ada Meja Terdaftar</p>
        </div>
        @endforelse
    </div>
</main>

<script>
    async function addTable() {
        const { value: tableNumber } = await Swal.fire({
            title: 'Registrasi Meja',
            input: 'text',
            inputPlaceholder: 'Contoh: 01',
            showCancelButton: true,
            confirmButtonColor: '#e53e3e',
            cancelButtonColor: '#1e293b',
            confirmButtonText: 'Simpan',
            customClass: {
                popup: 'rounded-[2.5rem] p-10',
                input: 'rounded-xl border-2 border-slate-100 font-black text-center text-xl py-4 focus:border-red-500 shadow-inner'
            }
        });

        if (tableNumber) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("tables.store") }}';
            form.innerHTML = `@csrf <input type="hidden" name="number" value="${tableNumber}">`;
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endsection