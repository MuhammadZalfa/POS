<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResepProduk extends Model
{
    protected $table = 'resep_produk';
    protected $primaryKey = 'id_resep';

    protected $fillable = [
        'id_produk',
        'id_item',
        'qty',
        'satuan',
    ];

    protected $casts = [
        'qty' => 'integer',
    ];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(ItemInventori::class, 'id_item', 'id_item');
    }
}
