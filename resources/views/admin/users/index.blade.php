@extends('layouts.admin')

@section('content')
<main class="max-w-7xl mx-auto py-10 px-4">
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-end mb-10 gap-6">
        <div>
            <h1 class="text-4xl font-black text-slate-900 uppercase tracking-tighter">Manajemen <span class="text-red-600">User</span></h1>
            <p class="text-slate-500 font-medium text-sm mt-1">Kelola akses kru Warmindo Pakdhene dalam satu dashboard.</p>
        </div>
        
        <a href="{{ route('users.create') }}" class="group bg-slate-900 hover:bg-red-600 text-white px-8 py-4 rounded-2xl font-bold text-xs uppercase transition-all shadow-2xl flex items-center gap-3 active:scale-95">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:rotate-90 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kru Baru
        </a>
    </div>

    {{-- TABEL MEWAH --}}
    <div class="bg-white/70 backdrop-blur-md rounded-[2.5rem] shadow-[0_20px_50px_rgba(0,0,0,0.05)] overflow-hidden border border-white">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Info Kru</th>
                    <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Hak Akses</th>
                    <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Bergabung</th>
                    <th class="px-8 py-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 text-right">Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($users as $user)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="px-8 py-6">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-2xl bg-gradient-to-br from-red-500 to-orange-600 flex items-center justify-center text-white font-black shadow-lg">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-black text-slate-900 uppercase">{{ $user->name }}</p>
                                <p class="text-xs font-medium text-slate-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-6">
                        <span class="px-4 py-1.5 {{ $user->role == 'owner' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }} text-[9px] font-black rounded-full uppercase tracking-widest shadow-sm">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-xs font-bold text-slate-500">{{ $user->created_at->format('d M Y') }}</p>
                    </td>
                    {{-- TINDAKAN DIBUAT SELALU TAMPIL --}}
                    <td class="px-8 py-6 text-right">
                        <div class="flex justify-end items-center gap-2">
                            <a href="{{ route('users.edit', $user->id) }}" class="p-3 hover:bg-blue-50 text-blue-600 rounded-xl transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            
                            @if(Auth::id() !== $user->id)
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Tendang kru ini?')">
                                @csrf @method('DELETE')
                                <button class="p-3 hover:bg-red-50 text-red-600 rounded-xl transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection