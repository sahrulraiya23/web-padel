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
                <div class="bg-danger text-white rounded p-2 fw-bold fs-5">P</div>
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
                        include 'koneksi.php';
                        
                        $query = "SELECT * FROM pemesanan ORDER BY id DESC";
                        $result = mysqli_query($koneksi, $query);
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
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $tanggal = new DateTime($row['tanggal_sewa']);
                                            $hari = $tanggal->format('N'); // 1=Senin, 7=Minggu
                                            
                                            $jam_mulai = new DateTime($row['jam_mulai']);
                                            $jam_selesai = new DateTime($row['jam_selesai']);
                                            $durasi = $jam_selesai->diff($jam_mulai)->h;
                                            
                                            // Tentukan tarif
                                            if ($hari >= 6) { // Weekend (Sabtu=6, Minggu=7)
                                                $tarif = 500000;
                                            } else {
                                                $tarif = 350000;
                                            }
                                            
                                            $total = $tarif * $durasi;
                                            
                                            echo '<tr>
                                                    <td>' . $row['id'] . '</td>
                                                    <td>' . htmlspecialchars($row['nama']) . '</td>
                                                    <td>' . htmlspecialchars($row['nomor_hp']) . '</td>
                                                    <td>' . date('d-m-Y', strtotime($row['tanggal_sewa'])) . '</td>
                                                    <td>' . $row['jam_mulai'] . '</td>
                                                    <td>' . $row['jam_selesai'] . '</td>
                                                    <td>Rp ' . number_format($total, 0, ',', '.') . '</td>
                                                    <td>' . date('d-m-Y H:i', strtotime($row['created_at'])) . '</td>
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
