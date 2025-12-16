<?php
// Pastikan hostnya "db", bukan "localhost"
$host = "db";
$dbname = "attendance_system";
$user = "annisa";
$pass = "12345";

try {
    $db = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $pass
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}
?>