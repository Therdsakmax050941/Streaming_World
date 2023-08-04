<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
  <script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">
</head>
<body>

<?php
require_once '../Back-End/woo_connection.php';

if (isset($_GET['productid']) && is_numeric($_GET['productid'])) {
  $productid = $_GET['productid'];
  $woocommerce->delete('products/' . $productid, ['force' => true]);
  $message = 'Delete Success!';
  $status = 'Success!';
  $type = 'success';
} else {
  $status = 'เกิดข้อผิดพลาด';
  $type = 'error';
  $message = 'Product ID not provided or invalid.';
}
echo "<script>";
  echo "swal({";
  echo "  title: '$status',";
  echo "icon: 'error',";
  echo "  text: '$message',";
  echo "  type: '$type',";
  echo "  timer: 2000,"; // แสดง SweetAlert ในเวลา 2 วินาที
  echo "  showConfirmButton: false"; // ไม่แสดงปุ่ม "OK" ใน SweetAlert
  echo "}, function() {";
  echo "  window.location.href = '../pages/package.php';"; // เมื่อหมดเวลา ให้เปลี่ยนหน้าไปที่ '../pages/package.php'
  echo "});";
  echo "</script>";
?>


</body>
</html>
