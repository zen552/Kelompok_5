@extends('layouts.app')

@section('content')
    <h1>Edit Transaksi #TRX-{{ $transaksi->id }}</h1>

    <div class="card">
        <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_kasir" class="form-label">Nama Kasir</label>
                        <input type="text" class="form-control" id="nama_kasir" name="nama_kasir" value="{{ old('nama_kasir', $transaksi->nama_kasir) }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email_pembeli" class="form-label">Email Pembeli (Opsional)</label>
                        <input type="email" class="form-control" id="email_pembeli" name="email_pembeli" value="{{ old('email_pembeli', $transaksi->email_pembeli) }}">
                    </div>
                </div>
                <hr>
                <p class="text-muted">
                    Catatan: Mengubah detail produk (item yang dibeli) tidak diizinkan pada form ini untuk menjaga integritas data.
                    Jika terjadi kesalahan, disarankan untuk menghapus dan membuat transaksi baru.
                </p>
            </div>
            <div class="card-footer text-end">
                <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update Transaksi</button>
            </div>
        </form>
    </div>
@endsection