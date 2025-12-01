<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include('ketnoi.php');

$email = trim($_POST['tendangnhap'] ?? '');
$matkhau = trim($_POST['matkhau'] ?? '');

// Kiểm tra trống
if ($email === '' || $matkhau === '') {
    echo "<script>alert('Vui lòng nhập đầy đủ email và mật khẩu!'); window.history.back();</script>";
    exit;
}

// Kiểm tra email
$sql = "SELECT * FROM nguoidung WHERE TRIM(EMAIL) = ?";
$stmt = mysqli_prepare($connect, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<script>alert('Email không tồn tại!'); window.history.back();</script>";
    exit;
}

$row = mysqli_fetch_assoc($result);

// Kiểm tra mật khẩu (không hash)
if ($matkhau !== trim($row['MATKHAU'])) {
    echo "<script>alert('Mật khẩu không đúng!'); window.history.back();</script>";
    exit;
}

// Lưu session
$_SESSION['MA_ND'] = $row['MA_ND'];
$_SESSION['EMAIL'] = $row['EMAIL'];
$_SESSION['ROLE'] = $row['ROLE'];

// Đăng nhập thành công nhưng KHÔNG chuyển trang
echo "<script>
        alert('Đăng nhập thành công!');
        window.location.href = 'index.php';
      </script>";
exit;
?>
