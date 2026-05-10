@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-10">
        <a href="{{ route('products.index') }}" class="inline-flex items-center text-sm font-bold text-red-600 hover:text-red-700 transition mb-4 group">
            <svg class="w-4 h-4 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Batal & Kembali
        </a>

        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">
            Edit <span class="bg-gradient-to-r from-red-600 to-orange-600 bg-clip-text text-transparent" style="-webkit-background-clip: text; -webkit-text-fill-color: transparent;">Menu Hidangan</span>
        </h1>
    </div>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="flex flex-col lg:flex-row gap-8">

            <div class="flex-1 space-y-8">
                <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-red-100 border border-white p-10">
                    <div class="grid grid-cols-1 gap-8">

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Nama Hidangan</label>
                            <input type="text" name="name" value="{{ $product->name }}"
                                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-0 focus:border-red-500 outline-none transition-all font-bold text-slate-700 shadow-inner"
                                required>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Deskripsi Menu</label>
                            <textarea name="description" rows="3"
                                class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-0 focus:border-red-500 outline-none transition-all font-bold text-slate-700 shadow-inner">{{ $product->description }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                            {{-- REVISI BAGIAN KATEGORI --}}
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Kategori</label>

                                <select name="category_id"
                                    class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-0 focus:border-red-500 outline-none font-bold text-slate-700 appearance-none shadow-inner">

                                    <option value="">-- Pilih Kategori --</option>

                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}"
                                            {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                                            {{ $cat->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Update Stok</label>
                                <div class="relative">
                                    <input type="number" name="stock" value="{{ $product->stock }}"
                                        class="w-full px-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-0 focus:border-red-500 outline-none font-bold text-slate-700 shadow-inner"
                                        required placeholder="0">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Harga Jual</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-6 text-red-600 font-black">Rp</span>
                                    <input type="number" name="price" value="{{ $product->price }}"
                                        class="w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-slate-100 rounded-2xl focus:ring-0 focus:border-red-500 outline-none font-bold text-slate-700 shadow-inner"
                                        required>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-slate-900 hover:bg-red-600 text-white font-black py-6 rounded-[2rem] shadow-2xl transition-all transform hover:-translate-y-2 uppercase tracking-[0.2em] text-sm">
                    Update Perubahan
                </button>
            </div>

            <div class="w-full lg:w-[400px]">
                <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-red-100 border border-white p-8">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-6 text-center">Foto Produk</label>

                    <div id="image-preview-container"
                        class="relative group cursor-pointer w-full aspect-square bg-slate-50 border-4 border-dashed border-slate-100 rounded-[2rem] overflow-hidden flex items-center justify-center transition-all hover:border-red-500">

                        <img id="image-preview" src="{{ asset('storage/' . $product->image) }}"
                            class="w-full h-full object-cover">

                        <div
                            class="absolute inset-0 bg-red-600/10 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span
                                class="bg-white text-red-600 px-4 py-2 rounded-xl text-[10px] font-black uppercase shadow-lg">
                                Ganti Foto
                            </span>
                        </div>
                    </div>

                    <input type="file" name="image" id="image-input" class="hidden" accept="image/*">

                    <div class="mt-6 p-4 bg-red-50 rounded-2xl border border-red-100">
                        <p class="text-[10px] text-red-400 font-bold text-center italic leading-relaxed">
                            Biarkan kosong jika tidak ingin mengganti foto produk.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </form>
</main>

<script>
    const imageInput = document.getElementById('image-input');
    const imagePreview = document.getElementById('image-preview');
    const previewContainer = document.getElementById('image-preview-container');

    previewContainer.addEventListener('click', () => {
        imageInput.click();
    });

    imageInput.addEventListener('change', function () {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imagePreview.src = e.target.result;
            }

            reader.readAsDataURL(file);
        }
    });
</script>
@endsection