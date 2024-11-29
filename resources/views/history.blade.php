<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Judul -->
    <title>History | Laporan Terintegrasi Online Platform</title>

    <!-- Icon Web -->
    <link rel="shortcut icon" href="images/iconlaptop.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- CSS Eksternal -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/history.css">
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

    <!-- Awal History -->
    <div class="container">
        <div class="form-container">
            <h2>Riwayat Laporan</h2>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Jenis</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Lokasi</th>
                            <th scope="col">Deskripsi</th>
                            <th scope="col">File Media</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelaporans as $index => $laporan)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $laporan->judul }}</td>
                                <td>{{ $laporan->tanggal_laporan }}</td>
                                <td>{{ $laporan->jenis->name_jenis ?? 'N/A' }}</td>
                                <td>{{ $laporan->kategori->name ?? 'N/A' }}</td>
                                <td>{{ $laporan->lokasi }}</td>
                                <td>{{ $laporan->deskripsi }}</td>
                                <td>
                                    @if($laporan->media)
                                        @php
                                            $mediaFiles = json_decode($laporan->media);
                                        @endphp
                                        @if(is_array($mediaFiles))
                                            @foreach($mediaFiles as $media)
                                                <a href="{{ asset('storage/'.$media) }}" target="_blank">Lihat File</a><br>
                                            @endforeach
                                        @else
                                            Tidak ada file
                                        @endif
                                    @else
                                        Tidak ada file
                                    @endif
                                </td>
                                <td class="text-white text-center
                                @if($laporan->status_id == 1) bg-danger
                                @elseif($laporan->status_id == 2) bg-primary
                                @elseif($laporan->status_id == 3) bg-success
                                @else bg-primary
                                @endif">
                                @if($laporan->status_id == 1)
                                    Dalam Antrian
                                @elseif($laporan->status_id == 2)
                                    Sedang Diproses
                                @elseif($laporan->status_id == 3)
                                    Selesai
                                @else
                                    N/A
                                @endif
                            </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Akhir History -->

    <!-- Awal Footer -->
    <footer class="fixed-bottom bg-light px-2">
        <nav class="d-flex justify-content-around">
            <div class="nav-item text-center p-2">
                <a href="/voting" class="text-decoration-none">
                    <i class="fas fa-up-down"></i><br />Voting
                </a>
            </div>
            <div class="nav-item text-center p-2">
                <a href="/history" class="text-decoration-none active">
                    <i class="fas fa-history"></i><br />History
                </a>
            </div>
            <div class="nav-item text-center p-2">
                <a href="/about" class="text-decoration-none">
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
</body>
</html>
