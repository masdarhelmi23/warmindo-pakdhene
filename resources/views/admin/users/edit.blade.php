@extends('layouts.admin')

@section('content')
<main class="max-w-3xl mx-auto py-20 px-4">
    <a href="{{ route('users.index') }}" class="text-slate-400 font-black text-[10px] uppercase tracking-widest hover:text-red-600 transition">← Kembali</a>

    <div class="mt-6 bg-white rounded-[3rem] shadow-2xl p-12 border border-slate-100">
        <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tighter mb-10">Edit Akses <span class="text-red-600">{{ $user->name }}</span></h2>

        <form action="{{ route('users.update', $user->id) }}" method="POST" class="space-y-8">
            @csrf @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 ml-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-red-600" required>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 ml-2">Email</label>
                    <input type="email" name="email" value="{{ $user->email }}" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-red-600" required>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 ml-2">Hak Akses</label>
                    <select name="role" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-red-600">
                        <option value="kasir" {{ $user->role == 'kasir' ? 'selected' : '' }}>KASIR</option>
                        <option value="owner" {{ $user->role == 'owner' ? 'selected' : '' }}>OWNER</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase text-slate-400 ml-2">Ganti Password</label>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ubah" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-red-600">
                </div>
            </div>

            <div class="flex gap-4 pt-6">
                <button type="submit" class="flex-1 bg-slate-900 hover:bg-red-600 text-white py-5 rounded-2xl font-black text-xs uppercase tracking-widest transition-all">Simpan Perubahan</button>
                
                {{-- Tombol Hapus di halaman Edit biar lebih rapi --}}
                <button type="button" onclick="document.getElementById('delete-form').submit()" class="bg-red-100 hover:bg-red-200 text-red-600 px-8 rounded-2xl font-black text-xs uppercase tracking-widest transition-all">Hapus Kru</button>
            </div>
        </form>

        <form id="delete-form" action="{{ route('users.destroy', $user->id) }}" method="POST" class="hidden">
            @csrf @method('DELETE')
        </form>
    </div>
</main>
@endsection