<?php 
// Include database connection
include('dbconnection.php');

if(isset($_POST['submit'])) {
    // --- PERBAIKAN UTAMA DI SINI ---
    // Gunakan mysqli_real_escape_string agar tanda kutip (') tidak bikin error
    $fname = mysqli_real_escape_string($con, $_POST['fname']);
    $lname = mysqli_real_escape_string($con, $_POST['lname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $bio   = mysqli_real_escape_string($con, $_POST['bio']);
    
    // Ambil info file gambar
    $ppic = $_FILES["profilepic"]["name"];

    // --- LOGIKA VALIDASI GAMBAR ---
    $extension = pathinfo($ppic, PATHINFO_EXTENSION); 
    $extension = strtolower($extension); 
    $allowed_extensions = array("jpg", "jpeg", "png", "gif"); 

    if(!in_array($extension, $allowed_extensions)) {
        echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
    } else {
        // Rename file
        $imgnewfile = md5($ppic) . "." . $extension;
        
        // Pindahkan file
        move_uploaded_file($_FILES["profilepic"]["tmp_name"], "profilepics/" . $imgnewfile);
        
        // Query Insert Data
        $query = mysqli_query($con, "insert into users(first_name, last_name, email, bio, profilepic) values('$fname','$lname','$email', '$bio','$imgnewfile')");
        
        if ($query) {
            echo "<script>alert('Mahasiswa berhasil ditambahkan!');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        } else {
            // Tampilkan error asli MySQL jika ada masalah lain
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <!-- Tailwind CSS -->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg">
            
            <div class="mb-8 text-center">
                <h2 class="text-3xl font-extrabold text-gray-900">Tambah Data Baru</h2>
                <p class="mt-2 text-sm text-gray-600">Isi data mahasiswa baru di bawah ini.</p>
            </div>

            <form class="space-y-6" method="POST" enctype="multipart/form-data">
                
                <div class="flex gap-4">
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" name="fname" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" name="lname" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" required placeholder="email@domain.com" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Short Bio</label>
                    <textarea name="bio" rows="3" required maxlength="100" placeholder="Ceritakan sedikit tentang mahasiswa ini..." class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                    <p class="text-xs text-gray-500 mt-1 text-right">Maksimal 100 karakter.</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:bg-gray-50 transition duration-150 ease-in-out relative bg-gray-50">
                        <div class="space-y-1 text-center">
                            <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-3"></i>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500 px-2">
                                    <span>Upload a file</span>
                                    <input id="file-upload" name="profilepic" type="file" class="sr-only" required onchange="updateFileName(this)">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">PNG, JPG, JPEG, GIF up to 2MB</p>
                            <p id="file-name" class="text-sm text-green-600 font-semibold mt-2 hidden bg-green-100 py-1 px-2 rounded inline-block"></p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-4 mt-8">
                    <a href="index.php" class="w-1/2 flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 text-decoration-none">Cancel</a>
                    <button type="submit" name="submit" class="w-1/2 flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">Simpan</button>
                </div>

            </form>
        </div>
    </div>

    <script>
        function updateFileName(input) {
            const fileNameDisplay = document.getElementById('file-name');
            if (input.files && input.files.length > 0) {
                fileNameDisplay.textContent = "Selected: " + input.files[0].name;
                fileNameDisplay.classList.remove('hidden');
            } else {
                fileNameDisplay.classList.add('hidden');
            }
        }
    </script>

</body>
</html>