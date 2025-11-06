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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Lightbox2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

    <!-- CSS Eksternal -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/voting.css">
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
    
    <!-- Awal Pelaporan -->
    <div class="container">
        <div class="form-container">
            <h2 class="text-center">Voting</h2>
            <h2 class="text-center">Kategori Berat</h2>

            <button type="button" class="btn-aturan" data-bs-toggle="modal" data-bs-target="#aturanModal">
                Peraturan Voting
            </button>
            
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
                                        <img src="{{ asset('storage/' . $media) }}" alt="Image" class="media-display">
                                    </a>
                                @elseif (in_array($extension, array_keys($mimeTypes)))
                                    <!-- Tampilkan video -->
                                    <<video controls class="media-display">
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

        <!-- Awal Modal Aturan Pelaporan -->
        <div class="modal fade" id="aturanModal" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header justify-content-center"> <!-- Tambahkan justify-content-center -->
                        <h5 class="modal-title" id="aturanModalLabel">Peraturan Voting</h5>
                    </div>
                    <div class="modal-body text-center">
                        <ol class="text-start">
                            <li>Setiap user dapat memberikan up-vote dan down-vote pada laporan dengan kategori berat.</li>
                            <li>Laporan kategori berat yang memiliki jumlah vote 0 tidak dapat di-down-vote.</li>
                            <li>Laporan kategori berat yang sudah selesai tidak akan ditampilkan di halaman voting.</li>
                        </ol>
                        <p><strong>Silahkan scroll sampai bawah untuk dapat melaporkan fasilitas.</strong></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Akhir Modal Aturan Pelaporan -->

    <!-- Notifikasi -->
    <div id="notification" class="notification"></div>

    <!-- Footer -->
    <footer class="fixed-bottom bg-light px-2" id="mainFooter">
        <nav class="d-flex justify-content-around" id="footerNav">
            <div class="nav-item text-center p-2">
                <a href="/voting" class="text-decoration-none active">
                    <i class="fas fa-up-down"></i><br />Voting
                </a>
            </div>
            <div class="nav-item text-center p-2">
                <a href="/history" class="text-decoration-none">
                    <i class="fas fa-history"></i><br />History
                </a>
            </div>
            <div id="emptyState" class="nav-item text-center p-2 lapor hidden">
                <a href="/lapor" class="text-decoration-none">
                    <i class="fas fa-bullhorn"></i><br />Lapor
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

    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

    <script src="js/script.js"></script>

    <!-- JS untuk Voting -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            setupVoting();
            setupSearch();
            setupScrollBehavior();
            checkEmptyState();
    
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
                                showNotification(data.message, data.success ? 'success' : 'error');
    
                                if (data.success) {
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
    
            function updateVoteCount(laporanId, netVotes) {
                const voteCountElement = document.getElementById(`vote-count-${laporanId}`);
                voteCountElement.innerText = netVotes;
            }
    
            function moveLaporanToCorrectPosition(laporanId, netVotes) {
                const laporanElement = document.querySelector(`[data-laporan-id="${laporanId}"]`).closest('.post-container');
                const laporanContainer = document.getElementById('postContainer');
                const laporanList = Array.from(laporanContainer.children);
    
                laporanElement.remove();
    
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
    
                        post.style.display = (title.includes(searchText) || description.includes(searchText) || location.includes(searchText)) ? '' : 'none';
                    });
                });
            }
    
            // Fungsi untuk Scroll Behavior
            function setupScrollBehavior() {
                let lastScrollTop = 0;
                const footerNav = document.querySelector('.lapor');
                const postContainer = document.getElementById('postContainer');

                window.addEventListener('scroll', () => {
                    const currentScroll = window.scrollY;
                    const containerBottom = postContainer.offsetHeight + postContainer.offsetTop;
                    const viewportBottom = window.innerHeight + currentScroll;

                    // Jika konten cukup tinggi untuk discroll
                    if (document.body.scrollHeight <= window.innerHeight) {
                        footerNav.classList.add('show');
                        footerNav.classList.remove('hidden');
                        return;
                    }

                    // Jika scroll ke bawah dan footer sudah mencapai bagian bawah
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

            // Fungsi untuk Cek Kondisi Laporan
            function checkEmptyState() {
                const postContainers = document.querySelectorAll('.post-container');
                const footerNav = document.querySelector('.lapor');

                // Jika tidak ada post container, tampilkan tombol lapor
                if (postContainers.length === 0) {
                    footerNav.classList.add('show');
                    footerNav.classList.remove('hidden');
                } else {
                    // Jika ada post container, cek apakah cukup tinggi untuk discroll
                    const contentHeight = document.body.scrollHeight;
                    const windowHeight = window.innerHeight;

                    // Jika tinggi konten kurang dari tinggi viewport (tidak bisa discroll), tampilkan tombol lapor
                    if (contentHeight <= windowHeight) {
                        footerNav.classList.add('show');
                        footerNav.classList.remove('hidden');
                    } else {
                        footerNav.classList.add('hidden');
                        footerNav.classList.remove('show');
                        setupScrollBehavior(); // Jalankan scroll behavior jika ada konten yang cukup tinggi untuk discroll
                    }
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
        });
    </script>    
</body>
</html>