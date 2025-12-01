<?php
session_start();
include('ketnoi.php');

ini_set('display_errors', 1);
error_reporting(E_ALL);

// === KIỂM TRA ĐĂNG NHẬP ===
if(!isset($_SESSION['MA_ND'])){
    die("⚠️ Bạn chưa đăng nhập!");
}
$MA_ND = $_SESSION['MA_ND'];

// === KHỞI TẠO GIỎ HÀNG ===
if(!isset($_SESSION['giohang'])){
    $_SESSION['giohang'] = [];
}

// === TĂNG/GIẢM SỐ LƯỢNG ===
if(isset($_GET['increase']) || isset($_GET['decrease'])){
    $MA_SP = isset($_GET['increase']) ? (int)$_GET['increase'] : (int)$_GET['decrease'];
    if(isset($_SESSION['giohang'][$MA_SP])){
        if(isset($_GET['increase'])){
            $_SESSION['giohang'][$MA_SP]++;
        } else {
            $_SESSION['giohang'][$MA_SP]--;
            if($_SESSION['giohang'][$MA_SP] <= 0){
                unset($_SESSION['giohang'][$MA_SP]);
            }
        }
    }
    $_SESSION['cart_qty'] = array_sum($_SESSION['giohang']);
    header("Location: gioHang1.php");
    exit();
}

// === XOÁ SẢN PHẨM ===
if(isset($_GET['delete'])){
    $MA_SP = (int)$_GET['delete'];
    unset($_SESSION['giohang'][$MA_SP]);
    $_SESSION['cart_qty'] = array_sum($_SESSION['giohang']);
    header("Location: gioHang1.php");
    exit();
}

// === XOÁ TẤT CẢ ===
if(isset($_GET['clear_cart'])){
    $_SESSION['giohang'] = [];
    $_SESSION['cart_qty'] = 0;
    header("Location: gioHang1.php");
    exit();
}

$giohang = $_SESSION['giohang'];
$totalPriceAll = 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Giỏ Hàng</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
<style>
.checkbox-cell { width: 40px; }
.checkbox-big { width: 18px; height: 18px; cursor: pointer; }
</style>
</head>
<body>
<div class="container-xl mt-4">
<h4 class="mb-4">🛒 Giỏ Hàng</h4>

<form action="xemDonHang2.php" method="POST">
<table class="table table-striped align-middle text-center">
<thead>
<tr>
<th class="checkbox-cell"><input type="checkbox" id="checkAll" class="checkbox-big"></th>
<th>Ảnh</th>
<th>Tên sản phẩm</th>
<th>Số lượng</th>
<th>Giá tiền</th>
<th>Thao tác</th>
</tr>
</thead>
<tbody>
<?php
if(!empty($giohang)){
    foreach($giohang as $MA_SP=>$soLuong){
        $sql = "SELECT * FROM sanpham WHERE MA_SP=$MA_SP";
        $res = mysqli_query($connect,$sql);
        $row = mysqli_fetch_assoc($res);

        $totalPrice = $row['GIA']*$soLuong;
        $totalPriceAll += $totalPrice;

        $imgSrc = !empty($row['HINHANH']) ? "../Shopee/".htmlspecialchars($row['HINHANH']) : "https://via.placeholder.com/60x60?text=No+Image";

        echo "<tr>
            <td class='checkbox-cell'><input type='checkbox' name='selected_items[]' value='$MA_SP' class='select-item checkbox-big'></td>
            <td><img src='$imgSrc' width='60' height='60' style='object-fit: contain;'></td>
            <td class='text-start'>".htmlspecialchars($row['TEN_SP'])."</td>
            <td>
                <a href='?decrease=$MA_SP' class='btn btn-sm btn-dark'>-</a>
                <span id='qty-$MA_SP'>$soLuong</span>
                <a href='?increase=$MA_SP' class='btn btn-sm btn-dark'>+</a>
            </td>
            <td id='price-$MA_SP'>".number_format($totalPrice,0,',','.')."₫</td>
            <td><a href='?delete=$MA_SP' class='btn btn-danger btn-sm'>Xóa</a></td>
        </tr>";
    }
}else{
    echo "<tr><td colspan='6' class='py-4'>Giỏ hàng trống! <a href='index.php'>Tiếp tục mua sắm</a></td></tr>";
}
?>
</tbody>
</table>

<?php if(!empty($giohang)): ?>
<div class="d-flex justify-content-between align-items-center">
<h5>Tổng tiền: <span id="totalPrice"><?= number_format($totalPriceAll,0,',','.') ?>₫</span></h5>
<button type="submit" class="btn btn-success">Xem đơn hàng</button>
</div>
<?php else: ?>

<?php endif; ?>
</form>

<div class="text-center mt-4">
<a href="?clear_cart=1" class="btn btn-danger btn-sm">Xóa tất cả</a>
</div>
</div>
</body>
</html>
