<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Warmindo Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-orange-50 flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border-t-8 border-orange-500">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Warmindo <span class="text-orange-500">Digital</span></h1>
            <p class="text-gray-500 text-sm">Silahkan login untuk mengelola pesanan</p>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm" role="alert">
                <p class="text-sm">{{ $errors->first() }}</p>
            </div>
        @endif

        <form action="/login" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                <input type="email" name="email" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200" 
                    placeholder="admin@warmindo.com" required>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
                <input type="password" name="password" 
                    class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-400 focus:border-orange-400 outline-none transition duration-200" 
                    placeholder="••••••••" required>
            </div>

            <button type="submit" 
                class="w-full bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-lg shadow-lg hover:shadow-orange-200 transition duration-300 transform hover:-translate-y-1">
                Masuk ke Dashboard
            </button>
        </form>

        <div class="mt-8 text-center border-t pt-6">
            <p class="text-gray-400 text-xs uppercase tracking-widest font-semibold">Sistem Kasir v1.0</p>
        </div>
    </div>

</body>
</html>