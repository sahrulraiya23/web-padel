<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Pemesanan Lapangan</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-light border-bottom">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between w-100">
                <img src="logo.png" alt="Logo" style="height: 40px; width: auto;">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Pemesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="riwayat.php">Riwayat</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-12 col-lg-10 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <h2 class="mb-4">Pemesanan Lapangan Padel</h2>

                        <?php
                        // Load konfigurasi dan functions
                        require_once 'config.php';
                        require_once 'functions.php';

                        $pesan = '';
                        $tipe_pesan = '';
                        $total_harga = 0;
                        $tampil_total = false;
                        $form_data = [];
                        $errors = [];

                        // Proses form submit
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                            $nama = trim($_POST['nama'] ?? '');
                            $nomor_hp = trim($_POST['nomor_hp'] ?? '');
                            $tanggal_sewa = trim($_POST['tanggal_sewa'] ?? '');
                            $jam_mulai = trim($_POST['jam_mulai'] ?? '');
                            $jam_selesai = trim($_POST['jam_selesai'] ?? '');

                            // Simpan data form untuk re-populate
                            $form_data = [
                                'nama' => $nama,
                                'nomor_hp' => $nomor_hp,
                                'tanggal_sewa' => $tanggal_sewa,
                                'jam_mulai' => $jam_mulai,
                                'jam_selesai' => $jam_selesai
                            ];

                            // Validasi input
                            $errors = validateInput($nama, $nomor_hp, $tanggal_sewa, $jam_mulai, $jam_selesai);

                            if (empty($errors)) {
                                // Hitung total
                                $total_harga = hitungTotal($tanggal_sewa, $jam_mulai, $jam_selesai);

                                // Simpan ke database
                                $result = savePemesanan($koneksi, $nama, $nomor_hp, $tanggal_sewa, $jam_mulai, $jam_selesai);

                                if ($result['status']) {
                                    $pesan = $result['message'];
                                    $tipe_pesan = 'success';
                                    $tampil_total = true;
                                    $form_data = []; // Kosongkan form
                                } else {
                                    $pesan = $result['message'];
                                    $tipe_pesan = 'danger';
                                }
                            }
                        }

                        // Tampilkan alert pesan
                        if ($pesan) {
                            echo '<div class="alert alert-' . htmlspecialchars($tipe_pesan) . ' alert-dismissible fade show" role="alert">
                                    ' . htmlspecialchars($pesan) . '
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>';
                        }

                        // Tampilkan error validasi
                        if (!empty($errors)) {
                            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>Terjadi Kesalahan:</strong>
                                    <ul class="mb-0 mt-2">';
                            foreach ($errors as $error) {
                                echo '<li>' . htmlspecialchars($error) . '</li>';
                            }
                            echo '</ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>';
                        }
                        ?>

                        <form action="" method="POST">
                            <div class="form-group mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama" value="<?php echo htmlspecialchars($form_data['nama'] ?? ''); ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="nomor_hp" class="form-label">Nomor HP</label>
                                <input type="tel" name="nomor_hp" id="nomor_hp" class="form-control" placeholder="Contoh: 08123456789" value="<?php echo htmlspecialchars($form_data['nomor_hp'] ?? ''); ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="tanggal_sewa" class="form-label">Tanggal Sewa</label>
                                <input type="date" name="tanggal_sewa" id="tanggal_sewa" class="form-control" value="<?php echo htmlspecialchars($form_data['tanggal_sewa'] ?? ''); ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                        <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="<?php echo htmlspecialchars($form_data['jam_mulai'] ?? ''); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                        <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="<?php echo htmlspecialchars($form_data['jam_selesai'] ?? ''); ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info small mb-3">
                                <strong>Tarif Weekday (Sen–Jum):</strong> Rp 350.000/jam<br>
                                <strong>Tarif Weekend (Sab–Min):</strong> Rp 500.000/jam
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-info">Submit</button>
                            </div>
                        </form>

                        <!-- Total Tagihan -->
                        <?php if ($tampil_total): ?>
                        <hr class="my-4">
                        <h5 class="mb-3">Total Tagihan</h5>
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <p class="mb-0"><strong>Total: <span class="text-success"><?php echo formatRupiah($total_harga); ?></span></strong></p>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


</body>

</html>