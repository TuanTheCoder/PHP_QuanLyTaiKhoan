<?php
require_once "dbconnect.php";
require_once "function.php";
session_start();
ob_start();
if (isset($_POST['dangnhap']) && ($_POST['dangnhap']) ) {
    $user=trim($_POST['username']);
    $pass=trim($_POST['user_pw']);
    $valid = true;
    if (empty($user)) {
        echo '<p>Username không được bỏ trống!</p>';
        $valid = false;
    }
    if (empty($pass)) {
        echo '<p>Password không được bỏ trống!</p>';
        $valid = false;
    }
    if ($valid) {
        $VaiTro=DangNhap($user,$pass);
        $_SESSION['admin']=$VaiTro;
        if ($_SESSION['admin']==1) {
            header('Location: admin.php');
        }
        else {
            header('Location: index.php');
        }
    }
    else{
        echo '<p>Đăng nhập thất bại!</p>';
        header('Location: login.php');
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\style.css">
    <title>Login</title>
</head>
<body>
    <header>
    <nav>
        <h2>TRANG QUẢN LÝ TÀI KHOẢN</h2>
        <ul>
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="#">Thông tin tài khoản</a></li>
            <li><a href="register.php">Đăng ký</a></li>
            <li><a href="login.php">Đăng nhập</a></li>
        </ul>
    </nav>
    </header>
    <div class="main">
        <h2>Login</h2>
        <form action="<?PHP echo $_SERVER['PHP_SELF']  ?>" method="post">
        <label for="username">Username: </label> <br>
        <input type="text" name="username" id="username" maxlength="255" required> <br>
        <label for="user_pw">Password</label> <br>
        <input type="password" name="user_pw" id="user_pw"  maxlength="32" required>     <br>    
        <input type="submit" name="dangnhap" value="Đáng nhập"><br>
        </form>
    </div>


    <footer>
        & 0306221391 - PHẠM ANH TUẤN
    </footer>
</body>
</html>