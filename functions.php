<?php
/**
 * Helper Functions untuk Sistem Pemesanan Lapangan Padel
 */

/**
 * Menentukan tarif berdasarkan hari
 * Weekday (Sen-Jum) = 350.000
 * Weekend (Sab-Min) = 500.000
 */
function getTarif($tanggal_sewa) {
    $tanggal = new DateTime($tanggal_sewa);
    $hari = $tanggal->format('N'); // 1=Senin, 7=Minggu
    
    return ($hari >= 6) ? 500000 : 350000;
}

/**
 * Menghitung durasi dalam jam (dibulatkan ke atas)
 */
function hitungDurasi($jam_mulai, $jam_selesai) {
    $jam_mulai_obj = new DateTime('2000-01-01 ' . $jam_mulai);
    $jam_selesai_obj = new DateTime('2000-01-01 ' . $jam_selesai);
    $diff = $jam_selesai_obj->diff($jam_mulai_obj);
    
    $durasi_jam = $diff->h;
    $durasi_menit = $diff->i;
    
    // Bulatkan ke atas jika ada sisa menit
    if ($durasi_menit > 0) {
        $durasi_jam += 1;
    }
    
    return $durasi_jam;
}

/**
 * Menghitung total tagihan
 */
function hitungTotal($tanggal_sewa, $jam_mulai, $jam_selesai) {
    $tarif = getTarif($tanggal_sewa);
    $durasi = hitungDurasi($jam_mulai, $jam_selesai);
    return $tarif * $durasi;
}

/**
 * Validasi input form
 */
function validateInput($nama, $nomor_hp, $tanggal_sewa, $jam_mulai, $jam_selesai) {
    $errors = [];
    
    // Validasi nama
    if (empty($nama)) {
        $errors['nama'] = 'Nama tidak boleh kosong';
    } elseif (strlen($nama) < 3) {
        $errors['nama'] = 'Nama minimal 3 karakter';
    } elseif (strlen($nama) > 100) {
        $errors['nama'] = 'Nama maksimal 100 karakter';
    }
    
    // Validasi nomor HP
    if (empty($nomor_hp)) {
        $errors['nomor_hp'] = 'Nomor HP tidak boleh kosong';
    } elseif (!preg_match('/^0[0-9]{9,11}$/', $nomor_hp)) {
        $errors['nomor_hp'] = 'Nomor HP tidak valid (08xx-xx-xxx)';
    }
    
    // Validasi tanggal
    if (empty($tanggal_sewa)) {
        $errors['tanggal_sewa'] = 'Tanggal tidak boleh kosong';
    } else {
        $tanggal = DateTime::createFromFormat('Y-m-d', $tanggal_sewa);
        if (!$tanggal) {
            $errors['tanggal_sewa'] = 'Format tanggal tidak valid';
        } elseif ($tanggal < new DateTime('today')) {
            $errors['tanggal_sewa'] = 'Tanggal tidak boleh di masa lalu';
        }
    }
    
    // Validasi jam mulai
    if (empty($jam_mulai)) {
        $errors['jam_mulai'] = 'Jam mulai tidak boleh kosong';
    }
    
    // Validasi jam selesai
    if (empty($jam_selesai)) {
        $errors['jam_selesai'] = 'Jam selesai tidak boleh kosong';
    }
    
    // Validasi durasi
    if (!empty($jam_mulai) && !empty($jam_selesai)) {
        $durasi = hitungDurasi($jam_mulai, $jam_selesai);
        if ($durasi <= 0) {
            $errors['jam_selesai'] = 'Jam selesai harus lebih besar dari jam mulai';
        }
    }
    
    return $errors;
}

/**
 * Menyimpan data pemesanan ke database
 */
function savePemesanan($koneksi, $nama, $nomor_hp, $tanggal_sewa, $jam_mulai, $jam_selesai) {
    $stmt = $koneksi->prepare("INSERT INTO pemesanan (nama, nomor_hp, tanggal_sewa, jam_mulai, jam_selesai) VALUES (?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        return ['status' => false, 'message' => 'Error preparing statement: ' . $koneksi->error];
    }
    
    $stmt->bind_param("sssss", $nama, $nomor_hp, $tanggal_sewa, $jam_mulai, $jam_selesai);
    
    if ($stmt->execute()) {
        $stmt->close();
        return ['status' => true, 'message' => 'Pemesanan berhasil disimpan'];
    } else {
        $stmt->close();
        return ['status' => false, 'message' => 'Error executing statement: ' . $koneksi->error];
    }
}

/**
 * Mengambil semua data pemesanan dari database
 */
function getPemesanans($koneksi) {
    $query = "SELECT * FROM pemesanan ORDER BY id DESC";
    $result = $koneksi->query($query);
    
    if (!$result) {
        return ['status' => false, 'message' => 'Error: ' . $koneksi->error, 'data' => []];
    }
    
    $pemesanans = [];
    while ($row = $result->fetch_assoc()) {
        $pemesanans[] = $row;
    }
    
    return ['status' => true, 'data' => $pemesanans];
}

/**
 * Format rupiah
 */
function formatRupiah($nominal) {
    return 'Rp ' . number_format($nominal, 0, ',', '.');
}

/**
 * Format tanggal Indonesia
 */
function formatTanggal($tanggal) {
    return date('d-m-Y', strtotime($tanggal));
}

/**
 * Format datetime Indonesia
 */
function formatDateTime($datetime) {
    return date('d-m-Y H:i', strtotime($datetime));
}

?>
