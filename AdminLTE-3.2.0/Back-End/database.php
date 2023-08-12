<?php
// ฟังก์ชันในการเชื่อมต่อฐานข้อมูล
function db_connect()
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

    // เชื่อมต่อกับ MySQL โดยใช้ตัวแปร $conn
    $conn = new mysqli($servername, $username, $password, $dbname);

    // ตรวจสอบการเชื่อมต่อฐานข้อมูล
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // ตั้งค่าภาษาให้กับฐานข้อมูล
    $conn->set_charset("utf8");

    return $conn;
}
?>
