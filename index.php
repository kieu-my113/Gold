    <?php
         session_start();
        include('ketnoi.php');
        //Kiểm tra đăng nhập
        include('header.php');
        

        $sqlTheLoai = "SELECT * FROM theloai";
        $ketquaTheLoai = mysqli_query($connect, $sqlTheLoai);
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <title>Website SHOPEE</title>
</head>
<style>
/* Khung Flash Sale chuẩn */
#flashSaleWrap {
   position: relative;
  background-color: #fff; 
  color: #000; 
  border-radius: 6px;
  padding: 20px;
}

/* Header Flash Sale */
#flashSaleHeader {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 12px;
}

/* Khu vực trượt sản phẩm */
#flashSaleProducts {
  display: flex;
  flex-wrap: nowrap;
  overflow-x: auto;
  scroll-behavior: smooth;
  gap: 18px;
  padding-bottom: 8px;
}

#flashSaleProducts {
  scrollbar-width: none;
}

/* Card sản phẩm kiểu Shopee  */
#flashSaleProducts .fs-card {
  flex: 0 0 auto;
  width: 220px;
  background: none;              
  border: none;                  
  box-shadow: none;              
  border-radius: 0;              
  overflow: hidden;
  transition: transform 0.2s ease;
  text-align: center;
}

#flashSaleProducts .fs-card img {
  width: 100%;
  height: 220px;
  object-fit: cover;
  display: block;
  border-radius: 6px;
}

#flashSaleProducts .fs-card:hover {
  transform: translateY(-4px);
}

/* Chữ và giá tiền */
#flashSaleProducts .fs-card .card-body {
  background: none; 
  padding: 8px 0 0;
}

#flashSaleProducts .fs-card p {
  margin-bottom: 4px;
}

#flashSaleProducts .fs-card .price {
  color: #ff5722;
  font-weight: 700;
}

/* Nút mũi tên */
.arrow-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: rgba(255, 87, 34, 0.9);
  border: none;
  border-radius: 50%;
  width: 42px;
  height: 42px;
  color: white;
  font-size: 22px;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 5;
  transition: 0.3s;
}

.arrow-btn:hover {
  background: #ff784e;
  transform: translateY(-50%) scale(1.1);
}
#prevBtn {
  left: -18px;
}
#nextBtn {
  right: -18px;
}
.btn-flashsale {
  background-color: #ff5722;
  color: #fff;
  border: none;
  border-radius: 20px;
  padding: 6px 16px;
  transition: 0.3s;
}

.btn-flashsale:hover {
  background-color: #ff784e;
  color: #fff;
}
.fs-card {
  cursor: pointer;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.fs-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
/* css tìm kiếm hàng đầu  */
#topSearchWrap {
  background: #fff;            
  color: #000;                 
  border-radius: 8px;
  padding: 20px;
  border: 1px solid #eee;      
}
#topSearchHeader h4 {
  color: #ff5722;
  font-weight: 700;
}
#topSearchProducts img {
  width: 200px;
  height: 200px;
  object-fit: cover;
  border-radius: 6px;
}
.top-card {
  flex: 0 0 auto;
  width: 200px;
  text-align: center;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
  background: #fff;
  border-radius: 6px;
}
.top-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.top-label {
  position: absolute;
  top: 0;
  left: 0;
  background: #ff5722;
  color: #fff;
  font-weight: 700;
  font-size: 13px;
  padding: 2px 6px;
  border-bottom-right-radius: 4px;
}
.sold-info {
  position: absolute;
  bottom: 0;
  width: 100%;
  background: rgba(0,0,0,0.5);
  color: #fff;
  font-size: 14px;
  font-weight: 500;
  padding: 3px 0;
  border-radius: 0 0 4px 4px;
}
#topSearchProducts p {
  color: #000;
  font-weight: 500;
}
.scroll-container {
  position: relative;
  display: flex;
  align-items: center;
}
#topSearchProducts {
  display: flex;
  gap: 18px;
  overflow-x: auto;
  scroll-behavior: smooth;
  padding-bottom: 8px;
  width: calc(220px * 5 + 18px * 4);
  margin: 0 auto;
}

