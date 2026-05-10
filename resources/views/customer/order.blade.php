<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Warmindo PRO - Meja {{ $tableNumber }}</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8fafc; 
        }
        .bottom-nav { 
            background: rgba(255, 255, 255, 0.9); 
            backdrop-filter: blur(20px); 
            -webkit-backdrop-filter: blur(20px);
        }
        .floating-card {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 10px 10px -5px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.8);
        }
        /* Custom SweetAlert Rincian */
        .swal-receipt {
            border-radius: 2.5rem !important;
            padding: 2rem !important;
        }
    </style>
</head>
<body class="pb-32">

    <header class="bg-slate-900 pt-10 pb-16 px-6 rounded-b-[3.5rem] shadow-2xl relative overflow-hidden text-center">
        <div class="relative z-10">
            <p class="text-red-400 font-bold text-[10px] uppercase tracking-[0.3em] mb-2">Digital Order System</p>
            <h1 class="text-3xl font-black text-white italic tracking-tight">
                WARMINDO <span class="text-red-600">PRO</span>
            </h1>
            <div class="mt-6 inline-flex bg-white/10 px-5 py-2.5 rounded-2xl backdrop-blur-md border border-white/10 items-center gap-3">
                <span class="text-white font-bold text-xs uppercase tracking-widest">Meja {{ $tableNumber }}</span>
            </div>
        </div>
        <div class="absolute -right-16 -top-16 w-64 h-64 bg-red-600/20 rounded-full blur-[80px]"></div>
    </header>

    <main class="px-6 mt-8 relative z-20">
        <div class="space-y-6">
            @forelse($products as $p)
            <div class="flex items-center gap-4 py-4 bg-white px-5 rounded-[2.5rem] floating-card shadow-2xl shadow-slate-200">
                <div class="w-20 h-20 rounded-[1.5rem] overflow-hidden flex-shrink-0 bg-slate-50 border border-slate-100">
                    <img src="{{ asset('storage/' . $p->image) }}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <h3 class="font-extrabold text-slate-800 text-sm leading-tight mb-1 uppercase tracking-tight">{{ $p->name }}</h3>
                    <p class="font-black text-red-600 text-base tracking-tighter">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                </div>
                <div class="flex items-center bg-slate-100 rounded-2xl p-1 border border-slate-200">
                    <button onclick="changeQty('{{ $p->name }}', {{ $p->price }}, -1)" class="w-9 h-9 flex items-center justify-center bg-white rounded-xl text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M20 12H4"/></svg>
                    </button>
                    <span id="qty-{{ Str::slug($p->name) }}" class="px-3 font-black text-slate-800 text-sm min-w-[32px] text-center">0</span>
                    <button onclick="changeQty('{{ $p->name }}', {{ $p->price }}, 1)" class="w-9 h-9 flex items-center justify-center bg-slate-900 rounded-xl text-white">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="3" d="M12 4v16m8-8H4"/></svg>
                    </button>
                </div>
            </div>
            @empty
            <p class="text-center py-10 text-slate-400 font-bold">Menu Kosong</p>
            @endforelse
        </div>
    </main>

    <div class="fixed bottom-0 left-0 right-0 p-6 bottom-nav border-t border-slate-100 shadow-2xl z-50">
        <div class="max-w-md mx-auto flex items-center justify-between">
            <div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total</p>
                <p class="text-2xl font-black text-slate-900 tracking-tighter" id="total-display">Rp 0</p>
            </div>
            <button onclick="showSummary()" class="bg-red-600 text-white px-10 py-4 rounded-[1.5rem] font-black uppercase text-xs tracking-widest shadow-xl shadow-red-200">
                Pesan (<span id="item-count">0</span>)
            </button>
        </div>
    </div>

    <script>
        let cart = [];

        function changeQty(name, price, delta) {
            const slug = name.toLowerCase().replace(/ /g, "-").replace(/[^\w-]+/g, "");
            const qtyElement = document.getElementById('qty-' + slug);
            let itemIndex = cart.findIndex(item => item.name === name);

            if (itemIndex > -1) {
                cart[itemIndex].qty += delta;
                if (cart[itemIndex].qty <= 0) {
                    cart.splice(itemIndex, 1);
                    qtyElement.innerText = 0;
                } else {
                    qtyElement.innerText = cart[itemIndex].qty;
                }
            } else if (delta > 0) {
                cart.push({ name, price, qty: 1 });
                qtyElement.innerText = 1;
            }
            renderUI();
        }

        function renderUI() {
            const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
            const count = cart.reduce((sum, item) => sum + item.qty, 0);
            document.getElementById('total-display').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('item-count').innerText = count;
        }

        // TAMPILAN RINCIAN MEWAH
        function showSummary() {
            if (cart.length === 0) return Swal.fire('Kosong!', 'Pilih menu dulu.', 'warning');

            let listHtml = cart.map(item => `
                <div class="flex justify-between items-center py-3 border-b border-dashed border-slate-200">
                    <div class="text-left">
                        <p class="font-bold text-slate-800 uppercase text-xs">${item.name}</p>
                        <p class="text-[10px] text-slate-400 font-black">${item.qty} x Rp ${item.price.toLocaleString('id-ID')}</p>
                    </div>
                    <p class="font-black text-slate-900 text-sm">Rp ${(item.price * item.qty).toLocaleString('id-ID')}</p>
                </div>
            `).join('');

            const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);

            Swal.fire({
                title: '<span class="text-xs font-black uppercase tracking-[0.3em] text-slate-400">Rincian Pesanan</span>',
                html: `
                    <div class="mt-4 bg-slate-50 p-6 rounded-[2rem] border border-slate-100 shadow-inner text-left">
                        <p class="text-[10px] font-black text-red-600 mb-4 tracking-widest uppercase">Meja Nomor {{ $tableNumber }}</p>
                        ${listHtml}
                        <div class="flex justify-between items-center mt-6">
                            <p class="font-black text-slate-400 text-xs uppercase">Total Bayar</p>
                            <p class="text-xl font-black text-red-600 tracking-tighter text-right">Rp ${total.toLocaleString('id-ID')}</p>
                        </div>
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Konfirmasi & Bayar',
                cancelButtonText: 'Ubah Pesanan',
                confirmButtonColor: '#1e293b',
                cancelButtonColor: '#94a3b8',
                customClass: { popup: 'swal-receipt' }
            }).then((result) => {
                if (result.isConfirmed) {
                    processCheckout();
                }
            });
        }

        function processCheckout() {
            Swal.fire({ title: 'Memproses...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

            Promise.all(cart.map(item => {
                return fetch("{{ route('order.process') }}", {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({
                        table_number: '{{ $tableNumber }}',
                        product_name: item.name,
                        quantity: item.qty,
                        total_price: item.price * item.qty
                    })
                });
            }))
            .then(() => {
                // REDIRECT KE HALAMAN PEMBAYARAN
                showPaymentSelection();
            });
        }

        // HALAMAN PEMBAYARAN MEWAH
        function showPaymentSelection() {
            const total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
            
            Swal.fire({
                title: '<h2 class="text-xl font-black text-slate-900 tracking-tighter">Pilih Metode Pembayaran</h2>',
                html: `
                    <div class="grid grid-cols-1 gap-4 mt-6">
                        <div class="p-5 border-2 border-slate-100 rounded-3xl flex items-center gap-4 bg-white hover:border-red-500 cursor-pointer transition-all">
                            <div class="w-12 h-12 bg-red-50 rounded-2xl flex items-center justify-center text-red-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <div class="text-left">
                                <p class="font-black text-slate-800 text-sm">QRIS / E-WALLET</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase">Ovo, Dana, ShopeePay</p>
                            </div>
                        </div>
                        <div class="p-5 border-2 border-slate-100 rounded-3xl flex items-center gap-4 bg-white hover:border-red-500 cursor-pointer transition-all">
                            <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <div class="text-left">
                                <p class="font-black text-slate-800 text-sm">BAYAR DI KASIR</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase">Tunai / Debit</p>
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 pt-6 border-t border-slate-100">
                         <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Tagihan</p>
                         <p class="text-3xl font-black text-slate-900 tracking-tighter">Rp ${total.toLocaleString('id-ID')}</p>
                    </div>
                `,
                showConfirmButton: true,
                confirmButtonText: 'Selesaikan Pesanan',
                confirmButtonColor: '#e53e3e',
                allowOutsideClick: false,
                customClass: { popup: 'swal-receipt' }
            }).then(() => {
                location.reload(); // Reset kembali ke awal setelah beres
            });
        }
    </script>
</body>
</html>