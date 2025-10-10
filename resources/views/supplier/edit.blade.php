@extends('layouts.app')

@section('content')
<h2>Edit Supplier</h2>

<form action="{{ route('suppliers.update', $supplier->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group mb-3">
        <label class="font-weight-bold">Nama supplier</label>
            <input type="text" class="form-control @error('supplier_name') is-invalid @enderror"
            name="supplier_name" value="{{ old('supplier_name', $supplier->supplier_name) }}" placeholder="Siapa nama supplier?">
        @error('supplier_name')
        <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group mb-3">
        <label class="font-weight-bold">Nama PIC Supplier</label>
            <input type="text" class="form-control @error('pic_supplier') is-invalid @enderror"
            name="pic_supplier" value="{{ old('pic_supplier', $supplier->pic_supplier) }}" placeholder="Siapa PICnya?">
        @error('pic_supplier')
        <div class="alert alert-danger mt-2">{{ $message }}</div>
        @enderror
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Kembali</a>
</form>
@endsection
