# Sistem Pemesanan Lapangan Padel

Aplikasi web sederhana untuk pemesanan lapangan padel yang dibangun menggunakan PHP dan MySQL.

## Deskripsi
Sistem ini memungkinkan pengguna untuk:
- Melakukan pemesanan lapangan padel dengan menginputkan data pribadi dan waktu sewa
- Melihat riwayat pemesanan yang telah dibuat

## Struktur File
- `index.php` - Halaman utama untuk membuat pemesanan
- `riwayat.php` - Halaman untuk melihat riwayat pemesanan
- `koneksi.php` - File koneksi database MySQL

## Teknologi
- **Backend**: PHP
- **Database**: MySQL
- **Frontend**: HTML5, Bootstrap 5
- **Server**: Laragon

## Instalasi
1. Pastikan Laragon sudah berjalan
2. Copy folder project ke `c:\laragon\www\`
3. Buat database `db_pemesanan` di MySQL:
   ```sql
   CREATE DATABASE db_pemesanan;
   ```
4. Akses aplikasi di `http://localhost/sertifikasi/`

## Konfigurasi Database

Koneksi database sudah dikonfigurasi di `koneksi.php`:
- **Host**: localhost
- **Username**: root
- **Password**: (kosong)
- **Database**: db_pemesanan

## Fitur
- ✅ Form pemesanan lapangan
- ✅ Validasi data input
- ✅ Penyimpanan data ke database
- ✅ Halaman riwayat pemesanan
- ✅ UI responsif dengan Bootstrap


