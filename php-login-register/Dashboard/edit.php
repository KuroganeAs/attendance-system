<?php 
// Include database connection
include('dbconnection.php');

if(isset($_POST['submit']))
{
    $eid = $_GET['editid'];
    
    // Amankan input dari karakter khusus (mencegah error SQL)
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $bio   = mysqli_real_escape_string($con, $_POST['bio']);
    
    // Query update data
    $query = mysqli_query($con, "UPDATE users set first_name='$fname', last_name='$lname', Email='$email', bio='$bio' where id='$eid'");
    
    if ($query) {
        echo "<script>alert('Data Mahasiswa berhasil di perbarui!');</script>";
        echo "<script type='text/javascript'> document.location ='index.php'; </script>";
    } else {
        echo "<script>alert('Something went wrong. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
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
        <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-lg border border-gray-100">
            
            <?php
            $eid = $_GET['editid'];
            $ret = mysqli_query($con, "select * from users where id='$eid'");
            while ($row = mysqli_fetch_array($ret)) {
            ?>

            <!-- Header -->
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-extrabold text-gray-900">
                    Edit Data
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    Update information for <strong><?php echo $row['first_name']; ?></strong>
                </p>
            </div>

            <!-- Form Start -->
            <form class="space-y-6" method="POST">
                
                <!-- Section Foto Profil (Read-Only di sini, edit di halaman terpisah) -->
                <div class="flex items-center justify-center mb-6">
                    <div class="text-center">
                        <div class="relative inline-block">
                            <?php 
                                $picPath = "profilepics/" . $row['profilepic'];
                                if(!empty($row['profilepic']) && file_exists($picPath)) {
                                    echo '<img src="'.$picPath.'" class="h-24 w-24 rounded-full object-cover border-4 border-gray-200 shadow-sm">';
                                } else {
                                    echo '<img src="https://ui-avatars.com/api/?name='.urlencode($row['first_name']).'" class="h-24 w-24 rounded-full border-4 border-gray-200 shadow-sm">';
                                }
                            ?>
                            <!-- Tombol Ganti Foto (Link ke change-image.php) -->
                            <a href="change-image.php?userid=<?php echo $row['id'];?>" class="absolute bottom-0 right-0 bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-full shadow-md transition duration-150" title="Change Photo">
                                <i class="fas fa-camera text-xs"></i>
                            </a>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Click camera icon to change photo</p>
                    </div>
                </div>

                <!-- Baris Nama Depan & Belakang -->
                <div class="flex gap-4">
                    <div class="w-1/2">
                        <label for="fname" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" name="fname" value="<?php echo $row['first_name'];?>" required 
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div class="w-1/2">
                        <label for="lname" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" name="lname" value="<?php echo $row['last_name'];?>" required 
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 sm:text-sm"><i class="far fa-envelope"></i></span>
                        </div>
                        <input type="email" name="email" value="<?php echo $row['email'];?>" required 
                               class="pl-10 appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <!-- Input Bio -->
                <div>
                    <label for="bio" class="block text-sm font-medium text-gray-700 mb-1">Short Bio</label>
                    <textarea name="bio" rows="3" required maxlength="100" 
                              class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"><?php echo $row['bio'];?></textarea>
                    <p class="text-xs text-gray-500 mt-1 text-right">Maksimal 100 karakter.</p>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex items-center justify-between gap-4 mt-8 pt-4 border-t border-gray-100">
                    <a href="index.php" class="w-1/2 flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-decoration-none transition duration-150">
                        Cancel
                    </a>
                    
                    <button type="submit" name="submit" class="w-1/2 flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                        Update Data
                    </button>
                </div>

            </form>
            <?php } ?>
        </div>
    </div>

</body>
</html>