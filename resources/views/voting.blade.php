<!DOCTYPE html>
<html lang="id">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting | Laporan Terintegrasi Online Platform</title>

    <!-- Icon Web -->
    <link rel="shortcut icon" href="images/iconlaptop.ico" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Lightbox2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

    <!-- CSS Eksternal -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/voting.css">
</head>
<body>

    <!-- Header -->
    <header class="text-align p-2">
        <div class="welcome-banner">
            <h1>Selamat datang, <span class="username">{{ $user->name }}</span></h1>
        </div>
    </header>

    <!-- Awal Pelaporan -->
    <div class="container">
        <div class="form-container">
            <h2 class="text-center">Voting</h2>
            <h2 class="text-center">Kategori Berat</h2>
            
            <!-- Input Pencarian -->
            <div class="search-bar mb-4">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari laporan...">
            </div>

            <div id="postContainer">
                @foreach ($laporanBerat as $laporan) <!-- Pastikan ini adalah koleksi laporan, bukan koleksi media -->
                @php
                    // Cek jika media berupa string JSON, baru lakukan json_decode
                    $mediaFiles = is_string($laporan->media) ? json_decode($laporan->media) : $laporan->media;

                    // Pastikan mediaFiles adalah array, jika tidak, set ke array kosong
                    $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [];
                @endphp

                    <div class="post-container">
                        <h3>{{ $laporan->judul }}</h3>
                        <p><strong>Tanggal:</strong> {{ $laporan->tanggal_laporan }}</p>
                        <p><strong>Lokasi:</strong> {{ $laporan->lokasi }}</p>
                        <p><strong>Deskripsi:</strong> {{ $laporan->deskripsi }}</p>

                        <!-- Kontainer Media -->
                        <div class="media-container">
                            <!-- Tampilkan setiap media -->
                            @foreach ($mediaFiles as $media)
                                @php
                                    $extension = pathinfo($media, PATHINFO_EXTENSION);
                                    $mimeTypes = [
                                        'mp4' => 'video/mp4',
                                        'f4v' => 'video/x-f4v',
                                        'flv' => 'video/x-flv',
                                        'm4v' => 'video/x-m4v',
                                        'mov' => 'video/quicktime',
                                        'mpe' => 'video/mpeg',
                                        'mpeg' => 'video/mpeg',
                                        'mpg' => 'video/mpeg',
                                        'ogv' => 'video/ogg',
                                        'qt' => 'video/quicktime',
                                        'swf' => 'application/x-shockwave-flash',
                                        'swfl' => 'application/x-shockwave-flash',
                                        'ts' => 'video/MP2T',
                                        'webm' => 'video/webm',
                                        'avi' => 'video/x-msvideo',
                                        'mkv' => 'video/x-matroska',
                                        'hevc' => 'video/mp4'
                                    ];
                        
                                    // Periksa apakah file adalah gambar
                                    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp']);
                                @endphp
                        
                                @if ($isImage)
                                    <!-- Gunakan Lightbox2 untuk gambar -->
                                    <a href="{{ asset('storage/' . $media) }}" data-lightbox="laporan-images" data-title="{{ $laporan->judul }}">
                                        <img src="{{ asset('storage/' . $media) }}" alt="Image" style="width: 1000px; margin: 5px; cursor: pointer; border-radius: 5px; margin-bottom: 20px;">
                                    </a>
                                @elseif (in_array($extension, array_keys($mimeTypes)))
                                    <!-- Tampilkan video -->
                                    <video controls style="width: 100%; margin: 10px 0; border-radius: 5px;">
                                        <source src="{{ asset('storage/' . $media) }}" type="{{ $mimeTypes[$extension] }}">
                                        Your browser does not support the video tag.
                                    </video>
                                @else
                                    <!-- Jika format file tidak dikenali -->
                                    <p>File tidak dikenali: {{ $media }}</p>
                                @endif
                            @endforeach
                        </div>
                        
                        <!-- Kontainer Vote -->
                        <div class="vote-container">
                            <button class="vote-btn" data-vote="up" data-laporan-id="{{ $laporan->id }}">
                                <i class="fas fa-arrow-up"></i>
                            </button>
                            <span class="vote-count" id="vote-count-{{ $laporan->id }}">
                                {{ $laporan->up_vote_count - $laporan->down_vote_count }}
                            </span>
                            <button class="vote-btn" data-vote="down" data-laporan-id="{{ $laporan->id }}">
                                <i class="fas fa-arrow-down"></i>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    <div id="notification" class="notification"></div>

    <!-- Footer -->
    <footer class="fixed-bottom bg-light px-2" id="mainFooter">
        <nav class="d-flex justify-content-around" id="footerNav">
            <div class="nav-item text-center p-2">
                <a href="/voting" class="text-dark text-decoration-none">
                    <i class="fas fa-up-down"></i><br />Voting
                </a>
            </div>
            <div class="nav-item text-center p-2">
                <a href="/history" class="text-dark text-decoration-none">
                    <i class="fas fa-history"></i><br />History
                </a>
            </div>
            <div id="emptyState" class="nav-item text-center p-2 lapor hidden">
                <a href="/lapor" class="text-dark text-decoration-none">
                    <i class="fas fa-bullhorn"></i><br />Lapor
                </a>
            </div>
            <div class="nav-item text-center p-2">
                <a href="/about" class="text-dark text-decoration-none">
                    <i class="fas fa-info"></i><br />About
                </a>
            </div>
            <div class="nav-item text-center p-2">
                <a href="/akun" class="text-dark text-decoration-none">
                    <i class="fas fa-user"></i><br />Akun
                </a>
            </div>
        </nav>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <!-- JS Eksternal -->
    <script src="js/script.js"></script>

    <!-- JS untuk Voting -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setupVoting();
            setupSearch();
            setupScrollBehavior();
            checkEmptyState(); 
        });

        // Fungsi untuk Voting
        function setupVoting() {
            document.querySelectorAll('.vote-btn').forEach(button => {
                button.addEventListener('click', function () {
                    const voteType = this.dataset.vote;
                    const laporanId = this.dataset.laporanId;

                    fetch(`/vote/${laporanId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        },
                        body: JSON.stringify({ change: voteType }),
                    })
                        .then(response => response.json())
                        .then(data => {
                            // Tampilkan notifikasi langsung dari pesan backend
                            showNotification(data.message, data.success ? 'success' : 'error');

                            if (data.success) {
                                // Update tampilan jumlah vote dan posisi laporan
                                updateVoteCount(laporanId, data.netVotes);
                                moveLaporanToCorrectPosition(laporanId, data.netVotes);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showNotification('Terjadi kesalahan pada sistem.', 'error');
                        });
                });
            });
        }

        // Fungsi untuk Memperbarui Jumlah Vote
        function updateVoteCount(laporanId, netVotes) {
            const voteCountElement = document.getElementById(`vote-count-${laporanId}`);
            voteCountElement.innerText = netVotes;
        }

        // Fungsi untuk Memindahkan Laporan Berdasarkan Jumlah Vote
        function moveLaporanToCorrectPosition(laporanId, netVotes) {
            const laporanElement = document.querySelector(`[data-laporan-id="${laporanId}"]`).closest('.post-container');
            const laporanContainer = document.getElementById('postContainer');
            const laporanList = Array.from(laporanContainer.children);

            // Hapus elemen sementara
            laporanElement.remove();

            // Cari posisi baru
            const insertIndex = laporanList.findIndex(el => parseInt(el.querySelector('.vote-count').innerText) < netVotes);
            laporanContainer.insertBefore(laporanElement, laporanList[insertIndex] || null);
        }

        // Fungsi untuk Pencarian
        function setupSearch() {
            const searchInput = document.getElementById('searchInput');
            const postContainers = document.querySelectorAll('.post-container');

            searchInput.addEventListener('input', function () {
                const searchText = this.value.toLowerCase();

                postContainers.forEach(post => {
                    const title = post.querySelector('h3').textContent.toLowerCase();
                    const description = post.querySelector('p:nth-of-type(3)').textContent.toLowerCase();
                    const location = post.querySelector('p:nth-of-type(2)').textContent.toLowerCase();

                    if (title.includes(searchText) || description.includes(searchText) || location.includes(searchText)) {
                        post.style.display = ''; // Tampilkan elemen
                    } else {
                        post.style.display = 'none'; // Sembunyikan elemen
                    }
                });
            });
        }

        // Fungsi untuk Scroll Behavior
        function setupScrollBehavior() {
            let lastScrollTop = 0;
            const footerNav = document.querySelector('.lapor');
            const postContainer = document.getElementById('postContainer');

            // Cek apakah halaman bisa di-scroll
            const isScrollable = document.body.scrollHeight > window.innerHeight;

            window.addEventListener('scroll', () => {
                const currentScroll = window.scrollY;
                const containerBottom = postContainer.offsetHeight + postContainer.offsetTop;
                const viewportBottom = window.innerHeight + currentScroll;

                // Jika halaman tidak scrollable (laporan kosong)
                if (!isScrollable) {
                    footerNav.classList.add('show');
                    footerNav.classList.remove('hidden');
                    return;
                }

                // Jika halaman scrollable, tampilkan tombol Lapor saat scroll ke bawah
                if (currentScroll > lastScrollTop && viewportBottom >= containerBottom) {
                    footerNav.classList.add('show');
                    footerNav.classList.remove('hidden');
                } else if (currentScroll < lastScrollTop) {
                    footerNav.classList.add('hidden');
                    footerNav.classList.remove('show');
                }

                lastScrollTop = currentScroll;
            });
        }

        // Fungsi untuk cek kondisi laporan
        function checkEmptyState() {
            const postContainers = document.querySelectorAll('.post-container');
            const footerNav = document.querySelector('.lapor');

            if (postContainers.length === 0) {
                footerNav.classList.add('show');
                footerNav.classList.remove('hidden');
            } else {
                footerNav.classList.add('hidden');
                footerNav.classList.remove('show');
                setupScrollBehavior(); // Pastikan fungsi scroll behavior diinisialisasi ulang
            }
        }

        // Fungsi untuk Menampilkan Notifikasi
        function showNotification(message, type = 'success') {
            const notification = document.getElementById('notification');
            notification.innerText = message;

            notification.classList.remove('success', 'error');
            notification.classList.add(type, 'show');

            setTimeout(() => {
                notification.classList.remove('show');
            }, 5000);
        }
    </script>
</body>
</html>