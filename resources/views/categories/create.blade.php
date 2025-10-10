@extends('layouts.app')

@section('content')
    <h1>Tambah Kategori Produk Baru</h1>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
    <hr>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Kategori</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-success mt-3">💾 Simpan Kategori</button>
    </form>
@endsection