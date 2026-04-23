<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail_transaksi';

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'qty',
        'harga',
        'subtotal',
        'catatan',
    ];

    protected $casts = [
        'qty' => 'integer',
        'harga' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}
