<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory', function (Blueprint $table) {
            $table->id('id_inventory');

            $table->unsignedBigInteger('id_produk');
            $table->string('tipe'); // masuk / keluar
            $table->integer('jumlah');
            $table->integer('stok_sebelum');
            $table->integer('stok_sesudah');
            $table->date('tanggal');
            $table->text('keterangan')->nullable();

            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('produk')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};