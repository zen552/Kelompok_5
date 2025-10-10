<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// Pastikan NAMA KELAS ini sesuai dengan nama file migrasi Anda
class CreateProductCategoriesTable extends Migration 
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id(); // id (int, autoincrement, primary key)
            $table->string('name', 100)->unique(); // Nama Kategori
            $table->text('description')->nullable(); // Deskripsi (opsional)
            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
}