<!-- CSS สำหรับตกแต่งตารางและปุ่ม -->
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
// Function สำหรับดึงรายการสินค้าทั้งหมดจาก WooCommerce
// ดึงรายการสินค้าทั้งหมดจาก WooCommerce
$products = getWooCommerceProducts();

// แสดงรายการสินค้าในรูปแบบตารางแบ่งหน้า
displayProductTable($products, 5);

function getWooCommerceProducts()
{
    global $woocommerce;

    try {
        $products = $woocommerce->get('products', ['per_page' => 100]);

        return $products;
    } catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
        return [];
    }
}

// Function สำหรับแสดงรายการสินค้าในรูปแบบตาราง
// Function สำหรับแสดงรายการสินค้าในรูปแบบตารางแบ่งหน้า
function displayProductTable($products, $itemsPerPage = 6)
{
    if (empty($products)) {
        echo 'No products found.';
        return;
    }
?>

    <div id="productContainer">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalProducts = count($products);
                $totalPages = ceil($totalProducts / $itemsPerPage);

                $currentPage = isset($_GET['page']) ? max(1, $_GET['page']) : 1;

                $startIndex = ($currentPage - 1) * $itemsPerPage;
                $endIndex = min($startIndex + $itemsPerPage, $totalProducts);

                for ($i = $startIndex; $i < $endIndex; $i++) {
                    $product = $products[$i];
                ?>
                    <tr>
                        <td><?php echo $product->id; ?></td>
                        <td><?php echo $product->type; ?></td>
                        <td><?php echo $product->name; ?></td>
                        <td><?php echo $product->price; ?></td>
                        <td><?php echo $product->description; ?></td>
                        <td><img src="<?php echo $product->images[0]->src; ?>" alt="<?php echo $product->name; ?>" style="max-width: 100px;"></td>
                        <td>

                            <?php

                            $button_text = ($product->stock_status == 'instock') ? 'ปิดใช้งาน' : 'เปิดใช้งาน';
                            $button_color = ($product->stock_status == 'instock') ? 'danger' : 'success';
                            ?>
                            <a href="../Back-End/update_product_status.php?productid=<?php echo $product->id; ?>&stock_status=<?php echo $product->stock_status; ?>" class="btn btn-<?php echo $button_color; ?>">
                                <?php echo $button_text; ?>
                            </a>
                            <a href='#' class='btn btn-primary btn-edit' data-toggle='modal' data-target='#editModal' data-product-id="<?= $product->id; ?>" data-product-name="<?= htmlspecialchars($product->name); ?>" data-product-price="<?= $product->price; ?>" data-product-description="<?= htmlspecialchars($product->description); ?>" data-product-image="<?= $product->images[0]->src; ?>
">
                                <i class='fa fa-edit'></i>
                            </a>






                            <a href="../Back-End/delete_product.php?productid=<?php echo $product->id; ?>" class="btn btn-danger btn-delete">
                                <i class="fa fa-trash"></i> <!-- หรือ <i class="fas fa-trash"></i> ถ้าใช้ Font Awesome 5 -->
                            </a>
                        </td>

                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
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