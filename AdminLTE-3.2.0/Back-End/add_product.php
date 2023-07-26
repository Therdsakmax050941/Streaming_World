<?php
require_once './function.php';

// ตรวจสอบว่ามีการส่งข้อมูลผ่าน POST มาหรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าที่ส่งมาจาก Form
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productDescription = $_POST['productDescription'];
    $productImage = $_FILES['productImage'];

    // เรียกใช้ฟังก์ชัน addProduct
    $addProductResult = addProduct($productName, $productPrice, $productDescription, $productImage);

    // ตรวจสอบผลลัพธ์จากการเพิ่มสินค้า
    if ($addProductResult === true) {
        // หากเพิ่มสินค้าสำเร็จ ให้เปลี่ยนเส้นทางไปยังหน้าที่ต้องการ หรือแสดงข้อความสำเร็จอื่น ๆ
        echo '<script>
                alert("Product has been Add Product successfully!");
                window.location.href = "../pages/package.php";
              </script>';
        exit();
    } else {
        // หากเพิ่มสินค้าไม่สำเร็จ ให้แสดงข้อความผิดพลาดหรือทำการจัดการต่อไปตามที่คุณต้องการ
        echo 'Error: Unable to add product';
    }
}
?>
