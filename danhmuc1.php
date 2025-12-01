<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Danh Mục - Shopee Style</title>

<style>
/* Tiêu đề */
.category-title {
    width: 1310px;
    margin: 20px auto 5px; /* khoảng cách dưới 5px */
    font-size: 20px;
    font-weight: 600;
    color: #767575;
    display: flex;
    align-items: center;
    gap: 5px; /* khoảng cách dấu gạch và chữ */
}

.title-bar {
    font-size: 20px;
    color: #5b5b5b;
}

/* Thanh danh mục */
.category-scroll {
    display: flex;
    flex-wrap: wrap; 
    justify-content: space-between;
    padding: 0; /* giảm padding trên/dưới */
    gap: 10px; 
    width: 1310px; 
    background-color: #fff; 
    margin: 0 auto;
}

.category-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    text-decoration: none;
    color: #222;
    transition: transform 0.3s, color 0.3s;
    flex: 1 1 18%; 
    max-width: 18%;
}

.category-item:hover {
    transform: translateY(-3px);
    color: #ff5722;
}

.category-icon {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: #fff;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    margin-bottom: 5px;
    transition: transform 0.3s, box-shadow 0.3s;
}

.category-item:hover .category-icon {
    transform: scale(1.1);
    box-shadow: 0 4px 12px rgba(255,87,34,0.4);
}

.category-icon img {
    max-width: 90%;
    max-height: 90%;
    object-fit: contain;
}

.category-name {
    font-size: 20px;
    font-weight: 500;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Responsive */
@media (max-width: 1024px) {
    .category-scroll {
        width: 100%;
    }
    .category-item {
        flex: 1 1 30%;
        max-width: 30%;
    }
}

@media (max-width: 600px) {
    .category-item {
        flex: 1 1 45%;
        max-width: 45%;
    }
}
</style>

</head>
<body>



<!-- Thanh danh mục -->
<div class="category-scroll">
  <!-- Tiêu đề -->
<div class="category-title">
    <span class="title-bar">|</span> DANH MỤC
</div>

<?php
$connect = mysqli_connect("localhost", "root", "", "tmdt");
if (!$connect) die("Kết nối thất bại: " . mysqli_connect_error());

$iconMap = [
    13 => 'thoitrang.jpg',
    14 => 'suckhoe.jpg',
    15 => 'thethao.jpg',
    16 => 'thietbidientu.jpg',
    17 => 'sacdep.jpg',
];

$sqltheloai = "SELECT * FROM theloai";
$ketqua = mysqli_query($connect, $sqltheloai);

if(!$ketqua){
    die("Lỗi truy vấn: " . mysqli_error($connect));
}

$counter = 0;
while($row = mysqli_fetch_assoc($ketqua)) {
    if ($counter >= 5) break; // chỉ lấy 5 icon
    $id = $row['matheloai'];
    $ten = htmlspecialchars($row['tentheloai']);
    $icon = $iconMap[$id] ?? 'default.jpg';
    $path = "danhmuc/".$icon;

    $link = "trangdmthoitrang.php?madm=$id";

    echo "
    <a href='$link' class='category-item'>
        <div class='category-icon'>
            <img src='$path' alt='$ten'>
        </div>
        <div class='category-name'>$ten</div>
    </a>
    ";
    $counter++;
}
?>
</div>

</body>
</html>
