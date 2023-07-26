<?php
require_once ('db_connection.php');

function displayAdminUsers()
{
    // เชื่อมต่อกับฐานข้อมูล
    $conn = connect_db();

    // คำสั่ง SQL สำหรับดึงข้อมูลทั้งหมดจากตาราง admin_user
    $sql = "SELECT * FROM admin_user";

    // ส่งคำสั่ง SQL เพื่อดึงข้อมูล
    $result = $conn->query($sql);

    // ตรวจสอบว่ามีข้อมูลหรือไม่
    if ($result->num_rows > 0) {
        // เริ่มต้นสร้างตาราง
        echo '<table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Username</th>
                        <th scope="col">Status</th>
                        <th scope="col">Handle</th>
                        <th scope="col">Actions</th> 
                    </tr>
                </thead>
                <tbody>';

        // วนลูปแสดงข้อมูลทีละแถว
        while ($row = $result->fetch_assoc()) {
            $status2 = ($row['status2'] == 1) ? 'เปิดให้ใช้งาน' : 'ถูกปิดการใช้งาน';

            echo '<tr>
            <th scope="row">' . $row['id'] . '</th>
            <td>' . $row['username'] . '</td>
            <td>' . $row['status'] . '</td>
            <td>' . $status2 . '</td>
            <td>';

            // เพิ่มเงื่อนไขในการตรวจสอบ status เพื่อไม่แสดงปุ่มแก้ไขหากเป็น superadmin
            if ($row['status'] !== 'superadmin') {
                echo '<button type="button" class="btn btn-outline-primary" onclick="editAdminUser(' . $row['id'] . ', \'' . $row['username'] . '\', \'' . $row['status'] . '\', \'' . $row['status2'] . '\')">แก้ไข</button>';
            }

            // เพิ่มเงื่อนไขในการตรวจสอบ status เพื่อไม่แสดงปุ่มลบหากเป็น superadmin
            if ($row['status'] !== 'superadmin') {
                echo '<button type="button" class="btn btn-outline-danger" onclick="confirmDelete(' . $row['id'] . ')">ลบ</button>';
            }

            echo '</td>
          </tr>';
        }

        // สิ้นสุดตาราง
        echo '</tbody>
              </table>';
    } else {
        // ถ้าไม่พบข้อมูล
        echo 'ไม่พบข้อมูล admin user';
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
}
// เพิ่มสินค้าใหม่
function deleteProduct($productId)
{
    $conn = connect_db();

    $sql = "DELETE FROM products WHERE id = '$productId'";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
    // ไม่ต้องปิดการเชื่อมต่อฐานข้อมูลที่นี่ เนื่องจากฟังก์ชันจะสิ้นสุดการทำงานทันทีเมื่อมีคำสั่ง return
}

function addProduct($productName, $productPrice, $productDescription, $productImage)
{
    $conn = connect_db();

    // ตรวจสอบว่าไฟล์รูปถูกอัปโหลดหรือไม่
    if (isset($productImage) && $productImage['error'] === 0) {
        $fileTmpPath = $productImage['tmp_name'];
        $fileName = $productImage['name'];
        $fileSize = $productImage['size'];
        $fileType = $productImage['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));
        $allowedExtensions = array("jpg", "jpeg", "png");

        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadFileDir = '../image/product_images/';
            $dest_path = $uploadFileDir . $fileName;

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                // บันทึกข้อมูลลงในฐานข้อมูล
                $sql = "INSERT INTO products (name, price, description, image) VALUES ('$productName', '$productPrice', '$productDescription', '$fileName')";
                if ($conn->query($sql) === TRUE) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    } else {
        return false;
    }
    // ไม่ต้องปิดการเชื่อมต่อฐานข้อมูลที่นี่ เนื่องจากฟังก์ชันจะสิ้นสุดการทำงานทันทีเมื่อมีคำสั่ง return
}


// แสดงรายการสินค้าทั้งหมด
function showProducts()
{
    $conn = connect_db();

    $sql = "SELECT * FROM products ORDER BY id DESC";
    $result = $conn->query($sql);

    $products = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }
    }

    $conn->close();
    return $products;
}
function showProductList()
{
    // เชื่อมต่อกับฐานข้อมูล
    $conn = connect_db();

    // คำสั่ง SQL สำหรับดึงข้อมูลสินค้าทั้งหมดจากตาราง products
    $sql = "SELECT * FROM products ORDER BY id DESC";

    // ส่งคำสั่ง SQL เพื่อดึงข้อมูล
    $result = $conn->query($sql);

    echo '<div class="container mt-5">
        <h1>Product List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Description</th>
                    <th scope="col">Image</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>';
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <th scope="row">' . $row['id'] . '</th>
                    <td>' . $row['name'] . '</td>
                    <td>' . $row['price'] . '</td>
                    <td>' . $row['description'] . '</td>
                    <td><img src="../image/product_images/' . $row['image'] . '" alt="Product Image" width="100"></td>
                    <td>
                    <a href="#" class="btn btn-outline-primary" data-product-id="' . $row['id'] . '" onclick="openEditProductModal(' . $row['id'] . ')">Edit</a>
                        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(' . $row['id'] . ')">Delete</button>
                    </td>
                </tr>';
        }
    } else {
        echo '<tr><td colspan="6">No products found</td></tr>';
    }

    echo '</tbody>
        </table>
    </div>';

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
}

