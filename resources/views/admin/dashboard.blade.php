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

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

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
            <li><a href="/admin/voting"><i class="fas fa-up-down"></i> Voting</a></li>
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
                        <a href="/profile" class="nav-link text-dark">
                            <i class="bi bi-person-circle"></i> Profile
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="content p-4">
            <!-- Card Section -->
            <div class="row table-section">
                <div class="col-lg-4 mb-3">
                    <div class="card bg-primary text-white" onclick="window.location.href='{{ route('pengguna') }}'" style="cursor: pointer;">
                        <div class="card-body">
                            <h5 class="card-title">Pengguna</h5>
                            <p class="card-text">{{$user_count}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="card bg-success text-white" onclick="window.location.href='{{ route('admin.laporan') }}'" style="cursor: pointer;">
                        <div class="card-body">
                            <h5 class="card-title">Laporan</h5>
                            <p class="card-text">{{$laporan_count}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mb-3">
                    <div class="card bg-warning text-white" onclick="window.location.href='{{ route('historylaporan') }}'" style="cursor: pointer;">
                        <div class="card-body">
                            <h5 class="card-title">History Laporan</h5>
                            <p class="card-text">{{$history_count}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <!-- Chart Section -->
            <div class="chart-section mb-4">
                <h4>Laporan Chart</h4>
                <div class="d-flex justify-content-end mb-2">
                    <button class="btn btn-secondary" id="downloadChart">Download Chart</button>
                </div>
                <div class="d-flex justify-content-end mb-2">
                    <select id="chartMode" class="form-select w-auto">
                        <option value="monthly">Per Bulan</option>
                        <option value="weekly">Per Minggu</option>
                        <option value="yearly">Per Tahun</option>
                    </select>
                    <div id="filterContainer" style="display: none;">
                        <select id="filterMonth" class="form-select w-auto">
                            <option value="">Pilih Bulan</option>
                            @foreach(range(1, 12) as $bulan)
                                <option value="{{ $bulan }}">{{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <canvas id="laporanChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
        <script>
//             self.addEventListener('push', function(event) {
//     const data = event.data.json();
//     const options = {
//         body: data.body,
//         icon: '/icon.png', // Ganti dengan ikon notifikasi
//     };
//     event.waitUntil(
//         self.registration.showNotification(data.title, options)
//     );
// });
// if ('serviceWorker' in navigator && 'PushManager' in window) {
//     navigator.serviceWorker.register('/service-worker.js').then(sw => {
//         console.log('Service Worker Registered', sw);

//         Notification.requestPermission().then(permission => {
//             if (permission === 'granted') {
//                 // Mendaftar Push Subscription
//                 sw.pushManager.subscribe({
//                     userVisibleOnly: true,
//                     applicationServerKey: 'YOUR_PUBLIC_VAPID_KEY'
//                 }).then(subscription => {
//                     // Kirim subscription ke server
//                     fetch('/save-subscription', {
//                         method: 'POST',
//                         headers: {
//                             'Content-Type': 'application/json',
//                             'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//                         },
//                         body: JSON.stringify(subscription)
//                     });
//                 });
//             }
//         });
//     });
// }

            function toggleSidebar() {
                const sidebar = document.getElementById('sidebarMenu');
                const main = document.querySelector('.main');
                sidebar.classList.toggle('show');
                main.classList.toggle('show-sidebar');
            }
            const laporanData = @json($laporan_per_bulan); // Data per bulan
            const laporanWeekly = @json($laporan_per_minggu);
            const weeklyData = laporanWeekly.map(item => item.jumlah);
            const weeklyLabels = laporanWeekly.map(item => item.minggu);
            const laporanYearly = @json($laporan_per_tahun); // Data per tahun

            // Labels untuk setiap tipe chart
            const labelsMonth = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const labelsYear = Array.from({ length: 2029 - 2024 + 1 }, (_, i) => `${2024 + i}`); // Tahun 2024–2029

            // Fungsi untuk mendapatkan jumlah minggu dalam bulan tertentu
            function getWeeksInMonth(month, year) {
                const firstDay = new Date(year, month - 1, 1); // Tanggal pertama bulan
                const lastDay = new Date(year, month, 0); // Tanggal terakhir bulan

                // Menghitung minggu pertama
                const firstWeekDay = firstDay.getDay(); // Hari pertama bulan (0: Sunday, 1: Monday, etc.)
                const daysInMonth = lastDay.getDate();

                // Jika minggu pertama dimulai pada hari Minggu (0), kita anggap minggu pertama pada hari Senin
                const adjustedFirstDay = (firstWeekDay === 0 ? 7 : firstWeekDay) - 1;
                const daysToLastDay = daysInMonth + adjustedFirstDay;

                // Menghitung jumlah minggu
                const weeks = Math.ceil(daysToLastDay / 7); // Minggu dihitung dari total hari dibagi 7
                return weeks;
            }


            // Data laporan bulanan
            const dataMonthly = new Array(12).fill(0);
            laporanData.forEach(item => dataMonthly[item.bulan - 1] = item.jumlah);

            // Inisialisasi chart
            const ctx = document.getElementById('laporanChart').getContext('2d');
            const laporanChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labelsMonth, // Default labels: Bulanan
                    datasets: [
                        {
                            label: 'Monthly',
                            data: dataMonthly,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            hidden: false // Default: Tampil
                        },
                        {
                            label: 'Weekly',
                            data: [], // Akan diperbarui sesuai bulan
                            borderColor: 'rgba(192, 75, 192, 1)',
                            backgroundColor: 'rgba(192, 75, 192, 0.2)',
                            hidden: true // Default: Sembunyi
                        },
                        {
                            label: 'Yearly',
                            data: laporanYearly.map(item => item.jumlah),
                            borderColor: 'rgba(192, 192, 75, 1)',
                            backgroundColor: 'rgba(192, 192, 75, 0.2)',
                            hidden: true // Default: Sembunyi
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: { beginAtZero: true },
                        y: { beginAtZero: true }
                    }
                }
            });

            // Fungsi untuk memperbarui chart
            function updateChart(mode, month = null) {
                if (mode === 'monthly') {
                    // Data bulanan
                    laporanChart.data.labels = labelsMonth; // Label bulan
                    laporanChart.data.datasets[0].hidden = false; // Tampilkan data bulanan
                    laporanChart.data.datasets[1].hidden = true; // Sembunyikan data mingguan
                    laporanChart.data.datasets[2].hidden = true; // Sembunyikan data tahunan

                    // Perbarui data bulanan
                    const dataMonthly = new Array(12).fill(0);
                    laporanData.forEach(item => {
                        dataMonthly[item.bulan - 1] = item.jumlah; // Sesuaikan dengan bulan yang ada
                    });
                    laporanChart.data.datasets[0].data = dataMonthly;
                } else if (mode === 'weekly' && month) {
                    const year = new Date().getFullYear();
                    const weeks = getWeeksInMonth(month, year); // Mendapatkan jumlah minggu dalam bulan
                    const weekLabels = Array.from({ length: weeks }, (_, i) => `Week ${i + 1}`); // Label untuk minggu

                    // Memfilter data mingguan berdasarkan bulan
                    const filteredWeeklyData = laporanWeekly
                        .filter(item => {
                            // Mengambil tanggal mulai minggu
                            const weekStart = item.minggu.split(' - ')[0];
                            const weekDate = new Date(`${weekStart} ${year}`); // Membuat tanggal dari minggu
                            const weekMonth = weekDate.getMonth() + 1; // Menyusun bulan dari tanggal

                            // Hitung minggu berdasarkan tanggal
                            const dayOfMonth = weekDate.getDate();
                            const weekNumber = Math.ceil(dayOfMonth / 7); // Menghitung minggu berdasarkan hari dalam bulan

                            return weekMonth === month; // Cek apakah bulan cocok dengan filter
                        })
                        .map(item => item.jumlah); // Ambil hanya jumlah laporan dari item

                    // Memastikan data mingguan memiliki jumlah yang sama dengan jumlah minggu dalam bulan
                    const weeklyData = new Array(weeks).fill(0); // Inisialisasi dengan angka 0
                    filteredWeeklyData.forEach((jumlah, index) => {
                        weeklyData[index] = jumlah; // Menyimpan data mingguan sesuai urutan minggu
                    });

                    // Memperbarui data chart
                    laporanChart.data.labels = weekLabels; // Mengupdate label minggu
                    laporanChart.data.datasets[0].hidden = true; // Sembunyikan data bulanan
                    laporanChart.data.datasets[1].hidden = false; // Tampilkan data mingguan
                    laporanChart.data.datasets[1].data = weeklyData; // Update data minggu
                    laporanChart.data.datasets[2].hidden = true; // Sembunyikan data tahunan

                } else if (mode === 'yearly') {
                    // Data tahunan
                    laporanChart.data.labels = labelsYear; // Label tahun
                    laporanChart.data.datasets[0].hidden = true; // Sembunyikan data bulanan
                    laporanChart.data.datasets[1].hidden = true; // Sembunyikan data mingguan
                    laporanChart.data.datasets[2].hidden = false; // Tampilkan data tahunan

                    // Perbarui data tahunan
                    const dataYearly = new Array(labelsYear.length).fill(0);
                    laporanYearly.forEach(item => {
                        const yearIndex = labelsYear.indexOf(item.tahun.toString());
                        if (yearIndex !== -1) {
                            dataYearly[yearIndex] = item.jumlah; // Sesuaikan dengan tahun yang ada
                        }
                    });
                    laporanChart.data.datasets[2].data = dataYearly;
                }
                laporanChart.update();
            }



            // Event listener untuk dropdown chart mode
            document.getElementById('chartMode').addEventListener('change', function () {
                const mode = this.value;
                const filterContainer = document.getElementById('filterContainer');
                const filterMonth = document.getElementById('filterMonth');

                if (mode === 'weekly') {
                    filterContainer.style.display = 'block'; // Tampilkan filter bulan
                } else {
                    filterContainer.style.display = 'none'; // Sembunyikan filter bulan
                    filterMonth.value = ''; // Reset filter bulan
                    updateChart(mode);
                }
            });

            // Event listener untuk filter bulan
            document.getElementById('filterMonth').addEventListener('change', function () {
                const month = parseInt(this.value);
                if (!isNaN(month)) {
                    updateChart('weekly', month);
                }
            });


            document.getElementById('downloadChart').addEventListener('click', () => {
                try {
                    const { jsPDF } = window.jspdf; // Pastikan jsPDF diimpor
                    const pdf = new jsPDF('landscape'); // Inisialisasi dokumen PDF dengan orientasi landscape
                    const chartCanvas = document.getElementById('laporanChart'); // Ambil canvas chart
                    const chartImage = chartCanvas.toDataURL('image/png'); // Convert canvas ke gambar

                    if (!chartImage.startsWith('data:image/png')) {
                        alert("Gagal membuat gambar dari grafik!");
                        console.error("Data URL tidak valid:", chartImage);
                        return;
                    }

                    // Ambil mode chart dan bulan yang dipilih
                    const chartMode = document.getElementById('chartMode').value; // Mode chart
                    const filterMonth = document.getElementById('filterMonth').value; // Bulan yang dipilih
                    const currentDate = new Date();

                    // Tambahkan header PDF
                    pdf.setFont('Helvetica', 'bold');
                    pdf.setFontSize(16);
                    pdf.text('Laporan Chart', 10, 15);

                    pdf.setFont('Helvetica', 'normal');
                    pdf.setFontSize(12);
                    pdf.text(`Tanggal: ${currentDate.toLocaleDateString('id-ID')}`, 10, 25);

                    // Tambahkan deskripsi berdasarkan mode chart
                    let description = '';
                    if (chartMode === 'weekly') {
                        const monthName = filterMonth
                            ? new Date(currentDate.getFullYear(), filterMonth - 1, 1).toLocaleString('id-ID', { month: 'long' })
                            : 'Tidak Dipilih';
                        description = `Mode: Per Minggu\nBulan: ${monthName}`;
                    } else if (chartMode === 'monthly') {
                        description = 'Mode: Per Bulan';
                    } else if (chartMode === 'yearly') {
                        description = 'Mode: Per Tahun';
                    }

                    const descriptionLines = pdf.splitTextToSize(description, 280); // Bungkus teks agar sesuai dengan lebar PDF landscape
                    pdf.text(descriptionLines, 10, 35); // Tambahkan deskripsi pada PDF

                    // Tambahkan gambar chart
                    pdf.addImage(chartImage, 'PNG', 11, 70, 280, 100); // Posisi dan ukuran gambar diatur untuk landscape

                    // Simpan PDF
                    const filename = `Laporan_Chart_${chartMode}_${currentDate.getFullYear()}_${currentDate.getMonth() + 1}.pdf`;
                    pdf.save(filename);

                } catch (error) {
                    console.error("Error saat mengunduh PDF:", error);
                    alert("Terjadi kesalahan saat mengunduh PDF.");
                }
            });


        </script>
</body>
</html>