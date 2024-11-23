<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LAPTOP | Jenis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Icon Web -->
    <link rel="shortcut icon" href="images/iconlaptop.ico" type="image/x-icon">

    <!-- CSS Eksternal -->
    <link rel="stylesheet" href="css/admin/main.css">
    <link rel="stylesheet" href="css/admin/jenis.css">
</head>

<body>
    <div class="sidebar" id="sidebarMenu">
        <div class="p-3 text-center border-bottom">
            <h4>LAPTOP</h4>
        </div>
        <ul>
            <li><a href="/dashboard"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li><a href="/pengguna"><i class="bi bi-people"></i> Pengguna</a></li>
            <li><a href="/jenis" class="active"><i class="bi bi-list-ul"></i> Jenis</a></li>
            <li><a href="/laporan"><i class="bi bi-file-earmark-text"></i> Laporan</a></li>
            <li><a href="/historylaporan"><i class="bi bi-clock-history"></i> History Laporan</a></li>
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
                <a class="navbar-brand">Jenis Laporan</a>
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

        <div class="content p-4 text-center">
            <h4>Tambah Jenis Laporan</h4>
            <form action="{{ route('jenis.store') }}" method="POST" class="form-input mx-auto">
                @csrf
                <div class="mb-3">
                    <label for="namaJenis" class="form-label">Nama Jenis</label>
                    <input type="text" id="namaJenis" name="name_jenis" class="form-control" placeholder="Masukkan nama jenis" required>
                </div>
                <div class="mb-3">
                    <label for="kategoriJenis" class="form-label">Kategori</label>
                    <select id="kategoriJenis" name="kategori_id" class="form-select" required>
                        <option value="1">Ringan</option>
                        <option value="2">Berat</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Tambahkan Jenis</button>
            </form>
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

        function tambahJenis() {
            const namaJenis = document.getElementById('namaJenis').value;
            const kategoriJenis = document.getElementById('kategoriJenis').value;

            if (namaJenis) {
                alert(`Jenis baru ditambahkan:\nNama: ${namaJenis}\nKategori: ${kategoriJenis}`);
            } else {
                alert("Nama jenis harus diisi!");
            }
        }
    </script>
</body>
</html>
