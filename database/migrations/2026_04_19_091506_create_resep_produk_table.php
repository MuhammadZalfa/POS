<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('resep_produk', function (Blueprint $table) {
            $table->id('id_resep');
            $table->unsignedBigInteger('id_produk');
            $table->unsignedBigInteger('id_item');
            $table->integer('qty');
            $table->string('satuan', 30)->default('pcs');
            $table->timestamps();

            $table->foreign('id_produk')->references('id_produk')->on('produk')->cascadeOnDelete();
            $table->foreign('id_item')->references('id_item')->on('item_inventori')->cascadeOnDelete();
            $table->unique(['id_produk', 'id_item']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resep_produk');
    }
};
