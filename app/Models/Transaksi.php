<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'sell_transactions';

    protected $fillable = [
        'nama_kasir',
    ];

    public function get_transaksi()
    {
        return $this->select(
                'sell_transactions.id',
                'sell_transactions.nama_kasir',
                'sell_transactions.created_at', // Cukup sekali saja
                DB::raw('GROUP_CONCAT(products.title SEPARATOR ", ") as product_titles'),
                DB::raw('SUM(dt.jumlah_pembelian) as total_quantity'),
                DB::raw('SUM(dt.jumlah_pembelian * products.price) as total_harga')
            )
            // Pastikan nama tabel detail & foreign key ini sudah benar sesuai database Anda
            ->join('sell_transactions_detail as dt', 'sell_transactions.id', '=', 'dt.id_sell_transactions')
            ->join('products', 'products.id', '=', 'dt.id_products')
            ->groupBy(
                'sell_transactions.id',
                'sell_transactions.nama_kasir',
                'sell_transactions.created_at'
            )
            ->latest('sell_transactions.created_at');
}

    public function details()
    {
        return $this->hasMany(DetailTransaksi::class, 'id_sell_transactions');
    }
}
