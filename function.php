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
           echo 'Tên tài khoản đã tồn tại! \n';
           return false;
        }
        else {
            echo 'Tên tài khoản hợp lệ! \n';
            return true;
        }
    } catch (Exception $ex) {
        echo 'Không thực hiện được KiemtraAdmin: '.$ex->getMessage();
      
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
        if (count($kq)>0) {
           return $kq;
        }
        else {
           
            return null;
        }
    } catch (Exception $ex) {
        echo 'Không thực hiện được KiemtraAdmin: '.$ex->getMessage();
        $conn=disconnectDB();
        return false;
        
    }

}

//Tra ve boolean kiem tra admin
function DangNhap($username,$password) {
    try {
       $checkUsername=KiemtraUsername($username);
         if ($checkUsername) {
             $data=GetUserData($username);
             if ($data) {
                 if (password_verify($password, $data[0]['password'])) {
                     echo 'Mật khẩu đúng! \n';
                     return $data[0]['admin'];
                 }
                 else {
                     echo 'Mật khẩu sai! \n';
                 }
             }
             else {
                 echo 'Không tìm thấy tài khoản! \n';
             }
    }
    } catch (Exception $ex) {
        echo 'Không thực hiện được KiemtraAdmin: '.$ex->getMessage().'\n';
        return 0;
    }
}

//Them tai khoan
function TaoTaiKhoan($username,$password){
    try {
        $conn=connectDB();
        $sql='INSERT INTO `tai_khoan`(`username`, `password`) VALUES (:user,:pass)';
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':user', $username);
        $stmt->bindValue(':pass', $password);
        $stmt->execute();
        $conn=disconnectDB();
        echo 'Tạo tài khoản thành công, chuyển về trang đăng nhập! \n';
        header('Location: login.php');
    } catch (Exception $ex) {
        echo 'Không thực hiện được TaoTaiKhoan(): '.$ex->getMessage().'\n';
        $conn=disconnectDB();
    }
}


?>


