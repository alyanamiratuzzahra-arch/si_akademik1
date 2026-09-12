# akademik1 — Setup

## 1. Taruh folder ini
Extract zip, taruh folder `akademik1` ke dalam `htdocs` (XAMPP) atau `www` (Laragon).
Boleh ditaruh langsung sebagai `htdocs/akademik1` — tidak perlu setting apa-apa lagi,
karena semua link sekarang otomatis menyesuaikan folder (fix utama dari bug 404 kemarin).

## 2. Import database
Buka phpMyAdmin, lalu import file `database.sql` yang ada di dalam folder ini.
Ini akan membuat database `si_akademik` beserta tabel `prodi`, `mahasiswa`, `matakuliah`
plus beberapa data contoh.

Kalau kredensial MySQL kamu bukan `root` tanpa password, sesuaikan di:
`config/database.php`

## 3. Akses aplikasi
Buka browser ke:
```
http://localhost/akademik1/public/
```

Login pakai:
- Username: `admin`
- Password: `admin123`

## Apa yang sudah dibetulkan
- Semua link sekarang pakai `base_url()` otomatis → tidak ada lagi 404 gara-gara
  path yang beda-beda antar file.
- `AuthController` dan router dirapikan supaya method-nya cocok.
- File yang tadinya kosong/corrupt (`AuthMiddleware`, `navbar`, `footer`,
  `mahasiswa/create.php`, `mahasiswa/edit.php`, `ProdiController`) sudah dibuat ulang.
- Halaman `/mahasiswa` sekarang lengkap: tombol **Tambah Mahasiswa**, form **pencarian**
  (NIM/nama, pakai prepared statement + LIKE), serta kolom **Aksi** berisi Edit
  (pindah halaman form edit) dan Hapus (popup konfirmasi lalu submit via POST,
  sesuai best practice di modul Acara 8 — tidak pakai GET untuk hapus).
- CRUD Prodi & Mata Kuliah ikut dilengkapi/dirapikan supaya konsisten.
