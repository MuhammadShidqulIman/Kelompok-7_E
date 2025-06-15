<?php
// File: db.php
// Pastikan semua pengaturan ini sudah benar.

$db_host = 'localhost';
$db_user = 'root';
$db_pass = ''; // Biarkan kosong jika tidak ada password.
$db_name = 'auth_navbar_db'; // Pastikan nama ini sama dengan di phpMyAdmin.

// Membuat koneksi
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
if ($conn->connect_error) {
    // Jika koneksi gagal, hentikan semua proses dan tampilkan pesan ini.
    // Ini membantu kita tahu jika masalahnya ada pada koneksi database.
    die("Koneksi Database GAGAL: " . $conn->connect_error);
}
?>
