# Sistem Pemesanan Lapangan Padel

Aplikasi web untuk pemesanan lapangan padel dibangun dengan PHP dan MySQL.

## Fitur
- ✅ Form pemesanan lapangan
- ✅ Validasi input lengkap
- ✅ Riwayat pemesanan
- ✅ UI responsif dengan Bootstrap

## Struktur File
- `index.php` - Halaman pemesanan
- `riwayat.php` - Halaman riwayat
- `config.php` - Konfigurasi database
- `functions.php` - Fungsi-fungsi bisnis
- `index.html` / `riwayat.html` - Template static

## Instalasi
1. Buat database: `CREATE DATABASE db_pemesanan;`
2. Copy folder ke `c:\laragon\www\`
3. Akses: `http://localhost/sertifikasi/`

## Teknologi
- PHP 7+
- MySQL
- Bootstrap 5
- Laragon

## Setup Database
- Host: localhost
- Username: root
- Password: (kosong)
- Database: db_pemesanan
- Tabel otomatis dibuat saat pertama kali dijalankan

## Catatan
- Tarif weekday (Sen-Jum): Rp 350.000/jam
- Tarif weekend (Sab-Min): Rp 500.000/jam
- Format HP: 08xx-xxx-xxxx
- Durasi dibulatkan ke atas jika ada sisa menit
