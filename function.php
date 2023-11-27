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
        if ($kq) {
           return true;
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
                $errors['noAcc'] = '<span id="error">Thông tin đăng nhập không chính xác! </span>';
                return -1;
            }
        } else {
            $errors['noAcc'] = '<span id="error">Thông tin đăng nhập không chính xác! </span>';
            return -1;
        }
    } catch (Exception $ex) {
        $errors['noAcc'] = '<span id="error">Không thực hiện được KiemtraAdmin: '.$ex->getMessage().'</span>';
        return 0;
    }
}

//Them tai khoan
function TaoTaiKhoan($username,$password,$alerts,&$errors){
    try {
        $conn=connectDB();
        $sql='INSERT INTO `tai_khoan`(`username`, `password`) VALUES (:user,:pass)';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user', $username);
        $stmt->bindValue(':pass', $password);
        $stmt->execute();
        $conn=disconnectDB();
        $alerts['newUser']='<span id="alert">Tạo tài khoản thành công, chuyển về trang đăng nhập! </span>';
        header('Location: login.php');
    } catch (Exception $ex) {
        $errors['newUser']= '<span id ="error">Không thực hiện được TaoTaiKhoan(): '.$ex->getMessage().'</span>';
        $conn=disconnectDB();
    }
}


?>


