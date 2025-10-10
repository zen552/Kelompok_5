@extends('layouts.app')

@section('content')
    <h1>Edit Kategori Produk: {{ $category->name }}</h1>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Kembali</a>
    <hr>

    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT') {{-- Menggunakan method PUT/PATCH untuk operasi update --}}
        
        <div class="form-group">
            <label for="name">Nama Kategori</label>
            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $category->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="description">Deskripsi</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $category->description) }}</textarea>
        </div>
        
        <button type="submit" class="btn btn-success mt-3">✅ Perbarui Kategori</button>
    </form>
@endsection