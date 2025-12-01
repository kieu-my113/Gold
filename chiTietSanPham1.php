<?php
session_start();
include('ketnoi.php');
include('header.php');

// ✅ Lấy mã sản phẩm từ URL
if (isset($_GET['MA_SP'])) {
    $MA_SP = (int)$_GET['MA_SP'];
} elseif (isset($_GET['masp'])) {
    $MA_SP = (int)$_GET['masp'];
} else {
    die("⚠️ Thiếu tham số MA_SP trên URL!");
}

// ✅ Lấy dữ liệu sản phẩm từ CSDL
$sql = "SELECT * FROM sanpham WHERE MA_SP = $MA_SP";
$ketqua = mysqli_query($connect, $sql);

if ($ketqua && mysqli_num_rows($ketqua) > 0) {
    $row = mysqli_fetch_assoc($ketqua);
} else {
    die("⚠️ Không tìm thấy sản phẩm trong cơ sở dữ liệu!");
}

// ✅ Khi bấm “Đặt mua”
if (isset($_GET['buy_now'])) {
    // Tạo giỏ hàng tạm chỉ chứa sản phẩm này
    $_SESSION['giohang_tam'] = [];
    $_SESSION['giohang_tam'][$MA_SP] = 1;

    // Chuyển sang xemDonHang.php
    header("Location: xemDonHang2.php?temp=1"); // có thể dùng param temp để phân biệt
    exit();
}

// ✅ Khi bấm “Thêm vào giỏ hàng”
if (isset($_GET['add_to_cart'])) {
    if (!isset($_SESSION['giohang'])) {
        $_SESSION['giohang'] = [];
    }

    if (isset($_SESSION['giohang'][$MA_SP])) {
        $_SESSION['giohang'][$MA_SP]++;
    } else {
        $_SESSION['giohang'][$MA_SP] = 1;
    }

    header("Location: gioHang1.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <title>Chi tiết sản phẩm</title>
</head>
<body>

<div class="container-xl mt-4">
    <div class="h5 pb-2 mb-4 border-bottom">
        <?php echo htmlspecialchars($row['TEN_SP']); ?>
    </div>       

    <div class="row">
        <!-- Hình ảnh sản phẩm -->
        <div class="col-md-6">
            <img src="../Shopee/<?php echo htmlspecialchars($row['HINHANH']); ?>" 
                 alt="Ảnh sản phẩm" 
                 class="img-fluid" 
                 style="max-height:400px; object-fit:cover;">
        </div>

        <!-- Thông tin sản phẩm -->
        <div class="col-md-6">
            <h5 class="mt-0"><?php echo htmlspecialchars($row['TEN_SP']); ?></h5>
            <p><?php echo nl2br(htmlspecialchars($row['MOTA'])); ?></p>
            <p class="fw-semibold">Giá: <?php echo number_format($row['GIA'],0,',','.'); ?>₫</p>

            <!-- ✅ Nút thêm vào giỏ hàng -->
            <?php if (isset($_SESSION['EMAIL'])): ?>
                <a href="chiTietSanPham1.php?MA_SP=<?php echo $row['MA_SP']; ?>&add_to_cart=1" 
                   class="btn btn-success me-2">
                    <i class="bi bi-cart-plus"></i> Thêm vào giỏ hàng
                </a>
            <?php else: ?>
                <a href="../Shopee/dangnhapMOI.php" 
                   class="btn btn-secondary me-2">
                    <i class="bi bi-person-lock"></i> Thêm vào giỏ hàng
                </a>
            <?php endif; ?>

            <!-- ✅ Nút đặt mua (chuyển thẳng sang xemDonHang và hiển thị sản phẩm đó) -->
            <?php if (isset($_SESSION['EMAIL'])): ?>
                <a href="chiTietSanPham1.php?MA_SP=<?php echo $row['MA_SP']; ?>&buy_now=1" 
                   class="btn btn-primary">
                    <i class="bi bi-cart-check"></i> Đặt mua
                </a>
            <?php else: ?>
                <a href="../Shopee/dangnhapMOI.php" 
                   class="btn btn-secondary">
                    <i class="bi bi-person-lock"></i> Đặt mua
                </a>
            <?php endif; ?>
        </div>
    </div> 
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
<?php include('footer.php'); ?>


</body>
</html>