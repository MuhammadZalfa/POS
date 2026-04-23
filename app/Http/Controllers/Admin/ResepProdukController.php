<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItemInventori;
use App\Models\Produk;
use App\Models\ResepProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ResepProdukController extends Controller
{
    public function index(Request $request)
    {
        $products = Produk::with(['kategori', 'resep.item'])
            ->orderBy('nama_produk')
            ->get();

        $items = ItemInventori::where('status', true)
            ->orderBy('nama_item')
            ->get();

        $selectedProduk = null;
        if ($request->filled('produk')) {
            $selectedProduk = $products->firstWhere('id_produk', (int) $request->produk);
        }
        if (!$selectedProduk) {
            $selectedProduk = $products->first();
        }

        $recipeMap = [];
        if ($selectedProduk) {
            $recipeMap = $selectedProduk->resep->keyBy('id_item')->map(function ($row) {
                return [
                    'qty' => (int) $row->qty,
                    'satuan' => $row->satuan,
                ];
            })->toArray();
        }

        return view('admin.resep-produk', compact('products', 'items', 'selectedProduk', 'recipeMap'));
    }

    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'items'           => 'nullable|array',
            'items.*.aktif'   => 'nullable|in:1',
            'items.*.qty'     => 'nullable|integer|min:1',
            'items.*.satuan'  => 'nullable|string|max:30',
        ]);

        DB::transaction(function () use ($validated, $produk) {
            ResepProduk::where('id_produk', $produk->id_produk)->delete();

            foreach (($validated['items'] ?? []) as $idItem => $payload) {
                $aktif = isset($payload['aktif']) && (string) $payload['aktif'] === '1';
                $qty = (int) ($payload['qty'] ?? 0);
                $satuan = trim((string) ($payload['satuan'] ?? ''));

                if (!$aktif) {
                    continue;
                }

                if ($qty <= 0 || $satuan === '') {
                    continue;
                }

                ResepProduk::create([
                    'id_produk' => $produk->id_produk,
                    'id_item'   => (int) $idItem,
                    'qty'       => $qty,
                    'satuan'    => $satuan,
                ]);
            }
        });

        return redirect()
            ->route('admin.recipes', ['produk' => $produk->id_produk])
            ->with('success', 'Resep produk berhasil disimpan.');
    }
}
