<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
</head>

<body>
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
            echo "<script>";
            echo "swal({";
            echo "  title: 'สร้างสมาชิกสำเร็จ',";
            echo "  text: 'ยินดีต้อนรับสมาชิกใหม่ " . $username . "',";
            echo "  type: 'success',";
            echo "  timer: 2000,"; // แสดง SweetAlert ในเวลา 2 วินาที
            echo "  showConfirmButton: false"; // ไม่แสดงปุ่ม "OK" ใน SweetAlert
            echo "}, function() {";
            echo "window.location.href = '../pages/users_admin.php?menu=2';"; // เมื่อหมดเวลา ให้เปลี่ยนหน้าไปที่ '../pages/package.php'
            echo "});";
            echo "</script>";
        } else {
            // Product update failed
            echo "<script>";
            echo "swal({";
            echo "  title: 'เกิดข้อผิดพลาด!',";
            echo "  text: 'Server Error',"; // Custom error message
            echo "  type: 'error',";
            echo "  timer: 2000,";
            echo "  showConfirmButton: false";
            echo "}, function() {";
            echo "  window.location.href = '../Back-End/logout.php';"; // Redirect to the same page or another page
            echo "});";
            echo "</script>";
        }

        // ปิดการเชื่อมต่อฐานข้อมูล
        $conn->close();
    }
    ?>
</body>

</html>