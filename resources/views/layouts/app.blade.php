<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetShop Dashboard</title>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Icon -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #f6f8f7;
        }
        .sidebar {
            height: 100vh;
            background-color: #fdd835;
            padding-top: 20px;
            position: fixed;
            left: 0;
            top: 0;
            width: 220px;
        }
        .sidebar a {
            color: #333;
            display: block;
            padding: 12px 20px;
            text-decoration: none;
            font-weight: 500;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background-color: #ffb300;
            color: white;
            border-radius: 8px;
        }
        .content {
            margin-left: 240px;
            padding: 20px;
        }
        .sidebar h4 {
            text-align: center;
            font-weight: bold;
            color: #333;
        }
        .pet-icon {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #333;
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="text-center mb-3">
            <i class="bi bi-shop pet-icon"></i>
            <h4>PetShop</h4>
        </div>
        
        <a href="{{ url('/products') }}" class="{{ request()->is('products*') ? 'active' : '' }}">
            <i class="bi bi-box"></i> Products
        </a>
        <a href="{{ url('/suppliers') }}" class="{{ request()->is('suppliers*') ? 'active' : '' }}">
            <i class="bi bi-truck"></i> Supplier
        </a>
        <a href="{{ url('/categories') }}" class="{{ request()->is('categories*') ? 'active' : '' }}">
            <i class="bi bi-tags"></i> Kategori Produk
        </a>
        <a href="{{ url('/transaksi') }}" class="{{ request()->is('transaksi*') ? 'active' : '' }}">
            <i class="bi bi-cash-stack"></i> Transaksi
        </a>
    </div>

    <!-- KONTEN -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        @yield('scripts')   <!-- 🔥 Tambahkan baris ini -->
</body>
</html>
