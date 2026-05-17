<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Pesanan - Warmindo Pakdhene</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght=400;600;800;900&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #000; 
            color: #f8fafc; 
            overflow-x: hidden;
        }

        /* Latar Belakang Gambar Fixed Cinematic */
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

        .bg-overlay {
            position: fixed;
            inset: 0;
            z-index: -1;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.9));
            pointer-events: none;
        }

        .card-status { 
            background: rgba(30, 41, 59, 0.4); 
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-radius: 2.5rem; 
            border: 1px solid rgba(255, 255, 255, 0.08); 
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.7); 
        }

        .pulse-glow {
            box-shadow: 0 0 0 0 rgba(225, 29, 72, 0.7);
            animation: pulse 1.5s infinite cubic-bezier(0.66, 0, 0, 1);
        }

        @keyframes pulse {
            to {
                box-shadow: 0 0 0 20px rgba(225, 29, 72, 0);
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col justify-between py-6 md:py-12">

<div class="bg-custom"></div>
<div class="bg-overlay"></div>

<main class="w-full max-w-md md:max-w-xl mx-auto px-5 my-auto">
    
    <div class="card-status p-6 md:p-8 text-center space-y-6">
        
        <div>
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-rose-500/10 border border-rose-500/20 text-rose-400 text-[10px] font-black uppercase tracking-widest">
                <span class="w-2 h-2 rounded-full bg-rose-500 {{ $orders->first()->status == 'pending' ? 'animate-ping' : '' }}"></span>
                Pesanan {{ ucfirst($orders->first()->status ?? 'Diproses') }}
            </span>
            <h1 class="text-2xl md:text-3xl font-black uppercase tracking-tighter text-white mt-3">
                WARMINDO <span class="text-rose-600">PAKDHAENE</span>
            </h1>
            <p class="text-xs text-slate-400 font-bold uppercase tracking-widest mt-1">Sistem Antrean Digital</p>
        </div>

        <hr class="border-white/10">

        <div class="py-2">
            <p class="text-[10px] uppercase tracking-[0.2em] text-slate-500 font-black mb-1">Nama Pemesan</p>
            <div class="text-xl md:text-2xl font-black text-rose-400 tracking-tight bg-slate-900/50 inline-block px-6 py-3 rounded-2xl border border-white/5 uppercase">
                {{ $orders->first()->customer_name ?? 'Kakak Pelanggan' }}
            </div>
            <p class="text-[9px] text-slate-500 font-bold mt-2 tracking-widest">GROUP ID: {{ $order_id }}</p>
        </div>

        <div class="bg-slate-900/40 border border-white/5 p-5 rounded-2xl text-left flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-rose-600 flex items-center justify-center text-white flex-shrink-0 pulse-glow text-lg">
                🍜
            </div>
            <div>
                <h4 class="text-xs font-black text-white uppercase tracking-wider">
                    @if($orders->first()->status == 'pending')
                        Menunggu Validasi Kasir
                    @elseif($orders->first()->status == 'waiting')
                        Sedang Dimasak Dapur
                    @else
                        Pesanan Selesai Hidang
                    @endif
                </h4>
                <p class="text-xs text-slate-400 mt-0.5">
                    Pesananmu otomatis dikunci ke sistem **Meja Nomor {{ $orders->first()->table_number ?? '-' }}**. Mohon ditunggu sebentar ya kak!
                </p>
            </div>
        </div>

        <div class="text-left space-y-3">
            <h3 class="text-[10px] font-black uppercase tracking-widest text-slate-500">Rincian Menu Yang Dipesan</h3>
            
            <div class="bg-black/30 border border-white/5 p-5 rounded-2xl space-y-3 shadow-inner">
                @php $totalHargaNyata = 0; @endphp
                
                @foreach($orders as $item)
                    @php $totalHargaNyata += $item->total_price; @endphp
                    <div class="flex justify-between items-center text-xs font-bold text-slate-300">
                        <span>{{ $item->product_name }} <span class="text-slate-500 text-[10px] ml-1">x{{ $item->quantity }}</span></span>
                        <span class="text-rose-400 font-black">Rp {{ number_format($item->total_price, 0, ',', '.') }}</span>
                    </div>
                @endforeach
                
                <div class="h-[1px] bg-white/10 my-2"></div>
                
                <div class="flex justify-between items-center pt-1">
                    <span class="text-[10px] uppercase font-black text-slate-400">Total Pembayaran</span>
                    <span class="text-xl font-black text-white tracking-tighter">Rp {{ number_format($totalHargaNyata, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="pt-2">
            <a href="{{ url('/?t=' . Request::query('t')) }}" class="inline-block w-full bg-slate-800 hover:bg-slate-700 text-slate-300 font-black py-4 rounded-xl text-xs uppercase tracking-widest border border-white/5 shadow-xl transition active:scale-95 text-center">
                Pesan Menu Tambahan
            </a>
            <p class="text-[9px] text-slate-500 font-bold mt-3 uppercase tracking-wider">Silakan langsung menuju ke kasir jika kakak ingin melakukan pembayaran tunai/QRIS.</p>
        </div>

    </div>
</main>

<footer class="w-full text-center mt-8">
    <p class="text-slate-600 text-[10px] font-black uppercase tracking-[0.3em]">
        &copy; {{ date('Y') }} <span class="text-rose-600">Warmindo PAKDHENE</span> Digital System.
    </p>
</footer>

</body>
</html>