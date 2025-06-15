<?php
// File: logout.php
// Script ini bertugas untuk menghapus sesi login pengguna.

// 1. Selalu mulai session sebelum bisa memanipulasinya.
session_start();

// 2. Hapus semua variabel yang tersimpan di dalam session.
// Ini akan menghapus $_SESSION['user_id'], $_SESSION['username'], dll.
$_SESSION = array();

// 3. Hancurkan session itu sendiri.
session_destroy();

// 4. Alihkan (redirect) pengguna kembali ke halaman utama.
// exit() digunakan untuk memastikan tidak ada kode lain yang berjalan setelah redirect.
header("Location: index.php");
exit();
?>
