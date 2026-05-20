@extends('layouts.admin')

@section('content')
<main class="max-w-3xl mx-auto py-20 px-4">
    <a href="{{ route('users.index') }}" class="flex items-center gap-2 text-slate-400 hover:text-slate-900 font-bold text-xs uppercase mb-10 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar
    </a>

    <div class="bg-white rounded-[3rem] shadow-2xl p-12 border border-slate-100 relative overflow-hidden">
        {{-- DEKORASI --}}
        <div class="absolute top-0 right-0 h-40 w-40 bg-red-600/5 rounded-full -mr-20 -mt-20"></div>
        
        <div class="relative">
            <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tighter mb-2">Tambah <span class="text-red-600">Kru</span></h2>
            <p class="text-slate-400 font-medium mb-10">Pastikan email aktif untuk keperluan sistem.</p>

            <form action="{{ route('users.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-slate-400 ml-2">Nama Lengkap</label>
                        <input type="text" name="name" placeholder="Andri Pakdhene" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-red-600 transition-all" required>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-slate-400 ml-2">Email Akun</label>
                        <input type="email" name="email" placeholder="kru@warmindo.com" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-red-600 transition-all" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-slate-400 ml-2">Hak Akses</label>
                        <select name="role" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-red-600 transition-all shadow-sm">
                            <option value="kasir">KASIR / KRU</option>
                            <option value="owner">OWNER / BOS</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase text-slate-400 ml-2">Kata Sandi</label>
                        <input type="password" name="password" placeholder="••••••••" class="w-full bg-slate-50 border-none rounded-2xl p-4 font-bold text-sm focus:ring-2 focus:ring-red-600 transition-all" required>
                    </div>
                </div>

                <div class="pt-6">
                    <button type="submit" class="w-full bg-slate-900 hover:bg-red-600 text-white py-5 rounded-2xl font-black text-sm uppercase tracking-widest transition-all shadow-xl active:scale-[0.98]">
                        Simpan Akun Kru
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection