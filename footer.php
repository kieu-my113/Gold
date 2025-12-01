<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Footer Shopee</title>

  <style>

    .footer-bct img {
    height: auto;   /* không ép chiều cao */
    width: auto;    /* để CSS riêng cho từng ảnh */
    max-height: 100px; /* tuỳ chỉnh kích thước tối đa nếu muốn */
    border: none;   /* xóa viền nếu có */
    box-shadow: none; /* xóa bóng nếu có */
}

/* Riêng ảnh vantay */
.img-vantay {
    width: 90px;       /* tăng kích thước tùy ý */
    height: auto;       /* giữ tỉ lệ */
    border-radius: 76px; /* bo tròn */
    overflow: hidden;
    border: none;       /* xóa khung trắng */
    box-shadow: none;   /* xóa bóng */
}

    .theodoi a {
      text-decoration: none;
      color: #333;              /* Màu chữ mặc định */
      transition: color 0.3s;   /* Hiệu ứng mượt khi đổi màu */
    }

    .theodoi a:hover {
      color: #ee4d2d;           /* Màu cam Shopee khi hover */
    }

    .theodoi img {
      vertical-align: middle;
      margin-right: 6px;
      transition: transform 0.3s;
    }

    
    /* Footer chung */
    .footer {
      background-color: #fff;
      padding: 40px 80px;
      color: #666;
      font-size: 14px;
      border-top: 1px solid #ddd;
    }

    .footer-section {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
    }

    .footer-section div {
      width: 200px;
      margin-bottom: 20px;
    }

    .footer-section h4 {
      margin-bottom: 10px;
      color: #000;
      font-size: 15px;
    }

    .footer-bottom {
      text-align: center;
      padding-top: 20px;
      border-top: 1px solid #ddd;
      font-size: 12px;
      color: #999;
    }

    .footer a {
        text-decoration: none;   /* Xóa gạch chân */
        color: #515050ff;             /* Màu mặc định */
        transition: color 0.3s;  /* Hiệu ứng mượt khi đổi màu */
        }

        .footer a:hover {
        color: #ee4d2d;          /* Màu cam Shopee khi hover */
        }

        .footer-giua {
        text-align: center;
        font-size: 13px;
        color: #666;
        margin-top: 20px;
        }

        .footer-bct {
        display: flex;
        justify-content: center; /* Canh giữa theo chiều ngang */
        align-items: center;     /* Căn giữa theo chiều dọc */
        gap: 20px;               /* Khoảng cách giữa 2 ảnh */
        margin-top: 10px;
        }

        .footer-bct img {
        height: 50px;
        width: auto;
        }

                .app-download {
        display: flex;
        align-items: center;      /* Căn giữa QR và logo theo chiều dọc */
        gap: 15px;                /* Khoảng cách giữa QR và nhóm logo */
        margin-top: 10px;
        }

        

        .qr {
  width: 120px;  
   height: 120px;              /* Giữ kích thước QR */
  border: 4px solid #fff;       /* Viền trắng xung quanh */
  border-radius: 8px;           /* Bo góc nhẹ cho đẹp */
  box-shadow: 0 0 6px rgba(0,0,0,0.2); /* Đổ bóng nhẹ */
  cursor: pointer;              /* Khi hover biến thành bàn tay */
  transition: transform 0.3s;   /* Hiệu ứng mượt */
}

.qr:hover {
  transform: scale(1.05);       /* Phóng nhẹ khi hover */
}
.store-item {
  display: flex;
  align-items: center;          /* canh giữa logo và chữ theo chiều dọc */
             /* nền trắng */
  border-radius: 8px;
           /* tạo khung trắng bao quanh */
  box-shadow: 0 1px 5px rgba(0,0,0,0.15);
  cursor: pointer;
  transition: transform 0.3s, box-shadow 0.3s;
  width: 100px;                 /* cố định chiều rộng khung (có thể chỉnh) */
}


        
        .store-logos {
            width: 20px;
        display: flex;
        flex-direction: column;   /* Xếp 3 logo theo cột */
        gap: 10px;                /* Khoảng cách giữa các logo */
        }

        .store-logos img {
  width: 100px;                /* Nhỏ hơn QR, cân đối */
  height: auto;
    border-radius: 8px;


  cursor: pointer;
  transition: transform 0.3s, box-shadow 0.3s;
}
        .footer-top {
            display: flex;                      /* Căn 2 phần cùng hàng */
            justify-content: space-between;     /* Left nằm trái, Right nằm phải */
            align-items: center;                /* Căn giữa theo chiều dọc */
            padding: 10px 10px;                 /* Khoảng cách hai bên */
            font-size: 14px;
            color: #666;
            border-top: 1px solid #ddd;         /* Gạch mảnh phía trên (giống Shopee) */
            }

            .footer-left {
            text-align: left;
            }

            .footer-right {
            text-align: right;
            }
            /* Khối chứa logo + chữ */
.logo-with-text {
  position: relative;
  display: inline-block;
  width: 130px;        /* khung vừa ảnh */
}

.logo-img {
  width: 100%;
  border: 2px solid #fff;
  border-radius: 6px;
}

/* Chữ nằm đè bên trong ảnh */
.logo-text {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  font-size: 14px;
  font-weight: 500;
  color: #333;
  pointer-events: none; /* không chặn click ảnh */
}

.thanhtoan img {
    width: 50px;
    height: 27px;
    object-fit: contain;       /* đảm bảo hình không bị méo */
    margin-right: 8px;         /* khoảng cách giữa các logo */
    vertical-align: middle;

    /* Bo góc và đổ bóng */
    border-radius: 8px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    transition: transform 0.3s, box-shadow 0.3s; /* hiệu ứng mượt khi hover */
}

/* Hiệu ứng hover */
.thanhtoan img:hover {
    transform: scale(1.1); /* phóng to nhẹ */
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25); /* đổ bóng mạnh hơn khi hover */
}

/* Phần thanh toán (3 logo 1 hàng) */
.payment-logos {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
  justify-items: center;
  margin-bottom: 20px;
}

/* Phần vận chuyển (mỗi hàng 3 logo) */
.shipping-logos {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
  justify-items: center;
  margin-bottom: 16px;
}
.theodoi p {
  margin-bottom: 10px; /* khoảng cách giữa các mạng xã hội */
}
.footer-section div p {
  margin-bottom: 10px;
}



       





  </style>
</head>

