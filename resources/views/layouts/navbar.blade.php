<nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{ asset('storage/logo-sekarang.png') }}" alt="Logo" height="40" class="me-2">
            <span class="d-none d-sm-inline">Kementerian Lingkungan Hidup dan Kehutanan</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active" href="/">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/profil">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Berita</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
.navbar-brand img {
    filter: brightness(0) invert(1);
}

.navbar {
    background-color: #556B2F !important;
    z-index: 1030;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.navbar .nav-link {
    color: white !important;
}

.navbar .nav-link:hover {
    color: #d4f5a1 !important;
}

body {
    padding-top: 56px;
    /* Height of navbar */
}
</style>