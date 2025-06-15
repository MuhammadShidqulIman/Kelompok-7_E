<?php
// File: login.php (Lengkap dengan pengecekan role yang benar)

// Memulai sesi jika belum ada.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Jika pengguna sudah login, langsung alihkan ke halaman utama.
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require 'db.php';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ambil data user dari database, TERMASUK kolom 'role'.
    $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        // Verifikasi password.
        if (password_verify($password, $user['password'])) {
            // Jika login berhasil, simpan info dasar ke session.
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            
            // =======================================================
            // INI ADALAH LOGIKA YANG SUDAH DIPERBAIKI
            // Sekarang kita memeriksa isi dari kolom 'role'.
            if ($user['role'] === 'admin') {
                // Jika perannya 'admin', berikan status admin ke session.
                $_SESSION['is_admin'] = true;
            }
            // =======================================================
            
            // Alihkan ke halaman utama.
            header("Location: index.php");
            exit();
        } else {
            $error = 'Username atau password yang Anda masukkan salah.';
        }
    } else {
        $error = 'Username atau password yang Anda masukkan salah.';
    }
    $stmt->close();
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - My Portfolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style> .text-gradient { background-clip: text; -webkit-background-clip: text; color: transparent; background-image: linear-gradient(to right, #8B5CF6, #EC4899); } </style>
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>
    <main class="flex-grow flex items-center justify-center py-12 px-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-8">
            <h2 class="text-3xl font-bold text-center text-gray-800">Welcome Back</h2>
            <?php if ($error): ?><div class="mt-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded" role="alert"><?php echo $error; ?></div><?php endif; ?>
            <form action="login.php" method="post" class="space-y-5 mt-6">
                <div>
                    <label for="username" class="block font-medium text-gray-700 mb-2">Username</label>
                    <input id="username" name="username" type="text" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div>
                    <label for="password" class="block font-medium text-gray-700 mb-2">Password</label>
                    <input id="password" name="password" type="password" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <button type="submit" class="w-full bg-purple-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-purple-700 transition-all">Login</button>
            </form>
            <div class="mt-6 text-center text-sm text-gray-600">
                Belum punya akun? <a href="register.php" class="text-purple-600 font-medium">Daftar di sini</a>
            </div>
        </div>
    </main>
</body>
</html>
