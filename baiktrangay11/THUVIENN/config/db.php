<?php
$host = 'localhost';
$db = 'db_thuvien';
$user = 'root';
$pass = 'newpassword';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>