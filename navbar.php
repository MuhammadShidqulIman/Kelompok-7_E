<?php
// File: navbar.php
// Komponen navbar ini akan kita gunakan di semua halaman.

// Memulai session untuk memeriksa status login.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="w-full border-b border-gray-200 sticky top-0 bg-white/90 backdrop-blur-sm z-50 shadow-sm">
    <nav class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
        <a class="text-2xl font-bold text-gradient flex items-center gap-1 cursor-pointer" href="index.php">
            <span>My Portfolio</span><span class="text-purple-500">.</span>
        </a>
        
        <ul class="hidden md:flex items-center space-x-8 text-sm font-medium">
            <li><a href="index.php#home" class="nav-link hover:text-purple-600 transition">HOME</a></li>
            <li><a href="index.php#about" class="nav-link hover:text-purple-600 transition">ABOUT</a></li>
            <li><a href="index.php#projects" class="nav-link hover:text-purple-600 transition">PROJECTS</a></li>
            <li><a href="index.php#contact" class="nav-link hover:text-purple-600 transition">CONTACT</a></li>
        </ul>
        
        <!-- Bagian Tombol Autentikasi Dinamis dengan PHP -->
        <div class="flex items-center space-x-4">
            <?php if (isset($_SESSION['user_id'])) : ?>
                <span class="font-semibold text-gray-700 hidden md:block">Halo, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <a href="logout.php" class="bg-red-600 text-white font-semibold px-5 py-2.5 rounded-lg hover:bg-red-700 transition">
                    Logout
                </a>
            <?php else : ?>
                <a href="login.php" class="bg-purple-600 text-white font-semibold px-5 py-2.5 rounded-lg hover:bg-purple-700 transition">
                    Login
                </a>
                <a href="register.php" class="bg-purple-100 text-purple-700 font-semibold px-5 py-2.5 rounded-lg hover:bg-purple-200 transition">
                    Register
                </a>
            <?php endif; ?>
        </div>
    </nav>
</header>
