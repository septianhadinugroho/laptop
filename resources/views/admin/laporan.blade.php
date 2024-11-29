<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>LAPTOP | Laporan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Icon Web -->
    <link rel="shortcut icon" href="images/iconlaptop.ico" type="image/x-icon">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- CSS Eksternal -->
    <link rel="stylesheet" href="css/admin/main.css">
    <link rel="stylesheet" href="css/admin/laporan.css">
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
            <li><a href="/laporan" class="active"><i class="bi bi-file-earmark-text"></i> Laporan</a></li>
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
                <a class="navbar-brand">Laporan</a>
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
            @if (session('success'))
            <div id="success-notification" class="alert alert-success">
                {{ session('success') }}
            </div>
            @elseif (session('error'))
                <div id="success-notification" class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <h4 class="text-center mb-4">Daftar Laporan</h4>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Update Status</th>
                            <th>Hapus Laporan</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody id="laporanTable">
                        @if ($pelaporan->isEmpty())
                            <tr>
                                <td colspan="7" class="text-center">Belum ada laporan yang tersedia.</td>
                            </tr>
                        @else
                        @foreach ($pelaporan as $laporan)
                        @php
                        $mediaItems = json_decode($laporan->media, true); // Decode media JSON to an array
                        @endphp
                        <tr>
                            <td>{{ $laporan->id }}</td>
                            <td>{{ $laporan->judul }}</td>
                            <td>{{ $laporan->deskripsi }}</td>
                            <td>
                                <span class="badge
                                    @if($laporan->status_id == 1) bg-danger
                                    @elseif($laporan->status_id == 2) bg-primary
                                    @else bg-success @endif">
                                    {{ $laporan->status->nama_status }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('laporan.updateStatus', $laporan->id) }}" method="POST">
                                    @csrf
                                    <select name="status_id" class="form-select form-select-sm">
                                        @foreach ($status as $stat)
                                            <option value="{{ $stat->id }}" {{ $stat->id == $laporan->status_id ? 'selected' : '' }}>
                                                {{ $stat->nama_status }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn-info btn-sm mt-2">Update</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('admin.deleteLaporan', $laporan->id) }}" method="GET">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="confirmDelete('{{ route('admin.deleteLaporan', $laporan->id) }}')">Hapus</button>
                                </form>
                            </td>
                            <td>
                                        <button class="btn btn-info btn-sm"
                                        data-laporan="{{ json_encode([
                                            'id' => $laporan->id,
                                            'judul' => $laporan->judul,
                                            'tanggal_laporan' => $laporan->tanggal_laporan,
                                            'jenis' => $laporan->jenis->name_jenis,
                                            'kategori' => $laporan->kategori->name,
                                            'lokasi' => $laporan->lokasi,
                                            'deskripsi' => $laporan->deskripsi,
                                            'media' => $laporan->media,
                                            'nama_pelapor' => $laporan->nama_pelapor
                                        ]) }}" onclick="showDetail(this)">Detail</button>
                            </td>
                        </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Laporan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nama Pelapor:</strong> <span id="modalNamaPelapor"></span></p>
                    <p><strong>Judul:</strong> <span id="modalJudul"></span></p>
                    <p><strong>Tanggal:</strong> <span id="modalTanggal"></span></p>
                    <p><strong>Jenis:</strong> <span id="modalJenis"></span></p>
                    <p><strong>Kategori:</strong> <span id="modalKategori"></span></p>
                    <p><strong>Lokasi:</strong> <span id="modalLokasi"></span></p>
                    <p><strong>Deskripsi:</strong> <span id="modalDeskripsi"></span></p>
                    <p><strong>File Media:</strong></p>
                    <div id="modalMedia" class="d-flex flex-wrap">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
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

    document.addEventListener("DOMContentLoaded", function () {
        const notification = document.getElementById("success-notification");
        if (notification) {
            // Timer untuk menghilangkan notifikasi setelah 3 detik
            setTimeout(() => {
                notification.style.transition = "opacity 0.5s ease";
                notification.style.opacity = "0"; // Buat transparan
                setTimeout(() => notification.remove(), 500); // Hapus elemen setelah animasi selesai
            }, 3000); // Waktu 3 detik
        }
    });

    function showDetail(button) {
    const laporan = JSON.parse(button.getAttribute('data-laporan')); // Ambil data dari atribut data-laporan

    // Mengisi konten modal dengan detail laporan
    console.log(laporan); // Periksa data laporan
    document.getElementById('modalNamaPelapor').textContent = laporan.nama_pelapor;
    document.getElementById('modalJudul').textContent = laporan.judul;
    document.getElementById('modalTanggal').textContent = laporan.tanggal_laporan;
    document.getElementById('modalJenis').textContent = laporan.jenis;
    document.getElementById('modalKategori').textContent = laporan.kategori;
    document.getElementById('modalLokasi').textContent = laporan.lokasi;
    document.getElementById('modalDeskripsi').textContent = laporan.deskripsi;

    const mediaContainer = document.getElementById('modalMedia');
    mediaContainer.innerHTML = ''; // Bersihkan media sebelumnya

    let mediaItems;
    try {
        mediaItems = JSON.parse(laporan.media); // Parsing JSON string media
    } catch (e) {
        mediaItems = [laporan.media]; // Jika media bukan JSON, asumsikan string tunggal
    }

        mediaItems.forEach(mediaItem => {
            const extension = mediaItem.split('.').pop().toLowerCase();
            const mediaPath = `{{ asset('storage') }}/${mediaItem}`;

            if (['jpg', 'jpe', 'jpeg', 'png', 'gif', 'svg', 'svgz'].includes(extension)) {
                const img = document.createElement('img');
                img.src = mediaPath;
                img.alt = 'Media Image';
                img.style.width = '450px';
                img.style.height = 'auto';
                img.style.margin = '5px';
                mediaContainer.appendChild(img);
            } else if (['mp4', 'f4v', 'flv', 'm4v', 'mov', 'mpe', 'mpeg', 'mpg', 'ogv', 'qt', 'swf', 'swfl', 'ts', 'webm', 'avi', 'mov', 'mkv', 'hevc'].includes(extension)) {
                const video = document.createElement('video');
                video.controls = true;
                video.style.width = '100%';
                video.style.height = 'auto';
                video.style.margin = '10px';

                const source = document.createElement('source');
                source.src = mediaPath;
                source.type = `video/${extension}`;
                video.appendChild(source);

                mediaContainer.appendChild(video);
            } else {
                // Jika media tidak didukung, tampilkan pesan error
                const warning = document.createElement('p');
                warning.textContent = 'Format media tidak didukung';
                warning.style.color = 'red';
                mediaContainer.appendChild(warning);
            }
        });

    // Tampilkan modal menggunakan Bootstrap
    new bootstrap.Modal(document.getElementById('detailModal')).show();
    // fungsi form delete
    function confirmDelete(deleteUrl) {
        // Atur action form ke URL penghapusan
        document.getElementById('deleteForm').action = deleteUrl;
        // Tampilkan modal konfirmasi
        const modal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
        modal.show();
    }

}

</script>
</body>
</html>