<body>
  <div class="footer">
    <div class="footer-section">
      <div>
        <h4>DỊCH VỤ KHÁCH HÀNG</h4>
        <p>
            <a href="https://help.shopee.vn/portal/4" target="_blank">
                Trung Tâm Trợ Giúp Shopee
            </a>
        </p>

        <p>
            <a href="https://shopee.vn/blog/">
                Shopee Blog

            </a>
            
        </p>

        <p>
            <a href="https://help.shopee.vn/portal/4/article/79090-[Th%C3%A0nh-vi%C3%AAn-m%E1%BB%9Bi]-Shopee-Mall-l%C3%A0-g%C3%AC?previousPage=search+recommendation+bar">
            Shopee Mall
            </a>
        </p>

        <p>
            <a href="https://help.shopee.vn/portal/4/article/">

              Hướng Dẫn Mua Hàng / Đặt Hàng
            </a>
        </p>

        <p>
            <a href="https://help.shopee.vn/portal/4/article/79180-[Th%c3%a0nh-vi%c3%aan-m%e1%bb%9bi]-L%c3%a0m-sao-%c4%91%e1%bb%83-mua-h%c3%a0ng-%2F-%c4%91%e1%ba%b7t-h%c3%a0ng-tr%c3%aan-%e1%bb%a9ng-d%e1%bb%a5ng-Shopee%3F">
              Hướng Dẫn Bán Hàng
           </a>
        </p>
        
        <p>
            <a href="https://help.shopee.vn/portal/4/category/59-Thanh-To%25C3%25A1n/708-V%25C3%25AD-ShopeePay?page=1">
              Ví ShopeePay
            </a>
        </p>

        <p>
            <a href="https://help.shopee.vn/portal/4/article/79144-[Shopee-Xu]-C%c3%a1c-c%c3%a2u-h%e1%bb%8fi-th%c6%b0%e1%bb%9dng-g%e1%ba%b7p">
              Shopee Xu
            </a>
        </p>

        <p>
            <a href="https://help.shopee.vn/portal/4/category/60-%25C4%2590%25C6%25A1n-H%25C3%25A0ng-V%25E1%25BA%25ADn-Chuy%25E1%25BB%2583n/703-%25C4%2590%25C6%25A1n-h%25C3%25A0ng?page=1">
                Đơn Hàng
            </a>
        </p>

        <p>
            <a href="https://help.shopee.vn/portal/4/article/79258-Tr%e1%ba%a3-h%c3%a0ng%2FHo%c3%a0n-ti%e1%bb%81n]-C%e1%ba%a9m-nang-Tr%e1%ba%a3-h%c3%a0ng-ho%c3%a0n-ti%e1%bb%81n">
                Trả Hàng / Hoàn Tiền
            </a>
        </p>

        <p>
            <a href="https://help.shopee.vn/portal/4/article/79191-%5BD%E1%BB%8Bch-v%E1%BB%A5%5D-L%C3%A0m-sao-%C4%91%E1%BB%83-li%C3%AAn-h%E1%BB%87-Ch%C4%83m-s%C3%B3c-Kh%C3%A1ch-h%C3%A0ng">
                Liên Hệ Shopee
            </a>
        </p>

        <p>
            <a href="https://help.shopee.vn/portal/4/article/79046-[Quy-%c4%91%e1%bb%8bnh]-Ch%c3%adnh-s%c3%a1ch-b%e1%ba%a3o-h%c3%a0nh-cho-s%e1%ba%a3n-ph%e1%ba%a9m-mua-t%e1%ba%a1i-Shopee">
                Chính Sách Bảo Hành
            </a>
        </p>
      </div>

      <div>
        <h4>SHOPEE VIỆT NAM</h4>
        <p>
            <a href="https://careers.shopee.vn/about">
                Về Shopee
            </a>
        </p>

        <p>
            <a href="https://careers.shopee.vn/about">
                Tuyển Dụng
            </a>
        </p>

        <p>
            <a href="https://help.shopee.vn/portal/4/article/77242">
                Điều Khoản Shopee
            </a>
        </p>

        <p>
            <a href="https://help.shopee.vn/portal/4/article/77244">
                Chính Sách Bảo Mật
            </a>
        </p>

        <p>
            <a href="banhang.shopee.vn">
                Kênh Người Bán
            </a>
        </p>

        <p>
            <a href="https://shopee.vn/flash_sale/">
                Flash Sale
            </a>
        </p>

        <p>
            <a href="https://shopee.vn/affiliate/">
                Tiếp Thị Liên Kết
            </a>
        </p>

        <p>
            <a href="">
                Liên Hệ Truyền Thông
            </a>
        </p>
      </div>

      <div class="thanhtoan">
        <h4>THANH TOÁN</h4>
          <div class="payment-logos">

            <img src="logo/visa.jpg" alt="Visa" >
            <img src="logo/mastercard.jpg" alt="">
            <img src="logo/jcb.jpg" alt="JCB" >
            <img src="logo/amc.jpg" alt="">
            <img src="logo/cod.jpg" alt="">
            <img src="logo/0.jpg" alt="">
            <img src="logo/spay.jpg" alt="">
            <img src="logo/spaylater.jpg" alt="">
          </div>

        <h4>ĐƠN VỊ VẬN CHUYỂN</h4>
        <div class="shipping-logos">
            <img src="logo/spx.jpg" alt="">
            <img src="logo/ghn.jpg" alt="">
            <img src="logo/vt.jpg" alt="">
            <img src="logo/vnp.jpg" alt="">
            <img src="logo/jt.jpg" alt="">
            <img src="logo/grab.jpg" alt="">
            <img src="logo/ninja.jpg" alt="">
            <img src="logo/be.jpg" alt="">
            <img src="logo/aha.jpg" alt="">
        </div>
      </div>

      <!-- THEO DÕI SHOPEE -->
      <div class="theodoi">
        <h4>THEO DÕI SHOPEE</h4>
        <p>
          <a href="https://www.facebook.com/ShopeeVN" target="_blank">
            <img src="logo/fb-den.png" alt="Facebook" width="18"> Facebook
          </a>
        </p>
        <p>
          <a href="https://www.instagram.com/Shopee_VN/" target="_blank">
            <img src="logo/itg-den.png" alt="Instagram" width="18"> Instagram
          </a>
        </p>
        <p>
          <a href="https://www.linkedin.com/company/shopee" target="_blank">
            <img src="logo/in.jpg" alt="LinkedIn" width="18"> LinkedIn
          </a>
        </p>
      </div>

      <!-- TẢI ỨNG DỤNG -->
        <div>
  <h4>TẢI ỨNG DỤNG SHOPEE</h4>

  <div class="app-download">
    <img src="logo/maqr.jpg" alt="Mã QR" class="qr" width="120">

    
        <div class="store-logos">
  <a href="https://apps.apple.com/vn/app/shopee/id959841449" target="_blank" class="store-item">
    <img src="logo/apple.jpg" alt="">
  
  </a>

  <a href="https://play.google.com/store/apps/details?id=com.shopee.vn" target="_blank" class="store-item">
    <img src="logo/google-play.jpg" alt="Google Play">
  </a>

  <a href="https://appgallery.huawei.com/app/C101473853" target="_blank" class="store-item">
    <img src="logo/huawei.jpg" alt="">
  </a>
