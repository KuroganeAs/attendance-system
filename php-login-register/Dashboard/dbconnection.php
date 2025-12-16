<?php
$con=mysqli_connect("db", "annisa", "12345", "attendance_system");
if(mysqli_connect_errno())
{
echo "Connection Fail".mysqli_connect_error();
}
?>