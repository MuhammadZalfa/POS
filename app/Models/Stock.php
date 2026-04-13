<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stock extends Model
{
    protected $table = 'stock';
    protected $primaryKey = 'id_produk';
    public $incrementing = false;   // karena primary key bukan auto-increment
    public $timestamps = false;

    protected $fillable = [
        'id_produk',
        'stok_sekarang',
    ];

    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'id_produk', 'id_produk');
    }
}