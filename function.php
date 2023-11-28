<?php
//Tra ve boolean kiem tra username
function KiemtraUsername($username) {
    try {
        $conn=connectDB();
        $sql='SELECT * FROM tai_khoan WHERE `username` =:user';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user', $username);
        $stmt->execute();
        $kq = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $kq = $stmt->fetchAll();
        $conn=disconnectDB();
        if ($kq > 0) {
           return true;
        }
        else {
            return false;
        }
    } catch (Exception $ex) {
        echo '<p> Không thực hiện được KiemtraAdmin: '.$ex->getMessage().'</p>';
        $conn=disconnectDB();
        return false;
      
    }

}

//Tra ve 1 mang data user
function GetUserData($username) {
    try {
        $conn=connectDB();
        $sql='SELECT * FROM tai_khoan WHERE `username` =:user';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user', $username);
        $stmt->execute();
        $kq = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $kq = $stmt->fetchAll();
        $conn=disconnectDB();
        if (count($kq)>0) {
           return $kq;
        }
        else {
            return null;
        }
    } catch (Exception $ex) {
        // echo '<p> Không thực hiện được KiemtraAdmin: '.$ex->getMessage() .'</p>';
        $conn=disconnectDB();
        return null;
        
    }

}

//Tra ve boolean kiem tra admin
function DangNhap($username, $password, &$errors) {
    try {
        $data = GetUserData($username);
        if (!empty($data)) {
            if (password_verify($password, $data[0]['password'])) {
                
                return $data[0]['admin'];
            } else {
                $errors['login']= '<span id="error">Đăng nhập thất bại!</span>';

                return -1;
            }
        } else {
            return -1;
        }
    } catch (Exception $ex) {
        $errors['noAcc'] = '<span id="error">Không thực hiện được KiemtraAdmin: '.$ex->getMessage().'</span>';
        return 0;
    }
}

//Them tai khoan
function TaoTaiKhoan($username,$password,&$success,&$errors){
    try {
        $conn=connectDB();
        $sql='INSERT INTO `tai_khoan`(`username`, `password`) VALUES (:user,:pass)';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user', $username);
        $stmt->bindValue(':pass', $password);
        $stmt->execute();
        $conn=disconnectDB();
        $success['newUser']='<span id="success">Tạo tài khoản thành công, chuyển về trang đăng nhập trong vòng 5 giây! </span>';
    
    } catch (Exception $ex) {
        $errors['newUser']= '<span id ="error">Không thực hiện được TaoTaiKhoan(): '.$ex->getMessage().'</span>';
        $conn=disconnectDB();
    }
}

//Set Cookie
function RememberLogin($remember,$username,$password){
    if ($remember == '1') {
        setcookie('username', $username, time() + 604800, '/');
        $password = password_hash($password, PASSWORD_BCRYPT);
        setcookie('password', $password, time() + 604800, '/');
    }
}

//Xoa Cookie
function XoaCookie(){
    setcookie('username', '', time() - 604800, '/');
    setcookie('password', '', time() - 604800, '/');
}

//Kiem tra dang nhap
function KiemTraDangNhap(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        ob_start();
    }
    if (!isset($_SESSION['username']) && !isset($_SESSION['password'])) {
        if (isset($_COOKIE['username']) && isset($_COOKIE['password'] )) {
         if (KiemtraUsername($_COOKIE['username'])==true) {
             $VaiTro=DangNhap($_COOKIE['username'],$_COOKIE['password'],$errors);
             if (!isset($errors['login']) && $VaiTro == 0 )  {
                 $_SESSION['username']=$_COOKIE['username'];
                 $_SESSION['password']=$_COOKIE['password'];
                 $_SESSION['role']=$VaiTro;
             }
         }
        }
    }
}

//Xoa Session
function XoaSession(){
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
        ob_start();
    }
    session_unset();
    session_destroy();
}



?>


