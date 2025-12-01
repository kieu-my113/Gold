<?php
include('header.php');
include('ketnoi.php'); // file kết nối $connect

// Lấy mã danh mục từ URL
$madm = isset($_GET['madm']) ? intval($_GET['madm']) : 0;

// Truy vấn sản phẩm theo danh mục
$sql = "SELECT * FROM sanpham WHERE MA_DMSP = $madm ORDER BY NGAYDANG DESC";
$result = mysqli_query($connect, $sql);

// Kiểm tra truy vấn
if (!$result) {
    die("Lỗi truy vấn: " . mysqli_error($connect));
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Danh Mục Sản Phẩm</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
<style>
    body { margin: 0; font-family: Arial, sans-serif; background: #f5f5f5; }
    .site { max-width: 1500px; margin: auto; padding: 16px; background: #fff; }
    .banner img { width: 100%; border-radius: 8px; }

    .layout { display: grid; grid-template-columns: 250px 1fr; gap: 20px; margin-top: 20px; }
    .sidebar { background: #fff; border-radius: 8px; padding: 16px; height: fit-content; }
    ul li { list-style: none; margin: 6px 0; }
    ul li a { text-decoration: none; color: #333; transition: 0.2s; }
    ul li a:hover { color: #ee4d2d; }

    .filter-group { margin-bottom: 18px; }
    .filter-group strong { font-size: 15px; display:block; margin-bottom:6px; }
    .filter-group ul { list-style:none; padding-left:0; }
    .filter-group li { display:flex; align-items:center; gap:8px; margin:6px 0; cursor:pointer; }
    .filter-group input[type=checkbox] { width:16px; height:16px; cursor:pointer; }
    .price-range { display:flex; align-items:center; gap:6px; margin-bottom:8px; }
    .price-range input { width:70px; padding:4px 6px; border:1px solid #ccc; border-radius:4px; }
    .apply-btn { background:#ee4d2d; color:#fff; padding:6px 10px; border:none; border-radius:4px; cursor:pointer; margin-top:4px; }
    .apply-btn:hover { background:#d8431f; }

    .sort-bar { background: #fff; padding: 12px; border-radius: 8px; display: flex; align-items: center; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; }
    .sort-bar button { border:1px solid #ccc; background:#fff; padding:6px 12px; border-radius:4px; cursor:pointer; transition: 0.2s; }
    .sort-bar button:hover { background:#ee4d2d; color:#fff; border-color:#ee4d2d; }

    /* Product Grid */
    .products { display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 20px; }

    .product-card {
        background: #fff;
        border-radius: 12px;
        padding: 12px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.08);
        transition: 0.3s;
        display: flex;
        flex-direction: column;
        text-align: center;
        text-decoration: none;
        color: #333;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        border: 1px solid #ee4d2d;
    }

    .product-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 8px;
    }

    .title { font-size: 14px; line-height: 1.4; height: 42px; overflow: hidden; margin-bottom: 6px; }
    .price { color: #ee4d2d; font-weight: bold; font-size: 16px; }
</style>

</head>
<body>
<div class="site">

  <div class="banner">
    <img src="images/sansaledm.png" alt="Banner">
  </div>

  <div class="layout">

      <aside class="sidebar">
  <h3>Tất Cả Danh Mục</h3>
  <ul>
    <?php
      $danhmuc = [
        13 => 'Thời Trang',
        14 => 'Sức Khỏe',
        15 => 'Thể Thao',
        16 => 'Thiết Bị Điện Tử',
        17 => 'Sắc Đẹp'
      ];

      foreach($danhmuc as $id => $ten){
          $sql_count = "SELECT COUNT(*) as sl FROM sanpham WHERE MA_DMSP = $id";
          $res_count = mysqli_query($connect, $sql_count);
          $row_count = mysqli_fetch_assoc($res_count);
          echo '<li><a href="trangdmthoitrang.php?madm='.$id.'">'.$ten.' ('.$row_count['sl'].')</a></li>';
      }
    ?>
  </ul>

  <!-- Bộ lọc vẫn giữ nguyên -->
  <h3>Bộ Lọc Tìm Kiếm</h3>

  <?php
  $filters = [
      'Đơn Vị Vận Chuyển' => ['Hỏa Tốc','Nhanh','Tiết Kiệm'],
      'Thương Hiệu' => ['AVOCADO','COOLMATE',"LEVI'S",'GENTLEMAN'],
      'Loại Shop' => ['Shopee Mall','Shop Yêu Thích','Shop Yêu Thích+'],
      'Tình Trạng' => ['Mới','Đã Sử Dụng'],
      'Đánh Giá' => ['⭐ trở lên','⭐⭐ trở lên','⭐⭐⭐ trở lên','⭐⭐⭐⭐ trở lên','⭐⭐⭐⭐⭐']
  ];

  foreach($filters as $filter_name => $options){
      echo '<div class="filter-group">';
      echo '<strong>'.$filter_name.'</strong>';
      echo '<ul>';
      foreach($options as $opt){
          echo '<li><input type="checkbox"> '.$opt.'</li>';
      }
      echo '</ul>';
      echo '</div>';
  }
  ?>

  <!-- Khoảng Giá -->
  <div class="filter-group">
    <strong>Khoảng Giá</strong>
    <div class="price-range">
      <label>Từ</label>
      <input type="text"> - <input type="text">
    </div>
    <button class="apply-btn">ÁP DỤNG</button>
  </div>
</aside>

      <!-- Bộ lọc vẫn giữ nguyên nếu muốn -->

    </aside>

    <main>
      <div class="sort-bar">
        <span>Sắp xếp theo:</span>
        <button>Phổ Biến</button>
        <button>Mới Nhất</button>
        <button>Bán Chạy</button>
        <button>Giá</button>
      </div>

      <section class="products">
      <?php
      if(mysqli_num_rows($result) > 0){
          while($row = mysqli_fetch_assoc($result)){
    echo '<a href="chiTietSanPham1.php?masp='.$row['MA_SP'].'" class="product-card">';
    echo '<img src="'.$row['HINHANH'].'" alt="'.$row['TEN_SP'].'">';
    echo '<div class="title">'.$row['TEN_SP'].'</div>';
    echo '<div class="price">₫'.number_format($row['GIA'],0,",",".").'</div>';
    echo '</a>';
}
      } else {
          echo "<p>Hiện chưa có sản phẩm nào trong danh mục này.</p>";
      }
      ?>
      </section>
    </main>
  </div>

</div>
</body>
</html>
