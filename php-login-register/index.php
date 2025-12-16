<?php
session_start();

// LOGIKA REDIRECT:
// Jika admin sudah login, langsung lempar ke Dashboard.
if(isset($_SESSION["user"])) {
    header("Location: Dashboard/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal - AttendanceSystem</title>
    
    <!-- Tailwind CSS -->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <!-- Google Fonts (Inter) -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- NAVBAR SIMPLE -->
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <div class="bg-blue-600 text-white p-2 rounded-lg">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <span class="font-bold text-xl text-gray-900">Attendance<span class="text-blue-600">System</span></span>
                </div>
                
                <!-- Buttons -->
                <div class="flex items-center gap-4">
                    <a href="login.php" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition">
                        Login Admin
                    </a>
                    <a href="register.php" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 transition shadow-sm">
                        Registrasi Admin
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- HERO SECTION (ADMIN FOCUSED) -->
    <div class="bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="text-center max-w-3xl mx-auto">
                <span class="inline-block py-1 px-3 rounded-full bg-blue-50 text-blue-600 text-xs font-semibold tracking-wide uppercase mb-4 border border-blue-100">
                    Portal Administrator V1.0
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight mb-6">
                    Pusat Kontrol Absensi <br>
                    <span class="text-blue-600">& Data Mahasiswa.</span>
                </h1>
                <p class="text-lg text-gray-500 mb-8 leading-relaxed">
                    Platform khusus administrator untuk mengorganisir data kehadiran, mengelola database mahasiswa, dan memantau aktivitas absensi secara terpusat dan efisien.
                </p>
                <div class="flex justify-center gap-4">
                    <a href="login.php" class="px-8 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Masuk ke Dashboard
                    </a>
                    <a href="register.php" class="px-8 py-3 bg-white text-gray-700 font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition">
                        Daftar Admin Baru
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- FEATURES GRID (ADMIN FEATURES) -->
    <div class="py-16 bg-gray-50 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                
                <!-- Card 1 -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center text-blue-600 mb-4">
                        <i class="fas fa-users-cog"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Kelola Mahasiswa</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Tambah, edit, dan hapus data mahasiswa dengan mudah melalui panel kontrol administrator yang intuitif.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center text-green-600 mb-4">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Monitoring Real-time</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Pantau data kehadiran mahasiswa secara langsung untuk memastikan ketertiban dan akurasi data absensi.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center text-purple-600 mb-4">
                        <i class="fas fa-database"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Database Terpusat</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">
                        Penyimpanan data yang aman dan terorganisir, memudahkan admin dalam pencarian dan rekapitulasi data.
                    </p>
                </div>

            </div>
        </div>
    </div>

    <!-- FOOTER SIMPLE -->
    <footer class="bg-white py-8 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm text-gray-400">
                &copy; 2025 AttendanceSystem
            </p>
        </div>
    </footer>

</body>
</html>