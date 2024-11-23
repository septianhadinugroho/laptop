<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LAPTOP | Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Icon Web -->
    <link rel="shortcut icon" href="images/iconlaptop.ico" type="image/x-icon">

    <!-- CSS Eksternal -->
    <link rel="stylesheet" href="css/admin/main.css">
    <link rel="stylesheet" href="css/admin/dashboard.css">

    <!-- Grafik -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <div class="sidebar" id="sidebarMenu">
        <div class="p-3 text-center border-bottom">
            <h4>LAPTOP</h4>
        </div>
        <ul>
            <li><a href="/dashboard" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
            <li><a href="/pengguna"><i class="bi bi-people"></i> Pengguna</a></li>
            <li><a href="/jenis"><i class="bi bi-list-ul"></i> Jenis</a></li>
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
                <a class="navbar-brand">Dashboard</a>
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
            <div class="row table-section">
                <div class="col-lg-4 mb-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h5 class="card-title">Pengguna</h5>
                            <p class="card-text">{{$user_count}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title">Laporan</h5>
                            <p class="card-text">{{$laporan_count}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title">History Laporan</h5>
                            <p class="card-text">{{$history_count}}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chart-section mb-4">
                <h4>Laporan Chart</h4>
                <div class="d-flex justify-content-end mb-2">
                    {{-- <button class="btn btn-info me-2">Month</button> --}}
                    <button class="btn btn-secondary ms-3">Download Chart</button>
                </div>
                <canvas id="laporanChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Ambil data laporan dari controller
        const laporanData = @json($laporan_per_bulan);

        // Static labels untuk 12 bulan
        const labels = [
            'January', 'February', 'March', 'April',
            'May', 'June', 'July', 'August',
            'September', 'October', 'November', 'December'
        ];

        // Inisialisasi data array dengan nol untuk 12 bulan
        const data = new Array(labels.length).fill(0);

        // Map data dari laporanData ke index yang sesuai
        laporanData.forEach(item => {
            if (item.bulan >= 1 && item.bulan <= 12) {
                data[item.bulan - 1] = item.jumlah; // Assign jumlah ke index yang benar
            }
        });

        // Fungsi untuk toggle sidebar
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebarMenu');
            const main = document.querySelector('.main');
            sidebar.classList.toggle('show');
            main.classList.toggle('show-sidebar');
        }

        // Chart.js Initialization
        const ctx = document.getElementById('laporanChart').getContext('2d');
        const laporanChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels, // Menggunakan static labels untuk 12 bulan
                datasets: [{
                    label: 'Laporan per Month',
                    data: data, // Menggunakan data yang telah dimapping
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 2,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)'
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        beginAtZero: true
                    },
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
