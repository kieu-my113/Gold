
<!DOCTYPE html> 
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Đăng ký | Shopee Việt Nam</title>
  <link rel="icon" href="https://cf.shopee.vn/file/faviconshopee.ico" type="image/x-icon">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
    body { background-color: #f5f5f5}
    .header { background-color: #fff; padding: 10px 30px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #ddd; }
    .header img { height: 60px; }
    .main { background-color: #d0011b; min-height: 450px; display: flex; justify-content: center; align-items: center; }
.register-box {
  background-color: #fff;
  width: 365px;
  padding: 50px;
  border-radius: 7px;
  position: absolute;       /* Dính trong khung nền đỏ */
  top: 305px;              /* Cách mép trên */
  right: 350px;             /* Lệch phải như ảnh */
  transform: translateY(-50%); /* Giúp căn giữa thực tế */
  box-shadow: 0 0 10px rgba(0,0,0,0.15);
  z-index: 10;
}

    .register-box h2 { text-align: center; color: #0f0002ff; margin-bottom: 80px; }
    .register-box input { width: 100%; padding: 10px; margin: 20px 0; border: 2px solid #ccc; border-radius: 3px; }
    .register-box button { width: 100%; padding: 10px; background-color: #d0011b; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-weight: bold; }
    .register-box button:hover { background-color: #a90015; }
    .divider { display: flex; align-items: center; text-align: center; color: #bdbdbd; font-size: 12px; margin: 20px 0;}
    .divider::before,.divider::after { content: ""; flex: 1; border-bottom: 1px solid #ddd;}
    .divider:not(:empty)::before { margin-right: .75em; }
    .divider:not(:empty)::after { margin-left: .75em; }
    .social-login {display: flex; justify-content: space-between; gap: 10px; margin: 20px 0; }
    .social-login button { flex: 1; display: flex; align-items: center; justify-content: center; gap: 8px; border: 1px solid #090101ff; border-radius: 5px; font-weight: bold; font-size: 14px; background-color: white; cursor: pointer; width: 130px; transition: background-color 0.3s;}
    .social-login button:hover {background-color: #f5f5f5;}
    .social-login img {width: 18px; height: 18px;}
    .facebook { color: #1877f2; border-color: #1877f2; cursor: pointer; font-weight: bold; text-decoration: none; }
    .facebook:hover { background-color: #f0f0f0;}
    .google { color: #db4437; border-color: #db4437;cursor: pointer; font-weight: bold; text-decoration: none; }
    .google:hover {background-color: #f0f0f0;}
    .terms { font-size: 12px; color: #999; line-height: 1.5; text-align: center;}
    .terms a { color: #ee4d2d; text-decoration: none;}
    .terms a:hover {text-decoration: underline;}
    .message { text-align: center; margin-top: 50px; font-size: 13px; }
    .footer { background-color: #fff; padding: 40px 80px; color: #666; font-size: 14px; border-top: 1px solid #ddd; }
    .footer-section { display: flex; justify-content: space-around; flex-wrap: wrap; }
    .footer-section div { width: 200px; margin-bottom: 20px; }
    .footer-section h4 { margin-bottom: 10px; color: #000; font-size: 15px; }
    .footer-bottom { text-align: center; padding-top: 20px; border-top: 1px solid #ddd; font-size: 12px; color: #999; }
  </style>
</head>
<body>

  <div class="header">
    <img width="60" src="https://img.icons8.com/color/70/shopee.png" alt="shopee"/> 
    <a href="#" style="color: #ee4d2d; text-decoration: none; position: fixed; left: 90px; "><h3> Shopee </h3> </a> 
    <a href="#" style="color: #040001ff; text-decoration: none; position: fixed; left: 170px;"><p> Đăng ký </p></a> 
    <a href="#" style="color: #d0011b; text-decoration: none;">Bạn cần giúp đỡ?</a> 
  </div>
  <div class="main">
    <div class="register-box">
     <h7>Đăng ký</h7>
      <form method="POST" action="trangdangkymk.php">
        <input type="text" name="dienthoai" id="emailInput" placeholder="Email" required>
<button type="submit" id="nextBtn">TIẾP THEO</button>

    <div class="divider">HOẶC</div>
    <div class="social-login">
      <div class="facebook">
        <button onclick="window.open('https://www.facebook.com/login.php?skip_api_login=1&api_key=421039428061656&kid_directed_site=0&app_id=421039428061656&signed_next=1&next=https%3A%2F%2Fwww.facebook.com%2Fv19.0%2Fdialog%2Foauth%3Fapp_id%3D421039428061656%26cbt%3D1760865456413%26channel_url%3Dhttps%253A%252F%252Fstaticxx.facebook.com%252Fx%252Fconnect%252Fxd_arbiter%252F%253Fversion%253D46%2523cb%253Dfc1fa29941b53e864%2526domain%253Dshopee.vn%2526is_canvas%253Dfalse%2526origin%253Dhttps%25253A%25252F%25252Fshopee.vn%25252Ff77a116844ecd541e%2526relation%253Dopener%26client_id%3D421039428061656%26display%3Dpopup%26domain%3Dshopee.vn%26e2e%3D%257B%257D%26fallback_redirect_uri%3Dhttps%253A%252F%252Fshopee.vn%252Fbuyer%252Fsignup%253Fgad_source%253D1%2526next%253Dhttps%25253A%25252F%25252Fshopee.vn%25252F%25253Fuls_trackid%25253D53up13i000vg%252526utm_campaign%25253Did_nrsuMwAfyU%252526utm_content%25253DCjwKCAjwmNLHBhA4EiwA3ts3mWR1pSiN9hdT4mcx_f_w4BWNbbvY8cF40ZBPSIV79_EUDRzXne9S4hoCsZ0QAvD_BwE_9040377%252526utm_medium%25253Daffiliates%252526utm_source%25253Dan_17358850357%252526utm_term%25253Ddt9qni5ticrb%252526gad_source%25253D1%2526uls_trackid%253D53up13i000vg%2526utm_campaign%253Did_nrsuMwAfyU%2526utm_content%253DCjwKCAjwmNLHBhA4EiwA3ts3mWR1pSiN9hdT4mcx_f_w4BWNbbvY8cF40ZBPSIV79_EUDRzXne9S4hoCsZ0QAvD_BwE_9040377%2526utm_medium%253Daffiliates%2526utm_source%253Dan_17358850357%2526utm_term%253Ddt9qni5ticrb%26locale%3Den_US%26logger_id%3Dfff50a38221ebb2e1%26origin%3D1%26redirect_uri%3Dhttps%253A%252F%252Fstaticxx.facebook.com%252Fx%252Fconnect%252Fxd_arbiter%252F%253Fversion%253D46%2523cb%253Df95c7bf1627df59d0%2526domain%253Dshopee.vn%2526is_canvas%253Dfalse%2526origin%253Dhttps%25253A%25252F%25252Fshopee.vn%25252Ff77a116844ecd541e%2526relation%253Dopener%2526frame%253Dff5818ce0e5933338%26response_type%3Dtoken%252Csigned_request%252Cgraph_domain%26scope%3Dpublic_profile%252Cemail%252Cuser_birthday%26sdk%3Djoey%26version%3Dv19.0%26ret%3Dlogin%26fbapp_pres%3D0%26tp%3Dunspecified&cancel_url=https%3A%2F%2Fstaticxx.facebook.com%2Fx%2Fconnect%2Fxd_arbiter%2F%3Fversion%3D46%23cb%3Df95c7bf1627df59d0%26domain%3Dshopee.vn%26is_canvas%3Dfalse%26origin%3Dhttps%253A%252F%252Fshopee.vn%252Ff77a116844ecd541e%26relation%3Dopener%26frame%3Dff5818ce0e5933338%26error%3Daccess_denied%26error_code%3D200%26error_description%3DPermissions%2Berror%26error_reason%3Duser_denied&display=popup&locale=vi_VN&pl_dbl=0')" class="facebook">
          <a href="https://www.facebook.com" target="_blank" class="social-btn facebook"> 
          <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook">
          <span style= "color: #1877f2">Facebook</span>
          </a>
        </button>
        </div>
        <div class="google">
          <button onclick="window.open('https://accounts.google.com/v3/signin/accountchooser?access_type=offline&client_id=549970890748-5kk9hu6u2auq3phcr7r6facblspeflu9.apps.googleusercontent.com&enable_granular_consent=true&gsiwebsdk=3&include_granted_scopes=false&prompt=consent&redirect_uri=storagerelay%3A%2F%2Fhttps%2Fshopee.vn%3Fid%3Dauth690566&response_type=code&scope=profile+email&dsh=S1244691311%3A1760865523232148&o2v=2&service=lso&flowName=GeneralOAuthFlow&opparams=%253Fenable_granular_consent%253Dtrue&continue=https%3A%2F%2Faccounts.google.com%2Fsignin%2Foauth%2Fconsent%3Fauthuser%3Dunknown%26part%3DAJi8hAO1cO6SnaScxNEERF_7ro0fUqPubi5JcEl4Ihxc_-e9bH9GUtGN0OQXBlDQUkZto3-FbmqacNUUtXem3Q4MhT1Z8eTkzcI0qSxVrc0xvMQyUucwGOaAbEpQLVuYt8MdJLFst-zg-Q-jHsXoxV9mvsH----1BNx5EyQgahtbYv4rVVUjnEytDaB2R0ZhWezT5EQ3gJWXW3hkCBPUYuGy9EjbsaQvmhuI_DcJ2Xd7mRHvgakyXv2EVYoDc0rBAOmN1w3M73an0NDkz1676TwxYtLq6hipqtCjgVPwMTO9X1JqZdyApNnxHjQDq31w95m5sGgfEhKkn0x3_VvsC3934Y8J53ysO3t0a-OIkSqLFFNwRD4Fzivq66SSnTOvmkAjqmBp7Lw4IfVb3qVJzHlUH3hI5deG0ezhe6YXys0cVlTHMQQO2Nv09NdnjmcNRMx4H1Agp0-pOYF_u5M2J240OQQkXKZc9A%26flowName%3DGeneralOAuthFlow%26as%3DS1244691311%253A1760865523232148%26client_id%3D549970890748-5kk9hu6u2auq3phcr7r6facblspeflu9.apps.googleusercontent.com%23&app_domain=https%3A%2F%2Fshopee.vn')" class="google">
          <a href="https://accounts.google.com" target="_blank" class="social-btn google">
          <img src="https://cdn-icons-png.flaticon.com/512/300/300221.png" alt="Google">
         <span style= "color: #db4437">Google</span>
         </a>
        </button>
      </div>
     </div>
      </form>
       <p class="terms">Bằng việc đăng ký, bạn đã đồng ý với Shopee về<br>
        <a href="#">Điều khoản dịch vụ</a> & <a href="#">Chính sách bảo mật</a>
      </p>

      <div class="message">
          <?php if (isset($message)) echo htmlspecialchars($message); ?>
      </div>
      <p style="text-align:center; margin-top:50px; font-size:13px;">
        Bạn đã có tài khoản?
        <a href="dangnhapMOI.php" style="color:#d0011b; text-decoration:none;">Đăng nhập</a>
      </p>
    </div>
  </div>

<?php include 'footer.php'; ?>

<script>
document.getElementById('nextBtn').addEventListener('click', function() {
    // Lấy giá trị email/điện thoại nếu cần
    var email = document.getElementById('emailInput').value;
    if(email === "") {
        alert("Vui lòng nhập email hoặc số điện thoại!");
        return;
    }
    // Chuyển trang với dữ liệu POST, hoặc đơn giản là GET
    window.location.href = 'trangdangkymk.php?email=' + encodeURIComponent(email);
});
</script>
</body>
</html>