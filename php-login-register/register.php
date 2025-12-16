<?php
session_start();
// Aktifkan error reporting untuk debugging jika perlu
error_reporting(E_ALL);
ini_set('display_errors', 0); // Matikan tampilan error kasar ke user

require_once("config.php");

// Jika sudah login, lempar ke dashboard
if(isset($_SESSION['user'])) {
    header("Location: Dashboard/index.php");
    exit;
}

$error = "";
$success = "";

if (isset($_POST['register'])) {

    $name     = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    // Validasi Sederhana
    if (empty($name) || empty($username) || empty($email) || empty($password)) {
        $error = "Semua kolom wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Format email tidak valid.";
    } elseif (strlen($password) < 4) {
        $error = "Password minimal 4 karakter.";
    } else {
        try {
            // Cek apakah username/email sudah ada
            $check = $db->prepare("SELECT id FROM userss WHERE username = ? OR email = ?");
            $check->execute([$username, $email]);
            
            if($check->rowCount() > 0){
                $error = "Username atau Email sudah terdaftar.";
            } else {
                // Hash Password & Insert
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO userss (name, username, email, password) VALUES (:name, :username, :email, :password)";
                $stmt = $db->prepare($sql);
                $saved = $stmt->execute([
                    ':name'     => $name,
                    ':username' => $username,
                    ':email'    => $email,
                    ':password' => $hash
                ]);

                if ($saved) {
                    // Redirect ke login setelah sukses
                    echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location.href='login.php';</script>";
                    exit;
                }
            }
        } catch (PDOException $e) {
            $error = "Terjadi kesalahan sistem: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - AttendanceSystem</title>
    
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
        
        <!-- Header Register -->
        <div class="text-center">
            <div class="mx-auto h-12 w-12 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 text-xl shadow-sm mb-4">
                <i class="fas fa-user-plus"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900">
                Daftar Admin Baru
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Buat akun untuk mulai mengelola sistem.
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

        <!-- Form Register -->
        <form class="mt-8 space-y-5" method="POST">
            
            <!-- Input Nama Lengkap -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-400 sm:text-sm"><i class="fas fa-id-card"></i></span>
                    </div>
                    <input id="name" name="name" type="text" required 
                        class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-200" 
                        placeholder="John Doe">
                </div>
            </div>

            <!-- Input Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-400 sm:text-sm"><i class="fas fa-user"></i></span>
                    </div>
                    <input id="username" name="username" type="text" required 
                        class="appearance-none block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition duration-200" 
                        placeholder="johndoe123">
                </div>
            </div>

            <!-- Input Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <div class="relative rounded-md shadow-sm">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <span class="text-gray-400 sm:text-sm"><i class="fas fa-envelope"></i></span>
                    </div>
                    <input id="email" name="email" type="email" required 
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
                <p class="mt-1 text-xs text-gray-500">Minimal 4 karakter.</p>
            </div>

            <!-- Tombol Register -->
            <div class="pt-2">
                <button type="submit" name="register" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-bold rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-md transition duration-200 transform hover:-translate-y-0.5">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-user-plus text-blue-500 group-hover:text-blue-400 transition"></i>
                    </span>
                    Daftar Sekarang
                </button>
            </div>

            <!-- Footer Link -->
            <div class="text-center text-sm">
                <p class="text-gray-600">
                    Sudah punya akun? 
                    <a href="login.php" class="font-medium text-blue-600 hover:text-blue-500 transition underline">
                        Login di sini
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