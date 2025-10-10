<?php
// database/seeders/ProductCategorySeeder.php - FINAL VERSION

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductCategory; 

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Bersihkan tabel yang benar sebelum seeding
        ProductCategory::truncate(); 

        $categories = [
            // Pastikan keys adalah product_category_name dan description
            [ 'product_category_name' => 'Makanan Hewan', 'description' => 'Semua jenis makanan kering, basah, dan snack untuk hewan peliharaan.', 'created_at' => now(), 'updated_at' => now(), ],
            [ 'product_category_name' => 'Mainan Hewan', 'description' => 'Berbagai macam mainan untuk anjing, kucing, burung, dan lainnya.', 'created_at' => now(), 'updated_at' => now(), ],
            [ 'product_category_name' => 'Aksesoris & Grooming', 'description' => 'Kalung, tali, sikat, sampo, dan perlengkapan perawatan.', 'created_at' => now(), 'updated_at' => now(), ],
            [ 'product_category_name' => 'Kandang & Tempat Tidur', 'description' => 'Kandang, carrier, tempat tidur, dan rumah-rumahan hewan.', 'created_at' => now(), 'updated_at' => now(), ],
            [ 'product_category_name' => 'Perlengkapan Kebersihan', 'description' => 'Kotak pasir, serbuk kayu, dan pembersih kandang.', 'created_at' => now(), 'updated_at' => now(), ],
        ];

        // Masukkan data menggunakan Model
        foreach ($categories as $category) {
             ProductCategory::create($category);
        }
    }
}