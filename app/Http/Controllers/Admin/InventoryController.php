<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inventory;
use App\Models\ItemInventori;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $items = ItemInventori::with([
            'inventory' => fn ($query) => $query->orderByDesc('id_inventory'),
        ])->orderByDesc('id_item')->get();

        $inventoryRows = $items->map(function ($item) {
            $lastInventory = $item->inventory->first();
            $stok = $lastInventory ? (int) $lastInventory->stok_sesudah : 0;
            $satuan = $lastInventory->satuan ?? $item->satuan_default;
            $min = (int) ($item->stok_minimal ?? 5);

            if ($stok <= 0) {
                $statusStok = 'Habis';
            } elseif ($stok <= $min) {
                $statusStok = 'Stok Rendah';
            } else {
                $statusStok = 'Aman';
            }

            return [
                'id_item'       => $item->id_item,
                'nama_item'     => $item->nama_item,
                'jenis'         => $item->jenis ?: '-',
                'stok'          => $stok,
                'satuan'        => $satuan,
                'stok_minimal'  => $min,
                'status_stok'   => $statusStok,
                'status_item'   => $item->status,
                'last_note'     => $lastInventory->keterangan ?? '-',
            ];
        });

        return view('admin.inventori', [
            'items'         => $items,
            'inventoryRows' => $inventoryRows,
            'totalItem'     => $inventoryRows->count(),
            'stokMenipis'   => $inventoryRows->where('status_stok', 'Stok Rendah')->count(),
            'stokHabis'     => $inventoryRows->where('status_stok', 'Habis')->count(),
        ]);
    }

    public function storeItem(Request $request)
    {
        $validated = $request->validate([
            'nama_item'      => 'required|string|max:255|unique:item_inventori,nama_item',
            'jenis'          => 'nullable|string|max:100',
            'satuan_default' => 'required|string|max:30',
            'stok_minimal'   => 'required|integer|min:0',
            'status'         => 'required|boolean',
        ]);

        ItemInventori::create($validated);

        return redirect()->route('admin.inventory')->with('success', 'Item inventori berhasil ditambahkan.');
    }

    public function updateItem(Request $request, ItemInventori $item)
    {
        $validated = $request->validate([
            'nama_item'      => 'required|string|max:255|unique:item_inventori,nama_item,' . $item->id_item . ',id_item',
            'jenis'          => 'nullable|string|max:100',
            'satuan_default' => 'required|string|max:30',
            'stok_minimal'   => 'required|integer|min:0',
            'status'         => 'required|boolean',
        ]);

        $item->update($validated);

        return redirect()->route('admin.inventory')->with('success', 'Item inventori berhasil diperbarui.');
    }

    public function storeStock(Request $request)
    {
        $validated = $request->validate([
            'id_item'     => 'required|exists:item_inventori,id_item',
            'jumlah'      => 'required|integer|min:1',
            'satuan'      => 'required|string|max:30',
            'keterangan'  => 'nullable|string|max:255',
        ], [
            'id_item.required' => 'Item inventori wajib dipilih.',
            'id_item.exists'   => 'Item inventori tidak valid.',
            'jumlah.required'  => 'Jumlah stok wajib diisi.',
            'jumlah.integer'   => 'Jumlah stok harus angka bulat.',
            'jumlah.min'       => 'Jumlah stok minimal 1.',
            'satuan.required'  => 'Satuan wajib dipilih.',
        ]);

        $lastInventory = Inventory::where('id_item', $validated['id_item'])
            ->orderByDesc('id_inventory')
            ->first();

        $stokSebelum = $lastInventory ? (int) $lastInventory->stok_sesudah : 0;
        $stokSesudah = $stokSebelum + (int) $validated['jumlah'];

        Inventory::create([
            'id_item'       => $validated['id_item'],
            'tipe'          => 'masuk',
            'jumlah'        => (int) $validated['jumlah'],
            'satuan'        => $validated['satuan'],
            'stok_sebelum'  => $stokSebelum,
            'stok_sesudah'  => $stokSesudah,
            'tanggal'       => now()->toDateString(),
            'keterangan'    => $validated['keterangan'] ?: 'Tambah stok',
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Stok berhasil ditambahkan.');
    }

    public function setStock(Request $request)
    {
        $validated = $request->validate([
            'id_item'     => 'required|exists:item_inventori,id_item',
            'stok_baru'   => 'required|integer|min:0',
            'satuan'      => 'required|string|max:30',
            'keterangan'  => 'nullable|string|max:255',
        ], [
            'id_item.required'   => 'Item inventori wajib dipilih.',
            'stok_baru.required' => 'Stok baru wajib diisi.',
            'stok_baru.integer'  => 'Stok baru harus angka bulat.',
            'stok_baru.min'      => 'Stok baru tidak boleh negatif.',
            'satuan.required'    => 'Satuan wajib dipilih.',
        ]);

        $lastInventory = Inventory::where('id_item', $validated['id_item'])
            ->orderByDesc('id_inventory')
            ->first();

        $stokSebelum = $lastInventory ? (int) $lastInventory->stok_sesudah : 0;
        $stokBaru = (int) $validated['stok_baru'];

        if ($stokBaru === $stokSebelum && ($lastInventory->satuan ?? null) === $validated['satuan']) {
            return redirect()->route('admin.inventory')->with('info', 'Tidak ada perubahan stok.');
        }

        $selisih = abs($stokBaru - $stokSebelum);
        $tipe = $stokBaru >= $stokSebelum ? 'masuk' : 'keluar';

        Inventory::create([
            'id_item'       => $validated['id_item'],
            'tipe'          => $tipe,
            'jumlah'        => $selisih,
            'satuan'        => $validated['satuan'],
            'stok_sebelum'  => $stokSebelum,
            'stok_sesudah'  => $stokBaru,
            'tanggal'       => now()->toDateString(),
            'keterangan'    => $validated['keterangan'] ?: 'Penyesuaian stok',
        ]);

        return redirect()->route('admin.inventory')->with('success', 'Stok berhasil diperbarui.');
    }
}
