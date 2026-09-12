-- =====================================================
-- Skema database untuk project SI Akademik (akademik1)
-- Import file ini lewat phpMyAdmin atau:
--   mysql -u root -p < database.sql
-- =====================================================

CREATE DATABASE IF NOT EXISTS si_akademik
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE si_akademik;

-- Tabel Program Studi
CREATE TABLE IF NOT EXISTS prodi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

-- Tabel Mahasiswa
CREATE TABLE IF NOT EXISTS mahasiswa (
    nim VARCHAR(20) PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) DEFAULT NULL,
    prodi_id INT NOT NULL,
    angkatan INT NOT NULL,
    CONSTRAINT fk_mahasiswa_prodi
        FOREIGN KEY (prodi_id) REFERENCES prodi(id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB;

-- Tabel Mata Kuliah
CREATE TABLE IF NOT EXISTS matakuliah (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(20) NOT NULL UNIQUE,
    nama_mk VARCHAR(100) NOT NULL,
    sks INT NOT NULL DEFAULT 2
) ENGINE=InnoDB;

-- Data contoh Prodi
INSERT INTO prodi (nama) VALUES
    ('Teknik Informatika'),
    ('Sistem Informasi Bisnis'),
    ('Manajemen Informatika');

-- Data contoh Mahasiswa
INSERT INTO mahasiswa (nim, nama, email, prodi_id, angkatan) VALUES
    ('E1234356', 'Qonitatul Hasanah', 'qonitatul@example.com', 1, 2024),
    ('E1234357', 'Budi Santoso', 'budi@example.com', 2, 2023),
    ('E1234358', 'Siti Aminah', 'siti@example.com', 1, 2024);

-- Data contoh Mata Kuliah
INSERT INTO matakuliah (kode, nama_mk, sks) VALUES
    ('TIF330805', 'Workshop SI Web Server', 3),
    ('TIF330101', 'Basis Data', 3);
