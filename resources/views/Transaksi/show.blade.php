<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-edge">
    <title>Data Transaksi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    body {
        background-color: #f8f9fa;
    }

    nav {
        width: 20px !important;
    }

    .container {
        max-width: 800px;
    }

    .card {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
    }

    h2, h3 {
        color: #333;
    }

    hr {
        border: 1px solid #dee2e6;
    }

    ul {
        padding-left: 0;
        list-style: none;
    }

    ul li {
        background-color: #e9ecef;
        padding: 10px;
        margin-bottom: 8px;
        border-radius: 8px;
    }

    ul li strong {
        color: #495057;
    }

    .center-text {
        text-align: center;
    }

    .button-container {
        position: fixed;
        bottom: 20px;
        left: 0;
        right: 0;
        text-align: center;
        padding: 0 20px;
    }

    .btn-back {
        background-color: #0d6efd;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-back:hover {
        background-color: #0b5ed7;
    }


</style>

<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="text-center">
                    <h1 class="my-4">Detail Transaksi</h1>
                    <hr>
                </div>
                <div class="card border-0 shadow-sm rounded">
                    <div class="card-body">
                        <h5 class="mb-3">Nama Kasir: {{ $transaksi->nama_kasir }}</h5>
                        <p><strong>Tanggal Transaksi:</strong> {{ $transaksi->transaksi_created }}</p>

                        <h3 class="mt-4 center-text">Produk Dalam Transaksi</h3>
                        <table class="table table-hover mt-3">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="bg-blue">Nama Produk</th>
                                    <th scope="col" class="bg-blue">Harga</th>
                                    <th scope="col" class="bg-blue">Jumlah</th>
                                    <th scope="col" class="bg-blue">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($products as $product)
                                <tr>
                                    <td class="bg-blue"><strong>{{ $product->title }}</strong></td>
                                    <td class="bg-blue">{{ "Rp.".number_format($product->price,2,',','.') }}</td>
                                    <td class="bg-blue">{{ $product->quantity }}</td>
                                    <td class="bg-blue">{{ "Rp".number_format($product->total_price, 2, ',', '.') }}</td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td class="bg-blue"></td>
                                    <td class="bg-blue"></td>
                                    <td class="bg-blue"><strong>Total Harga:</strong></td>
                                    <td class="bg-blue"><strong>{{ "Rp".number_format($transaksi->total_harga, 2, ',', '.') }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="button-container">
        <button onclick="window.history.back()" class="btn-back">Kembali</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
        Swal.fire({
            icon: "success",
            title: "BERHASIL",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
        @elseif(session('error'))
        Swal.fire({
            icon: "error",
            title: "GAGAL",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        });
        @endif
    </script>
</body>

</html>