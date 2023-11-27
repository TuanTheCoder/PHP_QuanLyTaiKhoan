<?php
require_once "dbconnect.php";
require_once "function.php";
session_start();
ob_start();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $user_pw = trim($_POST['user_pw']);
    $user_re_pw = trim($_POST['user_re_pw']);
    $errors = [];
    $alerts = [];
    $valid = true;
    $usernamecheck= preg_match('@[^\w]@',$username);
    if (empty($username) || strlen($username) > 32  || $usernamecheck) {
        if ( KiemtraUsername($username) == false) {
            $errors['usernamecheck'] ='<span id="error"> Tên tài khoản đã tồn tại! </span>';
        }
        $errors['usernamecheck']='<span id="error">Tên username không hợp lệ!</span>';
        $valid = false;
    }

    $vietHoa = preg_match('@[A-Z]@', $user_pw);
    $vietThuong = preg_match('@[a-z]@', $user_pw);
    $so = preg_match('@[0-9]@', $user_pw);
    $kyTu = preg_match('@[^\w]@', $user_pw);

    if (!$vietHoa || !$vietThuong || !$so || !$kyTu || strlen($user_pw) < 6 || strlen($user_pw) > 60) {
        $errors['password']= '<span id="error"> Mật khẩu phải có ít nhất 6 ký tự và thỏa mãn độ phức tạp! </span>';
        $valid = false;
    }
    if (empty($user_re_pw) ||  strcmp($user_pw, $user_re_pw)) {
        $errors['repass']= '<span id="error">Re-Password phải trùng khớp nhau!</span>';
        $valid = false;
    }
    if ($valid == true) {
        $user_pw = password_hash($user_pw, PASSWORD_BCRYPT);
        TaoTaiKhoan($username, $user_pw,$alerts, $errors);
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
    echo   '<div class="form-input">
       
        <form method="post">
        <h2>Register</h2>
            <label for="username">Username:</label> <br>
            <input type="text" name="username" id="username" maxlength="32" required> <br>';
            if (isset($errors['usernamecheck'])) {
                echo $errors['usernamecheck'];
            }
            
            echo '<label for="user_pw">Password</label> <br>
            <input type="password" name="user_pw" id="user_pw" maxlength="60" required> <br>' ;
            if (isset($errors['password'])) {
                echo $errors['password'];
            }
            
            
            echo '<label for="user_re_pw">Hãy nhập lại Password</label> <br>
            <input type="password" name="user_re_pw" id="user_re_pw" maxlength="60" required><br>';
            if (isset($errors['repass'])) {
                echo $errors['repass'];
            }
        
            echo '<input type="submit" name="dangky" value="Đăng ký"><br>';
            
            if (isset($alerts['newUser'])) {
                echo $alerts['newUser'];
            }
            else if (isset($errors['newUser'])) {
                echo $errors['newUser'];
            }
            
      echo'  </form>
    </div>';
}
 
   ?>
    <footer>
        & 0306221391 - PHẠM ANH TUẤN
    </footer>
</body>

</html>