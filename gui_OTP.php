<?php
session_start();
require 'ketnoi.php'; // Kết nối DB

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Thiết lập timezone
date_default_timezone_set('Asia/Ho_Chi_Minh');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Load PHPMailer
    require 'C:/xampp/htdocs/Shopee/PHPMailer/PHPMailer-master/src/PHPMailer.php';
    require 'C:/xampp/htdocs/Shopee/PHPMailer/PHPMailer-master/src/SMTP.php';
    require 'C:/xampp/htdocs/Shopee/PHPMailer/PHPMailer-master/src/Exception.php';

    $email = trim($_POST['EMAIL']);

    // Kiểm tra email đã tồn tại chưa
    $stmt = $conn->prepare("SELECT * FROM nguoidung WHERE EMAIL = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "Email đã tồn tại!";
    } else {
        // Tạo OTP và thời gian hết hạn 5 phút
        $otp = rand(100000, 999999);
        $role = 'nguoi_mua';

        $stmt_insert = $conn->prepare(
            "INSERT INTO nguoidung (EMAIL, MA_OTP, HET_HAN_OTP, ROLE) 
            VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 5 MINUTE), ?)"
        );
        $stmt_insert->bind_param("sis", $email, $otp, $role);
        $stmt_insert->execute();

        // Cấu hình Gmail
        $gmail_user = "nguyendoankieulinh@gmail.com";      
        $gmail_pass = "knae ksow ckxa zcrn";              

        $mail = new PHPMailer(true);

        try {
            // UTF-8 chuẩn cho Gmail
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = $gmail_user;
            $mail->Password = $gmail_pass;
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom($gmail_user, 'Shopee OTP');
            $mail->addAddress($email);

            // Subject encode chuẩn UTF-8
            $mail->Subject = '=?UTF-8?B?' . base64_encode('Mã OTP đăng ký Shopee') . '?=';

            // Body HTML chuẩn UTF-8
            $mail->isHTML(true);
            $mail->Body = "Mã OTP của bạn là: <b>$otp</b> (Hiệu lực 5 phút)";

            // Body plain text dự phòng
            $mail->AltBody = "Mã OTP của bạn là: $otp (Hiệu lực 5 phút)";

            $mail->send();

            $_SESSION['EMAIL'] = $email;
            header("Location: check_otp.php");
            exit;

        } catch (Exception $e) {
            $message = "Không thể gửi OTP: {$mail->ErrorInfo}";
        }
    }
}
?>

<!-- HTML Form -->
<form method="POST">
    <input type="email" name="EMAIL" placeholder="Nhập email" required>
    <button type="submit">Gửi OTP</button>
    <?php if(isset($message)) echo "<p style='color:red;'>$message</p>"; ?>
</form>
