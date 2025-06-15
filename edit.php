<?php
// File: edit_project.php
// Halaman formulir untuk admin mengedit proyek yang sudah ada.

session_start();
require 'db.php';

// Cek jika pengguna bukan admin atau tidak ada ID proyek di URL, alihkan
if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin'] || !isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$project_id = intval($_GET['id']); // Ambil ID dari URL dan pastikan itu angka
$error = '';
$success = '';

// Logika jika form disubmit (metode POST) untuk menyimpan perubahan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST['title']);
    $image_url = trim($_POST['image_url']);
    $description = trim($_POST['description']);

    if (empty($title) || empty($image_url) || empty($description)) {
        $error = "Semua kolom wajib diisi.";
    } else {
        $stmt = $conn->prepare("UPDATE projects SET title = ?, image_url = ?, description = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $image_url, $description, $project_id);

        if ($stmt->execute()) {
            $success = "Proyek berhasil diupdate! Anda akan dialihkan...";
            header("refresh:3;url=index.php#projects");
        } else {
            $error = "Gagal mengupdate proyek.";
        }
        $stmt->close();
    }
}

// Mengambil data proyek yang akan di-edit dari database untuk ditampilkan di form
$stmt_select = $conn->prepare("SELECT * FROM projects WHERE id = ?");
$stmt_select->bind_param("i", $project_id);
$stmt_select->execute();
$result = $stmt_select->get_result();
if ($result->num_rows === 1) {
    $project = $result->fetch_assoc();
} else {
    // Jika proyek dengan ID tersebut tidak ditemukan, kembali ke halaman utama
    header("Location: index.php");
    exit();
}
$stmt_select->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Proyek - Portfolio</title>
    <!-- Menggunakan Tailwind CSS agar konsisten -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .text-gradient { background-clip: text; -webkit-background-clip: text; color: transparent; background-image: linear-gradient(to right, #8B5CF6, #EC4899); }
    </style>
</head>
<body class="bg-gray-100">
    
    <?php include 'navbar.php'; // Memasukkan navbar yang sama ?>

    <main class="flex-grow container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-xl shadow-2xl p-8">
                <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">Edit Proyek</h2>
                
                <?php if ($error): ?><div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert"><?php echo $error; ?></div><?php endif; ?>
                <?php if ($success): ?><div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert"><?php echo $success; ?></div><?php endif; ?>

                <form action="edit.php?id=<?php echo $project['id']; ?>" method="post" class="space-y-5">
                    <div>
                        <label for="title" class="block font-medium text-gray-700 mb-2">Judul Proyek</label>
                        <input type="text" id="title" name="title" required value="<?php echo htmlspecialchars($project['title']); ?>"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    </div>
                    <div>
                        <label for="image_url" class="block font-medium text-gray-700 mb-2">URL Gambar</label>
                        <input type="url" id="image_url" name="image_url" placeholder="https://contoh.com/gambar.jpg" required value="<?php echo htmlspecialchars($project['image_url']); ?>"
                               class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                    </div>
                    <div>
                        <label for="description" class="block font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea id="description" name="description" rows="4" required
                                  class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400"><?php echo htmlspecialchars($project['description']); ?></textarea>
                    </div>
                    <div class="flex items-center gap-4 pt-2">
                        <button type="submit" class="w-full bg-purple-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-purple-700 transition-all">
                            Update Proyek
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
