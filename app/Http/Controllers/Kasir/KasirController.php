<?php

namespace App\Http\Controllers\Kasir;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\Inventory;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class KasirController extends Controller
{
    public function index()
    {
        $products = Produk::with(['kategori', 'resep.item'])
            ->where('status', true)
            ->orderBy('nama_produk')
            ->get();

        $stokTerakhir = Inventory::query()
            ->select('id_item', DB::raw('MAX(id_inventory) as max_id'))
            ->whereNotNull('id_item')
            ->groupBy('id_item');

        $stokMap = Inventory::query()
            ->joinSub($stokTerakhir, 'terakhir', function ($join) {
                $join->on('inventory.id_inventory', '=', 'terakhir.max_id');
            })
            ->select([
                'inventory.id_item as id_item',
                'inventory.stok_sesudah as stok_sesudah',
            ])
            ->get()
            ->pluck('stok_sesudah', 'id_item')
            ->map(fn ($stok) => (int) $stok)
            ->toArray();

        $menu = $products->map(function ($product) use ($stokMap) {
            $resep = $product->resep;
            $maxAvailable = 0;

            if ($resep->count() > 0) {
                $limits = [];

                foreach ($resep as $row) {
                    $stokItem = (int) ($stokMap[$row->id_item] ?? 0);
                    $qtyResep = max((int) $row->qty, 1);
                    $limits[] = intdiv($stokItem, $qtyResep);
                }

                $maxAvailable = count($limits) > 0 ? min($limits) : 0;
            }

            return [
                'id'            => $product->id_produk,
                'category'      => $product->kategori->nama_kategori ?? 'Tanpa Kategori',
                'name'          => $product->nama_produk,
                'price'         => (int) $product->harga,
                'description'   => $product->deskripsi,
                'available_qty' => max($maxAvailable, 0),
                'available'     => $maxAvailable > 0,
            ];
        })->values();

        return view('kasir.kasir', compact('menu'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'metode_pembayaran' => 'required|in:tunai,qris',
            'bayar'             => 'nullable|numeric|min:0',
            'items'             => 'required|array|min:1',
            'items.*.id_produk' => 'required|exists:produk,id_produk',
            'items.*.qty'       => 'required|integer|min:1',
        ], [
            'items.required' => 'Pesanan tidak boleh kosong.',
            'items.min'      => 'Pesanan tidak boleh kosong.',
        ]);

        $produkIds = collect($validated['items'])->pluck('id_produk')->unique()->values();

        $products = Produk::with(['resep'])
            ->whereIn('id_produk', $produkIds)
            ->where('status', true)
            ->get()
            ->keyBy('id_produk');

        if ($products->count() !== $produkIds->count()) {
            throw ValidationException::withMessages([
                'items' => 'Ada menu yang tidak aktif atau tidak ditemukan.',
            ]);
        }

        $grandTotal = 0;
        $detailRows = [];
        $pemakaianItem = [];

        foreach ($validated['items'] as $item) {
            $produk = $products[$item['id_produk']];
            $qtyOrder = (int) $item['qty'];
            $harga = (int) $produk->harga;
            $subtotal = $qtyOrder * $harga;
            $grandTotal += $subtotal;

            if ($produk->resep->isEmpty()) {
                throw ValidationException::withMessages([
                    'items' => 'Menu ' . $produk->nama_produk . ' belum memiliki resep.',
                ]);
            }

            $detailRows[] = [
                'id_produk' => $produk->id_produk,
                'qty'       => $qtyOrder,
                'harga'     => $harga,
                'subtotal'  => $subtotal,
            ];

            foreach ($produk->resep as $resep) {
                $idItem = (int) $resep->id_item;
                $pemakaianItem[$idItem] = ($pemakaianItem[$idItem] ?? 0) + ((int) $resep->qty * $qtyOrder);
            }
        }

        $bayar = $validated['metode_pembayaran'] === 'tunai'
            ? (int) ($validated['bayar'] ?? 0)
            : $grandTotal;

        if ($validated['metode_pembayaran'] === 'tunai' && $bayar < $grandTotal) {
            throw ValidationException::withMessages([
                'bayar' => 'Uang tunai tidak cukup.',
            ]);
        }

        $kembalian = max($bayar - $grandTotal, 0);

        $transaksi = DB::transaction(function () use ($pemakaianItem, $detailRows, $validated, $grandTotal, $bayar, $kembalian) {
            $stokAkhir = [];
            $satuanItem = [];

            foreach ($pemakaianItem as $idItem => $qtyKeluar) {
                $lastInventory = Inventory::where('id_item', $idItem)
                    ->orderByDesc('id_inventory')
                    ->lockForUpdate()
                    ->first();

                $stokSebelum = $lastInventory ? (int) $lastInventory->stok_sesudah : 0;
                if ($stokSebelum < $qtyKeluar) {
                    throw ValidationException::withMessages([
                        'items' => 'Stok item inventori tidak cukup untuk memproses transaksi.',
                    ]);
                }

                $stokAkhir[$idItem] = [
                    'sebelum' => $stokSebelum,
                    'sesudah' => $stokSebelum - $qtyKeluar,
                    'keluar'  => $qtyKeluar,
                ];
                $satuanItem[$idItem] = $lastInventory->satuan ?? 'pcs';
            }

            $transaksi = Transaksi::create([
                'kode_transaksi'    => 'TRX-' . now()->format('YmdHis') . '-' . random_int(100, 999),
                'id_user'           => auth()->id(),
                'tanggal_transaksi' => now(),
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'total'             => $grandTotal,
                'bayar'             => $bayar,
                'kembalian'         => $kembalian,
                'status'            => 'selesai',
            ]);

            foreach ($detailRows as $detail) {
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_produk'    => $detail['id_produk'],
                    'qty'          => $detail['qty'],
                    'harga'        => $detail['harga'],
                    'subtotal'     => $detail['subtotal'],
                    'catatan'      => null,
                ]);
            }

            foreach ($stokAkhir as $idItem => $data) {
                Inventory::create([
                    'id_item'       => $idItem,
                    'tipe'          => 'keluar',
                    'jumlah'        => $data['keluar'],
                    'satuan'        => $satuanItem[$idItem],
                    'stok_sebelum'  => $data['sebelum'],
                    'stok_sesudah'  => $data['sesudah'],
                    'tanggal'       => now()->toDateString(),
                    'keterangan'    => 'Pemakaian untuk transaksi kasir',
                ]);
            }

            return $transaksi;
        });

        return response()->json([
            'message'        => 'Transaksi berhasil diproses.',
            'kode_transaksi' => $transaksi->kode_transaksi,
            'total'          => $transaksi->total,
            'bayar'          => $transaksi->bayar,
            'kembalian'      => $transaksi->kembalian,
        ]);
    }
}
