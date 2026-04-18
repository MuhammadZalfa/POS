<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\Produk;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $products = Produk::with([
            'kategori',
            'inventory' => function ($query) {
                $query->orderByDesc('id_inventory');
            }
        ])->orderByDesc('id_produk')->get();

        $inventoryRows = $products->map(function ($product) {
            $lastInventory = $product->inventory->first();

            $stok = $lastInventory ? (int) $lastInventory->stok_sesudah : 0;
            $satuan = $lastInventory->satuan ?? '-';
            $min = 5;

            if ($stok <= 0) {
                $status = 'Habis';
            } elseif ($stok <= $min) {
                $status = 'Stok Rendah';
            } else {
                $status = 'Aman';
            }

            return [
                'id_produk'   => $product->id_produk,
                'nama_produk' => $product->nama_produk,
                'kategori'    => $product->kategori->nama_kategori ?? '-',
                'stok'        => $stok,
                'min'         => $min,
                'satuan'      => $satuan,
                'status'      => $status,
            ];
        });

        return view('admin.inventori', [
            'products'      => $products,
            'inventoryRows' => $inventoryRows,
            'totalProduk'   => $inventoryRows->count(),
            'stokMenipis'   => $inventoryRows->where('status', 'Stok Rendah')->count(),
            'stokHabis'     => $inventoryRows->where('status', 'Habis')->count(),
        ]);
    }

    public function storeStock(Request $request)
    {
        $validated = $request->validate([
            'id_produk'   => 'required|exists:produk,id_produk',
            'jumlah'      => 'required|integer|min:1',
            'satuan'      => 'required|string|max:30',
            'keterangan'  => 'nullable|string|max:255',
        ], [
            'id_produk.required' => 'Produk wajib dipilih.',
            'id_produk.exists'   => 'Produk tidak valid.',
            'jumlah.required'    => 'Jumlah stok wajib diisi.',
            'jumlah.integer'     => 'Jumlah stok harus angka bulat.',
            'jumlah.min'         => 'Jumlah stok minimal 1.',
            'satuan.required'    => 'Satuan wajib dipilih.',
        ]);

        $lastInventory = Inventory::where('id_produk', $validated['id_produk'])
            ->orderByDesc('id_inventory')
            ->first();

        $stokSebelum = $lastInventory ? (int) $lastInventory->stok_sesudah : 0;
        $stokSesudah = $stokSebelum + (int) $validated['jumlah'];

        Inventory::create([
            'id_produk'     => $validated['id_produk'],
            'tipe'          => 'masuk',
            'jumlah'        => (int) $validated['jumlah'],
            'satuan'        => $validated['satuan'],
            'stok_sebelum'  => $stokSebelum,
            'stok_sesudah'  => $stokSesudah,
            'tanggal'       => now()->toDateString(),
            'keterangan'    => $validated['keterangan'] ?: 'Tambah stok',
        ]);

        return redirect()
            ->route('admin.inventory')
            ->with('success', 'Stok berhasil ditambahkan.');
    }

    public function setStock(Request $request)
    {
        $validated = $request->validate([
            'id_produk'   => 'required|exists:produk,id_produk',
            'stok_baru'   => 'required|integer|min:0',
            'satuan'      => 'required|string|max:30',
            'keterangan'  => 'nullable|string|max:255',
        ], [
            'id_produk.required' => 'Produk wajib dipilih.',
            'stok_baru.required' => 'Stok baru wajib diisi.',
            'stok_baru.integer'  => 'Stok baru harus angka bulat.',
            'stok_baru.min'      => 'Stok baru tidak boleh negatif.',
            'satuan.required'    => 'Satuan wajib dipilih.',
        ]);

        $lastInventory = Inventory::where('id_produk', $validated['id_produk'])
            ->orderByDesc('id_inventory')
            ->first();

        $stokSebelum = $lastInventory ? (int) $lastInventory->stok_sesudah : 0;
        $stokBaru = (int) $validated['stok_baru'];

        if ($stokBaru === $stokSebelum && ($lastInventory->satuan ?? null) === $validated['satuan']) {
            return redirect()
                ->route('admin.inventory')
                ->with('info', 'Tidak ada perubahan stok.');
        }

        $selisih = abs($stokBaru - $stokSebelum);
        $tipe = $stokBaru > $stokSebelum ? 'masuk' : 'keluar';

        Inventory::create([
            'id_produk'     => $validated['id_produk'],
            'tipe'          => $tipe,
            'jumlah'        => $selisih,
            'satuan'        => $validated['satuan'],
            'stok_sebelum'  => $stokSebelum,
            'stok_sesudah'  => $stokBaru,
            'tanggal'       => now()->toDateString(),
            'keterangan'    => $validated['keterangan'] ?: 'Penyesuaian stok',
        ]);

        return redirect()
            ->route('admin.inventory')
            ->with('success', 'Stok berhasil diperbarui.');
    }
}