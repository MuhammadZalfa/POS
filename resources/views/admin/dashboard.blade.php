{{-- file: dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Dashboard - POS Native')
@section('header-title', '')
@section('header-subtitle', '')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-orange-50/30 -m-4 md:-m-6 p-4 md:p-6 min-h-screen">
    <div class="max-w-7xl mx-auto">

        {{-- Header dengan Animasi --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8 animate-fade-in-up">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Selamat Datang, <span class="text-orange-600">Admin!</span>
                </h1>
                <p class="text-base md:text-lg text-gray-600 mt-2 flex items-center gap-2">
                    <span class="inline-block w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    Ringkasan penjualan hari ini • {{ now()->format('d F Y') }}
                </p>
            </div>

            <button class="group relative inline-flex items-center gap-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-orange-500/20 transition-all duration-300 transform hover:scale-[1.02] active:scale-95">
                <img src="{{ asset('images/cashier (1).png') }}" alt="Buka Kasir" class="w-5 h-5 transition-transform group-hover:rotate-12">
                Buka Kasir
                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-yellow-300 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-yellow-400"></span>
                </span>
            </button>
        </div>

        {{-- Statistik Cards dengan Hover Effect --}}
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5 mb-8">
            {{-- Total Penjualan --}}
            <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 hover:border-orange-200 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 font-medium tracking-wide text-sm">Total Penjualan</p>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3 tracking-tight">Rp 1.250.000</h2>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded-full">↑ 12%</span>
                            <span class="text-gray-400 text-xs">dari kemarin</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-500 flex items-center justify-center shadow-md shadow-orange-200 group-hover:shadow-orange-300/50 transition-shadow">
                        <img src="{{ asset('images/sale-tag.png') }}" alt="Uang" class="w-6 h-6 text-white">
                    </div>
                </div>
            </div>

            {{-- Total Transaksi --}}
            <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 font-medium tracking-wide text-sm">Total Transaksi</p>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3 tracking-tight">87</h2>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded-full">↑ 8%</span>
                            <span class="text-gray-400 text-xs">dari kemarin</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-500 flex items-center justify-center shadow-md shadow-blue-200 group-hover:shadow-blue-300/50 transition-shadow">
                        <img src="{{ asset('images/shopping-cart.png') }}" alt="Grafik" class="w-6 h-6 text-white">
                    </div>
                </div>
            </div>

            {{-- Laba Hari Ini --}}
            <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 hover:border-green-200 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 font-medium tracking-wide text-sm">Laba Hari Ini</p>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3 tracking-tight">Rp 625.000</h2>
                        <div class="flex items-center gap-1 mt-2">
                            <span class="text-green-600 text-sm font-semibold bg-green-50 px-2 py-1 rounded-full">50% margin</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-green-400 to-green-500 flex items-center justify-center shadow-md shadow-green-200 group-hover:shadow-green-300/50 transition-shadow">
                        <img src="{{ asset('images/sales.png') }}" alt="Grafik" class="w-6 h-6">
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart + Transaksi Terbaru --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5 mb-8">
            {{-- Chart dengan Desain Lebih Menarik --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Penjualan 7 Hari Terakhir</h3>
                    <div class="flex gap-2">
                        <span class="text-xs font-medium bg-orange-100 text-orange-700 px-3 py-1 rounded-full">Mingguan</span>
                    </div>
                </div>

                <div class="relative h-[280px]">
                    {{-- Grid Lines --}}
                    <div class="absolute left-0 top-0 bottom-8 w-14 flex flex-col justify-between text-xs font-medium text-gray-400">
                        <span>800k</span>
                        <span>600k</span>
                        <span>400k</span>
                        <span>200k</span>
                        <span>0</span>
                    </div>

                    {{-- Chart Area --}}
                    <div class="ml-14 h-full border-l-2 border-b-2 border-gray-200 relative">
                        {{-- Horizontal Grid --}}
                        <div class="absolute inset-0 flex flex-col justify-between pointer-events-none">
                            <div class="border-t border-dashed border-gray-200"></div>
                            <div class="border-t border-dashed border-gray-200"></div>
                            <div class="border-t border-dashed border-gray-200"></div>
                            <div class="border-t border-dashed border-gray-200"></div>
                            <div class="border-t border-transparent"></div>
                        </div>

                        {{-- Bars dengan Gradient dan Animasi --}}
                        <div class="absolute inset-0 flex items-end justify-between px-3">
                            @php
                                $data = [
                                    ['day' => 'Sen', 'value' => 56],
                                    ['day' => 'Sel', 'value' => 47],
                                    ['day' => 'Rab', 'value' => 64],
                                    ['day' => 'Kam', 'value' => 61],
                                    ['day' => 'Jum', 'value' => 85],
                                    ['day' => 'Sab', 'value' => 93],
                                    ['day' => 'Min', 'value' => 77],
                                ];
                            @endphp
                            @foreach($data as $item)
                            <div class="flex flex-col items-center justify-end h-full w-[12%] group">
                                <div class="relative w-full bg-gradient-to-t from-orange-500 to-orange-400 rounded-t-lg shadow-md transition-all duration-500 group-hover:from-orange-600 group-hover:to-orange-500" 
                                     style="height: {{ $item['value'] }}%;">
                                    {{-- Tooltip --}}
                                    <div class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs rounded-md px-2 py-1 opacity-0 group-hover:opacity-100 transition whitespace-nowrap pointer-events-none">
                                        Rp {{ number_format($item['value'] * 8000, 0, ',', '.') }}
                                    </div>
                                </div>
                                <span class="mt-3 text-xs font-semibold text-gray-600">{{ $item['day'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Transaksi Terbaru dengan Efek Hover --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="text-xl font-bold text-gray-900">Transaksi Terbaru</h3>
                    <a href="#" class="text-sm font-medium text-orange-500 hover:text-orange-700 transition-colors">Lihat semua →</a>
                </div>

                <div class="space-y-1">
                    @php
                        $transactions = [
                            ['id' => 'TRX-001', 'time' => '14:30', 'items' => 3, 'amount' => 45000],
                            ['id' => 'TRX-002', 'time' => '14:15', 'items' => 2, 'amount' => 30000],
                            ['id' => 'TRX-003', 'time' => '14:00', 'items' => 4, 'amount' => 60000],
                            ['id' => 'TRX-004', 'time' => '13:45', 'items' => 2, 'amount' => 25000],
                            ['id' => 'TRX-005', 'time' => '13:30', 'items' => 3, 'amount' => 50000],
                        ];
                    @endphp
                    @foreach($transactions as $trx)
                    <div class="group flex items-center justify-between p-4 rounded-xl hover:bg-orange-50/50 transition-all duration-200 cursor-default border border-transparent hover:border-orange-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center group-hover:from-orange-100 group-hover:to-orange-200 transition-colors">
                                <img src="{{ asset('images/clip.png') }}" alt="arrow" class="w-5 h-5 text-gray-500 group-hover:text-orange-600" />
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 group-hover:text-orange-700 transition-colors">{{ $trx['id'] }}</h4>
                                <p class="text-sm text-gray-500 mt-0.5">{{ $trx['time'] }} • {{ $trx['items'] }} item</p>
                            </div>
                        </div>
                        <div class="text-lg font-bold text-orange-600 group-hover:text-orange-700 transition-colors">
                            Rp {{ number_format($trx['amount'], 0, ',', '.') }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Produk Terlaris dengan Card Interaktif --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-gray-900">Produk Terlaris</h3>
                <a href="#" class="text-sm font-medium text-orange-500 hover:text-orange-700 transition-colors flex items-center gap-1">
                    Lihat semua
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                @php
                    $products = [
                        ['name' => 'Kopi Susu Gula Aren', 'category' => 'Minuman', 'price' => 18000, 'sold' => 124, 'icon' => 'M20 13V7a2 2 0 00-2-2h-3V3H9v2H6a2 2 0 00-2 2v6m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4'],
                        ['name' => 'Croissant Coklat', 'category' => 'Snack', 'price' => 15000, 'sold' => 98, 'icon' => 'M12 8c-4 0-7 2-7 4s3 4 7 4 7-2 7-4-3-4-7-4z'],
                        ['name' => 'Matcha Latte', 'category' => 'Minuman', 'price' => 22000, 'sold' => 87, 'icon' => 'M5 13l4 4L19 7'],
                        ['name' => 'Roti Bakar Keju', 'category' => 'Makanan', 'price' => 20000, 'sold' => 76, 'icon' => 'M12 6v12m6-6H6'],
                    ];
                @endphp
                @foreach($products as $product)
                <div class="group bg-white rounded-xl p-5 border border-gray-200 hover:border-orange-300 hover:shadow-lg transition-all duration-300 transform hover:-translate-y-1">
                    <div class="w-full h-32 bg-gradient-to-br from-orange-50 to-orange-100 rounded-xl flex items-center justify-center mb-4 group-hover:from-orange-100 group-hover:to-orange-200 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-orange-500 group-hover:text-orange-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $product['icon'] }}"/>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-900 group-hover:text-orange-700 transition-colors">{{ $product['name'] }}</h4>
                    <p class="text-sm text-gray-500 mt-1">{{ $product['category'] }}</p>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-lg font-bold text-orange-600">Rp {{ number_format($product['price'], 0, ',', '.') }}</span>
                        <div class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                            </svg>
                            <span class="text-sm font-semibold text-gray-700">{{ $product['sold'] }} terjual</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

{{-- Tambahan Animasi CSS --}}
<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out;
    }
</style>
@endsection