<?php
require_once './db_connection.php';

// ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าที่ส่งมาจากฟอร์ม
    $username = $_POST['username'];
    $password = $_POST['password'];
    $status = $_POST['status'];

    // เชื่อมต่อกับฐานข้อมูล
    $conn = connect_db();

    // คำสั่ง SQL สำหรับเพิ่มข้อมูลใหม่ลงในตาราง admin_user
    $sql = "INSERT INTO admin_user (username, password, status, status2) VALUES ('$username', '$password', '$status', '1')";

    // ทำการเพิ่มข้อมูลลงในฐานข้อมูล
    if ($conn->query($sql) === TRUE) {
        // ถ้าเพิ่มข้อมูลสำเร็จ
        echo "<script>alert('เพิ่มข้อมูลสำเร็จ'); window.location.href = '../pages/users_admin.php';</script>";
    } else {
        // ถ้าเกิดข้อผิดพลาดในการเพิ่มข้อมูล
        echo "<script>alert('เกิดข้อผิดพลาดในการเพิ่มข้อมูล: . $conn->error;'); window.location.href = '../pages/users_admin.php';</script>";
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
}
?>
