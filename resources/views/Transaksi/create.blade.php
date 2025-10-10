@extends('layouts.app')

@section('content')
    <script src="//unpkg.com/alpinejs" defer></script>

    <h1>Buat Transaksi Baru</h1>

    <div class="card" x-data="transactionForm()">
        <form action="{{ route('transaksi.store') }}" method="POST">            
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nama_kasir" class="form-label">Nama Kasir</label>
                        <input type="text" class="form-control" id="nama_kasir" name="nama_kasir" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email_pembeli" class="form-label">Email Pembeli (Opsional)</label>
                        <input type="email" class="form-control" id="email_pembeli" name="email_pembeli">
                    </div>
                </div>
                <hr>
                <h5>Detail Produk</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in items" :key="index">
                            <tr>
                                <td>
                                    <select :name="`products[${index}][id]`" class="form-select" required>
                                        <option value="">Pilih Produk</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->title }} (Stok: {{ $product->stock }})</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" :name="`products[${index}][jumlah]`" class="form-control" min="1" value="1" required>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger" @click="removeItem(index)">Hapus</button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>

                <button type="button" class="btn btn-success" @click="addItem()">+ Tambah Produk</button>
            </div>
            <div class="card-footer text-end">
                <a href="{{-- Arahkan ke route index Anda --}}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
            </div>
        </form>
    </div>

    <script>
        function transactionForm() {
            return {
                // Inisialisasi dengan satu baris produk kosong
                items: [{}],
                
                // Fungsi untuk menambah item baru ke dalam array 'items'
                addItem() {
                    this.items.push({});
                },

                // Fungsi untuk menghapus item dari array 'items' berdasarkan posisinya (index)
                removeItem(index) {
                    // Pastikan setidaknya ada satu baris tersisa
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                }
            }
        }
    </script>
@endsection