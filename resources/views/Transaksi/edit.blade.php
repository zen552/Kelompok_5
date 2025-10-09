<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    .button-container {
        position: fixed;
        bottom: 20px;
        left: 0;
        right: 0;
        text-align: center;
        padding: 0 20px;
    }

    .btn-back {
        background-color: #0d6efd;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-back:hover {
        background-color: #0b5ed7;
    }
</style>
<body style="background: lightgray">
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12">
                <h3>Edit Transaksi</h3>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <!-- Error Message (if any) -->
                        @if(session('error'))
                            <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Nama Kasir Field -->
                            <div class="form-group">
                                <label for="nama_kasir">Nama Kasir</label>
                                <input type="text" name="nama_kasir" class="form-control" value="{{ old('nama_kasir', $transaksi->nama_kasir) }}" required>
                                @error('nama_kasir')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Products Section -->
                            <h3>Products</h3>
                            <div id="products-section">
                                @foreach ($transaksi->details as $index => $detail)
                                    <div class="product-entry">
                                        <div class="form-group">
                                            <label for="products[{{ $index }}][id_product]">Select Product</label>
                                            <select name="products[{{ $index }}][id_product]" class="form-control" required>
                                                <option value="">Select a product</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}" {{ $product->id == $detail->id_product ? 'selected' : '' }}>
                                                        {{ $product->title }} - {{ "Rp".number_format($product->price,2,',','.') }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="products[{{ $index }}][jumlah]">Quantity</label>
                                            <input type="number" name="products[{{ $index }}][jumlah]" class="form-control" min="1" value="{{ $detail->jumlah }}" required>
                                        </div>
                                        <button type="button" class="btn btn-danger remove-product">Remove</button>
                                        <hr>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Button to add more products -->
                            <button type="button" id="add-product" class="btn btn-secondary">Add More Product</button>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary">Update Transaksi</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="button-container">
        <button onclick="window.history.back()" class="btn-back">Kembali</button>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('add-product').addEventListener('click', function () {
            let productCount = document.querySelectorAll('.product-entry').length;
            let newProductEntry = `
                <div class="product-entry">
                    <div class="form-group">
                        <label for="products[${productCount}][id_product]">Select Product</label>
                        <select name="products[${productCount}][id_product]" class="form-control" required>
                            <option value="">Select a product</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">{{ $product->title }} - {{ "Rp".number_format($product->price,2,',','.') }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="products[${productCount}][jumlah]">Quantity</label>
                        <input type="number" name="products[${productCount}][jumlah]" class="form-control" min="1" required>
                    </div>
                    <button type="button" class="btn btn-danger remove-product">Remove</button>
                    <hr>
                </div>
            `;
            document.getElementById('products-section').insertAdjacentHTML('beforeend', newProductEntry);
        });
    
        // Event delegation for dynamically added elements
        document.getElementById('products-section').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-product')) {
                e.target.closest('.product-entry').remove();
            }
        });
    </script>
</body>
</html>
