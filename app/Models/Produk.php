<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    public $timestamps = false;

    protected $fillable = [
        'id_kategori',
        'nama_produk',
        'deskripsi',
        'harga',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'harga' => 'decimal:2',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function detailTransaksi(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'id_produk', 'id_produk');
    }

    public function resep(): HasMany
    {
        return $this->hasMany(ResepProduk::class, 'id_produk', 'id_produk');
    }
}
