<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
</head>

<body>
    <?php
    require_once('../Back-End/woo_connection.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $product_id = $_POST['productId'];
        $product_name = $_POST['productName'];
        $product_price = $_POST['productPrice'];
        $product_description = $_POST['productDescription'];

        $data = [
            'name' => $product_name,
            'type' => 'simple',
            'regular_price' => $product_price,
            'description' => $product_description,
            'short_description' => $product_description, // Define and populate $short_description
            'categories' => [],
        ];

        // Check if the image file is uploaded successfully
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            // Get the file name and extension
            $file_name = $_FILES['image']['name'];
            $file_tmp_name = $_FILES['image']['tmp_name'];

            // Move the uploaded file to a temporary location
            $target_directory = '../image/product_images/';
            $target_file = $target_directory . basename($file_name);

            // Here you can use $_FILES['image'] to process the image file further
            // For example, you can call a function to handle the image upload and return the image URL
            $image_url = handleImageUpload($_FILES['image']);

            // If the image upload is successful and you have the image URL
            if ($image_url) {
                $data['images'] = [
                    [
                        'src' => $image_url,
                    ],
                ];
            }
        }
    }

    // Update the product using WooCommerce API
    try {
        $updated_product = $woocommerce->put('products/' . $product_id, $data);

        if ($updated_product && isset($updated_product->id)) {
            // Product update was successful
            echo "<script>";
            echo "swal({";
            echo "  title: 'Success!',";
            echo "  text: 'อัพเดทสำเร็จ',";
            echo "  type: 'success',";
            echo "  timer: 2000,"; // แสดง SweetAlert ในเวลา 2 วินาที
            echo "  showConfirmButton: false"; // ไม่แสดงปุ่ม "OK" ใน SweetAlert
            echo "}, function() {";
            echo "  window.location.href = '../pages/package.php?menu=3';"; // เมื่อหมดเวลา ให้เปลี่ยนหน้าไปที่ '../pages/package.php'
            echo "});";
            echo "</script>";
        } else {
            // Product update failed
            echo "<script>";
            echo "swal({";
            echo "  title: 'Error!',";
            echo "  text: 'ไม่สามารถอัพเดทสินค้าได้',"; // Custom error message
            echo "  type: 'error',";
            echo "  timer: 2000,";
            echo "  showConfirmButton: false";
            echo "}, function() {";
            echo "  window.location.href = '../pages/package.php?menu=3';"; // Redirect to the same page or another page
            echo "});";
            echo "</script>";
        }
    } catch (Exception $e) {
        echo "<script>";
        echo "swal({";
        echo "  title: 'Error!',";
        echo "  text: 'An error occurred: " . $e->getMessage() . "',"; // Display the actual error message
        echo "  type: 'error',";
        echo "  timer: 2000,";
        echo "  showConfirmButton: false";
        echo "}, function() {";
        echo "  window.location.href = '../pages/package.php?menu=3';";
        echo "});";
        echo "</script>";
    }


    function handleImageUpload($image)
    {
        // Check if the product image is valid
        if ($image['error'] !== UPLOAD_ERR_OK) {
            return false; // Return false if there is an error in the uploaded image
        }

        // Set the target directory to store the uploaded images
        $target_directory = '../image/product_images/';

        // Generate a unique filename for the uploaded image to avoid overwriting existing images
        $imageFileName = uniqid() . '_' . $image['name'];

        // Move the uploaded image to the target directory
        if (!move_uploaded_file($image['tmp_name'], $target_directory . $imageFileName)) {
            return false; // Return false if the image move operation fails
        }

        return 'https://www.streamth.co/AdminLTE-3.2.0/image/product_images/' . $imageFileName; // Return the image URL on success
    }
    ?>
</body>

</html>