<!-- dashboard.php -->
<?php
require_once './db_connection.php';
session_start();

$conn = connect_db();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // เรียกใช้ฟังก์ชัน login และตรวจสอบผลลัพธ์
    $loginResult = login($username, $password);
    $usernamemd5 = sha1($username);
    if ($loginResult === true) {
        echo '<script>
                window.location.href = "../pages/dashboard.php?user='.$usernamemd5.'";
              </script>';
        exit();
    } elseif ($loginResult === false) {
        // ถ้า login ไม่สำเร็จ ให้แสดง SweetAlert2 alert
        echo '<script>
                alert("กรุณาตรวจสอบความถูกต้องอีกครั้ง!!");
                window.location.href = "../login.php?error=2";
              </script>';
        exit();
    }
}


// ฟังก์ชัน login ตัวอย่าง (คุณต้องเปลี่ยนแปลงเนื้อหาให้เหมาะสมกับระบบของคุณ)
// ฟังก์ชัน login ตัวอย่าง (คุณต้องเปลี่ยนแปลงเนื้อหาให้เหมาะสมกับระบบของคุณ)
// ฟังก์ชัน login
function login($username, $password)
{
    // เชื่อมต่อกับฐานข้อมูล
    $conn = connect_db();

    // ตรวจสอบว่ามีผู้ใช้ที่ใช้ username ที่ระบุหรือไม่
    $sql = "SELECT * FROM admin_user WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // ตรวจสอบเงื่อนไขสำหรับการเปิดใช้งานผู้ใช้
        if ($user['status2'] == 0) {
            // ถ้า status2 เป็น 0 แสดง SweetAlert2 แจ้งเตือน
            echo '<script>
                    alert("รหัสของคุณถูกปิดการใช้งาน");
                    window.location.href = "../login.php";
                  </script>';
            exit();
        }

        // เปรียบเทียบรหัสผ่านที่ถูกเข้ารหัสแบบ SHA1
        if (sha1($password) === $user['password']) {
            return true;
        } else {
            // รหัสผ่านไม่ถูกต้อง แสดง SweetAlert2 และเปลี่ยนเส้นทางไปยังหน้า login.php
            echo '<script>
                    alert("รหัสผ่านไม่ถูกต้อง!!");
                    window.location.href = "../login.php";
                  </script>';
            exit();
        }
    } else {
        // ไม่พบผู้ใช้ แสดง SweetAlert2 และเปลี่ยนเส้นทางไปยังหน้า login.php
        echo '<script>
                alert("ไม่พบผู้ใช้!!");
                window.location.href = "../login.php";
              </script>';
        exit();
    }
}

?>