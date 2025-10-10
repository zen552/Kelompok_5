<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;

class ProductCategoryController extends Controller
{
    /**
     * Menampilkan semua kategori.
     */
    public function index()
    {
        $categories = ProductCategory::all();
        return view('categories.index', compact('categories'));
    }

    /**
     * Menyimpan kategori baru (AJAX JSON response).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_category_name' => 'required|string|max:191|unique:category_product,product_category_name',
            'description' => 'nullable|string',
        ]);

        try {
            $category = ProductCategory::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Kategori baru berhasil ditambahkan!',
                'data' => $category,
            ], 201);
        } catch (Exception $e) {
            Log::error('Gagal menyimpan kategori', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan kategori. Periksa struktur tabel atau model.',
                'error_detail' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update kategori berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'product_category_name' => 'required|string|max:191|unique:category_product,product_category_name,' . $id,
            'description' => 'nullable|string',
        ]);

        try {
            $category = ProductCategory::findOrFail($id);
            $category->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil diperbarui!',
                'data' => $category,
            ]);
        } catch (Exception $e) {
            Log::error('Gagal update kategori', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui kategori.',
                'error_detail' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Hapus kategori.
     */
    public function destroy($id)
    {
        try {
            $category = ProductCategory::findOrFail($id);
            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kategori berhasil dihapus!',
            ]);
        } catch (Exception $e) {
            Log::error('Gagal menghapus kategori', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus kategori.',
                'error_detail' => $e->getMessage(),
            ], 500);
        }
    }
}
