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
                <div class="bg-danger text-white rounded p-2 fw-bold fs-5">P</div>
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
                        include 'koneksi.php';
                        
                        $pesan = '';
                        $tipe_pesan = '';
                        $total_harga = 0;
                        $tampil_total = false;

                        if (isset($_POST['submit'])) {
                            $nama = $_POST['nama'] ?? '';
                            $nomor_hp = $_POST['nomor_hp'] ?? '';
                            $tanggal_sewa = $_POST['tanggal_sewa'] ?? '';
                            $jam_mulai = $_POST['jam_mulai'] ?? '';
                            $jam_selesai = $_POST['jam_selesai'] ?? '';

                            if ($nama && $nomor_hp && $tanggal_sewa && $jam_mulai && $jam_selesai) {
                                // Hitung total tagihan
                                $tanggal = new DateTime($tanggal_sewa);
                                $hari = $tanggal->format('N'); // 1=Senin, 7=Minggu

                                // Tentukan tarif
                                if ($hari >= 6) { // Weekend (Sabtu=6, Minggu=7)
                                    $tarif = 500000;
                                } else {
                                    $tarif = 350000;
                                }

                                // Hitung durasi
                                $jam_mulai_obj = new DateTime('2000-01-01 ' . $jam_mulai);
                                $jam_selesai_obj = new DateTime('2000-01-01 ' . $jam_selesai);
                                $durasi_menit = $jam_selesai_obj->diff($jam_mulai_obj)->i;
                                $durasi_jam = $jam_selesai_obj->diff($jam_mulai_obj)->h;
                                
                                // Jika ada sisa menit, bulatkan ke atas
                                if ($durasi_menit > 0) {
                                    $durasi_jam += 1;
                                }

                                if ($durasi_jam > 0) {
                                    $total_harga = $tarif * $durasi_jam;
                                    
                                    // Simpan ke database
                                    $query = "INSERT INTO pemesanan (nama, nomor_hp, tanggal_sewa, jam_mulai, jam_selesai) 
                                             VALUES ('$nama', '$nomor_hp', '$tanggal_sewa', '$jam_mulai', '$jam_selesai')";
                                    $sql = mysqli_query($koneksi, $query);
                                    
                                    if ($sql) {
                                        $pesan = "Pemesanan Berhasil Disimpan!";
                                        $tipe_pesan = "success";
                                        $tampil_total = true;
                                        // Kosongkan form
                                        $_POST = array();
                                    } else {
                                        $pesan = "Gagal Menyimpan Pemesanan: " . mysqli_error($koneksi);
                                        $tipe_pesan = "danger";
                                    }
                                } else {
                                    $pesan = "Jam selesai harus lebih besar dari jam mulai!";
                                    $tipe_pesan = "warning";
                                }
                            } else {
                                $pesan = "Semua field harus diisi!";
                                $tipe_pesan = "warning";
                            }
                        }

                        if ($pesan) {
                            echo '<div class="alert alert-' . $tipe_pesan . ' alert-dismissible fade show" role="alert">
                                    ' . $pesan . '
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                  </div>';
                        }
                        ?>

                        <form action="" method="post">
                            <div class="form-group mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan nama" value="<?php echo isset($_POST['nama']) ? htmlspecialchars($_POST['nama']) : ''; ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="nomor_hp" class="form-label">Nomor HP</label>
                                <input type="tel" name="nomor_hp" id="nomor_hp" class="form-control" placeholder="Contoh: 08123456789" value="<?php echo isset($_POST['nomor_hp']) ? htmlspecialchars($_POST['nomor_hp']) : ''; ?>" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="tanggal_sewa" class="form-label">Tanggal Sewa</label>
                                <input type="date" name="tanggal_sewa" id="tanggal_sewa" class="form-control" value="<?php echo isset($_POST['tanggal_sewa']) ? htmlspecialchars($_POST['tanggal_sewa']) : ''; ?>" required>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="jam_mulai" class="form-label">Jam Mulai</label>
                                        <input type="time" name="jam_mulai" id="jam_mulai" class="form-control" value="<?php echo isset($_POST['jam_mulai']) ? htmlspecialchars($_POST['jam_mulai']) : ''; ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="jam_selesai" class="form-label">Jam Selesai</label>
                                        <input type="time" name="jam_selesai" id="jam_selesai" class="form-control" value="<?php echo isset($_POST['jam_selesai']) ? htmlspecialchars($_POST['jam_selesai']) : ''; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="alert alert-info small mb-3">
                                <strong>Tarif Weekday (Sen–Jum):</strong> Rp 350.000/jam<br>
                                <strong>Tarif Weekend (Sab–Min):</strong> Rp 500.000/jam
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" name="submit" class="btn btn-info">Submit</button>
                            </div>
                        </form>

                        <!-- Total Tagihan -->
                        <?php if ($tampil_total): ?>
                        <hr class="my-4">
                        <h5 class="mb-3">Total Tagihan</h5>
                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <p class="mb-0"><strong>Total: <span class="text-success"><?php echo 'Rp ' . number_format($total_harga, 0, ',', '.'); ?></span></strong></p>
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