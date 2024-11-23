<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Judul -->
    <title>Laporan Terintegrasi Online Platform</title>

    <!-- Icon Web -->
    <link rel="shortcut icon" href="images/iconlaptop.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- CSS Eksternal -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/awal.css">
</head>

<body>
    <!-- Awal -->
    <div class="welcome-container">
        <h1 class="welcome-title">Selamat Datang</h1>
        <p class="welcome-description">
            LAPTOP (Laporan Terintegrasi Online Platform) adalah solusi inovatif untuk memudahkan pelaporan fasilitas yang rusak atau hilang.
        </p>
        <button class="enter-button" onclick="location.href='{{ route('login') }}'">Yuk Masuk!</button>
    </div>
    <!-- Akhir -->

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <!-- JS Eksternal-->
    <script src="js/script.js"></script>
</body>
</html>
