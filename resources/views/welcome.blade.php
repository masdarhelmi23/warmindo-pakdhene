<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WARMINDO PAKDHENE - Digital System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800;900&display=swap" rel="stylesheet">
    
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #000; 
            color: #f8fafc; 
            overflow-x: hidden;
            display: flex;
            flex-direction: column;
        }

        /* Latar Belakang Gambar Fixed (Sama persis dengan Menu Digital) */
        .bg-custom {
            position: fixed;
            inset: 0;
            z-index: -2;
            background-image: url("{{ asset('bg.jpg') }}");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            pointer-events: none;
        }

        /* Overlay digelapkan sedikit agar gambar background tidak terlalu mendominasi teks */
        .bg-overlay {
            position: fixed;
            inset: 0;
            z-index: -1;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.85));
            pointer-events: none;
        }
        
        /* Modifikasi Card Glass Transparan agar Senada */
        .card-welcome { 
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 2.5rem; 
            border: 1px solid rgba(255, 255, 255, 0.1); 
            box-shadow: 0 30px 60px -15px rgba(0,0,0,0.8); 
        }
        
        .btn-action { 
            background: linear-gradient(135deg, #e11d48, #fb7185); 
        }

        .glass-step {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="antialiased">

<div class="bg-custom"></div>
<div class="bg-overlay"></div>

{{-- NAVBAR HEADER (Revisi: Bersih Tanpa Tombol Akses Staf) --}}
<nav class="bg-slate-900/90 backdrop-blur-xl border-b border-white/5 p-4 shadow-2xl sticky top-0 z-50">
    <div class="max-w-md mx-auto text-center">
        <h1 class="text-lg font-black tracking-tighter uppercase leading-none text-white">
            WARMINDO <span class="text-rose-600">PAKDHENE</span>
        </h1>
        <p class="text-[9px] opacity-60 font-bold uppercase tracking-[0.2em] mt-1 text-slate-400">Pusat Sistem Digital</p>
    </div>
</nav>

{{-- UTAMA / HERO CONTENT --}}
<main class="max-w-md mx-auto px-5 flex-1 flex flex-col justify-center items-center text-center py-8 w-full">
    
    {{-- Container Pelindung Teks --}}
    <div class="w-full bg-slate-950/60 backdrop-blur-md border border-white/5 rounded-[2.5rem] p-6 mb-6 shadow-2xl">
        {{-- Status Badge --}}
        <div class="inline-flex items-center gap-2 bg-slate-900/90 border border-white/10 px-3 py-1.5 rounded-full shadow-lg mb-4">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
            </span>
            <span class="text-[8px] font-black text-emerald-400 uppercase tracking-widest">Sistem Operasional Aktif</span>
        </div>

        {{-- Headline --}}
        <h1 class="text-3xl font-black text-white uppercase tracking-tight leading-none mb-3">
            Makan Enak<br>
            Pesan <span class="text-rose-500 italic">Tanpa Antre!</span>
        </h1>

        <p class="text-[10px] text-slate-400 font-bold leading-relaxed uppercase tracking-wider max-w-xs mx-auto">
            Selamat datang di era baru penikmat Indomie. Silakan ikuti panduan di bawah untuk mulai bersantap.
        </p>
    </div>

    {{-- CARA PESAN BOX --}}
    <div class="card-welcome p-6 w-full relative overflow-hidden">
        <div class="w-12 h-12 bg-rose-500/10 text-rose-500 rounded-xl flex items-center justify-center mx-auto mb-4 border border-rose-500/20 shadow-lg">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
            </svg>
        </div>

        <h3 class="text-[11px] font-black text-white uppercase tracking-[0.2em] mb-4 text-center">Panduan Memesan Hidangan</h3>
        
        <div class="text-left space-y-3 text-xs font-bold text-slate-300">
            <div class="flex items-start space-x-3 glass-step p-3.5 rounded-2xl">
                <span class="w-5 h-5 btn-action text-white rounded-lg flex items-center justify-center text-[9px] font-black shrink-0 shadow-md">1</span>
                <p class="leading-relaxed text-[11px]">Cari kode <span class="text-rose-400">QR Code</span> unik yang tertempel di pojok meja makan Anda.</p>
            </div>
            
            <div class="flex items-start space-x-3 glass-step p-3.5 rounded-2xl">
                <span class="w-5 h-5 btn-action text-white rounded-lg flex items-center justify-center text-[9px] font-black shrink-0 shadow-md">2</span>
                <p class="leading-relaxed text-[11px]">Buka kamera ponsel Anda, scan kodenya, lalu klik link menu digital yang muncul.</p>
            </div>
            
            <div class="flex items-start space-x-3 glass-step p-3.5 rounded-2xl">
                <span class="w-5 h-5 btn-action text-white rounded-lg flex items-center justify-center text-[9px] font-black shrink-0 shadow-md">3</span>
                <p class="leading-relaxed text-[11px]">Pilih menu favorit, isi nama kakak, lalu klik <span class="text-rose-400">Kirim Pesanan</span> untuk diteruskan ke dapur.</p>
            </div>
        </div>
    </div>

</main>

{{-- FOOTER (REVISI: Copyright berfungsi sebagai Hidden Link menuju Login) --}}
<footer class="w-full text-center py-4 border-t border-white/5 bg-slate-950/95 backdrop-blur-md mt-auto">
    <a href="{{ route('login') }}" class="text-[8px] font-black text-slate-600 hover:text-slate-500 uppercase tracking-[0.2em] inline-block transition-colors active:scale-95">
        © 2026 WARMINDO PAKDHENE DIGITAL SYSTEM. ALL RIGHTS RESERVED.
    </a>
</footer>

</body>
</html>