<?php
session_start();
include '../config/db.php';
if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

// Thêm phiếu mượn mới
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $madg = $_POST['MaDG'];
    $masach = $_POST['MaSach'];
    $ngaymuon = $_POST['NgayMuon'];

    $stmt = $conn->prepare("INSERT INTO PhieuMuon (MaDG, MaSach, NgayMuon, TrangThai) VALUES (?, ?, ?, 'Đang mượn')");
    $stmt->bind_param("sss", $madg, $masach, $ngaymuon);
    $stmt->execute();
}

// Cập nhật trạng thái phiếu mượn
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("UPDATE PhieuMuon SET TrangThai='Đã trả' WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Lấy danh sách phiếu mượn
$sql = "SELECT pm.id, dg.HoTen, s.TenSach, pm.NgayMuon, pm.TrangThai
        FROM PhieuMuon pm
        JOIN DocGia dg ON pm.MaDG = dg.MaDG
        JOIN Sach s ON pm.MaSach = s.MaSach
        ORDER BY pm.id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Quản lý Phiếu mượn</title>
    <link rel="stylesheet" href="../assets/css/phieumuon.css">
</head>
<body>
    <h2>Quản lý Phiếu mượn</h2>

    <form method="POST">
        <input name="MaDG" placeholder="Mã độc giả" required>
        <input name="MaSach" placeholder="Mã sách" required>
        <input name="NgayMuon" type="date" required>
        <button name="add">Thêm phiếu mượn</button>
    </form>

    <h3>Danh sách phiếu mượn</h3>
    <?php while ($row = $result->fetch_assoc()): ?>
        <p>
            <strong>Độc giả:</strong> <?= $row['HoTen'] ?> |
            <strong>Sách:</strong> <?= $row['TenSach'] ?> |
            <strong>Ngày mượn:</strong> <?= $row['NgayMuon'] ?> |
            <strong>Trạng thái:</strong> <?= $row['TrangThai'] ?>
            <?php if ($row['TrangThai'] == 'Đang mượn'): ?>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                    <button name="update">Đánh dấu đã trả</button>
                </form>
            <?php endif; ?>
        </p>
    <?php endwhile; ?>
</body>
</html>