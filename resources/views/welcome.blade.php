<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
    body,
    html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Poppins', sans-serif;
    }

    .carousel-item img {
        height: 100vh;
        object-fit: cover;
        width: 100%;
    }

    .carousel,
    .carousel-inner,
    .carousel-item {
        height: 100vh;
    }

    .overlay {
        background-color: rgba(0, 0, 0, 0.4);
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        z-index: 1;
    }

    .content {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        text-align: center;
        color: white;
        z-index: 2;
    }

    .navbar {
        background-color: #556B2F !important;
        z-index: 3;
    }

    .navbar .nav-link {
        color: white !important;
    }

    .navbar .nav-link:hover {
        color: #d4f5a1 !important;
    }

    .navbar-brand img {
        filter: brightness(0) invert(1);
    }

    .section-title {
        color: #556B2F;
        font-weight: bold;
        margin-bottom: 30px;
    }

    .card {
        border: 1px solid #556B2F;
    }

    .card-title {
        color: #556B2F;
        font-weight: bold;
    }

    .card-text {
        color: #333;
    }
    </style>
</head>

<body>

    @include('layouts.navbar')

    <!-- Carousel Background Only -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            @foreach($fotos as $key => $foto)
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/' . $foto->file) }}" class="d-block w-100" alt="Slide {{ $key }}">
            </div>
            @endforeach
        </div>
    </div>

    <!-- Overlay -->
    <div class="overlay"></div>

    <!-- Fixed Text -->
    <div class="content">
        <h1 class="display-4 fw-bold">Kementerian Lingkungan Hidup dan Kehutanan</h1>
        <p class="lead">Kami hadir untuk memudahkan anda mencari informasi mengenai kami!</p>
    </div>

    <!-- Profile Section -->
    <div class="container my-5">
        <h2 class="section-title text-center">Profil Kami</h2>
        <div class="row">
            @foreach ($profiles as $profile)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $profile->judul }}</h5>
                        <p class="card-text">{{ Str::limit(strip_tags($profile->isi), 150, '...') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>