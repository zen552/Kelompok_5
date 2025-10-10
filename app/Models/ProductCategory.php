<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;

     protected $table = 'category_product'; // pastikan nama tabel benar

    protected $fillable = [
        'product_category_name',
        'description',
    ];
}
