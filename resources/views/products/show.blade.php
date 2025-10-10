@extends('layouts.app')

@section('content')
<div class="container mt-4 mb-4">
    <h3>Detail Product</h3>

    <div class="row mt-3">
        <!-- IMAGE -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <img src="{{ asset('storage/image/'.$product->image) }}" class="rounded w-100">
                </div>
            </div>
        </div>

        <!-- DETAIL -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body">
                    <h3>{{ $product->title }}</h3>
                    <hr/>
                    <p><strong>Category:</strong> {{ $product->product_category_name }}</p>
                    <hr/>
                    <p><strong>Supplier:</strong> {{ $product->supplier_name }}</p>
                    <hr/>
                    <p><strong>Price:</strong> {{ "Rp " . number_format($product->price,2,',','.') }}</p>
                    <hr/>
                    <p><strong>Description:</strong></p>
                    <div class="border p-2 rounded" style="background: #f8f9fa;">
                        {!! $product->description !!}
                    </div>
                    <hr/>
                    <p><strong>Stock:</strong> {{ $product->stock }}</p>

                    <a href="{{ route('products.index') }}" class="btn btn-secondary mt-3">Back to Products</a>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary mt-3">Edit Product</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
