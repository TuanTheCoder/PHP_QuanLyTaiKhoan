<?php
require_once "dbconnect.php";
require_once "function.php";
KiemTraDangNhap();

if (isset($_POST['newpass']) && ($_POST['newpass']) ) {
    $pass=trim($_POST['user_pw']);
    $newpass=trim($_POST['new_user_pw']);
    $renewpass=trim($_POST['user_re_pw']);
    if (isset($_POST['remember'])){
        $remember=trim($_POST['remember']);
        } else {
        $remember=0;
    }

    $errors = [];
    $valid = true;

    if (empty($pass) || empty($newpass) || empty($renewpass)) {
        $errors['login']= '<span id="error">Dữ liệu không được phép bỏ trống!</span>';
        $valid = false;
    } else {
        $vietHoa = preg_match('@[A-Z]@',$newpass);
        $vietThuong = preg_match('@[a-z]@',$newpass);
        $so = preg_match('@[0-9]@', $newpass);
        $kyTu = preg_match('@[^\w]@', $newpass);

        if (!$vietHoa || !$vietThuong || !$so || !$kyTu || strlen($newpass) < 6 || strlen($newpass) > 60) {
            $errors['password'] = '<span id="error"> Mật khẩu phải có ít nhất 6 ký tự và thỏa mãn độ phức tạp bao gồm: ít nhất 1 chữ thường, 1 chữ hoa, 1 số, 1 ký tự đặc biệt! </span>';
            $valid = false;
        }
        if (strcmp($newpass,  $renewpass)) {
            $errors['repass'] = '<span id="error">Re-Password phải trùng khớp nhau!</span>';
            $valid = false;
        }
    }
   
    if ($valid) {
   
        if (KiemTraPassword($_SESSION['username'],$pass,$success,$errors)) {
            CapNhatMatKhau($_SESSION['username'],$newpass,$success,$errors);
            $_SESSION['password']=$newpass;
            if ($remember == '1') {
                CapNhatCookiePassword($_SESSION['username'],$newpass);
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
    <link rel="stylesheet" href="css/style.css">
    <title>Account</title>
</head>
<body>
<?php require_once'view\header.php';  

if ((isset($_SESSION['username']) && isset($_SESSION['password']) )  || (isset($_COOKIE['username']) && isset($_COOKIE['password'])  )) {
    echo '<div class="form-input">
    <form  method="post">
    <h2>Thay đổi thông tin tài khoản</h2>
   
    <label for="user_pw">Password hiện tại: </label> <br>
    <input type="password" name="user_pw" id="user_pw"  maxlength="60" required>  <br> 
    <label for="new_user_pw">Password mới: </label> <br>
    <input type="password" name="new_user_pw" id="new_user_pw"  maxlength="60" required>  <br> 
    <label for="user_re_pw">Hãy nhập lại Password mới: </label> <br>
    <input type="password" name="user_re_pw" id="user_re_pw" maxlength="60" required><br>
    <input type="checkbox" name="remember" id="remember" value="1"> <label for="remember">Remember me</label> <br>
    <input type="submit" name="newpass" value="Thay đổi"><br>' ;
    
    if (isset($errors['change'])) {
        echo $errors['change'];
    }
    if (isset($success['change'])) {
        echo $success['change'];
    }

    echo '</form>
    </div>';
} else {
    echo '<div class="form-input">
    <h2 id="alert">Bạn chưa đăng nhập! Trang sẽ chuyển sang trang login trong vòng 5 giây!</h2>
    </div>';
    header('Refresh: 5; URL=login.php');
}

?>
<footer>
    & 0306221391 - PHẠM ANH TUẤN
</footer>
</body>
</html>