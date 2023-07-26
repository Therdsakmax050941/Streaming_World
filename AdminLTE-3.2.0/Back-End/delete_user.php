<?php
// ไฟล์นี้จะรับค่าไอดีของข้อมูลที่ต้องการลบ และทำการลบข้อมูลในฐานข้อมูล

require_once './db_connection.php';

// ตรวจสอบว่ามีการส่งค่าไอดีของข้อมูลที่ต้องการลบมาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['userId'])) {
    // รับค่าไอดีของข้อมูลที่ต้องการลบ
    $userId = $_POST['userId'];

    // เชื่อมต่อกับฐานข้อมูล
    $conn = connect_db();

    // คำสั่ง SQL สำหรับลบข้อมูลที่มีไอดีที่กำหนด
    $sql = "DELETE FROM admin_user WHERE id = '$userId'";

    // ทำการลบข้อมูลในฐานข้อมูล
    if ($conn->query($sql) === TRUE) {
        // ถ้าลบสำเร็จส่งค่ากลับให้กับ JavaScript เพื่อแสดงสถานะการลบสำเร็จ
        $response = array('success' => true);
        echo json_encode($response);
    } else {
        // ถ้าเกิดข้อผิดพลาดในการลบ ส่งค่ากลับให้กับ JavaScript เพื่อแสดงสถานะการลบไม่สำเร็จ
        $response = array('success' => false);
        echo json_encode($response);
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
}
?>