/* Ẩn thanh trượt */
#topSearchProducts::-webkit-scrollbar {
  display: none;
}
#topSearchProducts {
  -ms-overflow-style: none;
  scrollbar-width: none;
}

/* Nút mũi tên */
.scroll-btn {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: #ff5722;
  color: #fff;
  border: none;
  font-size: 24px;
  cursor: pointer;
  padding: 8px 12px;
  border-radius: 50%;
  box-shadow: 0 2px 6px rgba(0,0,0,0.2);
  z-index: 10;
  transition: 0.2s;
}

.scroll-btn:hover {
  background: #e64a19;
}

/* Vị trí trái/phải */
.scroll-btn.left {
  left: -10px;
}
.scroll-btn.right {
  right: -10px;
}
/* hết css tìm kiếm hàng đầu  */
/* css bảng gợi ý hàng đầu  */
#suggestionWrap {
  background-color: #fff;
  border-radius: 8px;
  padding: 20px;
  margin-bottom: 30px;
}

#suggestionWrap h4 {
  color: #ff5722;
  font-weight: 700;
  text-align: center;
  margin-bottom: 20px;
}

#suggestionProducts {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 20px;
}

.suggestion-card {
  width: 200px;
  text-align: center;
  background: #fff;
  border-radius: 6px;
  transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.suggestion-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}

.suggestion-card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
  border-radius: 6px;
}
.product-card {
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
}
/* kết thúc css bảng gợi ý hàng đầu  */
</style>

<body>
  <?php include 'popup.php'; ?>

    <div class="container-xl mb-2 pt-4"> <div class="container mt-3"> <div class="row"> <!-- Carousel bên trái --> <div class="col-9"> <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="true" data-bs-touch="true"> <div class="carousel-inner"> <div class="carousel-item active" data-bs-interval="3000"> <img src="https://cf.shopee.vn/file/vn-11134258-7ras8-m5184szf0klz56_xxhdpi" class="d-block w-100 rounded-3" alt="Banner 1"> </div> <div class="carousel-item" data-bs-interval="3000"> <img src="https://cf.shopee.vn/file/sg-11134258-7rfhf-m9a09vs6phll28_xxhdpi" class="d-block w-100 rounded-3" alt="Banner 2"> </div> <div class="carousel-item" data-bs-interval="3000"> <img src="https://cf.shopee.vn/file/sg-11134258-7rfgn-m9e5lp1m3t9j03_xhdpi" class="d-block w-100 rounded-3" alt="Banner 3"> </div> </div> <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="visually-hidden">Previous</span> </button> <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="visually-hidden">Next</span> </button> </div> </div> <!-- 2 ảnh nhỏ bên phải --> <div class="col-3 d-flex flex-column justify-content-between"> <div class="mb-2"> <img src="logo/imgphai1.jpg" class="img-fluid rounded-3" alt="Banner nhỏ 1"> </div> <div> <img src="logo/imgphai2.jpg" class="img-fluid rounded-3" alt="Banner nhỏ 2"> </div> </div> </div> </div> </div>
    <?php include 'menudeal1k.php'; ?>

    <div class="container-xl my-4" id="flashSaleWrap">
  <div id="flashSaleHeader">
    <div class="d-flex align-items-center">
      <h4 class="mb-0" style="color:#ff5722;font-weight:700;">FLASH SALE</h4>
      <div id="countdown" class="ms-3 px-3 py-1 rounded" style="background:#000;color:#fff;font-weight:700;">01 : 44 : 02</div>
    </div>
    <a href="#" class="text-decoration-none" style="color:#ff5722;">Xem tất cả &gt;</a>
  </div>
 <!-- Nút mũi tên -->
  <button id="prevBtn" class="arrow-btn" style="left:-10px;"><i class="bi bi-chevron-left"></i></button>
  <button id="nextBtn" class="arrow-btn" style="right:-10px;"><i class="bi bi-chevron-right"></i></button>

  <div id="flashSaleProducts" class="pb-2">
 <?php
