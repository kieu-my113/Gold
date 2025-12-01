<?php
session_start();
include('ketnoi.php');


// Hiển thị lỗi để debug
ini_set('display_errors', 1);
error_reporting(E_ALL);

// ------------------------
// KIỂM TRA ĐĂNG NHẬP
// ------------------------
if (!isset($_SESSION['MA_ND'])) {
    die("⚠️ Bạn chưa đăng nhập!");
}
$MA_ND = $_SESSION['MA_ND'];

// ------------------------
// LẤY GIỎ HÀNG
// ------------------------
$giohang = $_SESSION['giohang'] ?? [];

// ------------------------
// LẤY THÔNG TIN KHÁCH HÀNG
// ------------------------
$customer = ['HOTEN'=>'', 'SDT'=>'', 'DIACHI'=>'']; // tránh undefined
$stmt_customer = mysqli_prepare($connect, "SELECT HOTEN, SDT, DIACHI FROM nguoidung WHERE MA_ND = ?");
mysqli_stmt_bind_param($stmt_customer, "i", $MA_ND);
mysqli_stmt_execute($stmt_customer);
$res_customer = mysqli_stmt_get_result($stmt_customer);
if ($res_customer && mysqli_num_rows($res_customer) > 0) {
    $customer = mysqli_fetch_assoc($res_customer);
}

// ------------------------
// XỬ LÝ NÚT "Thanh toán xong về Trang Chủ"
// ------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pay_now'])) {
    $selectedItems = isset($_POST['selected_items']) ? explode(',', $_POST['selected_items']) : [];

    // Xóa sản phẩm vừa mua khỏi giỏ hàng
    foreach ($selectedItems as $MA_SP) {
        unset($_SESSION['giohang'][$MA_SP]);
    }

    // Tính ngày giao hàng dự kiến (+3 ngày)
    $today = new DateTime();
    $today->modify('+3 day');
    $deliveryDate = $today->format('d/m/Y');

    // Alert + redirect về trang chủ
    echo "<script>
        alert('✅ Đơn hàng của bạn sẽ đến vào ngày $deliveryDate');
        window.location.href = 'index.php';
    </script>";
    exit();
}

