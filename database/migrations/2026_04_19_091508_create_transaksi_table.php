<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');
            $table->string('kode_transaksi')->unique();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->dateTime('tanggal_transaksi');
            $table->string('metode_pembayaran', 20);
            $table->decimal('total', 14, 2)->default(0);
            $table->decimal('bayar', 14, 2)->default(0);
            $table->decimal('kembalian', 14, 2)->default(0);
            $table->string('status', 30)->default('selesai');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
