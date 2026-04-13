<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'POS Native')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="min-h-screen relative overflow-hidden flex items-center justify-center px-4 py-8 bg-[#f8f3ee]">
    {{-- Background dekoratif --}}
    <div class="absolute inset-0 -z-10">
        <div class="absolute top-[-120px] left-[-100px] w-[260px] h-[260px] bg-orange-200/40 rounded-full blur-3xl"></div>
        <div class="absolute bottom-[-140px] right-[-100px] w-[300px] h-[300px] bg-orange-300/30 rounded-full blur-3xl"></div>
        <div class="absolute top-[20%] right-[12%] w-24 h-24 bg-white/40 rounded-full blur-2xl"></div>
        <div class="absolute bottom-[18%] left-[10%] w-20 h-20 bg-orange-100/60 rounded-full blur-2xl"></div>
    </div>

    <div class="w-full max-w-lg">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>