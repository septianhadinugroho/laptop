<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Judul -->
    <title>About | Laporan Terintegrasi Online Platform</title>

    <!-- Icon Web -->
    <link rel="shortcut icon" href="images/iconlaptop.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- CSS Eksternal -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top shadow-sm">
        <div class="container-fluid">
            <a href="/about" class="navbar-brand text-uppercase fw-bold custom-logo">
                LAPTOP
            </a>
            <div class="mx-auto"></div>
        </div>
    </nav>
        
    <!-- Awal Header -->
    <header class="text-align p-2">
        <div class="welcome-banner">
            <h1>Selamat datang, <span class="username">{{ Auth::user()->name }}</span></h1>
        </div>
    </header>
    <!-- Akhir Header -->

    <!-- Awal Carousel -->
    <section class="container my-4">
        <div id="laptopCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#laptopCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
                <button type="button" data-bs-target="#laptopCarousel" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#laptopCarousel" data-bs-slide-to="2"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="images/fotohome1.jpg" class="d-block w-100" alt="Home 1">
                </div>
                <div class="carousel-item">
                    <img src="images/fotohome2.jpg" class="d-block w-100" alt="Home 2">
                </div>
                <div class="carousel-item">
                    <img src="images/fotohome3.jpg" class="d-block w-100" alt="Home 3">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#laptopCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#laptopCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
    <!-- Akhir Carousel -->

    <!-- Awal Tentang Kami -->
    <section class="container my-5" id="tentang-kami">
        <h2 class="text-center">Tentang Kami</h2>
        <div class="row justify-content-center">
            <div class="col-12 mb-4" id="laptop-info">
                <div class="laptop-box">
                    <p>LAPTOP (Laporan Terintegrasi Online Platform) adalah solusi inovatif untuk memudahkan pelaporan fasilitas yang rusak atau hilang. Kami berkomitmen untuk membantu masyarakat kampus dan institusi dalam menjaga dan merawat fasilitas umum.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="visi-box">
                    <h3>Visi</h3>
                    <p>Menjadi platform pelaporan terdepan yang memfasilitasi pemeliharaan dan perbaikan infrastruktur publik secara efisien, menciptakan lingkungan yang lebih baik dan aman bagi masyarakat kampus.</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="misi-box">
                    <h3>Misi</h3>
                    <ul>
                        <li>Menyediakan platform yang mudah digunakan untuk pelaporan fasilitas rusak atau hilang.</li>
                        <li>Memfasilitasi komunikasi yang efektif antara masyarakat kampus dan pihak berwenang.</li>
                        <li>Meningkatkan kesadaran masyarakat kampus akan pentingnya menjaga fasilitas umum.</li>
                        <li>Mendorong partisipasi aktif masyarakat kampus dalam pemeliharaan infrastruktur publik.</li>
                        <li>Menggunakan teknologi untuk mempercepat proses penanganan laporan dan perbaikan fasilitas.</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Akhir Tentang Kami -->

    <!-- Awal Footer -->
    <footer class="fixed-bottom bg-light px-2">
        <nav class="d-flex justify-content-around">
            <div class="nav-item text-center p-2">
                <a href="/voting" class="text-decoration-none">
                    <i class="fas fa-up-down"></i><br />Voting
                </a>
            </div>
            <div class="nav-item text-center p-2">
                <a href="/history" class="text-decoration-none">
                    <i class="fas fa-history"></i><br />History
                </a>
            </div>
            <div class="nav-item text-center p-2">
                <a href="/about" class="text-decoration-none active">
                    <i class="fas fa-info"></i><br />About
                </a>
            </div>
            <div class="nav-item text-center p-2">
                <a href="/akun" class="text-decoration-none">
                    <i class="fas fa-user"></i><br />Akun
                </a>
            </div>
        </nav>
    </footer>
    <!-- Akhir Footer-->

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- JS Eksternal-->
    <script src="js/script.js"></script>
</body>
</html>