<?php
session_start();
include '../config/db.php';
if ($_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add'])) {
    $ma = $_POST['MaSach'];
    $ten = $_POST['TenSach'];
    $tg = $_POST['TacGia'];
    $img = $_POST['HinhAnh'];
    $stmt = $conn->prepare("INSERT INTO Sach VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $ma, $ten, $tg, $img);
    $stmt->execute();
}

$search = $_GET['search'] ?? '';
$like = "%$search%";
$stmt = $conn->prepare("SELECT * FROM Sach WHERE TenSach LIKE ? OR TacGia LIKE ?");
$stmt->bind_param("ss", $like, $like);
$stmt->execute();
$result = $stmt->get_result();

echo "<form method='POST'>
        <input name='MaSach' placeholder='Mã sách' required>
        <input name='TenSach' placeholder='Tên sách' required>
        <input name='TacGia' placeholder='Tác giả' required>
        <input name='HinhAnh' placeholder='Đường dẫn ảnh' required>
        <button name='add'>Thêm sách</button>
      </form>";

echo "<form method='GET'>
        <input name='search' placeholder='Tìm sách...'>
        <button type='submit'>Tìm</button>
      </form>";

while ($row = $result->fetch_assoc()) {
    echo "<p>{$row['MaSach']} - {$row['TenSach']} - {$row['TacGia']} - <img src='{$row['HinhAnh']}' width='50'></p>";
}
?>