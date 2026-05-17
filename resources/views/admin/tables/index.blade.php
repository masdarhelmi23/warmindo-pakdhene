@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Library CDN untuk fitur download gambar --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

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

    {{-- GRID CARD MEJA --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-2 sm:px-0">
        @forelse($tables as $t)
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-red-100 border border-slate-100 p-6 md:p-8 flex flex-col justify-between group relative overflow-hidden transition-all">
            
            {{-- Bagian Atas Card --}}
            <div>
                <div class="flex justify-between items-center mb-6">
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

                {{-- REVISI INTERFACE: Menampilkan Live Pratinjau Desain Mewah Langsung di Dashboard Sebelum di-Download --}}
                <div class="mb-6 flex justify-center">
                    <div id="print-template-{{ $t->id }}" style="width: 340px; height: 480px; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); padding: 25px; box-sizing: border-box; display: flex; flex-direction: column; align-items: center; justify-content: space-between; text-align: center; font-family: 'Arial', sans-serif; position: relative; border: 5px solid #ffffff; border-radius: 24px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.15);">
                        
                        {{-- Aksen Bingkai Emas Tipis Dalam --}}
                        <div style="position: absolute; top: 6px; left: 6px; right: 6px; bottom: 6px; border: 1px solid rgba(251, 191, 36, 0.25); pointer-events: none; border-radius: 18px;"></div>

                        {{-- Header Atas --}}
                        <div style="width: 100%;">
                            <div style="font-size: 11px; font-weight: 800; color: #fbbf24; letter-spacing: 3px; text-transform: uppercase; margin-bottom: 4px;">SILAKAN PINDAI</div>
                            <div style="font-size: 20px; font-weight: 900; color: #ffffff; letter-spacing: 1px; text-transform: uppercase; margin-bottom: 8px; line-height: 1.2;">MENU DIGITAL</div>
                            <div style="height: 2.5px; width: 50px; background-color: #ef4444; margin: 0 auto;"></div>
                        </div>

                        {{-- Box QR Code --}}
                        <div style="padding: 12px; background: #ffffff; border-radius: 16px; display: inline-block; border: 2.5px solid #fbbf24; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);">
                            {!! QrCode::size(140)->margin(1)->color(15, 23, 42)->generate(route('order.menu', ['t' => $t->token])) !!}
                        </div>

                        {{-- Informasi Nomor Meja --}}
                        <div style="margin-top: 2px;">
                            <span style="font-size: 9px; font-weight: 800; color: #94a3b8; letter-spacing: 2px; text-transform: uppercase; display: block; margin-bottom: 1px;">NOMOR MEJA</span>
                            <span style="font-size: 26px; font-weight: 900; color: #ffffff; letter-spacing: 1px;">{{ $t->number }}</span>
                        </div>

                        {{-- Panduan Alur Pemesanan --}}
                        <div style="width: 100%; background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(251, 191, 36, 0.15); border-radius: 10px; padding: 10px; box-sizing: border-box;">
                            <div style="display: flex; justify-content: space-around; align-items: center; text-align: center;">
                                <div style="flex: 1;">
                                    <div style="font-size: 9px; font-weight: 900; color: #fbbf24; text-transform: uppercase;">1. PINDAI QR</div>
                                    <div style="font-size: 7.5px; color: #94a3b8; font-weight: 500; margin-top: 2px; line-height: 1.2;">Buka kamera ponsel Anda</div>
                                </div>
                                <div style="font-size: 10px; color: rgba(251, 191, 36, 0.3); font-weight: bold; padding: 0 2px;">&rarr;</div>
                                <div style="flex: 1;">
                                    <div style="font-size: 9px; font-weight: 900; color: #fbbf24; text-transform: uppercase;">2. PILIH MENU</div>
                                    <div style="font-size: 7.5px; color: #94a3b8; font-weight: 500; margin-top: 2px; line-height: 1.2;">Tentukan pesanan Anda</div>
                                </div>
                                <div style="font-size: 10px; color: rgba(251, 191, 36, 0.3); font-weight: bold; padding: 0 2px;">&rarr;</div>
                                <div style="flex: 1;">
                                    <div style="font-size: 9px; font-weight: 900; color: #fbbf24; text-transform: uppercase;">3. KASIR</div>
                                    <div style="font-size: 7.5px; color: #94a3b8; font-weight: 500; margin-top: 2px; line-height: 1.2;">Bayar langsung di kasir</div>
                                </div>
                            </div>
                        </div>

                        {{-- Footer Brand (REVISI FIX: Mengubah teks brand Warmindo Pakdhene dari merah menjadi putih) --}}
                        <div style="width: 100%;">
                            <div style="font-size: 8px; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 1px;">Direct Order Access</div>
                            <div style="font-size: 13px; color: #ffffff; font-weight: 900; letter-spacing: 2px; text-transform: uppercase;">WARMINDO PAKDHENE</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bagian Bawah Card (Aksi Tombol) --}}
            <div class="mt-2 relative z-10">
                <button onclick="downloadQR('{{ $t->id }}', '{{ $t->number }}')" class="w-full py-4 bg-emerald-600 hover:bg-emerald-700 text-white text-[10px] font-black rounded-xl uppercase tracking-widest transition-all shadow-md active:scale-95 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Klik Download QR
                </button>
                
                <form id="delete-meja-{{ $t->id }}" action="{{ route('tables.destroy', $t->id) }}" method="POST" class="m-0 mt-2 text-center">
                    @csrf 
                    @method('DELETE')
                    <button type="button" onclick="confirmDeleteMeja('{{ $t->id }}', '{{ $t->number }}')" class="text-slate-400 hover:text-red-600 text-[9px] font-bold transition-all uppercase tracking-widest">
                        Hapus Data Meja
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 text-center bg-white/50 rounded-[2.5rem] border-4 border-dashed border-white shadow-2xl">
            <p class="text-slate-400 font-black uppercase tracking-widest text-xs">Belum Ada Meja Terdaftar</p>
        </div>
        @endforelse
    </div>
