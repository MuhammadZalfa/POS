<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

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
        ], [
            'nama_produk.required' => 'Nama produk wajib diisi.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_kategori.exists'   => 'Kategori tidak valid.',
            'harga.required'       => 'Harga wajib diisi.',
            'harga.numeric'        => 'Harga harus berupa angka.',
            'status.required'      => 'Status wajib dipilih.',
        ]);

        Produk::create($validated);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan.');
    }
}