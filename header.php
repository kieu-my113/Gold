<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kiểm tra số lượng sản phẩm trong giỏ
$totalQty = 0;
if (!empty($_SESSION['giohang']) && is_array($_SESSION['giohang'])) {
    foreach ($_SESSION['giohang'] as $qty) {
        $totalQty += (int)$qty;
    }
}

// Thông tin người dùng
$email = $_SESSION['EMAIL'] ?? null;

// Liên kết header
$navLinks = [
    ['label' => 'Kênh Người Bán  |', 'url' => '#'],
    ['label' => 'Trở thành Người bán Shopee  |', 'url' => '#'],
    ['label' => 'Tải ứng dụng  |', 'url' => '#']
];
$searchPlaceholder = 'Tìm kiếm sản phẩm, danh mục, thương hiệu...';
?>

<link rel="stylesheet" href="header.css">

<div id="shopee-header">
    <!-- TOPBAR -->
    <div class="topbar">
        <div class="container">
            <div class="left">
                <?php foreach ($navLinks as $n): ?>
                    <a href="<?= htmlspecialchars($n['url']) ?>"><?= htmlspecialchars($n['label']) ?></a>
                <?php endforeach; ?>
                <span>Kết nối</span>
                <img src="logo/fb-trang.png" alt="Facebook" height="18">
                <img src="logo/itg-trang.png" alt="Instagram" height="18">
            </div>
            <div class="right">
                <?php if ($email): ?>
                    <div class="dropdown">
                        <span class="user-btn">
                            <img src="../Shopee/logo/user (1).png" alt="">
                            <b><?= htmlspecialchars($email) ?></b>
                        </span>
                        <div class="dropdown-menu">
                            <a href="taikhoancuatoi.php">Tài Khoản Của Tôi</a>
                            <a href="#">Đơn Mua</a>
                            <a href="dangnhapMOI.php">Đăng xuất</a>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="trangdangkyshopeeT.php">Đăng ký</a> |
                    <a href="dangnhapMOI.php">Đăng nhập</a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- HEADER CHÍNH -->
    <header class="header">
        <div class="container">
            <div class="logo">
                <a href="index.php"><img src="logo/shopee.jpg" alt="Shopee"></a>
            </div>
            <div class="search-wrap">
                <form class="search-box" method="get" action="timkiem.php">
                    <input type="text" name="q" placeholder="<?= htmlspecialchars($searchPlaceholder) ?>">
                    <button type="submit"><i class="bi bi-search"></i></button>
                </form>
            </div>
            <div class="icons">
                <a class="icon-btn" href="gioHang1.php" id="cartIcon">
                    <img src="logo/giohang.png" alt="Cart" height="30">
                    <?php if ($totalQty > 0): ?>
                        <span class="badge" id="cartBadge"><?= $totalQty ?></span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    </header>
</div>

<script>
// Hàm cập nhật badge giỏ hàng
function updateCartBadge() {
    fetch('ajax_getCartQty.php')
        .then(res => res.json())
        .then(data => {
            const cartIcon = document.getElementById('cartIcon');
            let badge = document.getElementById('cartBadge');

            if (data.totalQty > 0) {
                if (!badge) {
                    badge = document.createElement('span');
                    badge.id = 'cartBadge';
                    badge.className = 'badge';
                    cartIcon.appendChild(badge);
                }
                badge.textContent = data.totalQty;
                badge.style.display = 'inline-block';
            } else {
                if (badge) badge.remove();
            }
        })
        .catch(err => console.error('Lỗi fetch badge giỏ hàng:', err));
}

// Gọi khi load trang
updateCartBadge();
</script>
