<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Trang Quản trị viên</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <h2>📚 Hệ thống Quản lý Thư viện</h2>
    <p>Xin chào quản trị viên <strong><?= $_SESSION['username'] ?></strong></p>

    <ul>
        <li><a href="sach.php">📘 Quản lý Sách</a></li>
        <li><a href="docgia.php">👤 Quản lý Độc giả</a></li>
        <li><a href="phieumuon.php">📄 Quản lý Phiếu mượn</a></li>
        <li><a href="../logout.php">🔓 Đăng xuất</a></li>
    </ul>
</body>
</html>