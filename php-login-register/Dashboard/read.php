<?php
// Include database connection
include('dbconnection.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User Details</title>
    <!-- Tailwind CSS -->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    
    <?php
    $vid = $_GET['viewid'];
    $ret = mysqli_query($con, "SELECT * from users where id=$vid");
    while ($row = mysqli_fetch_array($ret)) {
    ?>

    <div class="max-w-3xl w-full bg-white rounded-xl shadow-lg overflow-hidden">
        
        <!-- Header / Banner Warna Biru -->
        <div class="bg-blue-600 h-32 w-full relative">
            <div class="absolute top-10 left-20">
                <a href="index.php" class="text-white hover:text-blue-200 transition duration-150 flex items-center gap-2 font-medium">
                    <i class="fas fa-arrow-left"></i> Back to Dashboard
                </a>
            </div>
            <!-- Tombol Edit di Banner DIHAPUS, dipindah ke bawah agar lebih rapi -->
        </div>

        <div class="px-8 pb-8">
            <!-- Area Foto Profil dan Tombol Edit (Sejajar) -->
            <div class="relative flex justify-between items-end -mt-16 mb-6">
                <!-- Foto Profil Besar -->
                <div class="relative">
                    <?php 
                        $picPath = "profilepics/" . $row['profilepic'];
                        if(!empty($row['profilepic']) && file_exists($picPath)) {
                            echo '<img src="'.$picPath.'" class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover bg-white">';
                        } else {
                            echo '<img src="https://ui-avatars.com/api/?name='.urlencode($row['first_name']).'" class="w-32 h-32 rounded-full border-4 border-white shadow-lg bg-white">';
                        }
                    ?>
                </div>

                <!-- Tombol Edit Profile (Posisi Baru: Kanan Bawah Banner) -->
                <div class="mb-2">
                    <a href="edit.php?editid=<?php echo htmlentities($row['id']);?>" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                        <i class="fas fa-pen mr-2 text-gray-500"></i> Edit Profile
                    </a>
                </div>
            </div>

            <!-- Detail Informasi User -->
            <div>
                <h1 class="text-3xl font-bold text-gray-900">
                    <?php echo $row['first_name'] . ' ' . $row['last_name']; ?>
                </h1>
                <p class="text-sm text-gray-500 mb-6">User ID: #<?php echo $row['id']; ?></p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri: Contact Info -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Contact Information</h3>
                        
                        <div>
                            <p class="text-sm text-gray-500">Email Address</p>
                            <p class="text-lg font-medium text-gray-900 flex items-center gap-2">
                                <i class="far fa-envelope text-blue-500"></i>
                                <?php echo $row['email']; ?>
                            </p>
                        </div>
                        
                        <!-- Member Since SUDAH DIHAPUS -->
                    </div>

                    <!-- Kolom Kanan: Bio -->
                    <div class="bg-gray-50 p-6 rounded-lg border border-gray-100">
                        <h3 class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">About User</h3>
                        
                        <div class="prose max-w-none text-gray-800">
                            <p class="italic text-lg text-gray-600">
                                "<?php echo htmlspecialchars($row['bio']); ?>"
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php } ?>

</div>

</body>
</html>