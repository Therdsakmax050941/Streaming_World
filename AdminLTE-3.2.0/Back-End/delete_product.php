<!-- delete_product.php -->
<?php
require_once './function.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $productId = $_GET['id'];

    $result = deleteProduct($productId);
    if ($result) {
        echo '<script>
                alert("Product has been deleted successfully!");
                window.location.href = "../pages/package.php";
              </script>';
        exit();
    } else {
        echo "Error deleting product";
    }
}
?>
