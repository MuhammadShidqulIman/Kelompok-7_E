<?php
// File: index.php (Versi Final Lengkap)

// Memulai session untuk mengakses variabel $_SESSION.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Menghubungkan ke database.
require 'db.php';

// Pengecekan baru: Pastikan variabel $conn benar-benar ada.
if (!isset($conn) || $conn->connect_error) {
    die("<h1>Error Kritis</h1><p>Gagal memuat koneksi database dari 'db.php'. Pastikan file tersebut ada dan tidak memiliki error.</p>");
}

// Mengambil data proyek dari database.
$projects = [];
$projects_result = $conn->query("SELECT * FROM projects ORDER BY id DESC");
if ($projects_result && $projects_result->num_rows > 0) {
    while($row = $projects_result->fetch_assoc()) {
        $projects[] = $row;
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Hayabusa | Portofolio Developer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .text-gradient { background-clip: text; -webkit-background-clip: text; color: transparent; background-image: linear-gradient(to right, #8B5CF6, #EC4899); }
        html { scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 min-h-screen flex flex-col">
    
    <?php include 'navbar.php'; ?>

    <main class="flex-grow">
        <!-- Home Section -->
        <section id="home" class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center min-h-screen">
             <div class="md:w-1/2 mb-12 md:mb-0">
                <h3 class="text-xl font-medium text-gray-600 mb-2">Hello, I'm</h3>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gradient mb-4">Hayabusa</h1>
                <h2 class="text-2xl md:text-3xl font-semibold text-gray-700 mb-6">Frontend Developer</h2>
                <p class="text-gray-600 mb-8 max-w-lg leading-relaxed">
                    I craft exceptional digital experiences with modern web technologies. 
                    Passionate about creating beautiful, responsive, and user-friendly interfaces 
                    that make an impact.
                </p>
                <div class="mt-8 flex space-x-4">
                    <a href="#" class="social-icon text-gray-600 hover:text-purple-600 text-2xl"><i class="fab fa-github"></i></a>
                    <a href="#" class="social-icon text-gray-600 hover:text-purple-600 text-2xl"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="social-icon text-gray-600 hover:text-purple-600 text-2xl"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-icon text-gray-600 hover:text-purple-600 text-2xl"><i class="fab fa-instagram"></i></a>
                </div>
              </div>
              <div class="md:w-1/2 flex justify-center">
                <div class="w-80 h-80 rounded-full bg-purple-100 flex items-center justify-center overflow-hidden border-4 border-purple-200 shadow-lg">
                    <img src="assets/img/hayabusa.jpg" alt="Hayabusa" class="w-full h-full object-cover">
                </div>
              </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-6">
                <h1 class="text-3xl font-bold text-center mb-16 section-title text-purple-600">ABOUT ME</h1>
                <div class="flex flex-col lg:flex-row gap-12 items-center">
                    <div class="lg:w-1/3 flex justify-center">
                        <div class="w-64 h-64 rounded-2xl overflow-hidden shadow-xl">
                            <img src="assets/img/hayabusa.jpg" alt="Hayabusa" class="w-full h-full object-cover">
                        </div>
                    </div>
                    <div class="lg:w-2/3">
                        <h2 class="text-2xl font-bold mb-6 text-gradient">Who I Am</h2>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            I'm a passionate frontend developer with 5+ years of experience creating modern web applications. I specialize in React, Vue.js, and responsive design, with a keen eye for UI/UX details that make products stand out.
                        </p>
                        <p class="text-gray-600 mb-8 leading-relaxed">
                            My journey in web development started when I was 15, and since then I've worked with startups and established companies to bring their digital visions to life. I believe in writing clean, maintainable code and creating intuitive user experiences.
                        </p>
                        <div class="mb-8">
                            <h3 class="text-xl font-semibold mb-4 text-gray-700">My Skills</h3>
                            <div class="flex flex-wrap gap-3">
                                <span class="bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm font-medium">HTML5</span>
                                <span class="bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm font-medium">CSS3</span>
                                <span class="bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm font-medium">JavaScript</span>
                                <span class="bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm font-medium">PHP</span>
                                <span class="bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm font-medium">MySQL</span>
                                <span class="bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm font-medium">Tailwind CSS</span>
                                <span class="bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm font-medium">Bootstrap 5</span>
                                <span class="bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm font-medium">Git</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Projects Section -->
        <section id="projects" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-6">
                <h1 class="text-3xl font-bold text-center mb-4 section-title text-purple-600">MY PROJECTS</h1>
                <p class="text-center text-gray-600 mb-12">Beberapa karya yang pernah saya buat.</p>
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-xl font-semibold text-gray-700">Featured Work</h2>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) : ?>
                        <div>
                            <a href="add_project.php" class="bg-purple-600 text-white font-semibold px-6 py-3 rounded-lg hover:bg-purple-700 transition">
                                <i class="fas fa-plus mr-2"></i> Add Project
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php if (!empty($projects)) : ?>
                        <?php foreach ($projects as $project) : ?>
                            <div class="project-card bg-white rounded-lg overflow-hidden shadow-lg transform hover:-translate-y-2 transition-transform duration-300">
                                <div class="h-48 overflow-hidden">
                                    <img src="<?php echo htmlspecialchars($project['image_url']); ?>" alt="<?php echo htmlspecialchars($project['title']); ?>" class="w-full h-full object-cover">
                                </div>
                                <div class="p-6">
                                    <h3 class="text-xl font-bold mb-2"><?php echo htmlspecialchars($project['title']); ?></h3>
                                    <p class="text-gray-600 mb-4"><?php echo htmlspecialchars($project['description']); ?></p>
                                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) : ?>
                                        <div class="flex space-x-2 pt-2 border-t mt-4">
                                            <a href="edit.php?id=<?php echo $project['id']; ?>" class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-md text-sm font-medium">Edit</a>
                                            <a href="delete.php?id=<?php echo $project['id']; ?>" class="bg-red-100 text-red-800 px-3 py-1 rounded-md text-sm font-medium" onclick="return confirm('Anda yakin ingin menghapus proyek ini?');">Delete</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-600 col-span-3 text-center">Belum ada proyek yang ditambahkan. Silakan login sebagai admin untuk menambah proyek.</p>
                    <?php endif; ?>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-20 bg-white">
             <div class="max-w-7xl mx-auto px-6">
                <h1 class="text-3xl font-bold text-center mb-16 section-title text-purple-600">GET IN TOUCH</h1>
                <div class="flex flex-col lg:flex-row gap-12">
                    <div class="lg:w-1/2">
                        <h2 class="text-2xl font-bold mb-6 text-gradient">Contact Information</h2>
                        <p class="text-gray-600 mb-8 leading-relaxed">
                          Have a project in mind or want to discuss potential opportunities? 
                          Feel free to reach out to me through any of the channels below.
                        </p>
                        <div class="space-y-4">
                            <div class="flex items-start space-x-4">
                                <div class="text-purple-600 mt-1"><i class="fas fa-envelope"></i></div>
                                <div><h3 class="font-semibold text-gray-700">Email</h3><p class="text-gray-600">contact@hayabusa.dev</p></div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="text-purple-600 mt-1"><i class="fas fa-phone-alt"></i></div>
                                <div><h3 class="font-semibold text-gray-700">Phone</h3><p class="text-gray-600">+1 (123) 456-7890</p></div>
                            </div>
                            <div class="flex items-start space-x-4">
                                <div class="text-purple-600 mt-1"><i class="fas fa-map-marker-alt"></i></div>
                                <div><h3 class="font-semibold text-gray-700">Location</h3><p class="text-gray-600">Planet Mars</p></div>
                            </div>
                        </div>
                    </div>
                    <div class="lg:w-1/2">
                        <form action="#" method="POST" class="space-y-6 bg-gray-50 p-8 rounded-xl shadow-lg">
                            <div>
                                <label for="contact-name" class="block mb-2 font-medium text-gray-700">Your Name</label>
                                <input type="text" id="contact-name" name="name" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                            </div>
                            <div>
                                <label for="contact-email" class="block mb-2 font-medium text-gray-700">Email Address</label>
                                <input type="email" id="contact-email" name="email" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400">
                            </div>
                            <div>
                                <label for="contact-message" class="block mb-2 font-medium text-gray-700">Message</label>
                                <textarea id="contact-message" name="message" rows="5" required class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-purple-400"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-purple-600 text-white font-semibold px-8 py-3 rounded-lg hover:bg-purple-700 transition-all">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p>&copy; <?php echo date("Y"); ?> My Portfolio. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
