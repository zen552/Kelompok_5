<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiPenjualan extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel secara eksplisit.
     */
    protected $table = 'transaksi_penjualan';

    /**
     * Kolom yang boleh diisi secara massal (mass assignment).
     */
    protected $fillable = [
        'nama_kasir',
        'email_pembeli',
        'tanggal_transaksi',
    ];

    /**
     * Mendefinisikan relasi "satu ke banyak" (one-to-many) ke DetailTransaksiPenjualan.
     * Satu transaksi bisa memiliki banyak detail produk.
     */
    public function details()
    {
        return $this->hasMany(DetailTransaksiPenjualan::class, 'id_transaksi_penjualan');
    }
}