</main>

<script>
    // FITUR DOWNLOAD KARTU QR HD LANGSUNG DARI PRATINJAU UTAMA
    function downloadQR(id, tableNumber) {
        const targetElement = document.getElementById(`print-template-${id}`);
        
        // Render pratinjau yang sedang dilihat menjadi file gambar jernih
        html2canvas(targetElement, {
            scale: 3, // Skala tinggi 3x lipat agar saat dicetak fisik tidak buram/pecah
            backgroundColor: null,
            useCORS: true
        }).then(canvas => {
            const imageUri = canvas.toDataURL("image/png");
            const downloadLink = document.createElement('a');
            
            downloadLink.href = imageUri;
            downloadLink.download = `QR_Premium_Meja_${tableNumber}_Warmindo.png`;
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
            
            // Pop-up mewah SweetAlert2
            Swal.fire({
                icon: 'success',
                title: 'Download Berhasil',
                text: `Gambar QR Meja ${tableNumber} sukses disimpan ke perangkat.`,
                timer: 1800,
                confirmButtonColor: '#059669',
                showConfirmButton: false
            });
        });
    }

    // TAMBAH MEJA VIA SWEETALERT2
    async function addTable() {
        const { value: tableNumber } = await Swal.fire({
            title: 'Registrasi Meja Baru',
            input: 'text',
            inputPlaceholder: 'Contoh: 05',
            showCancelButton: true,
            confirmButtonColor: '#e53e3e',
            cancelButtonColor: '#1e293b',
            confirmButtonText: 'Simpan Meja',
            cancelButtonText: 'Batal'
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

    // HAPUS MEJA
    function confirmDeleteMeja(id, number) {
        Swal.fire({
            title: 'Hapus Meja ' + number + '?',
            text: `Apakah kamu yakin ingin menghapus data MEJA ${number}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e53e3e',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-meja-${id}`).submit();
            }
        });
    }
</script>
@endsection