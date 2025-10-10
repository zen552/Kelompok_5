@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-4">
    <h3>Add New Product</h3>
    <div class="card border-0 shadow-sm rounded">
        <div class="card-body">
            <form id="productForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                    <label class="font-weight-bold">IMAGE</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                </div>

                <div class="form-group">
                    <label for="product_category_id">Kategori</label>
                    <select name="product_category_id" class="form-control">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->product_category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_supplier">Supplier</label>
                    <select name="id_supplier" class="form-control">
                        <option value="">-- Pilih Supplier --</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->supplier_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">TITLE</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" placeholder="Masukkan Judul Product">
                </div>

                <div class="form-group mb-3">
                    <label class="font-weight-bold">DESCRIPTION</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" name="description" rows="5" placeholder="Masukkan Description Product"></textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">PRICE</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" name="price" placeholder="Masukkan Harga Product">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">STOCK</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" placeholder="Masukkan Stock product">
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-md btn-primary me-3">SAVE</button>
                <button type="button" id="resetBtn" onclick="resetForm()" class="btn btn-md btn-warning">RESET</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    CKEDITOR.replace('description');

    function resetForm() {
        document.getElementById("productForm").reset();

        for (var instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].setData('');
        }
    }
</script>
@endsection
