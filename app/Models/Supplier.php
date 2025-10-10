<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    // Sesuaikan dengan nama tabel di database
    protected $table = 'supplier';

    // Kolom yang boleh diisi melalui mass assignment
    protected $fillable = [
        'supplier_name',
        'pic_supplier',
    ];
}
