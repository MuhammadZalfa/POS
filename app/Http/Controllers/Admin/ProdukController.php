<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        $products = Produk::with(['kategori', 'resep.item'])
            ->orderByDesc('id_produk')
            ->get();

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
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_kategori.exists'   => 'Kategori tidak valid.',
            'harga.required'       => 'Harga wajib diisi.',
            'harga.numeric'        => 'Harga harus berupa angka.',
            'harga.min'            => 'Harga tidak boleh negatif.',
            'status.required'      => 'Status wajib dipilih.',
        ]);

        Produk::create($validated);

        return redirect()->route('admin.products')->with('success', 'Menu berhasil ditambahkan.');
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
            'harga.min'            => 'Harga tidak boleh negatif.',
            'status.required'      => 'Status wajib dipilih.',
        ]);

        $produk->update($validated);

        return redirect()->route('admin.products')->with('success', 'Menu berhasil diperbarui.');
    }

    public function toggleStatus(Produk $produk)
    {
        $produk->update([
            'status' => !$produk->status,
        ]);

        $statusText = $produk->status ? 'diaktifkan' : 'dinonaktifkan';

        return redirect()->route('admin.products')->with('success', "Menu berhasil {$statusText}.");
    }

    public function destroy(Produk $produk)
    {
        if ($produk->detailTransaksi()->exists()) {
            return redirect()->route('admin.products')
                ->with('error', 'Menu tidak bisa dihapus karena sudah dipakai dalam transaksi.');
        }

        $produk->resep()->delete();
        $produk->delete();

        return redirect()->route('admin.products')->with('success', 'Menu berhasil dihapus.');
    }
}
