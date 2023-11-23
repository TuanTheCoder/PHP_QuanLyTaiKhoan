<?php
function connectDB()
{
    $servername = "localhost";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=test_qltk", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "ket noi thanh cong";
    } catch (PDOException $e) {
        // echo "Ket noi that bai: " . $e->getMessage();
    }
    return $conn;
}

function disconnectDB()
{
    return NULL;
}
?>