<?php
include "dbconnect.php";
include "function.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
    <nav>
        <h2>TRANG QUẢN LÝ TÀI KHOẢN</h2>
        <a href="#">Trang chủ</a>
        <a href="#">Thông tin tài khoản</a>|
        <a href="#">Đăng ký</a>| 
        <a href="#">Đăng nhập</a>
    </nav>
    </header>
    <div>
        <form action="" method="post">
        <label for="hoten">Họ & Tên</label> <br>
        <input type="text" name="hoten" id="hoten" maxlength="255" required> <br>
        <label for="namsinh">Năm sinh</label> <br>
        <input type="number" name="namsinh" id="namsinh" maxlength="4" required> <br>
        <label for="email">Email</label> <br>
        <input type="email" name="email" id="email" maxlength="255" required> <br>
        <label for="user_pw">Password</label> <br>
        <input type="password" name="user_pw" id="user_pw"  maxlength="32" required>     <br>    
        <label for="user_re_pw">Hãy nhập lại Password</label> <br>
        <input type="password" name="user_re_pw" id="user_re_pw"  maxlength="32" required><br>
        <input type="submit" value="Đáng ký"><br>
        </form>
    </div>
    <?PHP 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name= trim($_POST['hoten']);
        $namsinh=trim($_POST['namsinh']);
        $email=trim($_POST['email']);
        $user_pw=trim($_POST['user_pw']);
        $user_re_pw=trim($_POST['user_re_pw']);
        $valid=true;

        if (empty($name)) {
           echo '<p>Ten khong duoc bo trong!</p>';
           $valid=false;
        }
        if(empty($namsinh) || $namsinh <=1900){
            echo '<p>Nam sinh khong duoc bo trong!</p>'; 
            $valid=false;
        }
        if(empty($email) ){
            echo '<p>Email khong duoc bo trong</p>'; 
            $valid=false;
        }
        if(empty($user_pw) || strlen($user_pw) < 8 || strlen($user_pw) >32 ){
            echo '<p>Password khong duoc bo trong</p>'; 
            $valid=false;
        }
        if(empty($user_re_pw) || strlen($user_re_pw) < 8 || strlen($user_re_pw) >32 ||  strcmp($user_pw,$user_re_pw) ){
            echo '<p>Password phải trùng khớp nhau!</p>'; 
            $valid=false;
        }
        if ($valid == true) {
           $user_pw=password_hash($user_pw,PASSWORD_BCRYPT);

        }
      


    }
    ?>
    <footer>
        & 0306221391 - PHẠM ANH TUẤN
    </footer>
</body>
</html>