// FLASH SALE
if (!isset($_SESSION['flashSaleList']) || !is_array($_SESSION['flashSaleList']) || empty($_SESSION['flashSaleList'])) {
    $sqlFlash = "SELECT MA_SP FROM sanpham ORDER BY RAND() LIMIT 6";
    $resultFlash = mysqli_query($connect, $sqlFlash);

    $_SESSION['flashSaleList'] = [];
    if ($resultFlash && mysqli_num_rows($resultFlash) > 0) {
        while ($sp = mysqli_fetch_assoc($resultFlash)) {
            $_SESSION['flashSaleList'][] = $sp['MA_SP'];
        }
    }
}

$flashIds = implode(',', $_SESSION['flashSaleList']);
$resultFlash = false;
if (!empty($flashIds)) {
    $sqlFlashShow = "SELECT * FROM sanpham WHERE MA_SP IN ($flashIds)";
    $resultFlash = mysqli_query($connect, $sqlFlashShow);
}

if ($resultFlash && mysqli_num_rows($resultFlash) > 0) {
    while ($sp = mysqli_fetch_array($resultFlash)) {
        echo "
        <a href='chiTietSanPham1.php?masp=" . $sp['MA_SP'] . "' class='text-decoration-none text-dark'>
          <div class='fs-card'>
            <img src='../Shopee/" . htmlspecialchars($sp['HINHANH']) . "' alt='" . htmlspecialchars($sp['TEN_SP']) . "'>
            <div class='card-body'>
              <p class='text-truncate fw-bold mb-1' style='color:#ff5722;'>" . htmlspecialchars($sp['TEN_SP']) . "</p>
              <p class='mb-2' style='color:#ff5722;font-weight:700;'>" . number_format($sp['GIA']) . " đ</p>
              <div class='btn btn-sm btn-flashsale fw-bold'>ĐANG BÁN CHẠY</div>
            </div>
          </div>
        </a>
        ";
    }
} else {
    echo "<p class='text-center text-muted'>Chưa có sản phẩm nào trong Flash Sale.</p>";
}
?>
  </div>
</div>
<!-- HẾT FLASH SALE -->
 <!-- TÌM KIẾM HÀNG ĐẦU -->
<div class="container-xl my-4" id="topSearchWrap">
  <div id="topSearchHeader" class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 text-warning fw-bold">TÌM KIẾM HÀNG ĐẦU</h4>
    <a href="#" class="text-decoration-none text-warning">Xem Tất Cả &gt;</a>
  </div>
<div class="scroll-container">
  <!-- Nút mũi tên trái -->
  <button class="scroll-btn left"><i class="bi bi-chevron-left"></i></button>

  <div id="topSearchProducts" class="d-flex overflow-auto gap-3 pb-2">
    <?php
      $sqlTop = "SELECT * FROM sanpham ORDER BY RAND() LIMIT 6";
      $resultTop = mysqli_query($connect, $sqlTop);

      while ($sp = mysqli_fetch_array($resultTop)) {
        echo "
        <a href='chiTietSanPham1.php?masp=".$sp['MA_SP']."' class='text-decoration-none text-light'>
          <div class='top-card'>
            <div class='position-relative'>
              <span class='top-label'>TOP</span>
              <img src='../Shopee/".$sp['HINHANH']."' alt='".htmlspecialchars($sp['TEN_SP'])."'>
              <div class='sold-info'>Bán ".rand(40,80)."k+ / tháng</div>
            </div>
            <p class='mt-2 text-truncate'>".htmlspecialchars($sp['TEN_SP'])."</p>
          </div>
        </a>
        ";
      }
    ?>
  </div>

  <!-- Nút mũi tên phải -->
  <button class="scroll-btn right"><i class="bi bi-chevron-right"></i></button>
</div>
<!-- HẾT TÌM KIẾM HÀNG ĐẦU -->
 <!-- GỢI Ý HÔM NAY -->
