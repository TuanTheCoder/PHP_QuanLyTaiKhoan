<?php
session_start();
require_once "dbconnect.php";
require_once "function.php";

ob_start();
if (isset($_POST['dangnhap']) && ($_POST['dangnhap']) ) {
    $user=trim($_POST['username']);
    $pass=trim($_POST['user_pw']);
    $errors = [];
    $valid = true;
    if (empty($user)) {
        $errors['login']= '<span id="error">Đăng nhập thất bại!</span>';
        $valid = false;
    }
    if (empty($pass)) {
        $errors['login']= '<span id="error">Đăng nhập thất bại!</span>';
        $valid = false;
    }
    if ($valid) {
        if (KiemtraUsername($user)==false) {
            $errors['login']= '<span id="error">Đăng nhập thất bại!</span>';
        }
        else {
            $VaiTro=DangNhap($user,$pass,$errors);
            if (!isset($errors['login']) && $VaiTro == 0 )  {
                $_SESSION['username']=$user;
                $_SESSION['password']=$pass;
                header('Location: index.php');
            }
            
           
        }
       
            
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
    <?PHP 
   if (isset($_SESSION['username']) && isset($_SESSION['password'])) {
    echo '<div class="form-input">
    <h2>Bạn đã đăng nhập rồi!, trang sẽ chuyển sang trang chủ trong vòng 5 giây!</h2>
    </div>';
    header('Refresh: 5; URL=index.php');
   }
   else {
    echo '<div class="form-input">
    <form  method="post">
    <h2>Login</h2>
   
    <label for="username">Username: </label> <br>
    <input type="text" name="username" id="username" maxlength="32" required> <br>
   
    <label for="user_pw">Password</label> <br>
    <input type="password" name="user_pw" id="user_pw"  maxlength="60" required>  <br> 
    
    <input type="submit" name="dangnhap" value="Đăng nhập"><br>' ;
    
   if (isset($errors['login'])) {
          echo $errors['login'];
   }


echo'    </form>
</div>';
   }
?>

    <footer>
        & 0306221391 - PHẠM ANH TUẤN
    </footer>
</body>
</html>
