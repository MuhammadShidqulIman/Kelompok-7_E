<?php
// File: register.php
require 'db.php';
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $admin_code = isset($_POST['admin_code']) ? trim($_POST['admin_code']) : '';

    if (empty($username) || empty($password)) {
        $error = 'Username dan password tidak boleh kosong!';
    } elseif ($password !== $confirm_password) {
        $error = 'Password tidak cocok!';
    } else {
        $stmt_check = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt_check->bind_param("s", $username);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            $error = 'Username ini sudah terdaftar.';
        } else {
            $role = 'visitor';
            $ADMIN_SECRET_CODE = 'RAHASIA123'; // Ini adalah kode rahasia Anda

            if ($admin_code === $ADMIN_SECRET_CODE) {
                $role = 'admin';
            }
            
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt_insert = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
            $stmt_insert->bind_param("sss", $username, $hashed_password, $role);
            
            if ($stmt_insert->execute()) {
                $success = 'Registrasi berhasil! Silakan <a href="login.php" class="font-bold">login</a>.';
            } else {
                $error = 'Registrasi gagal, coba lagi.';
            }
            $stmt_insert->close();
        }
        $stmt_check->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - My Portfolio</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style> .text-gradient { background-clip: text; -webkit-background-clip: text; color: transparent; background-image: linear-gradient(to right, #8B5CF6, #EC4899); } </style>
</head>
<body class="bg-gray-100">
    <?php include 'navbar.php'; ?>
    <main class="flex-grow flex items-center justify-center py-12 px-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full p-8">
            <h2 class="text-3xl font-bold text-center text-gray-800">Create Account</h2>
            <?php if ($error): ?><div class="mt-4 bg-red-100 border-red-400 text-red-700 px-4 py-3 rounded"><?php echo $error; ?></div><?php endif; ?>
            <?php if ($success): ?><div class="mt-4 bg-green-100 border-green-400 text-green-700 px-4 py-3 rounded"><?php echo $success; ?></div><?php endif; ?>
            <form action="register.php" method="post" class="space-y-5 mt-6">
                <div>
                    <label for="username" class="block font-medium text-gray-700 mb-2">Username</label>
                    <input id="username" name="username" type="text" required class="w-full border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div>
                    <label for="password" class="block font-medium text-gray-700 mb-2">Password</label>
                    <input id="password" name="password" type="password" required class="w-full border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div>
                    <label for="confirm_password" class="block font-medium text-gray-700 mb-2">Confirm Password</label>
                    <input id="confirm_password" name="confirm_password" type="password" required class="w-full border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <div>
                    <label for="admin_code" class="block font-medium text-gray-700 mb-2">Admin Code (Optional)</label>
                    <input id="admin_code" name="admin_code" type="text" class="w-full border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                </div>
                <button type="submit" class="w-full bg-purple-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-purple-700">Register</button>
            </form>
        </div>
    </main>
</body>
</html>
