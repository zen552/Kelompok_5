<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    // Fillable properties for mass assignment
    protected $fillable = [
        'nama_kasir', // Add nama_kasir here
        // Add other fillable properties if any
    ];

    public function get_transaksi()
{
    return $this->select(
        'transaksi.*',
        DB::raw('GROUP_CONCAT(products.title SEPARATOR ", ") as product_titles'), // Concatenate product titles
        DB::raw('SUM(dt.jumlah) as total_quantity'), // Total quantity of all products in the transaction
        DB::raw('SUM(dt.jumlah * products.price) as total_harga'), // Total price for the transaction
        DB::raw('MIN(products.price) as min_price'),
        'transaksi.created_at as transaksi_created'
    )
    ->join('detail_transaksi as dt', 'transaksi.id', '=', 'dt.id_transaksi')
    ->join('products', 'products.id', '=', 'dt.id_product')
    ->groupBy('transaksi.id') // Group by transaction ID
    ->latest('transaksi.created_at');
}


    public function details()
    {
        return $this->hasMany('App\Models\DetailTransaksi', 'id_transaksi'); // Make sure to point to the correct DetailTransaksi model
    }
}