function showOrderList()
{
    // เชื่อมต่อกับฐานข้อมูล
    $conn = connect_db();

    // คำสั่ง SQL สำหรับดึงข้อมูลสินค้าทั้งหมดจากตาราง products
    $sql = "SELECT * FROM `order` ORDER BY id DESC";

    // ส่งคำสั่ง SQL เพื่อดึงข้อมูล
    $result = $conn->query($sql);

    echo '<div class="container mt-5">
        <h1>Order List</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Customer Names</th>
                    <th scope="col">QTV</th>
                    <th scope="col">Price</th>
                    <th scope="col">Description</th>
                    <th scope="col">Created_At</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>';
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<tr>
                    <th scope="row">' . $row['id'] . '</th>
                    <td>' . $row['Customer_Names'] . '</td>
                    <td>' . $row['QTY'] . '</td>
                    <td>' . $row['Price'] . '</td>
                    <td>' . $row['Description'] . '</td>
                    <td>' . $row['Status'] . '</td>
                    <td>' . $row['Created_At'] . '</td>
                    <td>
                    <a href="#" class="btn btn-outline-primary" data-product-id="' . $row['id'] . '" onclick="openEditProductModal(' . $row['id'] . ')">อนุม้ติ</a>
                        <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(' . $row['id'] . ')">ยกเลิก</button>
                    </td>
                </tr>';
        }
    } else {
        echo '<tr><td colspan="6">No products found</td></tr>';
    }

    echo '</tbody>
        </table>
    </div>';

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
}
function updateProduct($productId, $productName, $productPrice, $productDescription, $productImage = null)
{
    require_once('./database.php');
    $conn = db_connect();

    // Prepare the SQL statement to update the product data
    $sql = "UPDATE products SET name = ?, price = ?, description = ?";
    $params = [$productName, $productPrice, $productDescription];

    // Check if a new product image is uploaded
    if ($productImage !== null) {
        $imagePath = uploadProductImage($productImage); // Call a function to handle image upload
        if (!$imagePath) {
            return false; // Return false if image upload fails
        }
        $sql .= ", image = ?";
        $params[] = $imagePath;
    }

    $sql .= " WHERE id = ?";
    $params[] = $productId;

    // Execute the SQL statement with the parameters
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        return false; // Return false if the SQL statement preparation fails
    }

    $result = $stmt->execute($params);
    $conn->close();

    return $result;
}

// function.php
function uploadProductImage($productImage)
{
    // Check if the product image is valid
    if ($productImage['error'] !== UPLOAD_ERR_OK) {
        return false; // Return false if there is an error in the uploaded image
    }

    // Set the target directory to store the uploaded images
    

    // Generate a unique filename for the uploaded image to avoid overwriting existing images
    $imageFileName = uniqid() . '_' . $productImage['name'];

    // Move the uploaded image to the target directory
    if (!move_uploaded_file($productImage['tmp_name'], '../image/product_images/' . $imageFileName)) {
        return false; // Return false if the image move operation fails
    }

    return $imageFileName; // Return the image file path on success
}

function getProductById($productId)
{
    require_once('./database.php');
    $conn = db_connect();

    // คำสั่ง SQL สำหรับดึงข้อมูลสินค้าตาม ID
    $sql = "SELECT * FROM products WHERE id = '$productId'";

    // ส่งคำสั่ง SQL เพื่อดึงข้อมูล
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
        $conn->close();
        return $product;
    } else {
        $conn->close();
        return null; // Return null when product is not found
    }
}






?>