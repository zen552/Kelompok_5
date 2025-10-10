<?php

namespace App\Http\Controllers;

use App\Models\TransaksiPenjualan;
use App\Models\Product; // Asumsi Anda punya model Product
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Untuk database transaction

class TransaksiPenjualanController extends Controller
{
    /**
     * VIEW: Menampilkan semua transaksi.
     */
    public function index()
    {
        // Mengambil semua data transaksi beserta detailnya (Eager Loading)
        // with('details.product') -> ambil relasi 'details', dan di dalam 'details' ambil relasi 'product'
        $transaksis = TransaksiPenjualan::with('details.product')->latest()->paginate(10);
        
        // Mengirim data ke view (Anda perlu membuat file view ini)
        return view('transaksi.index', compact('transaksis'));
    }

    /**
     * CREATE (FORM): Menampilkan form untuk membuat transaksi baru.
     */
    public function create()
    {
        $products = Product::orderBy('title')->get();
        return view('transaksi.create', compact('products'));
    }

    /**
     * CREATE (ACTION): Menyimpan transaksi baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input (sudah baik)
        $request->validate([
            'nama_kasir' => 'required|string|max:50',
            'email_pembeli' => 'nullable|email',
            'products' => 'required|array|min:1',
            'products.*.id' => 'required|exists:products,id',
            'products.*.jumlah' => 'required|integer|min:1',
        ]);

        // =================================================================
        // 1. Lakukan Pengecekan Stok & Kalkulasi Total SEBELUM ke Database
        // =================================================================
        $grandTotal = 0;
        $itemsToProcess = [];

        foreach ($request->products as $productData) {
            $product = Product::find($productData['id']);

            // Jika stok tidak mencukupi, langsung gagalkan proses
            if ($product->stock < $productData['jumlah']) {
                return redirect()->back()
                    ->with('error', 'Stok untuk produk "' . $product->title . '" tidak mencukupi. Sisa stok: ' . $product->stock)
                    ->withInput();
            }

            $subtotal = $product->price * $productData['jumlah'];
            $grandTotal += $subtotal;

            // Siapkan data untuk disimpan nanti
            $itemsToProcess[] = [
                'product' => $product,
                'jumlah' => $productData['jumlah'],
                'harga_saat_transaksi' => $product->price, // Kunci harga saat ini
                'subtotal' => $subtotal,
            ];
        }

        // =================================================================
        // 2. Gunakan DB Transaction (Closure-based lebih ringkas & aman)
        // =================================================================
        try {
            DB::transaction(function () use ($request, $grandTotal, $itemsToProcess) {
                // A. Simpan data transaksi utama dengan total harga
                $transaksi = TransaksiPenjualan::create([
                    'nama_kasir' => $request->nama_kasir,
                    'email_pembeli' => $request->email_pembeli,
                    'total_harga' => $grandTotal, // Simpan total harga
                ]);

                // B. Simpan detail transaksi dan kurangi stok
                foreach ($itemsToProcess as $item) {
                    $transaksi->details()->create([
                        'id_product' => $item['product']->id,
                        'jumlah_pembelian' => $item['jumlah'],
                        'harga_saat_transaksi' => $item['harga_saat_transaksi'], // Simpan harga
                        'subtotal' => $item['subtotal'], // Simpan subtotal
                    ]);

                    // C. Kurangi stok produk dengan metode yang lebih aman
                    $item['product']->decrement('stock', $item['jumlah']);
                }
            });

            return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dibuat.');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat transaksi: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show
     * 
     * 
     */
    public function show(TransaksiPenjualan $transaksi)
    {
    // Eager load relasi untuk efisiensi
    $transaksi->load('details.product');
    return view('transaksi.show', compact('transaksi'));
    }
    
    /**
     * UPDATE (FORM): Menampilkan form untuk mengedit transaksi.
     * (Catatan: Mengedit transaksi yang sudah jadi biasanya kompleks,
     * seringkali yang diizinkan hanya update status, bukan item.
     * Contoh ini adalah simplified update)
     */
    public function edit(TransaksiPenjualan $transaksi)
    {
        $products = Product::orderBy('title')->get();
        // Load relasi detail untuk digunakan di form
        $transaksi->load('details');
        
        return view('transaksi.edit', compact('transaksi', 'products'));
    }

    /**
     * UPDATE (ACTION): Memperbarui data transaksi di database.
     */
    public function update(Request $request, TransaksiPenjualan $transaksi)
    {
        // Logika update bisa mirip dengan store:
        // 1. Validasi
        // 2. Mulai DB Transaction
        // 3. Update data utama transaksi
        // 4. Hapus detail lama, buat detail baru (atau logika yang lebih kompleks)
        // 5. Kembalikan stok lama, kurangi stok baru
        // 6. Commit atau Rollback
        // (Untuk saat ini kita skip implementasi detailnya karena sangat bergantung pada business logic)
        
        $request->validate([
            'nama_kasir' => 'required|string|max:50',
            'email_pembeli' => 'nullable|email',
        ]);

        $transaksi->update($request->only(['nama_kasir', 'email_pembeli']));

        return redirect()->route('transaksi.index')->with('success', 'Data kasir berhasil diupdate.');
    }

    /**
     * DELETE: Menghapus transaksi dari database.
     */
    public function destroy(TransaksiPenjualan $transaksi)
    {
        // Logika untuk mengembalikan stok produk sebelum menghapus
        // DB::transaction(function() use ($transaksi) {
        //     foreach($transaksi->details as $detail) {
        //         Product::find($detail->id_product)->increment('stock', $detail->jumlah_pembelian);
        //     }
        //     $transaksi->delete(); // Ini akan otomatis menghapus detailnya karena onDelete('cascade')
        // });
        
        $transaksi->delete();

        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus.');
    }
}