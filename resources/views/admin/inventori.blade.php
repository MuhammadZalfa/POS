{{-- file: inventori.blade.php --}}
@extends('layouts.app')

@section('title', 'Inventori Stok Makanan - POS Native')
@section('header-title', '')
@section('header-subtitle', '')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-orange-50/30 -m-4 md:-m-6 p-4 md:p-6 min-h-screen">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8 animate-fade-in-up">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Inventori <span class="text-orange-600">Stok Makanan</span>
                </h1>
                <p class="text-base md:text-lg text-gray-600 mt-2 flex items-center gap-2">
                    <span class="inline-block w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    Pantau stok produk jadi • {{ now()->format('d F Y') }}
                </p>
            </div>

            <button onclick="openAddInventoryModal()" class="group relative inline-flex items-center gap-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-orange-500/20 transition-all duration-300 transform hover:scale-[1.02] active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk
            </button>
        </div>

        {{-- Ringkasan Kartu --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8 animate-fade-in-up" style="animation-delay: 0.05s">
            {{-- Total Produk --}}
            <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 hover:border-blue-200 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 font-medium tracking-wide text-sm">Total Produk</p>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3 tracking-tight">8</h2>
                        <p class="text-gray-400 text-xs mt-1">Produk aktif</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-500 flex items-center justify-center shadow-md shadow-blue-200 group-hover:shadow-blue-300/50 transition-shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Stok Menipis --}}
            <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 hover:border-yellow-200 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 font-medium tracking-wide text-sm">Stok Menipis</p>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3 tracking-tight">3</h2>
                        <p class="text-yellow-600 text-xs mt-1 flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-yellow-500 rounded-full"></span>
                            Di bawah batas minimum
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-yellow-400 to-yellow-500 flex items-center justify-center shadow-md shadow-yellow-200 group-hover:shadow-yellow-300/50 transition-shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>

            {{-- Stok Habis --}}
            <div class="group bg-white rounded-2xl p-6 shadow-sm hover:shadow-xl border border-gray-100 hover:border-red-200 transition-all duration-300 transform hover:-translate-y-1">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-gray-500 font-medium tracking-wide text-sm">Stok Habis</p>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mt-3 tracking-tight">1</h2>
                        <p class="text-red-500 text-xs mt-1">Perlu segera diisi ulang</p>
                    </div>
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-red-400 to-red-500 flex items-center justify-center shadow-md shadow-red-200 group-hover:shadow-red-300/50 transition-shadow">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabel Stok Makanan --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-fade-in-up" style="animation-delay: 0.1s">
            {{-- Filter & Search --}}
            <div class="p-5 border-b border-gray-100 flex flex-wrap items-center justify-between gap-4">
                <div class="relative">
                    <svg xmlns="http://www.w3.org/2000/svg" class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" placeholder="Cari produk..." class="pl-10 pr-4 py-2 w-64 text-sm border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition">
                </div>
                <div class="flex gap-2">
                    <select class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:ring-2 focus:ring-orange-200 outline-none">
                        <option>Semua Kategori</option>
                        <option>Cilok</option>
                        <option>Minuman</option>
                        <option>Lainnya</option>
                    </select>
                    <select class="text-sm border border-gray-200 rounded-lg px-3 py-2 bg-white focus:ring-2 focus:ring-orange-200 outline-none">
                        <option>Semua Status</option>
                        <option>Aman</option>
                        <option>Stok Rendah</option>
                        <option>Habis</option>
                    </select>
                </div>
            </div>

            {{-- Tabel --}}
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
                        @php
                            $inventory = [
                                ['name' => 'Cilok Original', 'category' => 'Cilok', 'stock' => 45, 'unit' => 'porsi', 'status' => 'Aman', 'min' => 10],
                                ['name' => 'Cilok Pedas', 'category' => 'Cilok', 'stock' => 28, 'unit' => 'porsi', 'status' => 'Aman', 'min' => 10],
                                ['name' => 'Cilok Keju', 'category' => 'Cilok', 'stock' => 8, 'unit' => 'porsi', 'status' => 'Stok Rendah', 'min' => 10],
                                ['name' => 'Cilok Bakso', 'category' => 'Cilok', 'stock' => 12, 'unit' => 'porsi', 'status' => 'Aman', 'min' => 8],
                                ['name' => 'Teh Manis', 'category' => 'Minuman', 'stock' => 3, 'unit' => 'gelas', 'status' => 'Stok Rendah', 'min' => 5],
                                ['name' => 'Es Jeruk', 'category' => 'Minuman', 'stock' => 0, 'unit' => 'gelas', 'status' => 'Habis', 'min' => 5],
                                ['name' => 'Teh Tawar', 'category' => 'Minuman', 'stock' => 15, 'unit' => 'gelas', 'status' => 'Aman', 'min' => 5],
                                ['name' => 'Gorengan', 'category' => 'Lainnya', 'stock' => 2, 'unit' => 'buah', 'status' => 'Stok Rendah', 'min' => 5],
                            ];
                        @endphp

                        @foreach($inventory as $index => $item)
                        <tr class="hover:bg-orange-50/30 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $item['name'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full 
                                    {{ $item['category'] == 'Cilok' ? 'bg-blue-50 text-blue-700' : '' }}
                                    {{ $item['category'] == 'Minuman' ? 'bg-cyan-50 text-cyan-700' : '' }}
                                    {{ $item['category'] == 'Lainnya' ? 'bg-gray-100 text-gray-700' : '' }}">
                                    {{ $item['category'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <span class="text-sm font-semibold text-gray-900">{{ $item['stock'] }}</span>
                                    <div class="w-16 h-2 bg-gray-200 rounded-full overflow-hidden">
                                        @php
                                            $maxStock = 50;
                                            $percentage = min(($item['stock'] / $maxStock) * 100, 100);
                                            $barColor = $item['status'] == 'Habis' ? 'bg-red-500' : ($item['status'] == 'Stok Rendah' ? 'bg-yellow-500' : 'bg-green-500');
                                        @endphp
                                        <div class="h-full {{ $barColor }}" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $item['unit'] }}
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
                                <button onclick="openEditModal({{ $index }})" class="p-1.5 rounded-lg text-gray-500 hover:text-orange-600 hover:bg-orange-50 transition-colors" title="Edit Stok">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> 
    </div>
</div>

{{-- ===================== MODAL TAMBAH PRODUK ===================== --}}
<div id="addInventoryModal" class="fixed inset-0 z-50 flex items-center justify-center hidden transition-opacity bg-black/30 backdrop-blur-sm" onclick="closeAddInventoryModal(event)">
    <div class="bg-white w-full max-w-lg mx-4 rounded-2xl shadow-2xl transform transition-all max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-gray-900">Tambah Produk Baru + Stok</h3>
                <button onclick="closeAddInventoryModal()" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="addInventoryForm" onsubmit="saveNewInventory(event)">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" id="invProductName" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition" placeholder="Contoh: Cilok Bakso">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select id="invProductCategory" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition bg-white">
                            <option value="">Pilih Kategori</option>
                            <option value="Cilok">Cilok</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok Awal <span class="text-red-500">*</span></label>
                        <input type="number" id="initialStock" min="0" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition" placeholder="Contoh: 20">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Satuan <span class="text-red-500">*</span></label>
                        <select id="stockUnit" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition bg-white">
                            <option value="">Pilih Satuan</option>
                            <option value="porsi">Porsi</option>
                            <option value="gelas">Gelas</option>
                            <option value="buah">Buah</option>
                            <option value="pack">Pack</option>
                            <option value="kg">Kg</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Batas Minimum Stok</label>
                        <input type="number" id="minStock" min="0" value="5" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition">
                        <p class="text-xs text-gray-500 mt-1">Peringatan stok menipis jika di bawah nilai ini</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Stok</label>
                        <input type="text" id="stockStatus" value="Aman" readonly disabled class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700">
                    </div>
                </div>
                <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeAddInventoryModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 rounded-xl shadow-md shadow-orange-200 transition-all">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===================== MODAL EDIT STOK ===================== --}}
<div id="editStockModal" class="fixed inset-0 z-50 flex items-center justify-center hidden transition-opacity bg-black/30 backdrop-blur-sm" onclick="closeEditModal(event)">
    <div class="bg-white w-full max-w-md mx-4 rounded-2xl shadow-2xl transform transition-all" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-gray-900">Update Stok</h3>
                <button onclick="closeEditModal()" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="editStockForm" onsubmit="updateStock(event)">
                <input type="hidden" id="editIndex" value="">
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk</label>
                    <input type="text" id="editProductName" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly disabled>
                </div>
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok Saat Ini</label>
                    <input type="text" id="currentStockDisplay" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-700" readonly disabled>
                </div>
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Stok Baru <span class="text-red-500">*</span></label>
                    <input type="number" id="newStockInput" min="0" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition">
                    <p class="text-xs text-gray-500 mt-1">Masukkan jumlah stok terbaru (minimal 0)</p>
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 rounded-xl shadow-md shadow-orange-200 transition-all">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===================== SCRIPT ===================== --}}
<script>
    // Data inventori dari PHP ke JavaScript
    const inventoryData = @json($inventory);

    // --- Modal Tambah ---
    const minStockInput = document.getElementById('minStock');
    const initialStockInput = document.getElementById('initialStock');
    const stockStatusField = document.getElementById('stockStatus');

    function updateStockStatus() {
        const stock = parseInt(initialStockInput.value) || 0;
        const min = parseInt(minStockInput.value) || 5;
        if (stock === 0) {
            stockStatusField.value = 'Habis';
        } else if (stock <= min) {
            stockStatusField.value = 'Stok Rendah';
        } else {
            stockStatusField.value = 'Aman';
        }
    }

    if (initialStockInput) {
        initialStockInput.addEventListener('input', updateStockStatus);
        minStockInput.addEventListener('input', updateStockStatus);
    }

    function openAddInventoryModal() {
        document.getElementById('addInventoryModal').classList.remove('hidden');
        document.getElementById('addInventoryForm').reset();
        document.getElementById('minStock').value = 5;
        updateStockStatus();
    }

    function closeAddInventoryModal(event) {
        if (!event || event.target === document.getElementById('addInventoryModal')) {
            document.getElementById('addInventoryModal').classList.add('hidden');
        }
    }

    function saveNewInventory(event) {
        event.preventDefault();
        const name = document.getElementById('invProductName').value;
        const category = document.getElementById('invProductCategory').value;
        const stock = parseInt(document.getElementById('initialStock').value);
        const unit = document.getElementById('stockUnit').value;
        const min = parseInt(document.getElementById('minStock').value);
        const status = document.getElementById('stockStatus').value;

        alert(`Produk "${name}" berhasil ditambahkan ke inventori!\nKategori: ${category}\nStok Awal: ${stock} ${unit}\nBatas Minimum: ${min}\nStatus: ${status}`);
        closeAddInventoryModal();
        // location.reload(); // Aktifkan jika ingin refresh setelah tambah
    }

    // --- Modal Edit Stok ---
    function openEditModal(index) {
        const item = inventoryData[index];
        document.getElementById('editIndex').value = index;
        document.getElementById('editProductName').value = item.name;
        document.getElementById('currentStockDisplay').value = item.stock + ' ' + item.unit;
        document.getElementById('newStockInput').value = item.stock;
        document.getElementById('editStockModal').classList.remove('hidden');
    }

    function closeEditModal(event) {
        if (!event || event.target === document.getElementById('editStockModal')) {
            document.getElementById('editStockModal').classList.add('hidden');
        }
    }

    function updateStock(event) {
        event.preventDefault();
        const index = document.getElementById('editIndex').value;
        const newStock = parseInt(document.getElementById('newStockInput').value);
        
        if (newStock >= 0) {
            const item = inventoryData[index];
            item.stock = newStock;
            
            // Update status berdasarkan stok baru
            if (newStock === 0) {
                item.status = 'Habis';
            } else if (newStock <= item.min) {
                item.status = 'Stok Rendah';
            } else {
                item.status = 'Aman';
            }
            
            alert(`Stok "${item.name}" berhasil diperbarui menjadi ${newStock} ${item.unit}. Status sekarang: ${item.status}`);
            closeEditModal();
            
            // Untuk melihat perubahan langsung, Anda bisa reload halaman:
            // location.reload();
            
            // Atau lakukan update DOM secara manual di sini (rekomendasi untuk production)
        } else {
            alert('Stok tidak boleh negatif!');
        }
    }

    // Tutup modal dengan tombol ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAddInventoryModal();
            closeEditModal();
        }
    });
</script>

{{-- Animasi CSS --}}
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up { animation: fadeInUp 0.6s ease-out; }
</style>
@endsection