</div>

  </div>
</div>


    </div>
   
    <div class="footer-bottom">
        <div class="footer-left">
              © 2025 Shopee. Tất cả các quyền được bảo lưu. 
        </div>

        <div class="footer-right">
        Quốc gia & Khu vực: Singapore | Indonesia | Thái Lan | Malaysia | Việt Nam | Philippines | Brazil | Mexico | Colombia | Chile | Đài Loan
        </div>
        
        <div class="footer-giua">
            CHÍNH SÁCH BẢO MẬT | QUY CHẾ HOẠT ĐỘNG | CHÍNH SÁCH VẬN CHUYỂN | CHÍNH SÁCH TRẢ HÀNG VÀ HOÀN TIỀN
        </div>

            <div class="footer-bct">
        <img src="logo/bct.jpg" alt="Bộ Công Thương" width="120">
        <img src="logo/bct.jpg" alt="Bộ Công Thương" width="120">
                <img src="logo/vantay.jpg" alt="Bộ Công Thương"  class="img-vantay">

        </div>
        <div class="footer-info">
            <p><strong>Công ty TNHH Shopee</strong></p>
            <p>Địa chỉ: Tầng 4-5-6, Tòa nhà Capital Place, số 29 đường Liễu Giai, Phường Ngọc Hà, Thành phố Hà Nội, Việt Nam</p>
            <p>Chăm sóc khách hàng: Gọi tổng đài Shopee (miễn phí) hoặc Trò chuyện với Shopee ngay trên Trung tâm trợ giúp</p>
            <p>Chịu Trách Nhiệm Quản Lý Nội Dung: Nguyễn Bùi Anh Tuấn</p>
            <p>Mã số doanh nghiệp: 0106773786 do Sở Kế hoạch và Đầu tư TP Hà Nội cấp lần đầu ngày 10/02/2015</p>
            <p>© 2015 - Bản quyền thuộc về Công ty TNHH Shopee</p>
            </div>
  </div>
</body>
</html>
