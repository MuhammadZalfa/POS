<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id('id_detail_transaksi');
            $table->unsignedBigInteger('id_transaksi');
            $table->unsignedBigInteger('id_produk');
            $table->integer('qty');
            $table->decimal('harga', 14, 2)->default(0);
            $table->decimal('subtotal', 14, 2)->default(0);
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi')->cascadeOnDelete();
            $table->foreign('id_produk')->references('id_produk')->on('produk')->restrictOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
