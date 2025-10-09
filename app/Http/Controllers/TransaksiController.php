<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * index
     * 
     * @return void
     */
    // public function index():view
    // {
    //     $transaksi = new Transaksi;
    //     $trans = $transaksi->get_transaksi()
    //                         ->latest('transaksi.created_at')
    //                         ->with('detail_transaksi')
    //                         ->paginate(10);
        
    //     return view('transaksi.index', compact('trans'));
    // }
    public function index(): view
{
    $transaksi = new Transaksi;
    // Get transactions and paginate
    $trans = $transaksi->get_transaksi()->paginate(10);
    
    return view('transaksi.index', compact('trans'));
}

    /**
     * show
     * 
     * @param mixed $id
     * @return View
     */
    public function show(string $id): View 
{
    $transaksi_model = new Transaksi;
    
    // Get the transaction with the details
    $transaksi = $transaksi_model->get_transaksi()->where("transaksi.id", $id)->firstOrFail();

    // Fetch individual products for this transaction
    $products = DB::table('detail_transaksi as dt')
        ->join('products', 'products.id', '=', 'dt.id_product')
        ->where('dt.id_transaksi', $id)
        ->select('products.title', 'dt.jumlah as quantity', 'products.price', DB::raw('dt.jumlah * products.price as total_price'))
        ->get();

    return view('transaksi.show', compact('transaksi', 'products'));
}

    
    /**
     * create
     * 
     * @return void
     */
    public function create(): View
    {
        $product = new Product;
        // Fetch products and store them in an array
        $products = $product->get_product()->get(); // Corrected to use just $products
        
        return view('transaksi.create', compact('products'));
    }

    /**
     * store
     * 
     * @param mixed $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
    // Validate incoming request data
    $request->validate([
        'nama_kasir' => 'required|string|max:255',
        'products' => 'required|array',
        'products.*.id_product' => 'required|integer|exists:products,id',
        'products.*.jumlah' => 'required|integer|min:1',
    ]);

    // Check stock for each product
    foreach ($request->products as $product) {
        $productModel = Product::find($product['id_product']);
        if ($productModel->stock < $product['jumlah']) {
            return redirect()->back()->with('error', 'Stock for ' . $productModel->title . ' is insufficient! Only ' . $productModel->stock . ' left.');
        }
    }

    // Create the Transaksi
    $transaksi = new Transaksi();
    $transaksi->nama_kasir = $request->input('nama_kasir');
    $transaksi->save(); // Save the transaction and keep its instance

    // Insert into the detail_transaksi table and adjust stock for each product
    foreach ($request->products as $product) {
        // Insert the product details
        DB::table('detail_transaksi')->insert([
            'id_transaksi' => $transaksi->id,
            'id_product' => $product['id_product'],
            'jumlah' => $product['jumlah'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Adjust stock for each product
        $productModel = Product::find($product['id_product']);
        $productModel->stock -= $product['jumlah']; // Deduct the stock
        $productModel->save(); // Save the updated stock
    }

    // Redirect with success message
    return redirect()->route('transaksi.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }



    /**
     * edit
     * 
     * @param mixed $transaksi
     * @return View
     */
    public function edit(string $id): View
    {
        $transaksi_model = new Transaksi;
        // Get the transaction with its details
        $transaksi = $transaksi_model->get_transaksi()->where("transaksi.id", $id)->firstOrFail();
        
        $transaksi = Transaksi::with('details')->findOrFail($id); // Load the transaction with its details

        $product = new Product;
        // Fetch products
        $products = $product->get_product()->get();

        $products = Product::all(); // Load all available products

    
    return view('transaksi.edit', compact('transaksi', 'products'));
    }
    /**
     * update
     * 
     * @param Request $request
     * @param Transaksi $transaksi
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request
        $request->validate([
            'nama_kasir' => 'required|string|max:255',
            'products' => 'required|array',
            'products.*.id_product' => 'required|integer|exists:products,id',
            'products.*.jumlah' => 'required|integer|min:1',
        ]);
    
        // Find the existing transaction
        $transaksi = Transaksi::findOrFail($id);
    
        // Store current details of the transaction
        $currentDetails = $transaksi->details()->get();
    
        // Check stock for each product before proceeding with update
        foreach ($request->products as $product) {
            $productModel = Product::find($product['id_product']);
            $currentDetail = $currentDetails->firstWhere('id_product', $product['id_product']);
            $newQuantity = $product['jumlah'];
    
            // Calculate the stock change (new quantity - current quantity)
            $quantityChange = $newQuantity - ($currentDetail->jumlah ?? 0);
    
            // If the stock is insufficient, return an error message
            if ($productModel->stock < $quantityChange) {
                return redirect()->back()->with('error', 'Stock for ' . $productModel->title . ' is insufficient! Only ' . $productModel->stock . ' left.');
            }
        }
    
        // Update the transaction's kasir name
        $transaksi->update([
            'nama_kasir' => $request->nama_kasir,
        ]);
    
        // Loop through current details to manage stock changes
        foreach ($currentDetails as $currentDetail) {
            // Find the new product data
            $newProductData = collect($request->products)->firstWhere('id_product', $currentDetail->id_product);
            
            if ($newProductData) {
                // If the product exists in both current and new, update stock based on the difference
                $newQuantity = $newProductData['jumlah'];
                $quantityChange = $newQuantity - $currentDetail->jumlah;
    
                // Adjust stock if the quantity changes
                $this->adjustStock($currentDetail->id_product, -$quantityChange);
    
                // Update detail record
                $currentDetail->jumlah = $newQuantity;
                $currentDetail->save();
            } else {
                // If the product doesn't exist in the new list, revert its stock and delete the detail
                $this->adjustStock($currentDetail->id_product, $currentDetail->jumlah); // Add back stock
                $currentDetail->delete(); // Remove the detail if it doesn't exist anymore
            }
        }
    
        // Handle new products that were added
        foreach ($request->products as $newProductData) {
            if (!$currentDetails->contains('id_product', $newProductData['id_product'])) {
                // If the product is new, add it and adjust stock
                $transaksi->details()->create([
                    'id_product' => $newProductData['id_product'],
                    'jumlah' => $newProductData['jumlah'],
                    'id_transaksi' => $transaksi->id,
                ]);
                $this->adjustStock($newProductData['id_product'], -$newProductData['jumlah']); // Decrease stock
            }
        }
    
        return redirect()->route('transaksi.index')->with('success', 'Transaksi updated successfully!');
    }    

    
    private function adjustStock($productId, $quantityChange)
    {
    $product = Product::findOrFail($productId);
    
    // Check if stock would go below zero
    if ($product->stock + $quantityChange < 0) {
        throw new \Exception('Stock for ' . $product->title . ' is insufficient!');
    }

    $product->stock += $quantityChange; // Adjust the stock based on the change
    $product->save();
    }


     /**
    * destroy
    *
    * @param mixed $id
    * @return RedirectResponse
    */

    public function destroy($id): RedirectResponse {

    $transaksi_model = new Transaksi;
    $transaksi = $transaksi_model->get_transaksi()->where("transaksi.id", $id)->firstOrFail();  

   
    $transaksi->delete();
    
    return redirect()->route('transaksi.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}    