<?php
// File: delete_project.php
// Script ini hanya untuk memproses penghapusan data, tidak ada tampilan HTML.

session_start();
require 'db.php';

// Cek jika pengguna bukan admin atau tidak ada ID proyek, hentikan proses
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin'] || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$project_id = $_GET['id'];

// Gunakan prepared statement untuk keamanan
$stmt = $conn->prepare("DELETE FROM projects WHERE id = ?");
$stmt->bind_param("i", $project_id);

// Jalankan query
if ($stmt->execute()) {
    // Jika berhasil, bisa tambahkan pesan sukses ke session (opsional)
    $_SESSION['message'] = "Proyek berhasil dihapus!";
} else {
    // Jika gagal, bisa tambahkan pesan error ke session (opsional)
    $_SESSION['error'] = "Gagal menghapus proyek.";
}

$stmt->close();
$conn->close();

// Alihkan kembali ke halaman utama
header("Location: index.php#projects");
exit();
?>
