-- ============================================================
-- DATABASE SETUP - Sistem Pemesanan Lapangan Padel
-- File    : db_pemesanan.sql
-- Jalankan file ini di MySQL Workbench atau via terminal:
--   mysql -u root -p < db_pemesanan.sql
-- ============================================================

-- 1. Buat database
CREATE DATABASE IF NOT EXISTS db_pemesanan
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE db_pemesanan;

-- 2. Buat tabel pemesanan
CREATE TABLE IF NOT EXISTS tbl_pemesanan (
    id             INT(11)        NOT NULL AUTO_INCREMENT,
    nama           VARCHAR(100)   NOT NULL,
    nomor_hp       VARCHAR(20)    NOT NULL,
    tanggal_sewa   DATE           NOT NULL,
    jam_mulai      TIME           NOT NULL,
    jam_selesai    TIME           NOT NULL,
    total_tagihan  DECIMAL(12,0)  NOT NULL,
    waktu_pesan    DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 3. Data contoh untuk pengujian
--    Skenario 1: Kamis 14 Agustus 2025 (Weekday), 11:00-13:00 → 2 jam × Rp350.000 = Rp700.000
INSERT INTO tbl_pemesanan (nama, nomor_hp, tanggal_sewa, jam_mulai, jam_selesai, total_tagihan, waktu_pesan)
VALUES ('Jono', '12345', '2025-08-14', '11:00:00', '13:00:00', 700000, '2025-08-13 11:29:16');

--    Skenario 2: Sabtu 16 Agustus 2025 (Weekend), 18:00-20:00 → 2 jam × Rp500.000 = Rp1.000.000
INSERT INTO tbl_pemesanan (nama, nomor_hp, tanggal_sewa, jam_mulai, jam_selesai, total_tagihan, waktu_pesan)
VALUES ('Test', '12345', '2025-08-16', '18:00:00', '20:00:00', 1000000, '2025-08-12 16:13:46');

--    Skenario 3: Rabu 13 Agustus 2025 (Weekday), 13:00-16:00 → 3 jam × Rp350.000 = Rp1.125.000
INSERT INTO tbl_pemesanan (nama, nomor_hp, tanggal_sewa, jam_mulai, jam_selesai, total_tagihan, waktu_pesan)
VALUES ('Rizuka Ari', '08110000003', '2025-08-13', '13:00:00', '16:00:00', 1125000, '2025-08-13 11:00:00');

--    Skenario 4: Minggu 17 Agustus 2025 (Weekend), 09:00-11:30 → 2.5 jam × Rp500.000 = Rp1.250.000
INSERT INTO tbl_pemesanan (nama, nomor_hp, tanggal_sewa, jam_mulai, jam_selesai, total_tagihan, waktu_pesan)
VALUES ('Siti Marlina', '08134567899', '2025-08-17', '09:00:00', '11:30:00', 1250000, '2025-08-17 08:40:00');

-- 4. Verifikasi
SELECT * FROM tbl_pemesanan;
