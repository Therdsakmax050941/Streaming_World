<?php
require_once('../woo_connection.php');

if (isset($_GET['order_id'])) {
    $orderId = $_GET['order_id'];

    // ดึงข้อมูลออร์เดอร์ของลูกค้าจาก WooCommerce API
    $order = getOrderDetails($orderId);

    // แสดงข้อมูลออร์เดอร์
    if ($order) {
        echo '<h4>รายการสินค้า:</h4>';
        echo '<table>';
        echo '<tr><th>ชื่อสินค้า</th><th>ราคา</th><th>จำนวน</th></tr>';
        foreach ($order->line_items as $item) {
            echo '<tr>';
            echo '<td>' . $item->name . '</td>';
            echo '<td>' . $item->price . '</td>';
            echo '<td>' . $item->quantity . '</td>';
            echo '</tr>';
        }
        echo '</table>';
        // คุณสามารถแสดงข้อมูลอื่นๆ เช่น ชื่อลูกค้า ที่อยู่ ราคารวม เป็นต้นได้
    } else {
        echo 'ไม่พบข้อมูลออร์เดอร์';
    }
}

function getOrderDetails($orderId)
{
    global $woocommerce;

    try {
        $order = $woocommerce->get('orders/' . $orderId);
        return $order;
    } catch (Exception $e) {
        return false;
    }
}
?>
