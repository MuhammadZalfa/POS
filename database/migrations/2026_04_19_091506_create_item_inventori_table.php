<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('item_inventori', function (Blueprint $table) {
            $table->id('id_item');
            $table->string('nama_item')->unique();
            $table->string('jenis')->nullable();
            $table->string('satuan_default', 30)->default('pcs');
            $table->integer('stok_minimal')->default(5);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('item_inventori');
    }
};
