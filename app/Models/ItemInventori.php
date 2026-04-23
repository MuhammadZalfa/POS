<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ItemInventori extends Model
{
    protected $table = 'item_inventori';
    protected $primaryKey = 'id_item';

    protected $fillable = [
        'nama_item',
        'jenis',
        'satuan_default',
        'stok_minimal',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'stok_minimal' => 'integer',
    ];

    public function inventory(): HasMany
    {
        return $this->hasMany(Inventory::class, 'id_item', 'id_item');
    }

    public function resep(): HasMany
    {
        return $this->hasMany(ResepProduk::class, 'id_item', 'id_item');
    }
}
