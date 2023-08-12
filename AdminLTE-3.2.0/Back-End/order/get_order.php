<style>
    /* ตกแต่งตาราง */
    table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #ddd;
    }

    th,
    td {
        padding: 8px;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
    }

    /* ตกแต่งปุ่ม Pagination */
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        justify-content: center;
        margin-top: 20px;
    }

    .pagination a {
        color: #000;
        padding: 8px 16px;
        text-decoration: none;
        border: 1px solid #ddd;
        margin: 0 4px;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .pagination a.active {
        background-color: #4CAF50;
        color: white;
        border: 1px solid #4CAF50;
    }

    .pagination a:hover:not(.active) {
        background-color: #ddd;
    }
</style>
<?php
include_once('../Back-End/woo_connection.php');
$products = getWooCommerceOrders();

// แสดงรายการสินค้าในรูปแบบตารางแบ่งหน้า
displayOrderTable($products, 5);
// Function สำหรับดึงรายการออร์เดอร์ทั้งหมดจาก WooCommerce
function getWooCommerceOrders()
{
    global $woocommerce;

    try {
        $orders = $woocommerce->get('orders', ['per_page' => 100]);

        return $orders;
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
        return [];
    }
}

// Function สำหรับแสดงรายการออร์เดอร์ในรูปแบบตารางแบ่งหน้า
function displayOrderTable($orders, $itemsPerPage = 6)
{
    if (empty($orders)) {
        echo 'No orders found.';
        return;
    }
?>

    <!-- ตารางแสดงรายการออร์เดอร์ -->
    <div id="orderContainer">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order Number</th>
                    <th>Customer Name</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalOrders = count($orders);
                $totalPages = ceil($totalOrders / $itemsPerPage);

                $currentPage = isset($_GET['page']) ? max(1, $_GET['page']) : 1;

                $startIndex = ($currentPage - 1) * $itemsPerPage;
                $endIndex = min($startIndex + $itemsPerPage, $totalOrders);

                for ($i = $startIndex; $i < $endIndex; $i++) {
                    $order = $orders[$i];
                ?>
                    <tr>
                        <td><?php echo $order->id; ?></td>
                        <td><?php echo $order->order_key; ?></td>
                        <td><?php echo $order->billing->first_name . ' ' . $order->billing->last_name; ?></td>
                        <td><?php echo $order->total; ?></td>
                        <td><?php echo $order->status; ?></td>
                        <td>
                            <!-- ตัวอย่างปุ่มแก้ไขและลบ -->
                            <a href="../Back-End/update_order_status.php?orderid=<?php echo $order->id; ?>&new_status=completed" class="btn btn-success">
                                อนุมัติ
                            </a>
                            <a href="#" class="btn btn-info btn-view" data-toggle="modal" data-target="#viewModal" data-order-id="<?php echo $order->id; ?>">
                                <i class="fa fa-search"></i>
                            </a>


                            <a href="../Back-End/delete_order.php?orderid=<?php echo $order->id; ?>" class="btn btn-danger btn-delete">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
    <!-- ปุ่ม Pagination -->
    <ul class="pagination">
        <?php
        if (isset($_GET['page'])) {
            $getpage = $_GET['page'];
        } else {
            $getpage = null;
        }
        for ($page = 1; $page <= $totalPages; $page++) {
            echo '<li><a class="' . ($page == $getpage ? 'active' : '') . '" href="?page=' . $page . '&menu=' . $_GET['menu'] . '">' . $page . '</a></li>';
        }
        ?>
    </ul>
<?php
}
?>