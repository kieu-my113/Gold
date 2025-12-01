<?php
session_start();

// Giả sử OTP đã được tạo và lưu vào session trước đó
// Ví dụ: $_SESSION['otp'] = 123456;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy OTP từ form gửi lên
    $user_otp = isset($_POST['otp']) ? trim($_POST['otp']) : '';

    // Kiểm tra xem OTP có hợp lệ không
    if (empty($user_otp)) {
        $response = [
            'status' => 'error',
            'message' => 'Vui lòng nhập OTP.'
        ];
    } elseif (!isset($_SESSION['otp'])) {
        $response = [
            'status' => 'error',
            'message' => 'OTP không tồn tại. Vui lòng thử lại.'
        ];
    } elseif ($user_otp == $_SESSION['otp']) {
        // OTP đúng
        // Xóa OTP sau khi sử dụng
        unset($_SESSION['otp']);

        $response = [
            'status' => 'success',
            'message' => 'Xác thực OTP thành công.'
        ];
    } else {
        // OTP sai
        $response = [
            'status' => 'error',
            'message' => 'OTP không đúng.'
        ];
    }

    // Trả về JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>

<!-- Form HTML (nếu muốn test trực tiếp) -->
<form method="POST" action="">
    <input type="text" name="otp" placeholder="Nhập OTP" required>
    <button type="submit">Xác thực OTP</button>
</form>
