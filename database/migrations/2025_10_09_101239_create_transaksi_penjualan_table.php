<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_penjualan', function (Blueprint $table) {
            $table->id(); // int, auto-increment, primary key
            $table->string('nama_kasir', 50);
            $table->text('email_pembeli')->nullable(); // nullable() berarti boleh kosong
            $table->timestamp('tanggal_transaksi')->useCurrent(); // default ke waktu saat ini
            $table->timestamps(); // membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_penjualan');
    }
};
