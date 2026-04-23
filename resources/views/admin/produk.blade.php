@extends('layouts.app')

@section('title', 'Kelola Menu')
@section('header-title', '')
@section('header-subtitle', '')

@section('content')
<div class="bg-gradient-to-br from-gray-50 to-orange-50/30 -m-4 md:-m-6 p-4 md:p-6 min-h-screen">
    <div class="max-w-7xl mx-auto">
        @if(session('success'))
            <div class="mb-4 rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 rounded-xl bg-red-50 border border-red-200 text-red-700 px-4 py-3">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 tracking-tight">
                    Kelola <span class="text-orange-600">Menu & Harga</span>
                </h1>
                <p class="text-base md:text-lg text-gray-600 mt-2">
                    Halaman ini hanya untuk menu jual. Stok tidak diatur di sini.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.recipes') }}"
                   class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-white border border-gray-200 text-gray-700 font-semibold hover:border-orange-300 hover:text-orange-600 transition">
                    Kelola Resep
                </a>
                <button onclick="openAddProductModal()"
                        class="inline-flex items-center gap-3 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white font-semibold px-6 py-3 rounded-xl shadow-lg shadow-orange-500/20 transition-all">
                    Tambah Menu
                </button>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/80">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Menu</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga Jual</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Resep</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($products as $product)
                            <tr class="hover:bg-orange-50/30 transition-colors">
                                <td class="px-6 py-4 align-top">
                                    <div class="font-medium text-gray-900">{{ $product->nama_produk }}</div>
                                    @if($product->deskripsi)
                                        <div class="text-sm text-gray-500 mt-1">{{ $product->deskripsi }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 align-top whitespace-nowrap">
                                    <span class="inline-flex px-2.5 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700">
                                        {{ $product->kategori->nama_kategori ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 align-top whitespace-nowrap text-sm font-semibold text-gray-900">
                                    Rp {{ number_format((float) $product->harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 align-top min-w-[260px]">
                                    @if($product->resep->count())
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($product->resep as $resep)
                                                <span class="inline-flex px-2.5 py-1 text-xs rounded-full bg-orange-50 text-orange-700 border border-orange-100">
                                                    {{ $resep->item->nama_item ?? 'Item terhapus' }}: {{ (int) $resep->qty }} {{ $resep->satuan }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-sm text-red-500 font-medium">Belum ada resep</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 align-top whitespace-nowrap">
                                    @if($product->status)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 align-top whitespace-nowrap text-center">
                                    <div class="flex flex-wrap items-center justify-center gap-2">
                                        <a href="{{ route('admin.recipes', ['produk' => $product->id_produk]) }}"
                                           class="px-3 py-2 rounded-lg border border-orange-200 bg-orange-50 text-orange-700 text-xs font-semibold hover:bg-orange-100 transition">
                                            Atur Resep
                                        </a>
                                        <button
                                            type="button"
                                            data-update-url="{{ route('admin.produk.update', $product) }}"
                                            data-nama="{{ $product->nama_produk }}"
                                            data-id_kategori="{{ $product->id_kategori }}"
                                            data-harga="{{ (float) $product->harga }}"
                                            data-deskripsi="{{ $product->deskripsi }}"
                                            data-status="{{ $product->status ? 1 : 0 }}"
                                            onclick="openEditModal(this)"
                                            class="px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-700 text-xs font-semibold hover:border-orange-300 hover:text-orange-600 transition">
                                            Edit
                                        </button>

                                        <form method="POST" action="{{ route('admin.produk.toggle', $product) }}" onsubmit="return confirm('Ubah status menu {{ $product->nama_produk }}?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-3 py-2 rounded-lg border border-gray-200 bg-white text-gray-700 text-xs font-semibold hover:border-orange-300 hover:text-orange-600 transition">
                                                Toggle
                                            </button>
                                        </form>

                                        <form method="POST" action="{{ route('admin.produk.destroy', $product) }}" onsubmit="return confirm('Hapus menu {{ $product->nama_produk }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-2 rounded-lg border border-red-200 bg-red-50 text-red-600 text-xs font-semibold hover:bg-red-100 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada menu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="addProductModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/30 backdrop-blur-sm" onclick="closeAddProductModal(event)">
    <div class="bg-white w-full max-w-lg mx-4 rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-gray-900">Tambah Menu</h3>
                <button onclick="closeAddProductModal()" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">✕</button>
            </div>

            <form method="POST" action="{{ route('admin.produk.store') }}">
                @csrf

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Menu</label>
                        <input type="text" name="nama_produk" value="{{ old('nama_produk') }}" required class="w-full px-4 py-3 border border-gray-200 rounded-xl" placeholder="Contoh: Cilok Kriwil Yamin 1 Porsi">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select name="id_kategori" required class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id_kategori }}" {{ old('id_kategori') == $category->id_kategori ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                        <input type="number" name="harga" min="0" value="{{ old('harga') }}" required class="w-full px-4 py-3 border border-gray-200 rounded-xl" placeholder="Contoh: 10000">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea name="deskripsi" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl" placeholder="Deskripsi singkat">{{ old('deskripsi') }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white">
                            <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeAddProductModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-xl">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div id="editProductModal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/30 backdrop-blur-sm" onclick="closeEditModal(event)">
    <div class="bg-white w-full max-w-lg mx-4 rounded-2xl shadow-2xl max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
        <div class="p-6">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-xl font-bold text-gray-900">Edit Menu</h3>
                <button type="button" onclick="closeEditModal()" class="p-1 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-colors">✕</button>
            </div>

            <form id="editProductForm" method="POST" action="">
                @csrf
                @method('PUT')

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Menu</label>
                        <input type="text" id="editProductName" name="nama_produk" required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                        <select id="editProductCategory" name="id_kategori" required class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id_kategori }}">{{ $category->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                        <input type="number" id="editSellingPrice" name="harga" min="0" required class="w-full px-4 py-3 border border-gray-200 rounded-xl">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                        <textarea id="editDeskripsi" name="deskripsi" rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl"></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="editProductStatus" name="status" class="w-full px-4 py-3 border border-gray-200 rounded-xl bg-white">
                            <option value="1">Aktif</option>
                            <option value="0">Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="flex gap-3 justify-end mt-6 pt-4 border-t border-gray-100">
                    <button type="button" onclick="closeEditModal()" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl">Batal</button>
                    <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-orange-600 hover:bg-orange-700 rounded-xl">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openAddProductModal() {
        document.getElementById('addProductModal').classList.remove('hidden');
    }

    function closeAddProductModal(event) {
        const modal = document.getElementById('addProductModal');
        if (!event || event.target === modal) {
            modal.classList.add('hidden');
        }
    }

    function openEditModal(button) {
        document.getElementById('editProductForm').action = button.dataset.updateUrl;
        document.getElementById('editProductName').value = button.dataset.nama;
        document.getElementById('editProductCategory').value = button.dataset.id_kategori;
        document.getElementById('editSellingPrice').value = button.dataset.harga;
        document.getElementById('editDeskripsi').value = button.dataset.deskripsi ?? '';
        document.getElementById('editProductStatus').value = button.dataset.status;
        document.getElementById('editProductModal').classList.remove('hidden');
    }

    function closeEditModal(event) {
        const modal = document.getElementById('editProductModal');
        if (!event || event.target === modal) {
            modal.classList.add('hidden');
        }
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAddProductModal();
            closeEditModal();
        }
    });
</script>
@endsection
