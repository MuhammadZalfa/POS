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
        'id_item',
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
        'jumlah' => 'integer',
        'stok_sebelum' => 'integer',
        'stok_sesudah' => 'integer',
    ];

    public function item(): BelongsTo
    {
        return $this->belongsTo(ItemInventori::class, 'id_item', 'id_item');
    }
}
