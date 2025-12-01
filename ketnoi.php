<?php
$server   = "localhost";   
$username = "root"; 
$password = "";      
$dbname   = "tmdt";    

// Kết nối OOP
$connect = new mysqli($server, $username, $password, $dbname);

// Kiểm tra kết nối
if ($connect->connect_error) {
    die("Kết nối không thành công: " . $connect->connect_error);
}

$connect->set_charset("utf8");
?>
