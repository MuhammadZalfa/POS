<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock', function (Blueprint $table) {
            $table->unsignedBigInteger('id_produk')->primary();
            $table->integer('stok_sekarang')->default(0);

            $table->foreign('id_produk')
                ->references('id_produk')
                ->on('produk')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock');
    }
};