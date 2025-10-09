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
        Schema::create('sell_transactions', function (Blueprint $table) {
            $table->id(); 
            $table->string('nama_kasir', 50);
            $table->text('email_pembeli');
            $table->timestamp('tanggal_transaksi')->useCurrent();
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sell_transactions');
    }
};
