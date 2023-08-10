<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
</head>
<body>

<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Retrieve form data
  $name = $_POST['name'];
  $price = $_POST['price'];
  $description = $_POST['description'];
  $short_description = $_POST['short_description'];
  $categories = $_POST['category'];

  // Check if the image file is uploaded successfully
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    // Get the file name and extension
    $file_name = $_FILES['image']['name'];
    $file_tmp_name = $_FILES['image']['tmp_name'];

    // Move the uploaded file to a temporary location
    $target_directory = '../image/product_images/'; // Directory where you want to save the image
    $target_file = $target_directory . basename($file_name);

    // Here you can use $_FILES['image'] to process the image file further
    // For example, you can call a function to handle the image upload and return the image URL
    $image_url = handleImageUpload($_FILES['image']);

    // If the image upload is successful and you have the image URL
    if ($image_url) {
      // Include the WooCommerce API client library
      require_once ('../Back-End/woo_connection.php');

      // Prepare data for creating the product in WooCommerce
      $data = [
        'name' => $name,
        'type' => 'simple',
        'regular_price' => $price,
        'description' => $description,
        'short_description' => $short_description,
        'categories' => [],
        'images' => [
          [
            'src' => $image_url, // Use the image URL obtained from the image upload function
          ],
        ],
      ];

      // Add categories
      foreach ($categories as $category_id) {
        $data['categories'][] = ['id' => $category_id];
      }

      // Create the product in WooCommerce
      try {
        $new_product = $woocommerce->post('products', $data);

         // Show SweetAlert on success
    echo "<script>";
    echo "swal({";
    echo "  icon: 'success',";
    echo "  title: 'สำเร็จ!',";
    echo "  text: 'สินค้าถูกสร้างขึ้นเรียบร้อยแล้ว รหัสสินค้าคือ " . $new_product->id . "',";
    echo "});";
    echo "window.location.href = '../pages/package.php?menu=3';";
    echo "</script>";
      } catch (Exception $e) {
        // Show SweetAlert on error
        echo "<script>";
        echo "swal({";
        echo "  icon: 'error',";
        echo "  title: 'เกิดข้อผิดพลาด!',";
        echo "  text: 'Error creating product: " . $e->getMessage() . "',";
        echo "});";
        echo "window.location.href = '../Back-End/logout.php';";
        echo "</script>";
      }
    } else {
      // Show SweetAlert if there is an error in image upload
      echo "<script>";
      echo "swal({";
      echo "  icon: 'error',";
      echo "  title: 'เกิดข้อผิดพลาด!',";
      echo "  text: 'Error uploading image.',";
      echo "});";
      echo "window.location.href = '../Back-End/logout.php';";
      echo "</script>";
    }
  } else {
    // Show SweetAlert if there is an error in image upload
    echo "<script>";
    echo "swal({";
    echo "  icon: 'error',";
    echo "  title: 'เกิดข้อผิดพลาด!',";
    echo "  text: 'Error uploading image: " . $_FILES['image']['error'] . "',";
    echo "});";
    echo "window.location.href = 'https://www.streamth.co/AdminLTE-3.2.0/Back-End/logout.php';";
    echo "</script>";
  }
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
