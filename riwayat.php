<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Riwayat Pemesanan</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-light border-bottom">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between w-100">
                <img src="logo.png" alt="Logo" style="height: 40px; width: auto;">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Pemesanan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="riwayat.php">Riwayat</a>
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
                        <h2 class="mb-4">Riwayat Pemesanan</h2>
                        
                        <?php
                        // Load konfigurasi dan functions
                        require_once 'config.php';
                        require_once 'functions.php';
                        
                        // Ambil data pemesanan
                        $result = getPemesanans($koneksi);
                        $pemesanans = $result['data'];
                        ?>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-sm">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>HP</th>
                                        <th>Tanggal</th>
                                        <th>Mulai</th>
                                        <th>Selesai</th>
                                        <th>Total (Rp)</th>
                                        <th>Waktu Pesan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($pemesanans)) {
                                        foreach ($pemesanans as $row) {
                                            $total = hitungTotal($row['tanggal_sewa'], $row['jam_mulai'], $row['jam_selesai']);
                                            
                                            echo '<tr>
                                                    <td>' . htmlspecialchars($row['id']) . '</td>
                                                    <td>' . htmlspecialchars($row['nama']) . '</td>
                                                    <td>' . htmlspecialchars($row['nomor_hp']) . '</td>
                                                    <td>' . formatTanggal($row['tanggal_sewa']) . '</td>
                                                    <td>' . htmlspecialchars($row['jam_mulai']) . '</td>
                                                    <td>' . htmlspecialchars($row['jam_selesai']) . '</td>
                                                    <td>' . formatRupiah($total) . '</td>
                                                    <td>' . formatDateTime($row['created_at']) . '</td>
                                                  </tr>';
                                        }
                                    } else {
                                        echo '<tr>
                                                <td colspan="8" class="text-center text-muted">Belum ada pemesanan</td>
                                              </tr>';
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</body>

</html>
