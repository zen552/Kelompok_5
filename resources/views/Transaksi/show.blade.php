@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Detail Transaksi #TRX-{{ $transaksi->id }}</h1>
        <a href="{{ route('transaksi.index') }}" class="btn btn-secondary">Kembali ke Daftar</a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">Informasi Transaksi</div>
                <div class="card-body">
                    <p><strong>ID Transaksi:</strong> TRX-{{ $transaksi->id }}</p>
                    <p><strong>Nama Kasir:</strong> {{ $transaksi->nama_kasir }}</p>
                    <p><strong>Email Pembeli:</strong> {{ $transaksi->email_pembeli ?? '-' }}</p>
                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d M Y, H:i:s') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Rincian Produk</div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-end">Jumlah</th>
                                <th class="text-end">Harga Satuan</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach ($transaksi->details as $detail)
                                @php
                                    $subtotal = $detail->product->price * $detail->jumlah_pembelian;
                                    $grandTotal += $subtotal;
                                @endphp
                                <tr>
                                    <td>{{ $detail->product->title }}</td>
                                    <td class="text-end">{{ $detail->jumlah_pembelian }}</td>
                                    <td class="text-end">Rp {{ number_format($detail->product->price, 0, ',', '.') }}</td>
                                    <td class="text-end">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Grand Total</th>
                                <th class="text-end">Rp {{ number_format($grandTotal, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection