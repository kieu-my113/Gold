<?php
session_start();
header('Content-Type: text/html; charset=UTF-8');
include('ketnoi.php');

// -------------------------------
// NẾU NHẤN ĐĂNG NHẬP → XỬ LÝ LUÔN
// -------------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['tendangnhap'] ?? '');
    $matkhau = trim($_POST['matkhau'] ?? '');
    $addToCart = $_POST['addToCart'] ?? '';

    // Kiểm tra trống
    if ($email === '' || $matkhau === '') {
        echo "<script>alert('Vui lòng nhập đầy đủ email và mật khẩu!'); window.history.back();</script>";
        exit;
    }

    // Query theo email
    $sql = "SELECT * FROM nguoidung WHERE TRIM(EMAIL) = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Email không tồn tại
    if (!$result || mysqli_num_rows($result) == 0) {
        echo "<script>alert('Email không tồn tại!'); window.history.back();</script>";
        exit;
    }

    $row = mysqli_fetch_assoc($result);

    // Mật khẩu sai (không hash)
    if ($matkhau !== trim($row['MATKHAU'])) {
        echo "<script>alert('Mật khẩu không đúng!'); window.history.back();</script>";
        exit;
    }

    // Lưu session
    $_SESSION['MA_ND'] = $row['MA_ND'];
    $_SESSION['EMAIL']  = $row['EMAIL'];
    $_SESSION['ROLE']   = $row['ROLE'];

    // -------------------------------
    // SAU LOGIN: TỰ ĐỘNG THÊM SP VÀO GIỎ
    // -------------------------------
    if ($addToCart != '') {

        $ma_nd = $row['MA_ND'];

        // Kiểm tra SP đã có trong giỏ chưa
        $sqlCheck = "SELECT * FROM giohang WHERE MA_ND = ? AND MA_SP = ?";
        $stmtC = mysqli_prepare($connect, $sqlCheck);
        mysqli_stmt_bind_param($stmtC, "ii", $ma_nd, $addToCart);
        mysqli_stmt_execute($stmtC);
        $rsC = mysqli_stmt_get_result($stmtC);

        if (mysqli_num_rows($rsC) > 0) {
            // Đã có → tăng số lượng
            $sqlUpdate = "UPDATE giohang 
                          SET SOLUONG = SOLUONG + 1 
                          WHERE MA_ND = ? AND MA_SP = ?";
            $stmtU = mysqli_prepare($connect, $sqlUpdate);
            mysqli_stmt_bind_param($stmtU, "ii", $ma_nd, $addToCart);
            mysqli_stmt_execute($stmtU);
        } else {
            // Chưa có → tạo mới
            $sqlInsert = "INSERT INTO giohang (MA_ND, MA_SP, SOLUONG) 
                          VALUES (?, ?, 1)";
            $stmtI = mysqli_prepare($connect, $sqlInsert);
            mysqli_stmt_bind_param($stmtI, "ii", $ma_nd, $addToCart);
            mysqli_stmt_execute($stmtI);
        }

        echo "<script>
                alert('Đăng nhập thành công! Sản phẩm đã được thêm vào giỏ hàng.');
                window.location.href='giohang.php';
              </script>";
        exit;
    }

    // Đăng nhập bình thường
    echo "<script>
            alert('Đăng nhập thành công!');
            window.location.href='index.php';
          </script>";
    exit;
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng nhập | Shopee Việt Nam</title>
  <link rel="icon" href="https://cf.shopee.vn/file/faviconshopee.ico" type="image/x-icon">

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      background-color: #f5f5f5;
    }

    /* Header */
    .header {
      background-color: #fff;
      padding: 5px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      border-bottom: 1px solid #ddd;
    }

    .header-left {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .header-left img {
      height: 60px;
    }

    .header-left h3 {
      color: #ee4d2d;
      font-size: 24px;
    }

    .header-left p {
      color: #333;
      font-size: 14px;
    }

    .header a {
      text-decoration: none;
      color: #d0011b;
      font-size: 14px;
    }

    /* Main container */
    .main-row {
      display: flex;
      min-height: 50vh;
    }

    .banner {
      flex: 1;
      background-color: #ee4d2d;
      color: white;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 5px 20px;
    }

    .banner img {
      max-width: 200px;
      margin-bottom: 30px;
    }

    .banner h1 {
      font-size: 24px;
      margin-bottom: 10px;
    }

    .banner p {
      font-size: 20px;
    }

    .login-form-container {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 10px 30px;
      background-color: #ee4d2d;
    }

    .login-form {
      width: 100%;
      max-width: 400px;
      background-color: #fff;
      padding: 40px;
      border-radius: 7px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    }

    /* Chat bubble + QR icon */
    .login-form-left {
      display: flex;
      flex-direction: row;
      align-items: center;
      gap: 10px;
      margin-bottom: 20px;
    }

    .login-form-left h4 {
      margin: 0;
      font-size: 16px;
    }

    .chat-bubble {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 180px;
      height: 40px;
      background-color: #fff8b5;
      border-radius: 10px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
      cursor: pointer;
      position: relative;
      padding: 0 10px;
    }

    .chat-bubble::after {
      content: '';
      position: absolute;
      top: 50%;
      right: -10px;
      transform: translateY(-50%);
      width: 0;
      height: 0;
      border-top: 10px solid transparent;
      border-bottom: 10px solid transparent;
      border-left: 10px solid #fff8b5;
    }

    .chat-bubble .text {
      color: #f1c40f;
      font-weight: bold;
    }

    .login-form-left img {
      width: 50px;
      height: 50px;
      cursor: pointer;
      border-radius: 5px;
    }

    /* Inputs */
    .login-form input {
      width: 100%;
      padding: 12px;
      margin: 12px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .login-form button {
      width: 100%;
      padding: 12px;
      background-color: #ee4d2d;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s ease;
    }

    .login-form button:hover {
      background-color: #a90015;
      transform: translateY(-2px);
    }

    /* Password eye */
    .password-container {
      position: relative;
    }

    .password-container span {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
    }

    .divider {
      color: #aaa;
      text-align: center;
      margin: 15px 0;
    }

    .social-login {
      display: flex;
      gap: 10px;
    }

    .social-btn {
      flex: 1;
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      display: flex;
      justify-content: center;
      gap: 8px;
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>

<body>

  <div class="header">
    <div class="header-left">
      <img src="https://img.icons8.com/color/70/shopee.png">
      <div>
        <h3>Shopee</h3>
        <p>Đăng Nhập</p>
      </div>
    </div>
    <a href="#">Bạn cần giúp đỡ?</a>
  </div>

  <div class="main-row">

    <!-- Left -->
    <div class="banner">
      <img src="../Shopee/logo/Shopeetrai.jpg">
      <h1>Nền tảng thương mại điện tử</h1>
      <p>hàng đầu Đông Nam Á</p>
    </div>

    <!-- Right -->
    <div class="login-form-container">
      <div class="login-form">

        <div class="login-form-left">
          <h4>Đăng Nhập</h4>

          <div class="chat-bubble" id="qrContainer">
            <div class="text">Đăng nhập với mã QR</div>
          </div>

          <img id="qrTrigger" src="../Shopee/logo/qrdangnhap.jpg">
        </div>

        <form method="POST" action="xuLyDangNhap.php">
          <input type="text" name="tendangnhap" placeholder="Email..." required>

          <div class="password-container">
            <input type="password" id="matkhau" name="matkhau" placeholder="Mật khẩu..." required>
            <span id="togglePassword">👁</span>
          </div>

          <button>ĐĂNG NHẬP</button>

          <p><a href="quenmatkhau.php">Quên mật khẩu?</a></p>

          <div class="divider">HOẶC</div>

          <div class="social-login">
            <a class="social-btn" href="https://www.facebook.com">
              <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" width="18"> Facebook
            </a>
            <a class="social-btn" href="https://accounts.google.com">
              <img src="https://cdn-icons-png.flaticon.com/512/300/300221.png" width="18"> Google
            </a>
          </div>

          <p style="margin-top:15px;">Bạn chưa có tài khoản?
            <a href="../Shopee/trangdangkyshopeeT.php">Đăng ký</a>
          </p>
        </form>

      </div>
    </div>

  </div>

  <?php include 'footer.php'; ?>

  <script>
    // Hiển thị / ẩn mật khẩu
    document.getElementById('togglePassword').onclick = function () {
      let input = document.getElementById('matkhau');
      input.type = input.type === "password" ? "text" : "password";
      this.textContent = input.type === "password" ? "👁" : "🙈";
    };

    // Chuyển sang trang quét QR
    document.getElementById('qrTrigger').onclick = function () {
      window.location.href = "qrdangnhap.php";
    };



  </script>

</body>

</html>