// ------------------------
// TÍNH TỔNG TIỀN
// ------------------------
$total_price = 0;
$shipFee = 20000; // phí vận chuyển mặc định
foreach ($giohang as $MA_SP => $soLuong) {
    $sql = "SELECT GIA FROM sanpham WHERE MA_SP = $MA_SP";
    $res = mysqli_query($connect, $sql);
    if ($res && mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $total_price += $row['GIA'] * $soLuong;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Thông Tin Giỏ Hàng</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
body { background-color: #ff5722; color: white; font-family: Segoe UI, sans-serif; }
.container { max-width: 650px; margin: 30px auto; background: #fff; color: #000; padding: 20px; border-radius: 8px; }
.btn-orange { background-color: #ff5722 !important; color: #fff !important; border: none; }
.product-item img { width: 55px; height: 55px; object-fit: contain; margin-right: 10px; }
.voucher-box { border: 1px solid #ff5722; border-radius: 6px; padding: 10px; cursor: pointer; margin-bottom: 10px; }
.selected-voucher { color: green; font-weight: bold; }
.form-check { padding: 12px; border: 1px solid #ddd; border-radius: 8px; margin-bottom: 12px; }
.form-check-label { margin-left: 8px; font-weight: 600; }
.payment-detail span { font-size: 17px; }
.modal-content, .modal-body, .modal-footer { color: #000 !important; } 
.modal-header h5, .modal-title { color: #000 !important; } 
.btn-close { filter: invert(0) !important; }
</style>
</head>
<body>
<div class="container">

<h2 class="text-center mb-3">Thông Tin Giỏ Hàng</h2>
<hr>

<h4>Thông Tin Khách Hàng</h4>
<p><strong>Tên:</strong> <?= htmlspecialchars($customer['HOTEN']) ?></p>
<p><strong>SĐT:</strong> <?= htmlspecialchars($customer['SDT']) ?></p>
<p><strong>Địa chỉ:</strong> <?= htmlspecialchars($customer['DIACHI']) ?></p>

<?php
if (!empty($giohang)) {  
    foreach ($giohang as $MA_SP => $soLuong) {
        $sql = "SELECT * FROM sanpham WHERE MA_SP = $MA_SP";
        $result = mysqli_query($connect, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $p = mysqli_fetch_assoc($result);
            $price_total = $p['GIA'] * $soLuong;

            // Đường dẫn ảnh giống giohang1.php
            $imgSrc = !empty($p['HINHANH']) ? "../Shopee/".htmlspecialchars($p['HINHANH']) : "https://via.placeholder.com/60x60?text=No+Image";

            echo "
            <div class='product-item d-flex align-items-center mb-3'>
                <img src='$imgSrc' alt=''>
                <div>
                    <strong>".htmlspecialchars($p['TEN_SP'])."</strong><br>
                    Số lượng: $soLuong – Giá: ".number_format($p['GIA'],0,',','.')."₫<br>
                    <strong>Tổng: ".number_format($price_total,0,',','.')."₫</strong>
                </div>
            </div>";
        }
    }
} else {
    echo "<p>Giỏ hàng trống.</p>";
}
?>

<hr>
<h4>Tổng tiền hàng: <span id="totalPrice"><?= number_format($total_price,0,',','.') ?>₫</span></h4>

<!-- VOUCHER SHOP -->
<div class="voucher-box" data-bs-toggle="modal" data-bs-target="#shopVoucherModal">
    <span style="color:#ff5722; font-weight:bold;">Voucher Shop</span><br>
    <span id="shopDiscount" class="selected-voucher">0₫</span>
</div>

<!-- VOUCHER SHOPEE -->
<div class="voucher-box" data-bs-toggle="modal" data-bs-target="#shopeeVoucherModal">
    <span style="color:#ff5722; font-weight:bold;">Voucher Shopee</span><br>
    <span id="shopeeDiscount" class="selected-voucher">0₫</span>
</div>

<h4 class="text-danger mt-2">Tổng thanh toán: 
    <span id="finalTotal"><?= number_format($total_price + $shipFee,0,',','.') ?>₫</span>
</h4>

<!-- CHI TIẾT THANH TOÁN -->
<div class="payment-detail mt-3">
    <h4 class="fw-bold">Chi tiết thanh toán</h4>
    <div class="d-flex justify-content-between">
        <span>Tổng tiền hàng</span>
        <span id="detailTotalPrice"><?= number_format($total_price,0,',','.') ?>₫</span>
    </div>
    <div class="d-flex justify-content-between">
        <span>Tổng phí vận chuyển</span>
        <span id="shipFee"><?= number_format($shipFee,0,',','.') ?>₫</span>
    </div>
    <div class="d-flex justify-content-between text-success">
        <span>Giảm giá phí vận chuyển</span>
        <span id="shipDiscount">0₫</span>
    </div>
    <div class="d-flex justify-content-between text-danger">
        <span>Tổng voucher giảm giá</span>
        <span id="voucherDiscount">0₫</span>
    </div>
    <hr>
    <div class="d-flex justify-content-between fw-bold" style="font-size:19px;">
        <span>Tổng thanh toán</span>
        <span id="finalPay"><?= number_format($total_price + $shipFee,0,',','.') ?>₫</span>
    </div>
    <div class="text-end mt-1 text-success">
        Tiết kiệm: <span id="saveTotal">0₫</span>
    </div>
</div>

<!-- FORM THANH TOÁN -->
<form method="post">
    <input type="hidden" name="selected_items" value="<?= implode(',', array_keys($giohang)) ?>">
    <button type="submit" name="pay_now" class="btn btn-orange w-100 mt-3">
        Thanh toán xong về Trang Chủ
    </button>
</form>

<!-- POPUP VOUCHER SHOP -->
<div class="modal fade" id="shopVoucherModal" tabindex="-1" aria-labelledby="shopVoucherModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="shopVoucherModalLabel">Voucher Shop</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-check">
          <input class="form-check-input shop-voucher" type="radio" name="shopVoucher" value="10000" data-min="50000" id="shopVoucher1">
          <label class="form-check-label" for="shopVoucher1">
            Giảm 10.000₫ cho đơn hàng từ 50.000₫
          </label>
          <div class="voucher-warning text-danger" style="display:none;"></div>
        </div>
        <div class="form-check">
          <input class="form-check-input shop-voucher" type="radio" name="shopVoucher" value="20000" data-min="100000" id="shopVoucher2">
          <label class="form-check-label" for="shopVoucher2">
            Giảm 20.000₫ cho đơn hàng từ 100.000₫
          </label>
          <div class="voucher-warning text-danger" style="display:none;"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-orange" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<!-- POPUP VOUCHER SHOPEE -->
<div class="modal fade" id="shopeeVoucherModal" tabindex="-1" aria-labelledby="shopeeVoucherModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="shopeeVoucherModalLabel">Voucher Shopee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-check">
          <input class="form-check-input shopee-voucher" type="radio" name="shopeeVoucher" value="15000" data-min="75000" data-type="discount" id="shopeeVoucher1">
          <label class="form-check-label" for="shopeeVoucher1">
            Giảm 15.000₫ cho đơn hàng từ 75.000₫
          </label>
          <div class="voucher-warning text-danger" style="display:none;"></div>
        </div>
        <div class="form-check">
          <input class="form-check-input shopee-voucher" type="radio" name="shopeeVoucher" value="20000" data-type="freeship" id="shopeeVoucher2">
          <label class="form-check-label" for="shopeeVoucher2">
            Miễn phí vận chuyển tối đa 20.000₫
          </label>
          <div class="voucher-warning text-danger" style="display:none;"></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-orange" data-bs-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<script>
let totalPrice = <?= $total_price ?>;
let shipFee = <?= $shipFee ?>;

function updateVoucherState() {
    document.querySelectorAll(".shop-voucher").forEach(v => {
        let min = Number(v.getAttribute("data-min") || 0);
        let wrapper = v.closest(".form-check");
        let warning = wrapper.querySelector(".voucher-warning");
        if (totalPrice < min) {
            v.disabled = true;
            wrapper.style.opacity = "0.4";
            wrapper.style.pointerEvents = "none";
            warning.style.display = "block";
            warning.innerText = "Mua thêm sản phẩm để được sử dụng voucher";
            if (v.checked) v.checked = false;
        } else {
            v.disabled = false;
            wrapper.style.opacity = "1";
            wrapper.style.pointerEvents = "auto";
            warning.style.display = "none";
        }
    });

    document.querySelectorAll(".shopee-voucher").forEach(v => {
        let min = Number(v.getAttribute("data-min") || 0);
        let type = v.getAttribute("data-type");
        let wrapper = v.closest(".form-check");
        let warning = wrapper.querySelector(".voucher-warning");
        if (type === "freeship") {
            v.disabled = false;
            wrapper.style.opacity = "1";
            wrapper.style.pointerEvents = "auto";
            warning.style.display = "none";
            return;
        }
        if (totalPrice < min) {
            v.disabled = true;
            wrapper.style.opacity = "0.4";
            wrapper.style.pointerEvents = "none";
            warning.style.display = "block";
            warning.innerText = "Mua thêm sản phẩm để được sử dụng voucher";
            if (v.checked) v.checked = false;
        } else {
            v.disabled = false;
            wrapper.style.opacity = "1";
            wrapper.style.pointerEvents = "auto";
            warning.style.display = "none";
        }
    });
}

function updateTotal() {
    updateVoucherState();
    let shopInput = document.querySelector("input.shop-voucher:checked");
    let shopeeInput = document.querySelector("input.shopee-voucher:checked");
    let shop = Number(shopInput?.value || 0);
    let shopMin = Number(shopInput?.getAttribute("data-min") || 0);
    let shopee = Number(shopeeInput?.value || 0);
    let type = shopeeInput?.getAttribute("data-type") || "";
    let shopeeMin = Number(shopeeInput?.getAttribute("data-min") || 0);
    let shipDiscount = 0;
    let productDiscount = 0;
    if (shop > 0 && totalPrice >= shopMin) productDiscount += shop;
    if (shopee > 0) {
        if (type === "freeship") shipDiscount = shopee;
        else if (totalPrice >= shopeeMin) productDiscount += shopee;
    }
    document.getElementById("shopDiscount").innerText = shop.toLocaleString() + "₫";
    document.getElementById("shopeeDiscount").innerText = shopee.toLocaleString() + "₫";
    document.getElementById("shipDiscount").innerText = "-" + shipDiscount.toLocaleString() + "₫";
    document.getElementById("voucherDiscount").innerText = "-" + productDiscount.toLocaleString() + "₫";
    let finalTotal = totalPrice + shipFee - productDiscount - shipDiscount;
    if (finalTotal < 0) finalTotal = 0;
    document.getElementById("finalPay").innerText = finalTotal.toLocaleString() + "₫";
    document.getElementById("finalTotal").innerText = finalTotal.toLocaleString() + "₫";
    document.getElementById("saveTotal").innerText = (productDiscount + shipDiscount).toLocaleString() + "₫";
}

document.querySelectorAll(".shop-voucher").forEach(e => e.addEventListener("change", updateTotal));
document.querySelectorAll(".shopee-voucher").forEach(e => e.addEventListener("change", updateTotal));

updateTotal();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
