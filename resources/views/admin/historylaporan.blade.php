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

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

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
            <li><a href="admin/voting"><i class="fas fa-up-down"></i> Voting</a></li>
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
                            <th>No</th>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Tanggal Selesai</th>
                            <th>Jenis</th>
                            <th>Kategori</th>
                            <th>Lokasi</th>
                            <th>Deskripsi</th>
                            <th>File Media</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($history->isEmpty())
                            <tr class="table-empty">
                                <td colspan="10">Tidak ada laporan yang selesai.</td>
                            </tr>
                        @else
                            @foreach($history as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->pelaporan->judul }}</td>
                                    <td>{{ $item->pelaporan->tanggal_laporan }}</td>
                                    <td>{{ $item->tanggal_selesai }}</td>
                                    <td>{{ $item->pelaporan->jenis->name_jenis }}</td>
                                    <td>{{ $item->pelaporan->kategori->name }}</td>
                                    <td>{{ $item->pelaporan->lokasi }}</td>
                                    <td>{{ $item->pelaporan->deskripsi }}</td>
                                    <td>
                                        @if($item->pelaporan->media)
                                            @foreach(json_decode($item->pelaporan->media, true) as $media)
                                                <a href="{{ asset('storage/' . $media) }}" target="_blank">Lihat File</a>
                                            @endforeach
                                        @else
                                            Tidak ada media
                                        @endif
                                    </td>
                                    <td>{{ $item->pelaporan->status->nama_status ?? 'Status tidak tersedia' }}</td>
                                </tr>
                            @endforeach
                        @endif
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