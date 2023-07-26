<?php include_once('../pages/menu.php');
require_once('../Back-End/function.php');

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="min-height: 2128.12px;">


  <div class=content>
    <h2 style="margin-left: 35%;">การจัดการสินค้า</h2>

    <div class="container mt-5">
      <h1>Create Product</h1>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addProductModal">Add Product</button>
      <div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="../Back-End/add_product.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                  <label for="productName" class="form-label">Product Name</label>
                  <input type="text" class="form-control" id="productName" name="productName" required>
                </div>
                <div class="mb-3">
                  <label for="productPrice" class="form-label">Product Price</label>
                  <input type="number" class="form-control" id="productPrice" name="productPrice" required>
                </div>
                <div class="mb-3">
                  <label for="productDescription" class="form-label">Product Description</label>
                  <textarea class="form-control" id="productDescription" name="productDescription" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                  <label for="productImage" class="form-label">Product Image</label>
                  <input type="file" class="form-control" id="productImage" name="productImage" required>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Modal for Edit Product -->
      <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form action="../Back-End/update_product.php" method="post" enctype="multipart/form-data">
                <input type="hidden" id="editProductId" name="productId">
                <div class="mb-3">
                  <label for="editProductName" class="form-label">Product Name</label>
                  <input type="text" class="form-control" id="editProductName" name="productName" required>
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
                <button type="submit" class="btn btn-primary" data-product-id="">Update</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php showProductList(); ?>
    </div>

  </div>


</div>

</div>
</div>
<!-- /.content-wrapper -->

<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> 3.2.0
  </div>
  <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script>
  function confirmDelete(productId) {
    if (confirm("Are you sure you want to delete this product?")) {
      // ส่ง request ไปยังหน้า delete_product.php เพื่อลบสินค้า
      window.location.href = "../Back-End/delete_product.php?id=" + productId;
    }
  }

  function openEditProductModal(productId) {
    // ดึงข้อมูลสินค้าที่ต้องการแก้ไขด้วย AJAX
    $.ajax({
      url: '../Back-End/get_product.php', // ตำแหน่งของไฟล์ที่จะดึงข้อมูลสินค้า
      method: 'post', // ใช้เมธอด POST ในการส่งค่า productId ไปยัง get_product.php
      data: {
        productId: productId
      }, // ส่งค่า productId ไปยัง get_product.php
      dataType: 'json', // กำหนดรูปแบบข้อมูลที่คืนกลับมาเป็น JSON
      success: function(data) {
        // เมื่อดึงข้อมูลสินค้าสำเร็จ
        // แสดงข้อมูลที่ได้รับใน Console เพื่อตรวจสอบว่าถูกต้องหรือไม่

        // นำข้อมูลที่ดึงมาใส่ใน input fields และกำหนดค่าภาพใน tag img
        $('#editProductId').val(data.id); // ใส่ค่า id ของสินค้าใน input field
        $('#editProductName').val(data.name); // ใส่ค่าชื่อสินค้าใน input field
        $('#editProductPrice').val(data.price); // ใส่ค่าราคาสินค้าใน input field
        $('#editProductDescription').val(data.description); // ใส่ค่าคำอธิบายสินค้าใน textarea
        $('#editProductImagePreview').attr('src', '../image/product_images/' + data.image); // กำหนด URL ของภาพสินค้าใน tag img

        // เพิ่ม attribute "data-product-id" เพื่อระบุ productId ในปุ่ม Update
        $('#editProductModal button[type="submit"]').attr('data-product-id', productId);

        // เปิด modal แก้ไข
        $('#editProductModal').modal('show');
      },
      error: function(xhr, status, error) {
        // แสดงข้อความผิดพลาดใน AJAX พร้อมกับแสดง responseText ที่ส่งกลับมาจากเซิร์ฟเวอร์
        alert('Failed to fetch product data: ' + error + '\nResponse: ' + xhr.responseText);// แสดงเนื้อหาของ response จากการเรียกใช้งาน AJAX/ แสดงเนื้อหาของ response จากการเรียกใช้งาน AJAX
      }
    });
  }
</script>



<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="dist/js/adminlte.js?v=3.2.0"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<script src="../dist/js/pages/dashboard3.js"></script>
<script src="../plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.4/dist/sweetalert2.all.min.js"></script>
</body>

</html>