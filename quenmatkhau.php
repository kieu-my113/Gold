<?php
session_start();

// Kết nối database
$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'tmdt'; // đổi tên database của bạn
$conn = new mysqli($host, $user, $pass, $db);
if($conn->connect_error){
    die(json_encode(['status'=>'error','msg'=>'Database error']));
}

// PHPMailer
require 'PHPMailer/PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer/PHPMailer-master/src/SMTP.php';
require 'PHPMailer/PHPMailer-master/src/Exception.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Gửi OTP
if(isset($_POST['action']) && $_POST['action']=='send_otp'){
    $email = $_POST['email'] ?? '';
    if($email){
        $otp = rand(100000,999999);
        $_SESSION['otp'] = $otp;
        $_SESSION['email_reset'] = $email;

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'nguyendoankieulinh@gmail.com';
            $mail->Password = 'knae ksow ckxa zcrn'; // App password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('no-reply@shopee.vn','Shopee');
            $mail->addAddress($email);
            $mail->Subject = "Code OTP Forgot Password";
            $mail->Body = "Mã OTP của bạn: $otp";

            $mail->send();
            echo json_encode(['status'=>'success']);
        } catch (Exception $e) {
            echo json_encode(['status'=>'error','msg'=>$mail->ErrorInfo]);
        }
    } else {
        echo json_encode(['status'=>'error','msg'=>'Email trống']);
    }
    exit;
}

// Kiểm tra OTP
if(isset($_POST['action']) && $_POST['action']=='check_otp'){
    $otp = $_POST['otp'] ?? '';
    if($otp && isset($_SESSION['otp']) && $otp == $_SESSION['otp']){
        echo json_encode(['status'=>'success']);
    } else {
        echo json_encode(['status'=>'error','msg'=>'OTP không đúng']);
    }
    exit;
}

