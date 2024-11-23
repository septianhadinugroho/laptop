<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lapor | Laporan Terintegrasi Online Platform</title>
    <link rel="shortcut icon" href="images/iconlaptop.ico" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/lapor.css">
</head>

<body>
    <!-- Notifikasi -->
    <div id="notification" class="notification"></div>
    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification(`{{ session('error') }}`, 'error');
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let errors = '';
                @foreach ($errors->all() as $error)
                    errors += `{{ $error }}\n`;
                @endforeach
                showNotification(errors, 'error');
            });
        </script>
    @endif
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                showNotification(`{{ session('success') }}`, 'success');
            });
        </script>
    @endif

    <div class="container">
        <div class="form-container">
            <button class="btn back-btn" onclick="window.location.href='/history'">
                <i class="fas fa-arrow-left"></i>
            </button>
                        
            <div id="notif" class="alert alert-success" role="alert" style="display: none;">
                <span class="checkmark">&#10003;</span> Laporan berhasil dikirim!
            </div>
            <h2>Formulir Laporan</h2>
            <button type="button" class="btn-aturan" data-bs-toggle="modal" data-bs-target="#aturanModal">
                Aturan Pelaporan
            </button>

            <!-- Formulir Laporan -->
            <form id="laporanForm" action="{{ route('lapor.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                <div class="mb-3">
                    <label for="nama_pelapor" class="form-label">Nama Pelapor</label>
                    <input type="text" class="form-control" id="nama_pelapor" value="{{ Auth::user()->name }}" readonly required>
                </div>
                <div class="mb-3">
                    <label for="judul" class="form-label">Judul</label>
                    <input type="text" class="form-control" name="judul" id="judul" required>
                </div>
                <div class="mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control" name="tanggal_laporan" id="tanggal" required>
                </div>
                <div class="mb-3">
                    <label for="jenis" class="form-label">Jenis</label>
                    <select class="form-select" name="jenis_id" id="jenis" required>
                        <option value="" disabled selected>Pilih laporan</option>
                        @foreach ($jenisList as $jenis)
                            <option value="{{ $jenis->id }}" data-kategori="{{ $jenis->kategori->name }}">
                                {{ $jenis->name_jenis }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-select" name="kategori_id" id="kategori" required>
                        <option value="" disabled selected></option>
                    </select>
                    <small class="form-text text-muted">
                        Kategori akan terisi otomatis saat memilih jenis laporan <br>
                    </small>
                </div>
                <div class="mb-3">
                    <label for="media" class="form-label">Gambar/Video</label>
                    <input type="file" class="form-control" name="media[]" id="media" accept="image/*,video/*" multiple>
                    <small class="form-text text-muted">
                        Accepted file types: <br>
                        Image files (.jpg, .jpeg, .png, .gif, .webp, .bmp) <br>
                        Video files (.mp4)
                    </small>
                </div>
                <div class="mb-3">
                    <label for="lokasi" class="form-label">Lokasi</label>
                    <input type="text" class="form-control" name="lokasi" id="lokasi" required>
                </div>
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" maxlength="110" required></textarea>
                    <small id="charCount" class="form-text text-muted">0/110 karakter</small>
                </div>                
                <button type="submit" class="btn btn-lapor w-100">Lapor</button>
            </form>
            {{-- penampilan media --}}
            @if(!empty($pelaporan->media))
                @foreach(json_decode($pelaporan->media) as $media)
                    @if(Str::endsWith($media, ['.jpg', '.jpeg', '.png']))
                        <img src="{{ asset('storage/' . $media) }}" alt="Media Image" style="max-width: 100%; height: auto;">
                    @elseif(Str::endsWith($media, ['.mp4', '.avi']))
                        <video controls style="max-width: 100%; height: auto;">
                            <source src="{{ asset('storage/' . $media) }}" type="video/{{ pathinfo($media, PATHINFO_EXTENSION) }}">
                            Your browser does not support the video tag.
                        </video>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
    <!-- Awal Modal Aturan Pelaporan -->
    <div class="modal fade" id="aturanModal" tabindex="-1" aria-labelledby="aturanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header justify-content-center"> <!-- Tambahkan justify-content-center -->
                    <h5 class="modal-title" id="aturanModalLabel">Aturan Pelaporan</h5>
                </div>
                <div class="modal-body text-center">
                    <p><strong>Pelaporan kategori berat hanya dapat dilaporkan setiap hari Kamis.</strong></p>
                    <p class="text-start"><strong>Kategori berat terdiri dari:</strong></p>
                    <ol class="text-start">
                        <li>Kabel LAN</li>
                        <li>AC Tidak Dingin</li>
                        <li>Keramik Lantai</li>
                        <li>Pintu Rusak</li>
                        <li>Kursi Rusak</li>
                        <li>Gorden Rusak</li>
                        <li>Colokan Tidak Berfungsi</li>
                        <li>Keran Kamar Mandi Tidak Berfungsi</li>
                        <li>Internet Tidak Lancar</li>
                        <li>Air Wastafel Kamar Mandi Tidak Berfungsi</li>
                        <li>Gantungan Kamar Mandi</li>
                        <li>Refill Galon</li>
                    </ol>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Akhir Modal Aturan Pelaporan -->

    <!-- Modal Ringkasan Laporan -->
    <div class="modal fade" id="laporanModal" tabindex="-1" aria-labelledby="laporanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="laporanModalLabel">Ringkasan Laporan</h5>
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
                    <p><strong>Media:</strong> <span id="modalMedia"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="confirmSubmit">Kirim Laporan</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal JS dan Function Lain -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisSelect = document.getElementById('jenis');
            const kategoriSelect = document.getElementById('kategori');
            const tanggalInput = document.getElementById('tanggal');
            const form = document.getElementById('laporanForm');


            // Filter awal: hanya tampilkan kategori "Ringan"
            for (let option of jenisSelect.options) {
                const kategori = option.getAttribute('data-kategori');
                if (kategori === 'Berat') {
                    option.style.display = 'none'; // Sembunyikan kategori "Berat"
                }
            }

            // Mengambil kategori berdasarkan jenis yang dipilih
            jenisSelect.addEventListener('change', function() {
                const jenisId = this.value;
                if (jenisId) {
                    fetch(`/getKategori/${jenisId}`)
                        .then(response => response.json())
                        .then(data => {
                            kategoriSelect.innerHTML = `<option value="${data.kategori_id}" selected>${data.kategori_name}</option>`;
                        })
                        .catch(error => console.error('Gagal mengambil kategori:', error));
                }
            });

            // Memastikan "Jenis" dengan kategori "Berat" hanya muncul pada hari Kamis
            tanggalInput.addEventListener('change', function() {
                const tanggal = new Date(this.value);
                const dayOfWeek = tanggal.getDay(); // 4 = Kamis

                // Loop through options in "jenis" select element
                for (let option of jenisSelect.options) {
                    const kategori = option.getAttribute('data-kategori');

                    // Tampilkan opsi hanya jika kategori adalah "Berat" dan hari adalah Kamis
                    if (kategori === 'Berat') {
                        option.style.display = (dayOfWeek === 4) ? 'block' : 'none';

                        // Jika opsi yang disembunyikan sedang dipilih, batalkan pemilihan dan reset kategori
                        if (dayOfWeek !== 4 && option.selected) {
                            option.selected = false;
                            kategoriSelect.innerHTML = `<option value="" disabled selected>Pilih kategori</option>`;
                        }
                    }
                }
            });

            // Menampilkan modal ringkasan laporan sebelum pengiriman form
            form.addEventListener('submit', function(event) {
                event.preventDefault(); // Mencegah pengiriman formulir

                // Ambil nilai dari formulir
                const namaPelapor = document.getElementById('nama_pelapor').value;
                const judul = document.getElementById('judul').value;
                const tanggal = document.getElementById('tanggal').value;
                const jenis = document.getElementById('jenis').options[document.getElementById('jenis').selectedIndex].text;
                const kategori = document.getElementById('kategori').options[document.getElementById('kategori').selectedIndex].text;
                const lokasi = document.getElementById('lokasi').value;
                const deskripsi = document.getElementById('deskripsi').value;
                const media = document.getElementById('media').files;

                // Set nilai-nilai ke elemen modal
                document.getElementById('modalNamaPelapor').innerText = namaPelapor;
                document.getElementById('modalJudul').innerText = judul;
                document.getElementById('modalTanggal').innerText = tanggal;
                document.getElementById('modalJenis').innerText = jenis;
                document.getElementById('modalKategori').innerText = kategori;
                document.getElementById('modalLokasi').innerText = lokasi;
                document.getElementById('modalDeskripsi').innerText = deskripsi;
                document.getElementById('modalMedia').innerText = media.length > 0 ? media[0].name : 'Tidak ada';

                // Tampilkan modal ringkasan laporan
                const laporanModal = new bootstrap.Modal(document.getElementById('laporanModal'));
                laporanModal.show();
            });

            // Mengonfirmasi pengiriman form ketika tombol "Kirim" dalam modal diklik
            document.getElementById('confirmSubmit').addEventListener('click', function() {
                form.submit();
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const deskripsiTextarea = document.getElementById('deskripsi');
            const charCount = document.getElementById('charCount');
            const maxChars = 110;

            // Update karakter secara real-time
            deskripsiTextarea.addEventListener('input', function () {
                const currentLength = deskripsiTextarea.value.length;

                // Update jumlah karakter
                charCount.textContent = `${currentLength}/${maxChars} karakter`;

                // Jika karakter melebihi batas, potong teks
                if (currentLength > maxChars) {
                    deskripsiTextarea.value = deskripsiTextarea.value.substring(0, maxChars);
                    charCount.textContent = `${maxChars}/${maxChars} karakter`;
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function () {
            const deskripsiTextarea = document.getElementById('deskripsi');
            const charCount = document.getElementById('charCount');
            const maxChars = 110;

            // Update karakter secara real-time
            deskripsiTextarea.addEventListener('input', function () {
                const currentLength = deskripsiTextarea.value.length;

                // Update jumlah karakter
                charCount.textContent = `${currentLength}/${maxChars} karakter`;

                // Jika karakter melebihi batas, potong teks
                if (currentLength > maxChars) {
                    deskripsiTextarea.value = deskripsiTextarea.value.substring(0, maxChars);
                    charCount.textContent = `${maxChars}/${maxChars} karakter`;
                }
            });
        });

        deskripsiTextarea.addEventListener('input', function () {
            const currentLength = deskripsiTextarea.value.length;

            // Update jumlah karakter
            charCount.textContent = `${currentLength}/${maxChars} karakter`;

            // Ubah warna teks jika mendekati batas
            if (currentLength >= maxChars * 0.8) {
                charCount.style.color = 'red';
            } else {
                charCount.style.color = 'gray';
            }

            // Jika karakter melebihi batas, potong teks
            if (currentLength > maxChars) {
                deskripsiTextarea.value = deskripsiTextarea.value.substring(0, maxChars);
                charCount.textContent = `${maxChars}/${maxChars} karakter`;
            }
        });

    </script>
</body>
</html>
