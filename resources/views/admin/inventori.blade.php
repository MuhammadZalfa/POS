@extends('layouts.app')

@section('title', 'Inventori Stok')
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

        @if(session('info'))
            <div class="mb-4 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-blue-700">
                {{ session('info') }}
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

        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Inventori <span class="text-orange-600">Stok Produk</span>
                </h1>
                <p class="text-base md:text-lg text-gray-600 mt-2">
                    Produk dari tabel produk • stok dan satuan dari tabel inventory
                </p>
            </div>

            <button type="button" onclick="openAddStockModal()"
                class="inline-flex items-center gap-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-orange-500/20 transition-all">
                Tambah Stok
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <p class="text-gray-500 font-medium text-sm">Total Produk</p>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3">{{ $totalProduk }}</h2>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <p class="text-gray-500 font-medium text-sm">Stok Menipis</p>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3">{{ $stokMenipis }}</h2>
            </div>

            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <p class="text-gray-500 font-medium text-sm">Stok Habis</p>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3">{{ $stokHabis }}</h2>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/80">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Satuan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($inventoryRows as $item)
                            @php
                                $maxStock = 50;
                                $percentage = min(($item['stok'] / $maxStock) * 100, 100);
                                $barColor = $item['status'] == 'Habis'
                                    ? 'bg-red-500'
                                    : ($item['status'] == 'Stok Rendah' ? 'bg-yellow-500' : 'bg-green-500');
                            @endphp

                            <tr class="hover:bg-orange-50/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $item['nama_produk'] }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-700">
                                        {{ $item['kategori'] }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-semibold text-gray-900">{{ $item['stok'] }}</span>
                                        <div class="w-16 h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full {{ $barColor }}" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                    {{ $item['satuan'] }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item['status'] == 'Aman')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Aman
                                        </span>
                                    @elseif($item['status'] == 'Stok Rendah')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                                            Stok Rendah
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Habis
                                        </span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <button
                                        type="button"
                                        data-id="{{ $item['id_produk'] }}"
                                        data-name="{{ $item['nama_produk'] }}"
                                        data-stock="{{ $item['stok'] }}"
                                        data-unit="{{ $item['satuan'] }}"
                                        onclick="openEditModal(this)"
                                        class="p-1.5 rounded-lg text-gray-500 hover:text-orange-600 hover:bg-orange-50 transition-colors"
                                        title="Set Stok Baru">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-6 text-center text-gray-500">
                                    Belum ada produk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH STOK --}}
<div id="addStockModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/30 backdrop-blur-sm" onclick="closeAddStockModal(event)">
    <div class="bg-white w-full max-w-lg mx-4 rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-gray-900">Tambah Stok</h3>
                <button type="button" onclick="closeAddStockModal()" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">✕</button>
            </div>

            <form method="POST" action="{{ route('admin.inventory.stock.store') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Produk</label>
                        <select name="id_produk" required class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white">
                            <option value="">Pilih Produk</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id_produk }}">{{ $product->nama_produk }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Tambahan</label>
                        <input type="number" name="jumlah" min="1" required class="w-full px-4 py-3 border border-gray-200 rounded-xl" placeholder="Contoh: 10">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                        <select name="satuan" required class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white">
                            <option value="">Pilih Satuan</option>
                            <option value="pcs">pcs</option>
                            <option value="porsi">porsi</option>
                            <option value="gelas">gelas</option>
                            <option value="botol">botol</option>
                            <option value="buah">buah</option>
                            <option value="pack">pack</option>
                            <option value="bungkus">bungkus</option>
                            <option value="kg">kg</option>
                            <option value="gram">gram</option>
                            <option value="liter">liter</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <input type="text" name="keterangan" class="w-full px-4 py-3 border border-gray-200 rounded-xl" placeholder="Contoh: Restock pagi">
                    </div>
                </div>

                <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeAddStockModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-xl">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL SET STOK --}}
<div id="editStockModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/30 backdrop-blur-sm" onclick="closeEditModal(event)">
    <div class="bg-white w-full max-w-md mx-4 rounded-2xl shadow-2xl" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-gray-900">Set Stok Baru</h3>
                <button type="button" onclick="closeEditModal()" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">✕</button>
            </div>

            <form method="POST" action="{{ route('admin.inventory.stock.set') }}">
                @csrf
                <input type="hidden" name="id_produk" id="editIdProduk">

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" id="editProductName" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok Saat Ini</label>
                    <input type="text" id="currentStockDisplay" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok Baru</label>
                    <input type="number" name="stok_baru" id="newStockInput" min="0" required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                    <select name="satuan" id="editSatuan" required class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white">
                        <option value="">Pilih Satuan</option>
                        <option value="pcs">pcs</option>
                        <option value="porsi">porsi</option>
                        <option value="gelas">gelas</option>
                        <option value="botol">botol</option>
                        <option value="buah">buah</option>
                        <option value="pack">pack</option>
                        <option value="bungkus">bungkus</option>
                        <option value="kg">kg</option>
                        <option value="gram">gram</option>
                        <option value="liter">liter</option>
                    </select>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <input type="text" name="keterangan" class="w-full px-4 py-3 border border-gray-200 rounded-xl" placeholder="Contoh: Koreksi stok malam">
                </div>

                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-xl">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAddStockModal() {
        document.getElementById('addStockModal').classList.remove('hidden');
    }

    function closeAddStockModal(event) {
        const modal = document.getElementById('addStockModal');
        if (!event || event.target === modal) {
            modal.classList.add('hidden');
        }
    }

    function openEditModal(button) {
        const id = button.dataset.id;
        const name = button.dataset.name;
        const stock = button.dataset.stock;
        const unit = button.dataset.unit;

        document.getElementById('editIdProduk').value = id;
        document.getElementById('editProductName').value = name;
        document.getElementById('currentStockDisplay').value = `${stock} ${unit}`;
        document.getElementById('newStockInput').value = stock;
        document.getElementById('editSatuan').value = unit !== '-' ? unit : '';
        document.getElementById('editStockModal').classList.remove('hidden');
    }

    function closeEditModal(event) {
        const modal = document.getElementById('editStockModal');
        if (!event || event.target === modal) {
            modal.classList.add('hidden');
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAddStockModal();
            closeEditModal();
        }
    });
</script>
@endsection