@extends('layouts.app')

@section('title', 'Resep Produk')
@section('header-title', '')
@section('header-subtitle', '')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-orange-50/30 -m-4 md:-m-6 p-4 md:p-6 min-h-screen">
    <div class="max-w-7xl mx-auto">
        @if(session('success'))
            <div class="mb-4 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-red-700">
                <div class="font-semibold mb-1">Ada error:</div>
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Kelola <span class="text-orange-600">Resep Produk</span>
                </h1>
                <p class="text-base md:text-lg text-gray-600 mt-2">
                    Tentukan komposisi item inventori untuk setiap menu jual.
                </p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.products') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white border border-gray-200 text-gray-700 font-semibold hover:border-orange-300 hover:text-orange-600 transition">
                    Kembali ke Menu
                </a>
                <a href="{{ route('admin.inventory') }}" class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white border border-gray-200 text-gray-700 font-semibold hover:border-orange-300 hover:text-orange-600 transition">
                    Lihat Inventori
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-1 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Daftar Menu</h2>
                    <p class="text-sm text-gray-500 mt-1">Pilih menu yang ingin diatur resepnya.</p>
                </div>
                <div class="max-h-[70vh] overflow-y-auto divide-y divide-gray-100">
                    @forelse($products as $product)
                        <a href="{{ route('admin.recipes', ['produk' => $product->id_produk]) }}"
                           class="block px-6 py-4 transition hover:bg-orange-50/50 {{ $selectedProduk && $selectedProduk->id_produk === $product->id_produk ? 'bg-orange-50 border-l-4 border-orange-500' : '' }}">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="font-semibold text-gray-900">{{ $product->nama_produk }}</div>
                                    <div class="text-sm text-gray-500 mt-1">{{ $product->kategori->nama_kategori ?? '-' }}</div>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm font-semibold text-gray-900">Rp {{ number_format((float) $product->harga, 0, ',', '.') }}</div>
                                    <div class="text-xs mt-1 {{ $product->resep->count() ? 'text-green-600' : 'text-red-500' }}">
                                        {{ $product->resep->count() ? $product->resep->count() . ' item resep' : 'Belum ada resep' }}
                                    </div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="px-6 py-8 text-center text-gray-500">Belum ada menu.</div>
                    @endforelse
                </div>
            </div>

            <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                @if($selectedProduk)
                    <div class="px-6 py-5 border-b border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900">{{ $selectedProduk->nama_produk }}</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Isi qty item yang dipakai untuk 1 kali penjualan menu ini.
                        </p>
                    </div>

                    <form method="POST" action="{{ route('admin.recipes.update', $selectedProduk) }}">
                        @csrf
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @forelse($items as $item)
                                    @php
                                        $current = $recipeMap[$item->id_item] ?? null;
                                    @endphp
                                    <div class="rounded-2xl border {{ $current ? 'border-orange-200 bg-orange-50/40' : 'border-gray-200 bg-white' }} p-4">
                                        <div class="flex items-start justify-between gap-3">
                                            <div>
                                                <div class="font-semibold text-gray-900">{{ $item->nama_item }}</div>
                                                <div class="text-xs text-gray-500 mt-1">
                                                    {{ $item->jenis ?: 'Tanpa jenis' }} • satuan default {{ $item->satuan_default }}
                                                </div>
                                            </div>
                                            <label class="inline-flex items-center gap-2 text-sm font-medium text-gray-700">
                                                <input type="checkbox"
                                                       name="items[{{ $item->id_item }}][aktif]"
                                                       value="1"
                                                       {{ $current ? 'checked' : '' }}
                                                       class="rounded border-gray-300 text-orange-600 focus:ring-orange-500">
                                                Pakai
                                            </label>
                                        </div>

                                        <div class="grid grid-cols-2 gap-3 mt-4">
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Qty</label>
                                                <input type="number"
                                                       min="1"
                                                       name="items[{{ $item->id_item }}][qty]"
                                                       value="{{ $current['qty'] ?? '' }}"
                                                       class="w-full px-4 py-2.5 border border-gray-200 rounded-xl">
                                            </div>
                                            <div>
                                                <label class="block text-xs font-medium text-gray-600 mb-1">Satuan</label>
                                                <select name="items[{{ $item->id_item }}][satuan]" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-white">
                                                    @foreach(['pcs','porsi','gelas','botol','buah','pack','bungkus'] as $satuan)
                                                        <option value="{{ $satuan }}" {{ ($current['satuan'] ?? $item->satuan_default) == $satuan ? 'selected' : '' }}>{{ $satuan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="md:col-span-2 rounded-2xl border border-dashed border-gray-300 p-6 text-center text-gray-500">
                                        Belum ada item inventori aktif. Buat item inventori dulu.
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3 bg-gray-50/50">
                            <a href="{{ route('admin.recipes', ['produk' => $selectedProduk->id_produk]) }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl">
                                Reset Form
                            </a>
                            <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-xl">
                                Simpan Resep
                            </button>
                        </div>
                    </form>
                @else
                    <div class="px-6 py-10 text-center text-gray-500">
                        Belum ada menu yang bisa diatur resepnya.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
