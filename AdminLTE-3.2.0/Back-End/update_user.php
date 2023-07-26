<?php
// ไฟล์นี้จะรับค่าที่ส่งมาจากแบบฟอร์มการแก้ไขข้อมูลผู้ใช้ และตรวจสอบและอัปเดตข้อมูลในฐานข้อมูล
require_once './db_connection.php';

// ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าที่ส่งมาจากแบบฟอร์มการแก้ไขข้อมูลผู้ใช้
    $userId = $_POST['userId'];
    $username = $_POST['username'];
    $status = $_POST['status'];
    $status2 = $_POST['status2'];

    // เชื่อมต่อกับฐานข้อมูล
    $conn = connect_db();

    // คำสั่ง SQL สำหรับอัปเดตข้อมูลผู้ใช้
    $sql = "UPDATE admin_user SET username = '$username', status = '$status', status2 = '$status2' WHERE id = '$userId'";

    // ทำการอัปเดตข้อมูลในฐานข้อมูล
    if ($conn->query($sql) === TRUE) {
        // ถ้าอัปเดตสำเร็จส่งค่ากลับให้กับ JavaScript เพื่อแสดงสถานะการแก้ไขสำเร็จ
        $response = array('success' => true);
        echo json_encode($response);
    } else {
        // ถ้าเกิดข้อผิดพลาดในการอัปเดต ส่งค่ากลับให้กับ JavaScript เพื่อแสดงสถานะการแก้ไขไม่สำเร็จ
        $response = array('success' => false);
        echo json_encode($response);
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
}
?>
