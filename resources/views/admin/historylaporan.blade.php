<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LAPTOP | History Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Icon Web -->
    <link rel="shortcut icon" href="images/iconlaptop.ico" type="image/x-icon">

    <!-- CSS Eksternal -->
    <link rel="stylesheet" href="css/admin/main.css">
    <link rel="stylesheet" href="css/admin/historylaporan.css">
</head>

<body>
    <div class="sidebar" id="sidebarMenu">
        <div class="p-3 text-center border-bottom">
            <h4>LAPTOP</h4>
        </div>
        <ul>
            <li><a href="/dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li><a href="/pengguna"><i class="bi bi-people"></i> Pengguna</a></li>
            <li><a href="/jenis"><i class="bi bi-list-ul"></i> Jenis</a></li>
            <li><a href="/laporan"><i class="bi bi-file-earmark-text"></i> Laporan</a></li>
            <li><a href="/historylaporan" class="active"><i class="bi bi-clock-history"></i> History Laporan</a></li>
            <li><a href="/profile"><i class="bi bi-person-circle"></i> Profile</a></li>
            <li><a href="/logout"><i class="bi bi-box-arrow-right"></i> Log Out</a></li>
        </ul>
    </div>

    <div class="main">
        <nav class="navbar navbar-light">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" aria-label="Toggle navigation" onclick="toggleSidebar()">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand">History Laporan</a>
                <ul class="navbar-nav ms-auto d-flex flex-row align-items-center">
                    <li class="nav-item mx-2">
                        <a href="#" class="nav-link text-dark">
                            <i class="bi bi-bell"></i> Notifications
                        </a>
                    </li>
                    <li class="nav-item mx-2">
                        <a href="/profile" class="nav-link text-dark">
                            <i class="bi bi-person-circle"></i> Profile
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="content p-4">
            <h4 class="text-center mb-4">Daftar History Laporan</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Jenis</th>
                            <th>Deskripsi</th>
                            <th>Tanggal Laporan</th>
                            <th>Media</th>
                            <th>Nama Pelapor</th>
                            <th>Lokasi</th>
                        </tr>
                    </thead>
                    <tbody id="historyLaporanTable">
                        <tr>
                            <td>1</td>
                            <td>Laporan Kehilangan Laptop</td>
                            <td>Berat</td>
                            <td>Elektronik</td>
                            <td>Laptop hilang di kampus saat jam kuliah.</td>
                            <td>2024-11-01</td>
                            <td><a href="#" class="btn btn-secondary btn-sm">Lihat Media</a></td>
                            <td>John Doe</td>
                            <td>Kampus Utama</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Laporan Kerusakan Laptop</td>
                            <td>Berat</td>
                            <td>Elektronik</td>
                            <td>Laptop tidak bisa menyala setelah jatuh.</td>
                            <td>2024-11-02</td>
                            <td><a href="#" class="btn btn-secondary btn-sm">Lihat Media</a></td>
                            <td>Jane Smith</td>
                            <td>Asrama Mahasiswa</td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Laporan Kehilangan Charger</td>
                            <td>Ringan</td>
                            <td>Aksesoris</td>
                            <td>Charger hilang saat di kelas.</td>
                            <td>2024-11-03</td>
                            <td><a href="#" class="btn btn-secondary btn-sm">Lihat Media</a></td>
                            <td>Mike Johnson</td>
                            <td>Kampus Utama</td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Laporan Pencurian Laptop</td>
                            <td>Berat</td>
                            <td>Elektronik</td>
                            <td>Laptop dicuri saat ditinggal di perpustakaan.</td>
                            <td>2024-11-04</td>
                            <td><a href="#" class="btn btn-secondary btn-sm">Lihat Media</a></td>
                            <td>Emily Brown</td>
                            <td>Perpustakaan</td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Laporan Kehilangan Mouse</td>
                            <td>Ringan</td>
                            <td>Aksesoris</td>
                            <td>Mouse hilang di ruang komputer.</td>
                            <td>2024-11-05</td>
                            <td><a href="#" class="btn btn-secondary btn-sm">Lihat Media</a></td>
                            <td>Alice White</td>
                            <td>Ruang Komputer</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebarMenu');
            const main = document.querySelector('.main');
            sidebar.classList.toggle('show');
            main.classList.toggle('show-sidebar');
        }
    </script>

</body>
</html>