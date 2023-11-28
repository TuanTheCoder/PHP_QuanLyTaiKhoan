<?php
require_once "dbconnect.php";
require_once "function.php";
KiemTraDangNhap();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $user_pw = trim($_POST['user_pw']);
    $user_re_pw = trim($_POST['user_re_pw']);
    $errors = [];
    $alerts = [];
    $success = [];
    $valid = true;
    $usernamecheck = preg_match('@[^\w]@', $username);
    if (empty($username) || strlen($username) > 32  || $usernamecheck) {
        $errors['usernamecheck'] = '<span id="error">Tên username không hợp lệ!</span>';
        $valid = false;
    }
    if (KiemtraUsername($username)) {
        $errors['usernamecheck'] = '<span id="error">Tên username không hợp lệ!</span>';
        $valid = false;
    }

    $vietHoa = preg_match('@[A-Z]@', $user_pw);
    $vietThuong = preg_match('@[a-z]@', $user_pw);
    $so = preg_match('@[0-9]@', $user_pw);
    $kyTu = preg_match('@[^\w]@', $user_pw);

    if (!$vietHoa || !$vietThuong || !$so || !$kyTu || strlen($user_pw) < 6 || strlen($user_pw) > 60) {
        $errors['password'] = '<span id="error"> Mật khẩu phải có ít nhất 6 ký tự và thỏa mãn độ phức tạp bao gồm: ít nhất 1 chữ thường, 1 chữ hoa, 1 số, 1 ký tự đặc biệt! </span>';
        $valid = false;
    }
    if (empty($user_re_pw) ||  strcmp($user_pw, $user_re_pw)) {
        $errors['repass'] = '<span id="error">Re-Password phải trùng khớp nhau!</span>';
        $valid = false;
    }
    if ($valid == true) {
        $user_pw = password_hash($user_pw, PASSWORD_BCRYPT);
        TaoTaiKhoan($username, $user_pw, $success, $errors);
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
    <?php require_once 'view\header.php';

    if ((isset($_SESSION['username']) && isset($_SESSION['password']))  || (isset($_COOKIE['username']) && isset($_COOKIE['password']))) {
        echo '<div class="form-input">
    <h2>Bạn đã đăng nhập! Trang sẽ chuyển sang trang chủ trong vòng 5 giây!</h2>
    </div>';
        header('Refresh: 5; URL=index.php');
    } else {
        echo   '<div class="form-input">
       
        <form method="post">
        <h2>Register</h2>
            <label for="username">Username:</label> <br>
            <input type="text" name="username" id="username" maxlength="32" required> <br>';
        if (isset($errors['usernamecheck'])) {
            echo $errors['usernamecheck'];
        }

        echo '<label for="user_pw">Password</label> <br>
            <input type="password" name="user_pw" id="user_pw" maxlength="60" required> <br>';
        if (isset($errors['password'])) {
            echo $errors['password'];
        }


        echo '<label for="user_re_pw">Hãy nhập lại Password</label> <br>
            <input type="password" name="user_re_pw" id="user_re_pw" maxlength="60" required><br>';
        if (isset($errors['repass'])) {
            echo $errors['repass'];
        }

        echo '<input type="submit" name="dangky" value="Đăng ký"><br>';

        if (isset($success['newUser'])) {
            echo $success['newUser'];
        } else if (isset($errors['newUser'])) {
            echo $errors['newUser'];
        }

        echo '  </form>
    </div>';
    }

    ?>
    <footer>
        & 0306221391 - PHẠM ANH TUẤN
    </footer>
</body>

</html>