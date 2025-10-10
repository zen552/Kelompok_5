<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tutorial Laravel</title>
    
    {{-- Link ke CSS Bootstrap dari CDN (agar tampilan rapi) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: #f4f6f9">

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                {{-- Di sinilah konten dari file anak (index.blade.php) akan ditampilkan --}}
                @yield('content')
            </div>
        </div>
    </div>
    
    {{-- Link ke JS Bootstrap (opsional tapi disarankan) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>