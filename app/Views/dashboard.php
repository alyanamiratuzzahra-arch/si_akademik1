<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - SI Akademik</title>
</head>
<body>
    <h2>Halaman Dashboard</h2>

    <?php
    if (session_status() === PHP_SESSION_NONE) session_start();

    // Tampilkan Alert Login Sukses (Flash Message)
    if (isset($_SESSION['flash_message'])) {
        echo "<p style='color: green; font-weight: bold;'>" . htmlspecialchars($_SESSION['flash_message']) . "</p>";
        unset($_SESSION['flash_message']);
    }
    ?>

    <p>Halo, Selamat Datang di Sistem Informasi Akademik!</p>
    <a href="/akademik1/public/mahasiswa">Kelola Data Mahasiswa</a> | 
    <a href="/akademik1/public/logout">Logout</a>
</body>
</html>