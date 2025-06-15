<?php
// File: add.php
// Halaman formulir untuk admin menambah proyek baru.

session_start();
require 'db.php';

// Cek jika pengguna bukan admin, alihkan (redirect) ke halaman utama.
// Ini adalah lapisan keamanan agar halaman ini tidak bisa diakses sembarang orang.
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit();
}

$error = '';
$success = '';

// Logika ini hanya berjalan jika admin menekan tombol "Simpan Proyek" (metode POST).
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $image_url = trim($_POST['image_url']);
    $description = trim($_POST['description']);

    // Validasi sederhana: pastikan tidak ada kolom yang kosong.
    if (empty($title) || empty($image_url) || empty($description)) {
        $error = "Semua kolom wajib diisi.";
    } else {
        // Gunakan prepared statement untuk memasukkan data dengan aman.
        $stmt = $conn->prepare("INSERT INTO projects (title, image_url, description) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $image_url, $description);

        if ($stmt->execute()) {
            $success = "Proyek baru berhasil ditambahkan! Anda akan dialihkan kembali ke halaman utama...";
            // Alihkan kembali ke halaman utama setelah 3 detik agar pesan sukses terbaca.
            header("refresh:3;url=index.php#projects");
        } else {
            $error = "Gagal menambahkan proyek. Silakan coba lagi.";
        }
        $stmt->close();
    }
    // Koneksi ditutup hanya jika ada proses POST
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Proyek Baru - Portfolio</title>
    <!-- Menggunakan Tailwind CSS agar konsisten -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .text-gradient { background-clip: text; -webkit-background-clip: text; color: transparent; background-image: linear-gradient(to right, #8B5CF6, #EC4899); }
    </style>
</head>
<body class="bg-gray-100">
    
    <?php include 'navbar.php'; // Memasukkan navbar yang sama dengan tema Tailwind ?>

    <main class="flex-grow container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-2xl p-8">
                <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Formulir Tambah Proyek</h2>
                
                <!-- Menampilkan pesan error atau sukses jika ada -->
                <?php if ($error): ?>
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <?php if ($success): ?>
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>

                <form action="add_project.php" method="post" class="space-y-5">
                    <div>
                        <label for="title" class="block font-medium text-gray-700 mb-2">Judul Proyek</label>
                        <input type="text" id="title" name="title" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    </div>
                    <div>
                        <label for="image_url" class="block font-medium text-gray-700 mb-2">URL Gambar</label>
                        <input type="url" id="image_url" name="image_url" placeholder="https://contoh.com/gambar.jpg" required
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    </div>
                    <div>
                        <label for="description" class="block font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea id="description" name="description" rows="4" required
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400"></textarea>
                    </div>
                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="w-full bg-purple-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-purple-700 transition-all">
                            Simpan Proyek
                        </button>
                        <a href="index.php#projects" class="w-full text-center bg-gray-200 text-gray-800 font-semibold px-6 py-3 rounded-lg hover:bg-gray-300 transition-all">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </main>

</body>
</html>
