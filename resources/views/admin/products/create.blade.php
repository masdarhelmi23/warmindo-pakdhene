@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    
    <div class="mb-10">
        <a href="{{ route('products.index') }}" class="inline-flex items-center text-sm font-bold text-red-600 hover:text-red-700 transition mb-4 group">
            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Menu
        </a>

        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">
            Tambah <span class="bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent" style="-webkit-background-clip:text; -webkit-text-fill-color:transparent;">Menu Baru</span>
        </h1>

        <p class="mt-2 text-slate-500 font-medium font-semibold uppercase tracking-widest text-xs">
            Informasi Produk Digital Warmindo Pro
        </p>
    </div>

    <form id="productForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="flex-1 space-y-8">
                <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-red-100 border border-white p-10">
                    <div class="grid grid-cols-1 gap-8">
                        
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Nama Hidangan</label>
                            <input type="text" name="name" id="name"
                                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-0 focus:border-red-500 outline-none transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300 shadow-inner" 
                                placeholder="Contoh: Indomie Goreng Spesial">
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Deskripsi Menu</label>
                            <textarea name="description" rows="3"
                                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-0 focus:border-red-500 outline-none transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300 shadow-inner"
                                placeholder="Jelaskan detail rasa atau isi porsi hidangan ini..."></textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Kategori Menu</label>

                                <div class="relative">
                                    <select name="category_id" id="category"
                                        class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-0 focus:border-red-500 outline-none font-bold text-slate-700 appearance-none shadow-inner transition-all">
                                        <option value="">-- Pilih Kategori --</option>

                                        @foreach($categories as $cat)
                                            <option value="{{ $cat->id }}">
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <div class="absolute inset-y-0 right-0 flex items-center pr-6 pointer-events-none">
                                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 9l-7 7-7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Stok Barang</label>

                                <input type="number" name="stock" id="stock"
                                    class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-0 focus:border-red-500 outline-none transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300 shadow-inner" 
                                    placeholder="0">
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Harga Jual</label>

                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-6 text-red-600 font-black">Rp</span>

                                    <input type="number" name="price" id="price"
                                        class="w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-0 focus:border-red-500 outline-none transition-all duration-300 font-bold text-slate-700 placeholder:text-slate-300 shadow-inner" 
                                        placeholder="0">
                                </div>
                            </div>

                        </div>

                        <div class="flex items-center justify-between p-6 bg-slate-900 rounded-3xl shadow-xl">
                            <div>
                                <p class="font-bold text-white uppercase text-xs tracking-widest">Publish Menu</p>
                                <p class="text-[10px] text-slate-400 font-medium">Menu akan langsung muncul di halaman scan pelanggan.</p>
                            </div>

                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="status" value="1" class="sr-only peer" checked>

                                <div class="w-14 h-7 bg-slate-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-red-600 after:content-[''] after:absolute after:top-[4px] after:left-[4px] after:bg-white after:rounded-full after:h-5 after:w-6 after:transition-all"></div>
                            </label>
                        </div>

                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" 
                        class="w-full bg-slate-900 hover:bg-red-600 text-white font-black py-6 rounded-[2rem] shadow-2xl transition-all duration-300 transform hover:-translate-y-2 flex items-center justify-center space-x-3 uppercase tracking-[0.2em] text-sm">

                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>

                        <span>Simpan Data Ke Sistem</span>
                    </button>
                </div>
            </div>

            <div class="w-full lg:w-[400px] space-y-6">
                <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-red-100 border border-white p-8">

                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 text-center">
                        Foto Produk Hidangan
                    </label>
                    
                    <div id="image-preview-container" class="relative group cursor-pointer w-full aspect-square bg-slate-50 border-4 border-dashed border-slate-100 rounded-[2rem] overflow-hidden flex items-center justify-center hover:border-red-500 transition-all duration-300 shadow-inner">

                        <img id="image-preview" src="#" alt="Preview" class="hidden w-full h-full object-cover">
                        
                        <div id="placeholder-text" class="text-center p-6">
                            <div class="w-20 h-20 bg-white rounded-3xl shadow-sm flex items-center justify-center mx-auto mb-4">
                                <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>

                            <p class="text-slate-400 font-black text-[10px] uppercase tracking-widest">
                                Klik Untuk Upload Foto
                            </p>
                        </div>

                        <div class="absolute inset-0 bg-red-600/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="bg-white text-red-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-lg">
                                Ganti Foto
                            </span>
                        </div>
                    </div>

                    <input type="file" name="image" id="image-input" class="hidden" accept="image/*">
                    
                    <div class="mt-6 p-4 bg-red-50 rounded-2xl border border-red-100">
                        <p class="text-[10px] text-red-400 font-bold text-center italic leading-relaxed">
                            Gunakan foto dengan rasio 1:1 agar tampilan di menu pelanggan terlihat simetris.
                        </p>
                    </div>

                </div>
            </div>

        </div>
    </form>
</main>

<script>
const productForm = document.getElementById('productForm');
const imageInput = document.getElementById('image-input');
const imagePreview = document.getElementById('image-preview');
const previewContainer = document.getElementById('image-preview-container');
const placeholderText = document.getElementById('placeholder-text');

/* preview gambar */
previewContainer.addEventListener('click', () => {
    imageInput.click();
});

imageInput.addEventListener('change', function () {
    const file = this.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            imagePreview.src = e.target.result;
            imagePreview.classList.remove('hidden');
            placeholderText.classList.add('hidden');
        }

        reader.readAsDataURL(file);
    }
});

/* validasi submit */
productForm.addEventListener('submit', function(e){

    const name = document.getElementById('name').value.trim();
    const category = document.getElementById('category').value;
    const stock = document.getElementById('stock').value;
    const price = document.getElementById('price').value;
    const image = imageInput.files.length;

    let errors = [];

    if(name === ''){
        errors.push('Nama Hidangan wajib diisi');
    }

    if(category === ''){
        errors.push('Kategori wajib dipilih');
    }

    if(stock === '' || parseInt(stock) < 1){
        errors.push('Stok wajib diisi');
    }

    if(price === '' || parseInt(price) < 1){
        errors.push('Harga wajib diisi');
    }

    if(image === 0){
        errors.push('Foto produk wajib diupload');
    }

    if(errors.length > 0){
        e.preventDefault();

        Swal.fire({
            icon: 'error',
            title: 'Data Belum Lengkap!',
            html: errors.join('<br>'),
            confirmButtonColor: '#e53e3e',
            background: '#ffffff',
            customClass:{
                title:'font-black text-slate-800',
                popup:'rounded-[2rem] shadow-2xl'
            }
        });
    }
});
</script>
@endsection