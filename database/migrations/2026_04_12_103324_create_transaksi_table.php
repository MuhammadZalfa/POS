<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id('id_transaksi');

            $table->unsignedBigInteger('id_user');
            $table->date('tanggal');
            $table->decimal('total_harga', 15, 2);
            $table->decimal('bayar', 15, 2);
            $table->decimal('kembalian', 15, 2);
            $table->string('metode_pembayaran');
            $table->string('status'); // selesai / pending

            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};