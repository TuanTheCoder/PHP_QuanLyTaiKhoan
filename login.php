<?php
require_once "dbconnect.php";
require_once "function.php";
session_start();
ob_start();
if (isset($_POST['dangnhap']) && ($_POST['dangnhap']) ) {
    $user=trim($_POST['username']);
    $pass=trim($_POST['user_pw']);
    $errors = [];
    $valid = true;
    if (empty($user)) {
        $errors['$usernamecheck']='<span id="error">Username không được bỏ trống!</span>';
        $valid = false;
    }
    if (empty($pass)) {
        $errors['password']='<span id="error">Password không được bỏ trống!</span>';
        $valid = false;
    }
    if ($valid) {
        if (KiemtraUsername($user)==false) {
            $errors['login']= '<span id="error">Đăng nhập thất bại!</span>';
        }
        else {
            $VaiTro=DangNhap($user,$pass,$errors);
            if (!isset($errors['noAcc']))  {
                $_SESSION['admin']=$VaiTro;
                if ($_SESSION['admin']==1) 
                    header('Location: admin.php');
                else if ($_SESSION['admin']==0)
                    header('Location: index.php');
                else
                    $errors['login']= '<span id="error">Đăng nhập thất bại!</span>';
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
            <li><a href="#">Thông tin tài khoản</a></li>
            <li><a href="register.php">Đăng ký</a></li>
            <li><a href="login.php">Đăng nhập</a></li>
        </ul>
    </nav>
    </header>
    <div class="form-input">
        <form  method="post">
        <h2>Login</h2>
        <?PHP 
          if (isset($errors['noAcc'])) {
            echo $errors['noAcc'];
        }
    
        ?>
        <label for="username">Username: </label> <br>
        <input type="text" name="username" id="username" maxlength="32" required> <br>
        <?PHP
        if (isset($errors['usernamecheck'])) {
            echo $errors['usernamecheck'];
        }
        ?>
        <label for="user_pw">Password</label> <br>
        <input type="password" name="user_pw" id="user_pw"  maxlength="60" required>  <br>  
        <?PHP
        if (isset($errors['password'])) {
            echo $errors['password'];
        }
        ?>
        <input type="submit" name="dangnhap" value="Đăng nhập"><br>
        <?PHP
       if (isset($errors['login'])) {
              echo $errors['login'];
       }

       ?>
        </form>
    </div>


    <footer>
        & 0306221391 - PHẠM ANH TUẤN
    </footer>
</body>
</html>
