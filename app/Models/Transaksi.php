<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'kode_transaksi',
        'id_user',
        'tanggal_transaksi',
        'metode_pembayaran',
        'total',
        'bayar',
        'kembalian',
        'status',
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'total' => 'decimal:2',
        'bayar' => 'decimal:2',
        'kembalian' => 'decimal:2',
    ];

    public function details(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
