<?php
require_once "dbconnect.php";
require_once "function.php";
session_start();
ob_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $user_pw = trim($_POST['user_pw']);
    $user_re_pw = trim($_POST['user_re_pw']);
    $valid = true;

    if (empty($username)) {
        echo '<p>Tên username không hợp lệ!</p>';
        $valid = false;
    }

    $vietHoa = preg_match('@[A-Z]@', $password);
    $vietThuong = preg_match('@[a-z]@', $password);
    $so    = preg_match('@[0-9]@', $password);
    $kyTu= preg_match('@[^\w]@', $password);

    if (!$vietHoa || !$vietThuong || !$so || !$kyTu || strlen($password) < 8 || strlen($user_pw) > 32) {
        echo 'Mật khẩu phải có ít nhất 8 ký tự và thỏa mãn độ phức tạp! \n';
        $valid = false;
    } 
    if (empty($user_re_pw) ||  strcmp($user_pw, $user_re_pw)) {
        echo '<p>Re-Password phải trùng khớp nhau!</p>';
        $valid = false;
    }
    if ($valid == true) {
        $user_pw = password_hash($user_pw, PASSWORD_BCRYPT);
        TaoTaiKhoan($username, $user_pw);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css\style.css">
    <title>Register</title>
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
         <h2>Register</h2>
        <form method="post">
            <label for="username">Username:</label> <br>
            <input type="text" name="username" id="username" maxlength="255" required> <br>
            <label for="user_pw">Password</label> <br>
            <input type="password" name="user_pw" id="user_pw" maxlength="32" required> <br>
            <label for="user_re_pw">Hãy nhập lại Password</label> <br>
            <input type="password" name="user_re_pw" id="user_re_pw" maxlength="32" required><br>
            <input type="submit" name="dangky" value="Đáng ký"><br>
        </form>
    </div>
   
    <footer>
        & 0306221391 - PHẠM ANH TUẤN
    </footer>
</body>

</html>