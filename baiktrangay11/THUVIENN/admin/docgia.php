<?php
session_start();
include '../config/db.php';
if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $madg = $_POST['MaDG'];
    $hoten = $_POST['HoTen'];
    $email = $_POST['Email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt1 = $conn->prepare("INSERT INTO Account(username, password, role) VALUES (?, ?, 'docgia')");
    $stmt1->bind_param("ss", $username, $password);
    $stmt1->execute();

    $stmt2 = $conn->prepare("INSERT INTO DocGia VALUES (?, ?, ?, ?)");
    $stmt2->bind_param("ssss", $madg, $hoten, $email, $username);
    $stmt2->execute();
}

$result = $conn->query("SELECT * FROM DocGia");

echo "<form method='POST'>
        <input name='MaDG' placeholder='Mã độc giả' required>
        <input name='HoTen' placeholder='Họ tên' required>
        <input name='Email' placeholder='Email' required>
        <input name='username' placeholder='Username' required>
        <input name='password' type='password' placeholder='Password' required>
        <button type='submit'>Thêm độc giả</button>
      </form>";

while ($row = $result->fetch_assoc()) {
    echo "<p>{$row['MaDG']} - {$row['HoTen']} - {$row['Email']}</p>";
}
?>