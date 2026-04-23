<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS Cilok · Pilih Peran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center justify-center p-4">

    <div class="max-w-5xl w-full">
        {{-- Header --}}
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center gap-2 bg-white/60 backdrop-blur-sm px-4 py-1.5 rounded-full border border-gray-200 shadow-sm mb-4">
                <span class="text-orange-500 text-lg">🍢</span>
                <span class="text-sm font-semibold text-gray-600">POS Cilok</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 tracking-tight">POS Cilok</h1>
            <p class="text-gray-500 mt-2 text-lg">Sistem Kasir & Manajemen</p>
        </div>

        {{-- Kartu pilihan peran --}}
        <div class="grid md:grid-cols-2 gap-6">
            {{-- Kartu Admin --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Admin</h2>
                </div>
                <p class="text-gray-500 mb-6 leading-relaxed">
                    Akses penuh: Dashboard, Produk, Inventori, dan Laporan
                </p>
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center justify-between w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-5 rounded-xl transition duration-200 group">
                    <span>Masuk sebagai Admin</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>

            {{-- Kartu Kasir --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-200 p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 4v2m8-2v2" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800">Kasir</h2>
                </div>
                <p class="text-gray-500 mb-6 leading-relaxed">
                    Interface cepat khusus transaksi penjualan
                </p>
                <a href="{{ route('kasir.index') }}" class="inline-flex items-center justify-between w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-3 px-5 rounded-xl transition duration-200 group">
                    <span>Masuk sebagai Kasir</span>
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
            </div>
        </div>

        {{-- Footer demo --}}
        <div class="text-center mt-10 text-sm text-gray-400">
            Demo sistem - klik salah satu peran untuk masuk
        </div>
    </div>

</body>
</html>