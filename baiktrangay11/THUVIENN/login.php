<?php
session_start();
include 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM Account WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $acc = $result->fetch_assoc();

    if ($acc && password_verify($password, $acc['password'])) {
        $_SESSION['username'] = $acc['username'];
        $_SESSION['role'] = $acc['role'];
        if ($acc['role'] == 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: trang_chu.php");
        }
    } else {
        echo "Sai thông tin đăng nhập!";
    }
}
?>

<form method="POST">
    <input name="username" placeholder="Username" required>
    <input name="password" type="password" placeholder="Password" required>
    <button type="submit">Đăng nhập</button>
</form>