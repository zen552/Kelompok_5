<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'sell_transactions_detail';

    protected $fillable = [
        'id_transaksi',
        'id_product',
        'jumlah',
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi');
    }

    // Kalau kamu ingin juga ambil nama produk dari tabel produk:
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_product');
    }
}
