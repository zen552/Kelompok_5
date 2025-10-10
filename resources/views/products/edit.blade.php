@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-4">
    <h4>Edit Product</h4>
    <div class="card border-0 shadow-sm rounded">
        <div class="card-body">
            <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- IMAGE -->
                <div class="form-group mb-3">
                    <label class="font-weight-bold">IMAGE</label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                    @error('image')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- PRODUCT CATEGORY -->
                <div class="form-group mb-3">
                    <label for="product_category_id">Product Category</label>
                    <select class="form-control" id="product_category_id" name="product_category_id">
                        <option value="">-- Select Category Product --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('product_category_id', $product->product_category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->product_category_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_category_id')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- SUPPLIER -->
                <div class="form-group mb-3">
                    <label for="supplier_id">Supplier</label>
                    <select class="form-control" name="id_supplier" id="supplier_id">
                        <option value="">-- Select Supplier --</option>
                        @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}"
                                {{ old('id_supplier', $product->supplier_id) == $supplier->id ? 'selected' : '' }}>
                                {{ $supplier->supplier_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('id_supplier')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- TITLE -->
                <div class="form-group mb-3">
                    <label class="font-weight-bold">TITLE</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                        name="title" value="{{ old('title', $product->title) }}" placeholder="Masukkan Judul Product">
                    @error('title')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- DESCRIPTION -->
                <div class="form-group mb-3">
                    <label class="font-weight-bold">DESCRIPTION</label>
                    <textarea class="form-control @error('description') is-invalid @enderror"
                        name="description" rows="5" placeholder="Masukkan Description Product">{{ old('description', $product->description) }}</textarea>
                    @error('description')
                        <div class="alert alert-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- PRICE & STOCK -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">PRICE</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror"
                                name="price" value="{{ old('price', $product->price) }}" placeholder="Masukkan Harga Product">
                            @error('price')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="font-weight-bold">STOCK</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror"
                                name="stock" value="{{ old('stock', $product->stock) }}" placeholder="Masukkan Stock Product">
                            @error('stock')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-md btn-primary me-3">UPDATE</button>
                <button type="reset" class="btn btn-md btn-warning">RESET</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    CKEDITOR.replace('description');
</script>
@endsection