<div class="container-xl my-4" style="background: #ffffff; border-radius: 8px; padding: 20px;">
  <h4 class="text-center text-danger mb-4" style="border-bottom: 2px solid #ff5722; padding-bottom: 8px;">GỢI Ý HÔM NAY</h4>
  <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 g-3">
    <?php
      $sqlGoiY = "SELECT * FROM sanpham ORDER BY RAND() LIMIT 20";
      $resultGoiY = mysqli_query($connect, $sqlGoiY);

      while ($sp = mysqli_fetch_array($resultGoiY)) {
        $giamGia = rand(10, 50); // Random giảm giá
        echo "
        <div class='col'>
          <a href='chiTietSanPham1.php?masp=".$sp['MA_SP']."' class='text-decoration-none text-dark'>
                <div class='card border-0 shadow-sm h-100 position-relative product-card' style='background:#ffffff; border-radius: 6px;'>
              <span class='position-absolute top-0 start-0 bg-danger text-white px-1 small' style='font-size: 13px;'>-".$giamGia."%</span>
              <img src='../Shopee/".$sp['HINHANH']."' class='card-img-top' alt='".htmlspecialchars($sp['TEN_SP'])."' style='height:200px; object-fit: cover; border-radius: 6px 6px 0 0;'>
              <div class='card-body p-2'>
                <p class='text-truncate fw-bold mb-1' style='font-size:14px;'>".htmlspecialchars($sp['TEN_SP'])."</p>
                <p class='text-warning fw-bold mb-1'>".number_format($sp['GIA'])." đ</p>
                <div class='d-flex flex-wrap gap-1'>
                  <span class='badge bg-danger'>Yêu thích</span>
                  <span class='badge bg-warning text-dark'>Rẻ Vô Địch</span>
                </div>
              </div>
            </div>
          </a>
        </div>
        ";
      }
    ?>
  </div>
</div>
    <?php
    ?>
<script>
  // Đếm ngược flash sale (ví dụ 1h 44p 2s)
  let h = 1, m = 44, s = 2;
  const countdown = document.getElementById("countdown");

  function updateCountdown() {
    if (s > 0) s--;
    else {
      s = 59;
      if (m > 0) m--;
      else {
        m = 59;
        if (h > 0) h--;
      }
    }
    countdown.textContent =
      String(h).padStart(2, "0") + " : " +
      String(m).padStart(2, "0") + " : " +
      String(s).padStart(2, "0");
  }

  setInterval(updateCountdown, 1000);
</script>
<script>
  const container = document.getElementById("flashSaleProducts");
  document.getElementById("prevBtn").onclick = () => {
    container.scrollBy({ left: -250, behavior: "smooth" });
  };
  document.getElementById("nextBtn").onclick = () => {
    container.scrollBy({ left: 250, behavior: "smooth" });
  };
</script>
<script>
const topContainer = document.getElementById('topSearchProducts'); // container chính
const topBtnLeft = document.querySelector('.scroll-btn.left');
const topBtnRight = document.querySelector('.scroll-btn.right');

// Lấy danh sách sản phẩm
const topProducts = topContainer.querySelectorAll('.top-card');
const visibleCount = 5; // Hiển thị 5 sản phẩm mỗi lần
let currentIndex = 0;

// Tính chiều rộng 1 sản phẩm (bao gồm khoảng cách)
const itemWidth = topProducts[0].offsetWidth + 18; // 18 là khoảng cách gap giữa các thẻ

topBtnRight.addEventListener('click', () => {
  if (currentIndex < topProducts.length - visibleCount) {
    currentIndex++;
    topContainer.scrollTo({
      left: currentIndex * itemWidth,
      behavior: 'smooth'
    });
  }
});

topBtnLeft.addEventListener('click', () => {
  if (currentIndex > 0) {
    currentIndex--;
    topContainer.scrollTo({
      left: currentIndex * itemWidth,
      behavior: 'smooth'
    });
  }
});
</script>
<?php include('footer.php'); ?>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap core JavaScript-->
<script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</html>