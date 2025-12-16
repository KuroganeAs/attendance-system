<?php 
// Database Connection
include('dbconnection.php');

if(isset($_POST['submit'])) {
    $uid = $_GET['userid'];
    
    // Getting the post values
    $ppic = $_FILES["profilepic"]["name"];
    $oldppic = $_POST['oldpic'];
    $oldprofilepic = "profilepics" . "/" . $oldppic;

    // --- LOGIKA BARU UNTUK VALIDASI EKSTENSI ---
    
    // 1. Ambil ekstensi dengan pathinfo (lebih aman)
    $extension = pathinfo($ppic, PATHINFO_EXTENSION);
    
    // 2. Ubah jadi huruf kecil semua
    $extension = strtolower($extension);

    // 3. Daftar ekstensi valid (tanpa titik)
    $allowed_extensions = array("jpg", "jpeg", "png", "gif");

    // 4. Cek apakah ekstensi valid
    if(!in_array($extension, $allowed_extensions)) {
        echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
    } else {
        // Rename file baru (tambahkan titik sebelum ekstensi)
        $imgnewfile = md5($ppic) . "." . $extension;
        
        // Pindahkan file ke folder profilepics
        move_uploaded_file($_FILES["profilepic"]["tmp_name"], "profilepics/" . $imgnewfile);
        
        // Update database
        $query = mysqli_query($con, "update users set ProfilePic='$imgnewfile' where id='$uid' ");
        
        if ($query) {
            // Hapus foto lama agar tidak menuh-menuhin server
            if(file_exists($oldprofilepic)){
                unlink($oldprofilepic);
            }
            
            echo "<script>alert('Profile pic updated successfully');</script>";
            echo "<script type='text/javascript'> document.location ='index.php'; </script>";
        } else {
            echo "<script>alert('Something Went Wrong. Please try again');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Image</title>
    <!-- Tambahkan CSS Bootstrap/Tailwind agar tampilan lebih rapi -->
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
        
        <?php
        $eid = $_GET['userid'];
        $ret = mysqli_query($con, "select * from users where id='$eid'");
        while ($row = mysqli_fetch_array($ret)) {
        ?>
        
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Update Profile Picture</h2>
        <p class="text-gray-600 mb-6">Choose a new image to update your profile.</p>

        <form method="POST" enctype="multipart/form-data">
            
            <input type="hidden" name="oldpic" value="<?php echo $row['profilepic'];?>">
            
            <!-- Tampilkan Foto Lama -->
            <div class="mb-4 flex justify-center">
                <?php 
                    $picPath = "profilepics/" . $row['profilepic'];
                    if(!empty($row['profilepic']) && file_exists($picPath)) {
                        echo '<img src="'.$picPath.'" width="120" height="120" class="rounded-full border shadow">';
                    } else {
                        echo '<img src="https://ui-avatars.com/api/?name='.urlencode($row['first_name']).'" width="120" height="120" class="rounded-full">';
                    }
                ?>
            </div>
            
            <!-- Input File Baru -->
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">New Image</label>
                <input type="file" class="w-full px-3 py-2 border rounded" name="profilepic" required="true">
                <p class="text-red-500 text-xs italic mt-1">Only jpg / jpeg / png / gif format allowed.</p>
            </div> 
            
            <!-- Tombol Submit -->
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded w-full" name="submit">
                    Update Image
                </button>
            </div>
            
            <!-- Tombol Kembali -->
            <div class="mt-4 text-center">
                <a href="edit.php?editid=<?php echo $row['id'];?>" class="text-gray-500 hover:text-gray-800 text-sm">Cancel & Return</a>
            </div>

        </form>
        <?php } ?>
    </div>
</div>

</body>
</html>