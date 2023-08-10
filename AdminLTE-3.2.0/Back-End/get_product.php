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
    <!-- Modal แก้ไข Product -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Form แก้ไข Product ที่ต้องการแก้ไข -->
                    <form action="../Back-End/update_product.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="editProductId" name="productId">
                        <div class="mb-3">
                            <label for="editProductName" class="form-label">Product Name</label>
                            <input type="text" class="form-control" id="editProductName" name="productName" value="" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductPrice" class="form-label">Product Price</label>
                            <input type="number" class="form-control" id="editProductPrice" name="productPrice" required>
                        </div>
                        <div class="mb-3">
                            <label for="editProductDescription" class="form-label">Product Description</label>
                            <textarea class="form-control" id="editProductDescription" name="productDescription" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editProductImage" class="form-label">Product Image</label>
                            <input type="file" class="form-control" id="editProductImage" name="productImage">
                            <img src="" alt="Product Image" id="editProductImagePreview" style="max-width: 100px; margin-top: 10px;">
                        </div>
                        <!-- เปลี่ยนปุ่ม submit เป็นปุ่ม button และเพิ่ม event handler ใน JavaScript -->
                        <button type="button" class="btn btn-primary" data-product-id="" id="updateProductButton">Update</button>
                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.btn-edit').on('click', function() {
                var productId = $(this).data('product-id');
                var productName = $(this).data('product-name');
                var productPrice = $(this).data('product-price');
                var productDescription = $(this).data('product-description');
                var productImage = $(this).data('product-image');

                // เติมข้อมูลลงในช่อง input ใน Modal
                $('#editProductId').val(productId);
                $('#editProductName').val(productName);
                $('#editProductPrice').val(productPrice);
                $('#editProductDescription').val(productDescription);
                $('#editProductImagePreview').attr('src', productImage);

                console.log('Product ID:', productId);
                console.log('Product Name:', productName);
                console.log('Product Price:', productPrice);
                console.log('Product Description:', productDescription);
                console.log('Product Image:', productImage);

                // เพิ่ม event handler สำหรับปุ่ม Update
                $('#updateProductButton').on('click', function() {
                    // ตรวจสอบข้อมูลก่อนส่งไปยังฟอร์มแก้ไข
                    var updatedProductId = $('#editProductId').val(productId);
                    var updatedProductName = $('#editProductName').val();
                    var updatedProductPrice = $('#editProductPrice').val();
                    var updatedProductDescription = $('#editProductDescription').val();
                    // ... เพิ่มตัวแปรอื่น ๆ ตามความต้องการ

                    // ดำเนินการส่งข้อมูลไปยังฟอร์มแก้ไข
                    // ...

                    // ลบ event handler เมื่อกดปุ่ม Update แล้ว
                    $('#updateProductButton').off('click');
                });
            });
        });
    </script>


<?php
}
?>