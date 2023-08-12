<?php
function connect_db()
{   
    /* Server SiteGround
    $servername = "127.0.0.1"; 
    $username = "ugzkj7rk5jeky"; 
    $password = "xq8htnm6wsau"; 
    $dbname = "dbpgpuxfegqmrr"; 
    */
    $servername = "127.0.0.1"; // หรือชื่อ host ของคุณ
    $username = "root"; // ชื่อผู้ใช้ฐานข้อมูล
    $password = ""; // รหัสผ่านฐานข้อมูล
    $dbname = "streaming"; // ชื่อฐานข้อมูล

    // สร้างการเชื่อมต่อกับ MySQL
    $conn = new mysqli($servername, $username, $password, $dbname);

    // ตรวจสอบการเชื่อมต่อ
    // ตรวจสอบการเชื่อมต่อฐานข้อมูล
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // เพิ่มโค้ดนี้เพื่อบันทึกข้อความข้อผิดพลาดใน PHP error log


    return $conn;
}
?>