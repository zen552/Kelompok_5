<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksiPenjualan extends Model
{
    use HasFactory;

    /**
     * Menentukan nama tabel secara eksplisit.
     */
    protected $table = 'detail_transaksi_penjualan';

    /**
     * Menonaktifkan timestamps (created_at, updated_at) untuk model ini
     * karena tidak didefinisikan di migrasi.
     */
    public $timestamps = false;

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'id_transaksi_penjualan',
        'id_product',
        'jumlah_pembelian',
    ];

    /**
     * Mendefinisikan relasi "milik" (belongs to) ke TransaksiPenjualan.
     * Setiap detail pasti milik satu transaksi.
     */
    public function transaksi()
    {
        return $this->belongsTo(TransaksiPenjualan::class, 'id_transaksi_penjualan');
    }

    /**
     * Mendefinisikan relasi ke model Product.
     * Setiap detail terkait dengan satu produk.
     */
    public function product()
    {
        // Pastikan Anda sudah punya model Product
        return $this->belongsTo(Product::class, 'id_product');
    }
}