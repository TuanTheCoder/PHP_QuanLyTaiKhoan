<?php
function connectDB()
{
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "qlsv";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Kết nối thành công";
    return $conn; 
}
catch(PDOException $e) {
    if($e->getCode() == 1049) {
        echo "Không tìm thấy database, đang tạo database mới!";
        try {
            $conn = new PDO("mysql:host=$servername;", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = file_get_contents('../database/qlsv.sql');
            $conn->exec($sql);
            echo "Khởi tạo database thành công!";
            return $conn; 
        }
        catch(PDOException $e) {
            echo "Khởi tạo thất bại, mã lỗi là: " . $e->getMessage();
        }
    } else {
        echo "Kết nối database thất bại! Mã lỗi là: " . $e->getMessage();
    }
}
}


function disconnectDB()
{
    return NULL;
}
?>