// Đặt mật khẩu mới (không hash)
if(isset($_POST['action']) && $_POST['action']=='reset_password'){
    $password = $_POST['password'] ?? '';
    if($password && isset($_SESSION['email_reset'])){
        $email = $conn->real_escape_string($_SESSION['email_reset']);
        $password = $conn->real_escape_string($password);

        $sql = "UPDATE users SET password='$password' WHERE email='$email'";
        if($conn->query($sql)){
            unset($_SESSION['otp'], $_SESSION['email_reset']);
            echo json_encode(['status'=>'success']);
        } else {
            echo json_encode(['status'=>'error','msg'=>'Cập nhật DB thất bại']);
        }
    } else {
        echo json_encode(['status'=>'error','msg'=>'Có lỗi xảy ra']);
    }
    exit;
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Quên mật khẩu | Shopee</title>
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:Arial,sans-serif;}
body{background:#f5f5f5;display:flex;flex-direction:column;min-height:100vh;}
.header{background:#fff;padding:10px 30px;display:flex;align-items:center;border-bottom:1px solid #ddd;}
.header img{height:60px;}
main{flex-grow:1;display:flex;justify-content:center;align-items:center;padding:40px 15px;}
.card{width:380px;background:#fff;padding:25px 35px;border-radius:6px;box-shadow:0 4px 14px rgba(0,0,0,0.1);margin-bottom:20px;}
.input-group{margin-bottom:20px;}
.input-group input{width:100%;padding:10px 12px;border:1.5px solid #ccc;border-radius:4px;font-size:14px;}
.submit-btn{width:100%;padding:12px 0;font-size:16px;font-weight:600;border:none;border-radius:4px;cursor:pointer;background:#ee4d2d;color:#fff;}
.submit-btn:disabled{background:#f9a192;cursor:not-allowed;}
.password-rules{font-size:12px;margin-top:10px;margin-left:6px;color:#999;line-height:1.4;}
.rule.valid{color:#38b000;}
.rule.invalid{color:#e03e2f;}
#otpCard,#passwordCard{display:none;}
</style>
</head>
<body>
<div class="header">
<img src="https://img.icons8.com/color/70/shopee.png" alt="Shopee">
<h3>Shopee</h3>
</div>

<main>
<!-- Email -->
<div class="card" id="emailCard">
<h2>Nhập Email</h2>
<form id="emailForm">
<div class="input-group"><input type="email" id="emailInput" placeholder="Email" required></div>
<button type="submit" class="submit-btn">Gửi OTP</button>
</form>
</div>

<!-- OTP -->
<div class="card" id="otpCard">
<h2>Xác minh OTP</h2>
<form id="otpForm">
<div class="input-group"><input type="text" id="otpInput" placeholder="Nhập OTP" required></div>
<button type="submit" class="submit-btn">Tiếp theo</button>
</form>
</div>

<!-- Password -->
<div class="card" id="passwordCard">
<h2>Đặt mật khẩu mới</h2>
<form id="passwordForm">
<div class="input-group"><input type="password" id="password" placeholder="Mật khẩu mới" required></div>
<button type="submit" class="submit-btn" disabled>Đặt mật khẩu</button>
<br>
<div class="password-rules">
<div id="rule-lower" class="rule invalid">• Ít nhất 1 chữ thường</div>
<div id="rule-upper" class="rule invalid">• Ít nhất 1 chữ hoa</div>
<div id="rule-number" class="rule invalid">• Ít nhất 1 chữ số</div>
<div id="rule-special" class="rule invalid">• Ít nhất 1 ký tự đặc biệt (!@#$%^&*)</div>
<div id="rule-length" class="rule invalid">• 8-16 ký tự</div>
</div>
</form>
</div>
</main>

<script>
// Email → OTP
document.getElementById('emailForm').addEventListener('submit', e=>{
  e.preventDefault();
  fetch('quenmatkhau.php',{
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:'action=send_otp&email='+encodeURIComponent(document.getElementById('emailInput').value)
  }).then(r=>r.json()).then(d=>{
    if(d.status==='success'){
      alert('OTP đã gửi vào email!');
      document.getElementById('emailCard').style.display='none';
      document.getElementById('otpCard').style.display='block';
    } else alert(d.msg);
  });
});

// OTP → Password
document.getElementById('otpForm').addEventListener('submit', e=>{
  e.preventDefault();
  fetch('quenmatkhau.php',{
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:'action=check_otp&otp='+encodeURIComponent(document.getElementById('otpInput').value)
  }).then(r=>r.json()).then(d=>{
    if(d.status==='success'){
      document.getElementById('otpCard').style.display='none';
      document.getElementById('passwordCard').style.display='block';
    } else alert(d.msg);
  });
});

// Validate password
const pwdInput = document.getElementById('password');
const submitBtn = document.querySelector('#passwordForm .submit-btn');
const rules = {
  lower: document.getElementById('rule-lower'),
  upper: document.getElementById('rule-upper'),
  number: document.getElementById('rule-number'),
  special: document.getElementById('rule-special'),
  length: document.getElementById('rule-length')
};

pwdInput.addEventListener('input', ()=>{
  const val = pwdInput.value;
  const checks = {
    lower: /[a-z]/.test(val),
    upper: /[A-Z]/.test(val),
    number: /[0-9]/.test(val),
    special: /[!@#$%^&*]/.test(val),
    length: val.length>=8 && val.length<=16
  };
  for(let k in checks){
    rules[k].className = checks[k]?'rule valid':'rule invalid';
  }
  submitBtn.disabled = !Object.values(checks).every(Boolean);
});

document.getElementById('passwordForm').addEventListener('submit', e=>{
  e.preventDefault();
  fetch('quenmatkhau.php',{
    method:'POST',
    headers:{'Content-Type':'application/x-www-form-urlencoded'},
    body:'action=reset_password&password='+encodeURIComponent(pwdInput.value)
  }).then(r=>r.json()).then(d=>{
    if(d.status==='success'){
      alert('Mật khẩu mới đã được lưu! 🎉');
      window.location.href='dangnhapMOI.php';
    } else alert(d.msg);
  });
});
</script>
</body>
</html>
