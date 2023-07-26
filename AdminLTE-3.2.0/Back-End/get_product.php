<?php
require_once('./function.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST['productId'];

    // Call the getProductById function to fetch product data from the database
    $product = getProductById($productId);

    if ($product) {
        // Send the product data as JSON response
        header('Content-Type: application/json');
        echo json_encode($product);
        
    } else {
        // If product not found, send an error message
        echo json_encode(['error' => 'Product not found']);
    }
}
?>

