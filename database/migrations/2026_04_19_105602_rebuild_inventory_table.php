<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::dropIfExists('inventory');

        Schema::create('inventory', function (Blueprint $table) {
            $table->increments('id_inventory');
            $table->unsignedInteger('id_item');
            $table->string('tipe', 20);
            $table->integer('jumlah');
            $table->string('satuan', 30);
            $table->integer('stok_sebelum')->default(0);
            $table->integer('stok_sesudah')->default(0);
            $table->date('tanggal');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('id_item')
                ->references('id_item')
                ->on('item_inventori')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory');
    }
};