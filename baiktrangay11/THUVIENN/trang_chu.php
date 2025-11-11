<?php
session_start();
include 'config/db.php';

if ($_SESSION['role'] != 'docgia') {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT MaDG, HoTen FROM DocGia WHERE username=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$docgia = $stmt->get_result()->fetch_assoc();

echo "<h2>Chào mừng {$docgia['HoTen']}</h2>";

$search = $_GET['search'] ?? '';
$like = "%$search%";

$sql = "SELECT s.TenSach, s.TacGia, pm.NgayMuon, pm.TrangThai
        FROM PhieuMuon pm
        JOIN Sach s ON pm.MaSach = s.MaSach
        WHERE pm.MaDG = ?
        AND (s.TenSach LIKE ? OR s.TacGia LIKE ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $docgia['MaDG'], $like, $like);
$stmt->execute();
$result = $stmt->get_result();

echo "<form method='GET'>
        <input name='search' placeholder='Tìm sách...'>
        <button type='submit'>Tìm</button>
      </form>";

while ($row = $result->fetch_assoc()) {
    echo "<p>{$row['TenSach']} - {$row['TacGia']} - {$row['NgayMuon']} - {$row['TrangThai']}</p>";
}
?>