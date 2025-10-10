<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaksi extends Model
{
    protected $table = 'sell_transactions';

    protected $fillable = [
        'nama_kasir',
        'tanggal_transaksi',
        'total_harga',
    ];

 public static function getSellTransaction()
{
    return DB::table('sell_transactions as transaksi')
        ->select(
            'transaksi.*',
            DB::raw('GROUP_CONCAT(products.title SEPARATOR ", ") as product_titles'),
            DB::raw('SUM(dt.jumlah_pembelian) as total_quantity'),
            DB::raw('SUM(dt.jumlah_pembelian * products.price) as total_harga'),
            DB::raw('MIN(products.price) as min_price'),
            'transaksi.created_at as transaksi_created'
        )
        ->join('sell_transactions_detail as dt', 'transaksi.id', '=', 'dt.id_sell_transactions') // ✅ pakai 's'
        ->join('products', 'products.id', '=', 'dt.id_products')
        ->groupBy('transaksi.id')
        ->orderByDesc('transaksi.created_at');
}
    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi');
    }
}
