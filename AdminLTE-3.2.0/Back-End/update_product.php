<?php
require_once('./function.php');
require_once('./database.php');

// update_product.php
// update_product.php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $productId = $_POST['productId'];
  $productName = $_POST['productName'];
  $productPrice = $_POST['productPrice'];
  $productDescription = $_POST['productDescription'];

  // Check if a new product image is uploaded
  if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === 0) {
      $productImage = $_FILES['productImage'];
      if (updateProduct($productId, $productName, $productPrice, $productDescription, $productImage)) {
          // ทำสิ่งที่คุณต้องการเมื่ออัปเดตสินค้าสำเร็จ
          // ยกตัวอย่างเช่น:
          echo "<script>alert('อัพเดทข้อมูลสำเร็จ'); window.location.href = '../pages/package.php';</script>";
          
      } else {
          // ทำสิ่งที่คุณต้องการเมื่อเกิดข้อผิดพลาดในการอัปเดตสินค้า
          // ยกตัวอย่างเช่น:
          echo "<script>alert('อัพเดทข้อมูลสำเร็จ'); window.location.href = '../Back-End/login.php';</script>";
      }
  } else {
      // If no new product image is uploaded, call the updateProduct() function without the image parameter
      if (updateProduct($productId, $productName, $productPrice, $productDescription)) {
          // ทำสิ่งที่คุณต้องการเมื่ออัปเดตสินค้าสำเร็จ
          // ยกตัวอย่างเช่น:
          echo "<script>alert('อัพเดทข้อมูลสำเร็จ'); window.location.href = '../pages/package.php';</script>";
      } else {
          // ทำสิ่งที่คุณต้องการเมื่อเกิดข้อผิดพลาดในการอัปเดตสินค้า
          // ยกตัวอย่างเช่น:
          echo "<script>alert('อัพเดทข้อมูลสำเร็จ'); window.location.href = '../Back-End/login.php';</script>";
      }
  }
}

  
?>

