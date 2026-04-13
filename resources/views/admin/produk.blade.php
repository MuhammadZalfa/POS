{{-- file: produk.blade.php --}}
@extends('layouts.app')

@section('title', 'Kelola Produk - POS Native')
@section('header-title', '')
@section('header-subtitle', '')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-orange-50/30 -m-4 md:-m-6 p-4 md:p-6 min-h-screen">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-8 animate-fade-in-up">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Kelola <span class="text-orange-600">Menu & Harga</span>
                </h1>
                <p class="text-base md:text-lg text-gray-600 mt-2 flex items-center gap-2">
                    <span class="inline-block w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    Daftar semua produk • {{ now()->format('d F Y') }}
                </p>
            </div>

            <button onclick="openAddProductModal()" class="group relative inline-flex items-center gap-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-orange-500/20 transition-all duration-300 transform hover:scale-[1.02] active:scale-95">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 transition-transform group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Produk
            </button>
        </div>

        {{-- Tabel Produk --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden animate-fade-in-up" style="animation-delay: 0.1s">
            {{-- Filter / Search --}}
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
                        <option>Aktif</option>
                        <option>Nonaktif</option>
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga Modal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga Jual</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Margin</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @php
                            $products = [
                                ['id' => 1, 'name' => 'Cilok Original', 'category' => 'Cilok', 'modal' => 2500, 'jual' => 5000, 'margin' => 50, 'status' => 'Aktif'],
                                ['id' => 2, 'name' => 'Cilok Pedas', 'category' => 'Cilok', 'modal' => 2500, 'jual' => 5000, 'margin' => 50, 'status' => 'Aktif'],
                                ['id' => 3, 'name' => 'Cilok Keju', 'category' => 'Cilok', 'modal' => 3500, 'jual' => 7000, 'margin' => 50, 'status' => 'Aktif'],
                                ['id' => 4, 'name' => 'Cilok Bakso', 'category' => 'Cilok', 'modal' => 4000, 'jual' => 8000, 'margin' => 50, 'status' => 'Aktif'],
                                ['id' => 5, 'name' => 'Teh Manis', 'category' => 'Minuman', 'modal' => 1000, 'jual' => 3000, 'margin' => 67, 'status' => 'Aktif'],
                                ['id' => 6, 'name' => 'Es Jeruk', 'category' => 'Minuman', 'modal' => 2000, 'jual' => 5000, 'margin' => 60, 'status' => 'Aktif'],
                                ['id' => 7, 'name' => 'Teh Tawar', 'category' => 'Minuman', 'modal' => 500, 'jual' => 2000, 'margin' => 75, 'status' => 'Aktif'],
                                ['id' => 8, 'name' => 'Gorengan', 'category' => 'Lainnya', 'modal' => 800, 'jual' => 2000, 'margin' => 60, 'status' => 'Aktif'],
                            ];
                        @endphp

                        @foreach($products as $index => $product)
                        <tr class="hover:bg-orange-50/30 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $product['name'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full 
                                    {{ $product['category'] == 'Cilok' ? 'bg-blue-50 text-blue-700' : '' }}
                                    {{ $product['category'] == 'Minuman' ? 'bg-cyan-50 text-cyan-700' : '' }}
                                    {{ $product['category'] == 'Lainnya' ? 'bg-gray-100 text-gray-700' : '' }}">
                                    {{ $product['category'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                Rp {{ number_format($product['modal'], 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                Rp {{ number_format($product['jual'], 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-1.5">
                                    <span class="text-sm font-semibold {{ $product['margin'] >= 60 ? 'text-green-600' : 'text-orange-600' }}">
                                        {{ $product['margin'] }}%
                                    </span>
                                    <div class="w-12 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full {{ $product['margin'] >= 60 ? 'bg-green-500' : 'bg-orange-400' }}" style="width: {{ $product['margin'] }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    {{ $product['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <div class="flex items-center justify-center gap-1">
                                    {{-- Tombol Edit --}}
                                    <button onclick="openEditModal({{ $index }})" class="p-1.5 rounded-lg text-gray-500 hover:text-orange-600 hover:bg-orange-50 transition-colors" title="Edit">
                                        <img src="{{ asset('images/edit.png') }}" class="w-5 h-5" alt="Edit">
                                    </button>
                                    {{-- Tombol Toggle Status (Aktif/Nonaktif) --}}
                                    <button onclick="toggleStatus({{ $index }})" class="p-1.5 rounded-lg text-gray-500 hover:text-orange-600 hover:bg-orange-50 transition-colors" title="Nonaktifkan">
                                        <img src="{{ asset('images/check.png') }}" class="w-5 h-5" alt="Toggle Status">
                                    </button>
                                    {{-- Tombol Hapus --}}
                                    <button onclick="openDeleteModal({{ $index }})" class="p-1.5 rounded-lg text-gray-500 hover:text-red-600 hover:bg-red-50 transition-colors" title="Hapus">
                                        <img src="{{ asset('images/trash.png') }}" class="w-5 h-5" alt="Hapus">
                                    </button>
                                </div>
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
<div id="addProductModal" class="fixed inset-0 z-50 flex items-center justify-center hidden transition-opacity bg-black/30 backdrop-blur-sm" onclick="closeAddProductModal(event)">
    <div class="bg-white w-full max-w-lg mx-4 rounded-2xl shadow-2xl transform transition-all max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-gray-900">Tambah Produk Baru</h3>
                <button onclick="closeAddProductModal()" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="addProductForm" onsubmit="saveNewProduct(event)">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" id="productName" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition" placeholder="Contoh: Cilok Keju">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select id="productCategory" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition bg-white">
                            <option value="">Pilih Kategori</option>
                            <option value="Cilok">Cilok</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Modal (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" id="costPrice" min="0" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition" placeholder="Contoh: 3500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" id="sellingPrice" min="0" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition" placeholder="Contoh: 7000">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="productStatus" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition bg-white">
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeAddProductModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 rounded-xl shadow-md shadow-orange-200 transition-all">Simpan Produk</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===================== MODAL EDIT PRODUK ===================== --}}
<div id="editProductModal" class="fixed inset-0 z-50 flex items-center justify-center hidden transition-opacity bg-black/30 backdrop-blur-sm" onclick="closeEditModal(event)">
    <div class="bg-white w-full max-w-lg mx-4 rounded-2xl shadow-2xl transform transition-all max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-gray-900">Edit Produk</h3>
                <button onclick="closeEditModal()" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="editProductForm" onsubmit="updateProduct(event)">
                <input type="hidden" id="editIndex" value="">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" id="editProductName" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select id="editProductCategory" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition bg-white">
                            <option value="Cilok">Cilok</option>
                            <option value="Minuman">Minuman</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Modal (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" id="editCostPrice" min="0" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga Jual (Rp) <span class="text-red-500">*</span></label>
                        <input type="number" id="editSellingPrice" min="0" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="editProductStatus" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-orange-200 focus:border-orange-400 outline-none transition bg-white">
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 rounded-xl shadow-md shadow-orange-200 transition-all">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ===================== MODAL KONFIRMASI HAPUS ===================== --}}
<div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center hidden transition-opacity bg-black/30 backdrop-blur-sm" onclick="closeDeleteModal(event)">
    <div class="bg-white w-full max-w-md mx-4 rounded-2xl shadow-2xl transform transition-all" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-900">Konfirmasi Hapus</h3>
                <button onclick="closeDeleteModal()" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus produk <span id="deleteProductName" class="font-semibold text-gray-900"></span>? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex gap-3 justify-end">
                <button type="button" onclick="closeDeleteModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors">Batal</button>
                <button id="confirmDeleteBtn" class="px-5 py-2.5 text-sm font-medium text-white bg-red-500 hover:bg-red-600 rounded-xl shadow-md shadow-red-200 transition-all">Hapus</button>
            </div>
        </div>
    </div>
</div>

{{-- ===================== SCRIPT ===================== --}}
<script>
    // Data produk dari PHP ke JavaScript (tambahkan ID untuk referensi)
    const productsData = @json($products);

    // --- Modal Tambah ---
    function openAddProductModal() {
        document.getElementById('addProductModal').classList.remove('hidden');
        document.getElementById('addProductForm').reset();
    }

    function closeAddProductModal(event) {
        if (!event || event.target === document.getElementById('addProductModal')) {
            document.getElementById('addProductModal').classList.add('hidden');
        }
    }

    function saveNewProduct(event) {
        event.preventDefault();
        const name = document.getElementById('productName').value;
        const category = document.getElementById('productCategory').value;
        const cost = parseInt(document.getElementById('costPrice').value);
        const sell = parseInt(document.getElementById('sellingPrice').value);
        const status = document.getElementById('productStatus').value;

        if (sell < cost) {
            alert('Harga jual tidak boleh kurang dari harga modal!');
            return;
        }

        alert(`Produk "${name}" berhasil ditambahkan!\nKategori: ${category}\nModal: Rp ${cost.toLocaleString()}\nJual: Rp ${sell.toLocaleString()}\nStatus: ${status}`);
        closeAddProductModal();
        // location.reload();
    }

    // --- Modal Edit ---
    function openEditModal(index) {
        const product = productsData[index];
        document.getElementById('editIndex').value = index;
        document.getElementById('editProductName').value = product.name;
        document.getElementById('editProductCategory').value = product.category;
        document.getElementById('editCostPrice').value = product.modal;
        document.getElementById('editSellingPrice').value = product.jual;
        document.getElementById('editProductStatus').value = product.status;
        document.getElementById('editProductModal').classList.remove('hidden');
    }

    function closeEditModal(event) {
        if (!event || event.target === document.getElementById('editProductModal')) {
            document.getElementById('editProductModal').classList.add('hidden');
        }
    }

    function updateProduct(event) {
        event.preventDefault();
        const index = document.getElementById('editIndex').value;
        const product = productsData[index];
        
        const newName = document.getElementById('editProductName').value;
        const newCategory = document.getElementById('editProductCategory').value;
        const newCost = parseInt(document.getElementById('editCostPrice').value);
        const newSell = parseInt(document.getElementById('editSellingPrice').value);
        const newStatus = document.getElementById('editProductStatus').value;

        if (newSell < newCost) {
            alert('Harga jual tidak boleh kurang dari harga modal!');
            return;
        }

        // Update data (simulasi)
        product.name = newName;
        product.category = newCategory;
        product.modal = newCost;
        product.jual = newSell;
        product.status = newStatus;
        product.margin = Math.round(((newSell - newCost) / newSell) * 100);

        alert(`Produk "${newName}" berhasil diperbarui!`);
        closeEditModal();
        // location.reload(); // Uncomment untuk melihat perubahan di tabel
    }

    // --- Toggle Status (Nonaktifkan/Aktifkan) ---
    function toggleStatus(index) {
        const product = productsData[index];
        const newStatus = product.status === 'Aktif' ? 'Nonaktif' : 'Aktif';
        product.status = newStatus;
        alert(`Status produk "${product.name}" diubah menjadi ${newStatus}`);
        // location.reload();
    }

    // --- Modal Hapus ---
    let deleteIndex = null;

    function openDeleteModal(index) {
        deleteIndex = index;
        const product = productsData[index];
        document.getElementById('deleteProductName').textContent = product.name;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal(event) {
        if (!event || event.target === document.getElementById('deleteModal')) {
            document.getElementById('deleteModal').classList.add('hidden');
            deleteIndex = null;
        }
    }

    document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
        if (deleteIndex !== null) {
            const product = productsData[deleteIndex];
            alert(`Produk "${product.name}" telah dihapus.`);
            // Di sini bisa hapus dari array dan refresh tabel, atau kirim AJAX
            productsData.splice(deleteIndex, 1);
            closeDeleteModal();
            // location.reload();
        }
    });

    // Tutup modal dengan ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAddProductModal();
            closeEditModal();
            closeDeleteModal();
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