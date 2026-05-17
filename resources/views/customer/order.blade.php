<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WARMINDO PAKDHENE - Menu Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #000; 
            color: #f8fafc; 
            overflow-x: hidden;
        }

        /* Latar Belakang Gambar Fixed */
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
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.8));
            pointer-events: none;
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        
        .card-menu { 
            background: rgba(255, 255, 255, 0.98); 
            backdrop-filter: blur(10px);
            border-radius: 2.5rem; 
            border: 1px solid rgba(255, 255, 255, 0.2); 
            box-shadow: 0 20px 40px -10px rgba(0,0,0,0.5); 
        }
        
        .btn-action { background: linear-gradient(135deg, #e11d48, #fb7185); }
        
        .badge-stok { 
            z-index: 40; 
            position: absolute; 
            top: 15px; 
            left: 15px; 
            font-size: 10px; 
            font-weight: 900; 
            box-shadow: 0 8px 15px rgba(0,0,0,0.3);
            border: 2px solid white;
        }

        .glass-category {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }

        /* CUSTOM CSS UNTUK POPUP GELAP TRANSPARAN */
        .dark-glass-popup {
            background: rgba(15, 23, 42, 0.8) !important;
            backdrop-filter: blur(20px) !important;
            -webkit-backdrop-filter: blur(20px) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 3rem !important;
        }
        .dark-glass-content {
            color: #f8fafc !important;
        }
        .dark-glass-input {
            background: rgba(255, 255, 255, 0.05) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            border-radius: 1.5rem !important;
        }
        .dark-glass-list {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.05) !important;
        }
    </style>
</head>
<body class="pb-36">

<div class="bg-custom"></div>
<div class="bg-overlay"></div>

<nav class="sticky top-0 z-50 bg-slate-900 border-b border-white/5 p-5 shadow-2xl">
    <div class="max-w-md mx-auto flex justify-between items-center">
        <div>
            <h1 class="text-xl font-black tracking-tighter uppercase leading-none text-white">Warmindo <span class="text-rose-600">Pakdhene</span></h1>
            <p class="text-[10px] opacity-60 font-bold uppercase tracking-[0.2em] mt-1 text-slate-400">Pengalaman Menu Digital</p>
        </div>
        <div class="bg-rose-600 px-5 py-2.5 rounded-2xl shadow-lg shadow-rose-900/40 text-center">
            <span class="block text-[8px] font-black uppercase text-rose-100">Meja</span>
            <span class="text-lg font-black leading-none text-white">{{ $table->number ?? $tableNumber }}</span>
        </div>
    </div>
</nav>

<div class="sticky top-[84px] z-40 glass-category border-b border-white/5 py-4">
    <div class="max-w-md mx-auto px-5 flex gap-3 overflow-x-auto no-scrollbar">
        @foreach($categories as $cat)
            @if($products->where('category_id', $cat->id)->count() > 0)
            <a href="#cat-{{ $cat->id }}" class="whitespace-nowrap px-6 py-3 rounded-2xl bg-white/10 text-white text-[10px] font-black uppercase tracking-widest hover:bg-rose-600 transition-all border border-white/10 shadow-sm">
                {{ $cat->name }}
            </a>
            @endif
        @endforeach
    </div>
</div>

<main class="max-w-md mx-auto px-5 mt-8 space-y-12">
    @foreach($categories as $cat)
        @php $catProducts = $products->where('category_id', $cat->id); @endphp
        @if($catProducts->count() > 0)
        <section id="cat-{{ $cat->id }}" class="scroll-mt-40">
            <div class="flex items-center gap-4 mb-8">
                <h2 class="text-xs font-black uppercase tracking-[0.3em] text-rose-500">{{ $cat->name }}</h2>
                <div class="h-[1px] flex-1 bg-white/10"></div>
            </div>

            <div class="grid gap-8">
                @foreach($catProducts as $p)
                <div class="card-menu p-5 flex gap-5 relative {{ $p->stock <= 0 ? 'opacity-50 grayscale' : '' }}">
                    @if($p->stock > 0)
                        <div class="badge-stok rounded-2xl px-4 py-2 text-white {{ $p->stock <= 5 ? 'bg-orange-500' : 'bg-emerald-500' }}">
                            SISA {{ $p->stock }}
                        </div>
                    @else
                        <div class="absolute inset-0 z-30 bg-black/40 flex items-center justify-center rounded-[2.5rem] backdrop-blur-[2px]">
                            <span class="bg-white text-rose-600 px-6 py-2 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-xl">Habis</span>
                        </div>
                    @endif

                    <div class="w-28 h-28 rounded-[2rem] overflow-hidden flex-shrink-0 bg-slate-100 shadow-inner border border-slate-200">
                        <img src="{{ asset('storage/' . $p->image) }}" class="w-full h-full object-cover">
                    </div>

                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-sm font-black uppercase text-slate-800 leading-tight">{{ $p->name }}</h3>
                            <p class="text-rose-600 font-black text-lg mt-1 tracking-tighter">Rp {{ number_format($p->price,0,',','.') }}</p>
                        </div>
                        <div class="flex items-center justify-between mt-4">
                            <div class="flex items-center gap-4 bg-slate-50 p-1 rounded-2xl border border-slate-100">
                                <button onclick="changeQty('{{ $p->name }}', {{ $p->price }}, -1, {{ $p->stock }})" class="w-9 h-9 rounded-xl bg-white text-slate-400 font-bold shadow-sm">-</button>
                                <span id="qty-{{ Str::slug($p->name) }}" class="text-sm font-black w-4 text-center text-slate-900">0</span>
                                <button onclick="changeQty('{{ $p->name }}', {{ $p->price }}, 1, {{ $p->stock }})" class="btn-action w-9 h-9 rounded-xl text-white font-bold shadow-md shadow-rose-200">+</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        @endif
    @endforeach
</main>

<div class="fixed bottom-8 left-0 right-0 px-6 z-50">
    <div class="max-w-md mx-auto bg-slate-900/90 backdrop-blur-xl rounded-[2.8rem] p-4 flex items-center justify-between shadow-2xl border border-white/10">
        <div class="pl-5">
            <p class="text-[8px] uppercase tracking-[0.2em] text-slate-500 font-black">Total Pembayaran</p>
            <h3 id="total-display" class="text-xl font-black text-white tracking-tighter">Rp 0</h3>
        </div>
        <button onclick="showSummary()" class="btn-action px-10 py-5 rounded-[2.2rem] text-[10px] uppercase font-black text-white tracking-[0.2em] shadow-lg shadow-rose-500/20 active:scale-95 transition-all">
            PESAN (<span id="item-count">0</span>)
        </button>
    </div>
</div>

<script>
    let cart = [];
    const tableNum = "{{ $table->number ?? $tableNumber }}";

    function changeQty(name, price, delta, stock) {
        const slug = name.toLowerCase().replace(/ /g,"-").replace(/[^\w-]+/g,"");
        const qtyEl = document.getElementById('qty-' + slug);
        let idx = cart.findIndex(i => i.name === name);

        if(idx > -1) {
            if(delta > 0 && cart[idx].qty >= stock) return toast('Stok Habis!');
            cart[idx].qty += delta;
            if(cart[idx].qty <= 0) cart.splice(idx,1);
        } else if(delta > 0 && stock > 0) {
            cart.push({name, price, qty: 1});
        }
        
        qtyEl.innerText = cart.find(i => i.name === name)?.qty || 0;
        renderUI();
    }

    function renderUI() {
        const total = cart.reduce((s,i) => s + (i.price * i.qty), 0);
        const count = cart.reduce((s,i) => s + i.qty, 0);
        document.getElementById('total-display').innerText = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('item-count').innerText = count;
    }

    function toast(msg) {
        Swal.fire({ text: msg, toast: true, position: 'top', timer: 2000, showConfirmButton: false, icon: 'warning', background: 'rgba(15, 23, 42, 0.9)', color: '#fff' });
    }

    function showSummary() {
        if(cart.length === 0) return toast('Pilih menu dulu kak!');
        let itemsHtml = cart.map(i => `
            <div class="flex justify-between py-4 border-b border-white/5 text-sm font-bold text-slate-200">
                <span>${i.name} x${i.qty}</span>
                <span class="text-rose-400">Rp ${(i.price*i.qty).toLocaleString('id-ID')}</span>
            </div>`).join('');
        
        const total = cart.reduce((s,i) => s + (i.price*i.qty), 0);

        Swal.fire({
            background: 'transparent',
            customClass: {
                popup: 'dark-glass-popup',
                htmlContainer: 'dark-glass-content'
            },
            title: '<p class="text-[10px] font-black uppercase tracking-widest text-rose-500">Konfirmasi Pesanan</p>',
            html: `
                <div class="text-left">
                    <input type="text" id="cust_name" class="dark-glass-input w-full p-5 mb-5 outline-none focus:border-rose-500 transition-all font-bold" placeholder="Tulis Nama Kakak">
                    <div class="dark-glass-list p-6 rounded-[2.5rem]">
                        ${itemsHtml}
                        <div class="mt-5 text-white font-black text-2xl tracking-tighter flex justify-between">
                            <span class="text-[10px] uppercase text-slate-400 self-center">Total</span>
                            <span>Rp ${total.toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                </div>`,
            showCancelButton: true,
            confirmButtonText: 'Kirim Pesanan',
            confirmButtonColor: '#e11d48',
            cancelButtonText: 'Nanti Dulu',
            cancelButtonColor: 'transparent',
            preConfirm: () => {
                const name = document.getElementById('cust_name').value;
                if(!name) return Swal.showValidationMessage('Namanya diisi dulu ya kak!');
                return name;
            }
        }).then((res) => { if(res.isConfirmed) processCheckout(res.value); });
    }

    async function processCheckout(custName) {
        const urlParams = new URLSearchParams(window.location.search);
        const tableToken = urlParams.get('t'); 

        Swal.fire({ 
            title: 'Mengirim...', 
            background: 'rgba(15, 23, 42, 0.9)', 
            color: '#fff',
            customClass: { popup: 'dark-glass-popup' },
            allowOutsideClick: false, 
            didOpen: () => Swal.showLoading() 
        });
        
        try {
            const resp = await fetch("{{ route('order.process') }}", {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                },
                body: JSON.stringify({ 
                    table_number: tableNum, 
                    table_token: tableToken,
                    customer_name: custName, 
                    items: cart 
                })
            });
            
            const res = await resp.json();
            if(res.success) {
                Swal.fire({ 
                    icon: 'success', 
                    title: 'Siap Kak!', 
                    text: 'Pesanan sudah masuk ke dapur ya.', 
                    background: 'rgba(15, 23, 42, 0.9)', 
                    color: '#fff',
                    customClass: { popup: 'dark-glass-popup' }
                }).then(() => {
                    // REVISI FIX REDIRECT: Otomatis memindahkan ke halaman status pesanan pelanggan asli bawaan data controller!
                    window.location.href = res.redirect_url;
                });
            } else {
                Swal.fire({ icon: 'error', title: 'Ups!', text: res.message, background: 'rgba(15, 23, 42, 0.9)', color: '#fff', customClass: { popup: 'dark-glass-popup' } });
            }
        } catch(e) { 
            Swal.fire({ icon: 'error', title: 'Error', text: 'Masalah Koneksi', background: 'rgba(15, 23, 42, 0.9)', color: '#fff', customClass: { popup: 'dark-glass-popup' } }); 
        }
    }
</script>
</body>
</html>