<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;

class TransaksiController extends Controller
{
    /**
     * Menampilkan semua transaksi
     */
    public function index()
    {
        // Ambil semua transaksi + produk terkait (dari query builder di model Transaksi)
        $transaksis = Transaksi::getSellTransaction()->get();

        return view('transaksi.index', compact('transaksis'));
    }

    /**
     * Menampilkan detail dari satu transaksi
     */
    public function show($id)
    {
        // Ambil transaksi berdasarkan ID beserta detail-nya
        $transaksi = Transaksi::with('details')->findOrFail($id);

        return view('transaksi.show', compact('transaksi'));
    }
}
