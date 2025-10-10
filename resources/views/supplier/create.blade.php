@extends('layouts.app')

@section('content')
<h2>Tambah Supplier</h2>

<form action="{{ route('suppliers.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label for="supplier_name" class="form-label">Nama Supplier</label>
        <input type="text" name="supplier_name" class="form-control" required>
    </div>
    <div class="mb-3">
        <label for="pic_supplier" class="form-label">PIC Supplier</label>
        <input type="text" name="pic_supplier" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Simpan</button>
    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
