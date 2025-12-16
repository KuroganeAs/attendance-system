<?php
session_start();

// 1. Cek Sesi Login
if(!isset($_SESSION["user"])) {
    header("Location: ../login.php"); 
    exit;
}

// 2. Koneksi Database
include('dbconnection.php'); 

// 3. Logika Hapus Data
if(isset($_GET['delid'])) {
    $rid = intval($_GET['delid']);
    $profilepic = $_GET['ppic'];
    $ppicpath = "profilepics" . "/" . $profilepic;
    
    // Hapus data dari database
    $sql = mysqli_query($con, "delete from users where id=$rid");
    
    // Hapus file fisik jika ada
    if(file_exists($ppicpath)){
        unlink($ppicpath);
    }

    if($sql){
        echo "<script>alert('Data deleted successfully');</script>"; 
        echo "<script>window.location.href = 'index.php'</script>";     
    } else {
        echo "<script>alert('Failed to delete');</script>"; 
    }
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Attendance System</title>
    
    <!-- Tailwind CSS (Framework UI) -->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Google (Inter) agar terlihat modern -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Font Awesome (Ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-50">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo / Brand -->
                <div class="flex items-center">
                    <div class="flex-shrink-0 flex items-center gap-2">
                        <div class="bg-blue-600 text-white p-2 rounded-lg">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <span class="font-bold text-xl text-gray-800">Attendance<span class="text-blue-600">System</span></span>
                    </div>
                </div>

                <!-- User Profile & Logout -->
                <div class="flex items-center gap-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-medium text-gray-900">
                            <?php echo htmlspecialchars($_SESSION["user"]["name"]); ?>
                        </p>
                        <p class="text-xs text-gray-500">
                            Administrator
                        </p>
                    </div>
                    <div class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold border border-blue-200">
                        <?php echo strtoupper(substr($_SESSION["user"]["name"], 0, 1)); ?>
                    </div>
                    <div class="border-l pl-4 border-gray-300">
                        <a href="../logout.php" class="text-sm font-medium text-red-600 hover:text-red-800 transition duration-150">
                            Logout <i class="fas fa-sign-out-alt ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        <!-- Header Section -->
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Data Mahasiswa
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Kelola data mahasiswa yang terdaftar dalam sistem absensi
                </p>
            </div>
            <div class="mt-4 flex md:mt-0 md:ml-4">
                <a href="insert.php" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    <i class="fas fa-plus mr-2"></i> Tambah Data Mahasiswa
                </a>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white shadow-lg rounded-xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                No
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Profil mahasiswa
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Kontak
                            </th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Bio
                            </th>
                            <th scope="col" class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        $ret = mysqli_query($con, "select * from users order by id desc");
                        $cnt = 1;
                        $row_count = mysqli_num_rows($ret);
                        
                        if($row_count > 0){
                            while ($row = mysqli_fetch_array($ret)) {
                        ?>
                        <tr class="hover:bg-blue-50 transition duration-150 ease-in-out group">
                            <!-- No -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                <?php echo $cnt;?>
                            </td>

                            <!-- Foto & Nama -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12 relative">
                                        <?php 
                                            $picPath = "profilepics/" . $row['profilepic'];
                                            if(!empty($row['profilepic']) && file_exists($picPath)) {
                                                echo '<img src="'.$picPath.'" class="h-12 w-12 rounded-full object-cover border-2 border-white shadow-sm group-hover:border-blue-200">';
                                            } else {
                                                echo '<img src="https://ui-avatars.com/api/?name='.urlencode($row['first_name']).'&background=random" class="h-12 w-12 rounded-full border-2 border-white shadow-sm">';
                                            }
                                        ?>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">
                                            <?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']);?>
                                        </div>
                                        <div class="text-xs text-gray-400">
                                            ID: #<?php echo $row['id']; ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Email -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">
                                    <i class="far fa-envelope text-gray-400 mr-2"></i>
                                    <?php echo htmlspecialchars($row['email']);?>
                                </div>
                            </td>

                            <!-- Bio -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-500 max-w-xs truncate">
                                    <?php echo htmlspecialchars($row['bio']);?>
                                </div>
                            </td>

                            <!-- Action Buttons -->
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="flex justify-center space-x-3">
                                    <!-- View -->
                                    <a href="read.php?viewid=<?php echo htmlentities($row['id']);?>" class="text-blue-500 hover:text-blue-700 bg-blue-100 hover:bg-blue-200 p-2 rounded-full transition" title="View Details">
                                        <i class="fas fa-eye w-4 h-4"></i>
                                    </a>
                                    
                                    <!-- Edit -->
                                    <a href="edit.php?editid=<?php echo htmlentities($row['id']);?>" class="text-yellow-500 hover:text-yellow-700 bg-yellow-100 hover:bg-yellow-200 p-2 rounded-full transition" title="Edit Data">
                                        <i class="fas fa-pen w-4 h-4"></i>
                                    </a>
                                    
                                    <!-- Delete -->
                                    <a href="index.php?delid=<?php echo ($row['id']);?>&&ppic=<?php echo $row['profilepic'];?>" class="text-red-500 hover:text-red-700 bg-red-100 hover:bg-red-200 p-2 rounded-full transition" title="Delete" onclick="return confirm('Are you sure you want to delete this user?');">
                                        <i class="fas fa-trash-alt w-4 h-4"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            $cnt++;
                            } 
                        } else { ?>
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fas fa-inbox text-4xl mb-3 text-gray-300"></i>
                                        <p class="text-lg font-medium">No users found</p>
                                        <p class="text-sm">Get started by adding a new user.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Footer Tabel (Opsional: Pagination area) -->
            <div class="bg-gray-50 px-6 py-3 border-t border-gray-200 flex items-center justify-between">
                <span class="text-xs text-gray-500">
                    Menampilkan total <?php echo isset($row_count) ? $row_count : 0; ?> mahasiswa
                </span>
            </div>
        </div>
    </div>

</body>
</html>