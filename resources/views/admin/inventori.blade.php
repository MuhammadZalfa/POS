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

        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Inventori <span class="text-orange-600">Item Ready</span>
                </h1>
                <p class="text-base md:text-lg text-gray-600 mt-2">
                    Halaman ini untuk stok item fisik seperti cilok, pangsit, tahu, minuman, dan snack.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <button type="button" onclick="openAddItemModal()" class="inline-flex items-center gap-3 bg-white border border-gray-200 hover:border-orange-300 text-gray-700 hover:text-orange-600 font-semibold px-6 py-3 rounded-xl transition-all">
                    Tambah Item
                </button>
                <button type="button" onclick="openAddStockModal()" class="inline-flex items-center gap-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-orange-500/20 transition-all">
                    Tambah Stok
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                <p class="text-gray-500 font-medium text-sm">Total Item</p>
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3">{{ $totalItem }}</h2>
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Item</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jenis</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Satuan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Min</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Stok</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status Item</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($inventoryRows as $item)
                            @php
                                $maxStock = max($item['stok_minimal'] * 4, 1);
                                $percentage = min(($item['stok'] / $maxStock) * 100, 100);
                                $barColor = $item['status_stok'] == 'Habis'
                                    ? 'bg-red-500'
                                    : ($item['status_stok'] == 'Stok Rendah' ? 'bg-yellow-500' : 'bg-green-500');
                            @endphp
                            <tr class="hover:bg-orange-50/30 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-medium text-gray-900">{{ $item['nama_item'] }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $item['last_note'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item['jenis'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <span class="text-sm font-semibold text-gray-900">{{ $item['stok'] }}</span>
                                        <div class="w-16 h-2 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full {{ $barColor }}" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item['satuan'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $item['stok_minimal'] }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item['status_stok'] == 'Aman')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Aman
                                        </span>
                                    @elseif($item['status_stok'] == 'Stok Rendah')
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-50 text-yellow-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>Stok Rendah
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Habis
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($item['status_item'])
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <div class="flex flex-wrap items-center justify-center gap-2">
                                        <button type="button"
                                                data-update-url="{{ route('admin.inventory.item.update', $item['id_item']) }}"
                                                data-id="{{ $item['id_item'] }}"
                                                data-name="{{ $item['nama_item'] }}"
                                                data-jenis="{{ $item['jenis'] === '-' ? '' : $item['jenis'] }}"
                                                data-satuan="{{ $item['satuan'] }}"
                                                data-min="{{ $item['stok_minimal'] }}"
                                                data-status="{{ $item['status_item'] ? 1 : 0 }}"
                                                onclick="openEditItemModal(this)"
                                                class="px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-700 text-xs font-semibold hover:border-orange-300 hover:text-orange-600 transition">
                                            Edit Item
                                        </button>
                                        <button type="button"
                                                data-id="{{ $item['id_item'] }}"
                                                data-name="{{ $item['nama_item'] }}"
                                                data-stock="{{ $item['stok'] }}"
                                                data-unit="{{ $item['satuan'] }}"
                                                onclick="openEditStockModal(this)"
                                                class="px-3 py-2 rounded-lg border border-orange-200 bg-orange-50 text-orange-700 text-xs font-semibold hover:bg-orange-100 transition">
                                            Set Stok
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-6 text-center text-gray-500">Belum ada item inventori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="addItemModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/30 backdrop-blur-sm" onclick="closeAddItemModal(event)">
    <div class="bg-white w-full max-w-lg mx-4 rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-gray-900">Tambah Item Inventori</h3>
                <button type="button" onclick="closeAddItemModal()" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100">✕</button>
            </div>

            <form method="POST" action="{{ route('admin.inventory.item.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Item</label>
                        <input type="text" name="nama_item" required class="w-full px-4 py-3 border border-gray-200 rounded-xl" placeholder="Contoh: Cilok">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                        <input type="text" name="jenis" class="w-full px-4 py-3 border border-gray-200 rounded-xl" placeholder="Contoh: Makanan, Minuman, Snack">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Satuan Default</label>
                        <select name="satuan_default" required class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white">
                            <option value="">Pilih Satuan</option>
                            @foreach(['pcs','porsi','gelas','botol','buah','pack','bungkus'] as $satuan)
                                <option value="{{ $satuan }}">{{ $satuan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Minimal</label>
                        <input type="number" name="stok_minimal" min="0" value="5" required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" required class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeAddItemModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-xl">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editItemModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/30 backdrop-blur-sm" onclick="closeEditItemModal(event)">
    <div class="bg-white w-full max-w-lg mx-4 rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-gray-900">Edit Item Inventori</h3>
                <button type="button" onclick="closeEditItemModal()" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100">✕</button>
            </div>

            <form id="editItemForm" method="POST" action="">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Item</label>
                        <input type="text" id="editItemName" name="nama_item" required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis</label>
                        <input type="text" id="editItemJenis" name="jenis" class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Satuan Default</label>
                        <select id="editItemSatuan" name="satuan_default" required class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white">
                            @foreach(['pcs','porsi','gelas','botol','buah','pack','bungkus'] as $satuan)
                                <option value="{{ $satuan }}">{{ $satuan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Minimal</label>
                        <input type="number" id="editItemMin" name="stok_minimal" min="0" required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="editItemStatus" name="status" required class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeEditItemModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-xl">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="addStockModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/30 backdrop-blur-sm" onclick="closeAddStockModal(event)">
    <div class="bg-white w-full max-w-lg mx-4 rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-gray-900">Tambah Stok</h3>
                <button type="button" onclick="closeAddStockModal()" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100">✕</button>
            </div>

            <form method="POST" action="{{ route('admin.inventory.stock.store') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Item Inventori</label>
                        <select name="id_item" required class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white">
                            <option value="">Pilih Item</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id_item }}">{{ $item->nama_item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jumlah Tambahan</label>
                        <input type="number" name="jumlah" min="1" required class="w-full px-4 py-3 border border-gray-200 rounded-xl" placeholder="Contoh: 20">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Satuan</label>
                        <select name="satuan" required class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white">
                            <option value="">Pilih Satuan</option>
                            @foreach(['pcs','porsi','gelas','botol','buah','pack','bungkus'] as $satuan)
                                <option value="{{ $satuan }}">{{ $satuan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                        <input type="text" name="keterangan" class="w-full px-4 py-3 border border-gray-200 rounded-xl" placeholder="Contoh: Restock pagi">
                    </div>
                </div>
                <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeAddStockModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-xl">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editStockModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/30 backdrop-blur-sm" onclick="closeEditStockModal(event)">
    <div class="bg-white w-full max-w-md mx-4 rounded-2xl shadow-2xl" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-gray-900">Set Stok Baru</h3>
                <button type="button" onclick="closeEditStockModal()" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100">✕</button>
            </div>

            <form method="POST" action="{{ route('admin.inventory.stock.set') }}">
                @csrf
                <input type="hidden" name="id_item" id="editStockIdItem">

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Item</label>
                    <input type="text" id="editStockName" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly>
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
                    <select name="satuan" id="editStockSatuan" required class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white">
                        @foreach(['pcs','porsi','gelas','botol','buah','pack','bungkus'] as $satuan)
                            <option value="{{ $satuan }}">{{ $satuan }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
                    <input type="text" name="keterangan" class="w-full px-4 py-3 border border-gray-200 rounded-xl" placeholder="Contoh: Koreksi stok malam">
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeEditStockModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-xl">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAddItemModal() {
        document.getElementById('addItemModal').classList.remove('hidden');
    }

    function closeAddItemModal(event) {
        const modal = document.getElementById('addItemModal');
        if (!event || event.target === modal) {
            modal.classList.add('hidden');
        }
    }

    function openEditItemModal(button) {
        document.getElementById('editItemForm').action = button.dataset.updateUrl;
        document.getElementById('editItemName').value = button.dataset.name;
        document.getElementById('editItemJenis').value = button.dataset.jenis;
        document.getElementById('editItemSatuan').value = button.dataset.satuan;
        document.getElementById('editItemMin').value = button.dataset.min;
        document.getElementById('editItemStatus').value = button.dataset.status;
        document.getElementById('editItemModal').classList.remove('hidden');
    }

    function closeEditItemModal(event) {
        const modal = document.getElementById('editItemModal');
        if (!event || event.target === modal) {
            modal.classList.add('hidden');
        }
    }

    function openAddStockModal() {
        document.getElementById('addStockModal').classList.remove('hidden');
    }

    function closeAddStockModal(event) {
        const modal = document.getElementById('addStockModal');
        if (!event || event.target === modal) {
            modal.classList.add('hidden');
        }
    }

    function openEditStockModal(button) {
        document.getElementById('editStockIdItem').value = button.dataset.id;
        document.getElementById('editStockName').value = button.dataset.name;
        document.getElementById('currentStockDisplay').value = `${button.dataset.stock} ${button.dataset.unit}`;
        document.getElementById('newStockInput').value = button.dataset.stock;
        document.getElementById('editStockSatuan').value = button.dataset.unit;
        document.getElementById('editStockModal').classList.remove('hidden');
    }

    function closeEditStockModal(event) {
        const modal = document.getElementById('editStockModal');
        if (!event || event.target === modal) {
            modal.classList.add('hidden');
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAddItemModal();
            closeEditItemModal();
            closeAddStockModal();
            closeEditStockModal();
        }
    });
</script>
@endsection
