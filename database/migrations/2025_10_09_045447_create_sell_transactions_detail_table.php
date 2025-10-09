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
        Schema::create('sell_transactions_detail', function (Blueprint $table) {
                        $table->id(); // Primary key
            $table->unsignedBigInteger('id_sell_transactions'); // FK ke transaksi_penjualan
            $table->unsignedBigInteger('id_products'); // FK ke products
            $table->integer('jumlah_pembelian'); // Jumlah barang dibeli

            // Tambahkan relasi (opsional tapi direkomendasikan)
            $table->foreign('id_sell_transactions')
                  ->references('id')
                  ->on('sell_transactions')
                  ->onDelete('cascade');

            $table->foreign('id_products')
                  ->references('id')
                  ->on('products')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_transactions_detail');
    }
};
