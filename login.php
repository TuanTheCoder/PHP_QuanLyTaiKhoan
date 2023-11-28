<?php
require_once "dbconnect.php";
require_once "function.php";
KiemTraDangNhap();

if (isset($_POST['dangnhap']) && ($_POST['dangnhap']) ) {
    $user=trim($_POST['username']);
    $pass=trim($_POST['user_pw']);
    if (isset($_POST['remember'])){
    $remember=trim($_POST['remember']);}
    else {
        $remember=0;
    }
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
                $_SESSION['role']=$VaiTro;
                if ($remember == '1') {
                    RememberLogin($remember,$user,$pass);
                }
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
<?php require_once'view\header.php'; 

if ((isset($_SESSION['username']) && isset($_SESSION['password']) )  || (isset($_COOKIE['username']) && isset($_COOKIE['password'])  )) {
    echo '<div class="form-input">
    <h2>Bạn đã đăng nhập! Trang sẽ chuyển sang trang chủ trong vòng 5 giây!</h2>
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
    <input type="checkbox" name="remember" id="remember" value="1"> <label for="remember">Remember me</label> <br>
    <input type="submit" name="dangnhap" value="Đăng nhập"><br>' ;
    
   if (isset($errors['login'])) {
          echo $errors['login'];
   }
   if (isset($success['login'])) {
    echo $success['login'];
    header('Refresh: 5; URL=index.php');
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
