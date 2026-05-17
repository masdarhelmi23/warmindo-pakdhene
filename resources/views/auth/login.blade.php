<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Warmindo Pakdhene</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #020617;
        }

        /* Animated Background */
        .mesh-gradient {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: #020617;
            background-image: 
                radial-gradient(at 0% 0%, rgba(225, 29, 72, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(249, 115, 22, 0.15) 0px, transparent 50%);
            z-index: -1;
        }

        .glass-card {
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .input-premium {
            background: rgba(255, 255, 255, 0.03) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
            color: white !important;
            transition: all 0.3s ease;
        }

        .input-premium:focus {
            border-color: #f43f5e !important;
            background: rgba(255, 255, 255, 0.07) !important;
            box-shadow: 0 0 15px rgba(244, 63, 94, 0.1);
        }

        .btn-gradient {
            background: linear-gradient(135deg, #e11d48, #fb7185);
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(225, 29, 72, 0.3);
            filter: brightness(1.1);
        }

        .float { animation: floating 6s ease-in-out infinite; }
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen p-4 overflow-y-auto relative select-none">

    <div class="mesh-gradient"></div>

    <div class="absolute top-10 left-10 w-44 h-44 md:w-64 md:h-64 bg-rose-600/10 rounded-full blur-[80px] md:blur-[100px] float pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-52 h-52 md:w-80 md:h-80 bg-orange-600/10 rounded-full blur-[80px] md:blur-[100px] float pointer-events-none" style="animation-delay: 2s;"></div>

    {{-- CARD LOGIN GLASSMORPHISM --}}
    <div class="glass-card p-6 md:p-10 rounded-[2.5rem] w-full max-w-md relative overflow-hidden my-auto shadow-2xl z-10">
        <div class="absolute top-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-rose-500 to-transparent opacity-50"></div>

        {{-- HEADER LOGO BRAND --}}
        <div class="text-center mb-8 md:mb-10">
            <h1 class="text-2xl md:text-3xl font-black tracking-tighter text-white mb-2">
                WARMINDO <span class="text-transparent bg-clip-text bg-gradient-to-r from-rose-400 to-orange-400">PAKDENE</span>
            </h1>
            <div class="flex items-center justify-center gap-2">
                <span class="h-px w-6 bg-white/10"></span>
                <p class="text-slate-400 text-[9px] md:text-[10px] uppercase tracking-[0.3em] font-bold">Admin Central Access</p>
                <span class="h-px w-6 bg-white/10"></span>
            </div>
        </div>

        {{-- FORM AUTHENTICATION INTERAKTIF --}}
        <form id="loginForm" class="space-y-5 md:space-y-6">
            @csrf
            
            <div class="space-y-2">
                <label class="text-[10px] md:text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Administrator Email</label>
                <div class="relative">
                    <input type="email" name="email" id="email"
                        class="input-premium w-full px-5 py-4 rounded-2xl outline-none text-sm" 
                        placeholder="admin@warmindo.com" required>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] md:text-[11px] font-black uppercase tracking-widest text-slate-400 ml-1">Security Key</label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                        class="input-premium w-full px-5 py-4 rounded-2xl outline-none text-sm" 
                        placeholder="••••••••" required>
                </div>
            </div>

            <button type="submit" id="btnSubmit"
                class="btn-gradient w-full text-white font-black py-4 rounded-2xl shadow-xl text-xs uppercase tracking-widest mt-4 active:scale-95 transition-all flex items-center justify-center gap-2">
                <span>Authenticate Now</span>
            </button>
        </form>

        <div class="mt-8 md:mt-10 text-center">
            <p class="text-slate-500 text-[8px] md:text-[9px] uppercase tracking-[0.4em] font-bold border-t border-white/5 pt-6 md:pt-8">
                Warmindo Pakdhene Digital System v2.0
            </p>
        </div>
    </div>

    {{-- BOTTOM FOOTER STANDARD --}}
    <div class="mt-8 mb-4 text-slate-600 text-[9px] md:text-[10px] font-medium tracking-wide z-10 text-center">
        &copy; 2026 Warmindo Pakdhene Digital. All rights reserved.
    </div>

    {{-- JURUS AJAX POPUP DAN REDIRECT ROLE MANAGEMENT (REVISI PERBAIKAN ERROR TEXT) --}}
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const btnSubmit = document.getElementById('btnSubmit');
            const originalBtnText = btnSubmit.innerHTML;
            
            btnSubmit.disabled = true;
            btnSubmit.innerHTML = `<span>Memverifikasi...</span>`;

            const formData = new FormData(this);

            fetch('/login', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                // Jika server merespon dengan pengalihan rute murni, tangkap URL tujuannya
                if (response.redirected) {
                    return { success: true, is_redirected: true, redirect_url: response.url };
                }
                
                if (!response.ok) {
                    // PENTING: Jika eror, parsing isi JSON-nya agar teks pesan aslinya keluar
                    return response.json().then(err => { throw err; });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    let roleTitle = "ADMIN KASIR";
                    let destinationUrl = data.redirect_url;

                    if (data.role === 'owner' || destinationUrl.includes('owner')) {
                        roleTitle = 'OWNER (PEMILIK)';
                    }
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Akses Diterima!',
                        html: `Selamat datang kembali.<br>Akses masuk dikonfirmasi sebagai <b class="text-emerald-500 font-black">${roleTitle}</b>.`,
                        background: '#0f172a',
                        color: '#fff',
                        confirmButtonColor: '#e11d48',
                        timer: 1800,
                        showConfirmButton: false,
                        willClose: () => {
                            window.location.replace(destinationUrl);
                        }
                    });
                }
            })
            .catch(error => {
                btnSubmit.disabled = false;
                btnSubmit.innerHTML = originalBtnText;

                // REVISI FIX: Membongkar data string JSON agar memunculkan teks murni saja
                let errorTextMessage = 'Email atau Password yang Anda masukkan salah!';
                
                if (error && typeof error === 'object') {
                    if (error.message) {
                        errorTextMessage = error.message;
                    } else if (error.errors && error.errors.email) {
                        errorTextMessage = error.errors.email[0];
                    }
                } else if (typeof error === 'string') {
                    try {
                        let parsed = JSON.parse(error);
                        if (parsed.message) errorTextMessage = parsed.message;
                    } catch(e) {
                        errorTextMessage = error;
                    }
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Autentikasi Gagal',
                    text: errorTextMessage, // Teks rapi tanpa tanda kurung kurawal kode JSON lagi!
                    background: '#0f172a',
                    color: '#fff',
                    confirmButtonColor: '#e11d48'
                });
            });
        });
    </script>

</body>
</html>