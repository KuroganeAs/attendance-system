<?php
session_start();
require_once "config.php";

// Jika sudah login, lempar ke dashboard
if(isset($_SESSION['user'])) {
    header("Location: Dashboard/index.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Query mencari user berdasarkan username ATAU email
    $sql = "SELECT * FROM userss WHERE username = :username OR email = :username";
    $stmt = $db->prepare($sql);
    $stmt->execute([':username' => $username]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verifikasi Password
        if (password_verify($password, $user['password'])) {
            // Set Session
            $_SESSION['user'] = $user;
            // Redirect ke Dashboard
            header("Location: Dashboard/index.php");
            exit;
        } else {
            $error = "Password yang Anda masukkan salah.";
        }
    } else {
        $error = "Akun tidak ditemukan. Silakan daftar terlebih dahulu.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AttendanceSystem</title>
    
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
<body class="bg-gray-50 flex items-center justify-center min-h-screen py-12 px-4 sm:px-6 lg:px-8">

    <div class="max-w-md w-full space-y-8 bg-white p-10 rounded-2xl shadow-xl border border-gray-100">
        
        <!-- Header Login -->
        <div class="text-center">
            <div class="mx-auto h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 text-xl shadow-sm mb-4">
                <i class="fas fa-user-lock"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900">
                Admin Login
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Masuk untuk mengelola sistem absensi
            </p>
        </div>

        <!-- Alert Error -->
        <?php if ($error): ?>
            <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-md animate-pulse">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-500"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700 font-medium">
                            <?= $error ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Form Login -->
        <form class="mt-8 space-y-6" method="POST">
            <div class="space-y-4">
                
                <!-- Input Username/Email -->
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username / Email</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-400 sm:text-sm"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input id="username" name="username" type="text" required 
                            class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-200" 
                            placeholder="admin@example.com">
                    </div>
                </div>

                <!-- Input Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-400 sm:text-sm"><i class="fas fa-lock"></i></span>
                        </div>
                        <input id="password" name="password" type="password" required 
                            class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-200" 
                            placeholder="••••••••">
                    </div>
                </div>

            </div>

            <!-- Tombol Login -->
            <div>
                <button type="submit" name="login" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-md transition duration-200 transform hover:-translate-y-0.5">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt text-blue-500 group-hover:text-blue-400 transition"></i>
                    </span>
                    Masuk Sekarang
                </button>
            </div>

            <!-- Footer Link -->
            <div class="text-center text-sm">
                <p class="text-gray-600">
                    Belum punya akun admin? 
                    <a href="register.php" class="font-medium text-blue-600 hover:text-blue-500 transition underline">
                        Daftar di sini
                    </a>
                </p>
                <div class="mt-4">
                    <a href="index.php" class="text-gray-400 hover:text-gray-600 transition text-xs">
                        <i class="fas fa-arrow-left mr-1"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        </form>
    </div>

</body>
</html>