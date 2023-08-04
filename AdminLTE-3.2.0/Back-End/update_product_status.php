<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
</head>
<body>

<?php
require_once '../Back-End/woo_connection.php';

if (isset($_GET['productid']) && is_numeric($_GET['productid'])) {
  $productid = $_GET['productid'];

  if ($_GET['stock_status'] != 'instock') {
    $data = [
      'stock_status' => "instock"
    ];
    $woocommerce->put('products/' . $productid, $data);
    $redirect_url = '../pages/package.php';
    $message = 'สินค้าถูกเปิดใช้งานสำเร็จ';
  } else {
    $data = [
      'stock_status' => "outofstock"
    ];
    $woocommerce->put('products/' . $productid, $data);
    $redirect_url = '../pages/package.php';
    $message = 'สินค้าถูกปิดใช้งานสำเร็จ';
  }

  echo "<script>";
  echo "swal({";
  echo "  title: 'Success!',";
  echo "  text: '$message',";
  echo "  type: 'success',";
  echo "  timer: 2000,"; // แสดง SweetAlert ในเวลา 2 วินาที
  echo "  showConfirmButton: false"; // ไม่แสดงปุ่ม "OK" ใน SweetAlert
  echo "}, function() {";
  echo "  window.location.href = '../pages/package.php';"; // เมื่อหมดเวลา ให้เปลี่ยนหน้าไปที่ '../pages/package.php'
  echo "});";
  echo "</script>";
} else {
  // กรณีไม่มีค่า productid ที่ส่งมาหรือไม่ใช่ตัวเลข ให้เกิดเหตุการณ์ผิดพลาดหรือเปิดหน้าแจ้งเตือน
  echo 'Product ID not provided or invalid.';
  header('../Back-End/logout.php');
}
?>
