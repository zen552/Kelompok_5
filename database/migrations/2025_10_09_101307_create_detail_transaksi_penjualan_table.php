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
        Schema::create('detail_transaksi_penjualan', function (Blueprint $table) {
            $table->id(); // int, auto-increment, primary key
            
            // Kolom untuk Foreign Key
            $table->unsignedBigInteger('id_transaksi_penjualan');
            $table->unsignedBigInteger('id_product');

            $table->integer('jumlah_pembelian');

            // Mendefinisikan Foreign Key Constraint
            $table->foreign('id_transaksi_penjualan')
                  ->references('id')
                  ->on('transaksi_penjualan')
                  ->onDelete('cascade'); // Jika transaksi induk dihapus, detail ikut terhapus

            $table->foreign('id_product')
                  ->references('id')
                  ->on('products') // Asumsi nama tabel produk adalah 'products'
                  ->onDelete('restrict'); // Mencegah produk dihapus jika sudah ada di transaksi

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi_penjualan');
    }
};
