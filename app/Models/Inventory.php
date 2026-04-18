<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inventory extends Model
{
    protected $table = 'inventory';
    protected $primaryKey = 'id_inventory';
    public $timestamps = false;

    protected $fillable = [
        'id_produk',
        'tipe',
        'jumlah',
        'satuan',
        'stok_sebelum',
        'stok_sesudah',
        'tanggal',
        'keterangan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}