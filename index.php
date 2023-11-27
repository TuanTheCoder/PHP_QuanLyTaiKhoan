<?php
require_once "dbconnect.php";
require_once "function.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
ob_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Index</title>
</head>
<body>
    <header>
        <nav>
            <h2>TRANG QUẢN LÝ TÀI KHOẢN</h2>
            <ul>
                <li><a href="index.php">Trang chủ</a></li>
                <?php 
                if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
                    echo '<li><a href="account.php">Thông tin tài khoản</a></li>
                    <li><a href="logout.php">Đăng xuất</a></li>';
                } else {
                    echo '<li><a href="register.php">Đăng ký</a></li>
                    <li><a href="login.php">Đăng nhập</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>

    <footer>
        & 0306221391 - PHẠM ANH TUẤN
    </footer>
</body>
</html>