<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Inventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    public function index()
    {
        $products = Produk::with('kategori')->orderBy('id_produk', 'desc')->get();
        $categories = Kategori::orderBy('nama_kategori')->get();

        return view('admin.produk', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'harga'       => 'required|numeric|min:0',
            'deskripsi'   => 'nullable|string',
            'status'      => 'required|boolean',
            'stok_awal'   => 'required|integer|min:0',
            'satuan'      => 'required|string|max:30',
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_kategori.exists'   => 'Kategori tidak valid.',
            'harga.required'       => 'Harga wajib diisi.',
            'harga.numeric'        => 'Harga harus berupa angka.',
            'status.required'      => 'Status wajib dipilih.',
            'stok_awal.required'   => 'Stok awal wajib diisi.',
            'stok_awal.integer'    => 'Stok awal harus angka bulat.',
            'stok_awal.min'        => 'Stok awal tidak boleh negatif.',
            'satuan.required'      => 'Satuan wajib dipilih.',
        ]);

        DB::transaction(function () use ($validated) {
            $produk = Produk::create([
                'nama_produk' => $validated['nama_produk'],
                'id_kategori' => $validated['id_kategori'],
                'harga'       => $validated['harga'],
                'deskripsi'   => $validated['deskripsi'] ?? null,
                'status'      => $validated['status'],
            ]);

            Inventory::create([
                'id_produk'     => $produk->id_produk,
                'tipe'          => 'masuk',
                'jumlah'        => $validated['stok_awal'],
                'satuan'        => $validated['satuan'],
                'stok_sebelum'  => 0,
                'stok_sesudah'  => $validated['stok_awal'],
                'tanggal'       => now()->toDateString(),
                'keterangan'    => 'Stok awal produk',
            ]);
        });

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'harga'       => 'required|numeric|min:0',
            'deskripsi'   => 'nullable|string',
            'status'      => 'required|boolean',
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_kategori.exists'   => 'Kategori tidak valid.',
            'harga.required'       => 'Harga wajib diisi.',
            'harga.numeric'        => 'Harga harus berupa angka.',
            'status.required'      => 'Status wajib dipilih.',
        ]);

        $produk->update($validated);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil diperbarui.');
    }

    public function toggleStatus(Produk $produk)
    {
        $produk->update([
            'status' => !$produk->status,
        ]);

        $statusText = $produk->status ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.products')->with('success', "Produk berhasil {$statusText}.");
    }

    public function destroy(Produk $produk)
    {
        if ($produk->detailTransaksi()->exists()) {
            return redirect()->route('admin.products')
                ->with('error', 'Produk tidak bisa dihapus karena sudah dipakai dalam transaksi.');
        }

        DB::transaction(function () use ($produk) {
            $produk->inventory()->delete();
            $produk->delete();
        });

        return redirect()->route('admin.products')->with('success', 'Produk berhasil dihapus.');
    }
}