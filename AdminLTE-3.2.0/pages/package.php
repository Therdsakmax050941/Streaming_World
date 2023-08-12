<?php include_once('../pages/menu.php');
require_once('../Back-End/function.php');

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="min-height: 2128.12px;">


  <div class=content>
    <h2 style="margin-left: 35%;">การจัดการสินค้า</h2>

    <div class="container mt-5">
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
              <div class="container mt-4">
                <h2>สร้างสินค้าใน WooCommerce</h2>
                <form method="post" action="../Back-End/add_product_api.php" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="name">ชื่อสินค้า:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                  </div>

                  <div class="form-group">
                    <label for="price">ราคา:</label>
                    <input type="text" class="form-control" id="price" name="price" required>
                  </div>

                  <div class="form-group">
                    <label for="description">รายละเอียดสินค้า:</label>
                    <textarea class="form-control" id="description" name="description" rows="4" cols="50"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="short_description">คำอธิบายสั้นๆ:</label>
                    <textarea class="form-control" id="short_description" name="short_description" rows="2" cols="50"></textarea>
                  </div>

                  <div class="form-group">
                    <label for="category">หมวดหมู่:</label>
                    <select class="form-control" id="category" name="category[]" multiple required>
                      <option value="9">Category 1</option>
                      <option value="14">Category 2</option>
                      <!-- เพิ่มหมวดหมู่อื่นๆ ตามต้องการ -->
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="image">อัปโหลดรูปภาพ:</label>
                    <input type="file" id="image" name="image" required><br>
                  </div>

                  <button type="submit" class="btn btn-primary">สร้างสินค้า</button>
                </form>

              </div>

            </div>
          </div>
        </div>
      </div>
      <!-- Modal for Edit Product -->
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
                  <label for="editProductDescription" class="form-label">Product Description(Do Not Delete < p>
                      < p />)</label>
                  <textarea class="form-control" id="editProductDescription" name="productDescription" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                  <label for="editProductImage" class="form-label">Product Image</label>
                  <input type="file" class="form-control" id="editProductImage" name="productImage">
                  <input type="hidden" id="inputProductImagePreview" name="oldImage">
                  <img src="" alt="Product Image" id="editProductImagePreview" style="max-width: 100px; margin-top: 10px;">
                </div>
                <!-- เปลี่ยนปุ่ม submit เป็นปุ่ม button และเพิ่ม event handler ใน JavaScript -->
                <button type="submit" class="btn btn-primary" data-product-id="">Update</button>
              </form>


            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <?php require_once('../Back-End/get_product.php'); ?>
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
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  function createProduct() {
    const form = document.getElementById('productForm');
    const formData = new FormData(form);

    axios.post('../Back-End/add_product_api.php', formData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        }
      })
      .then(response => {
        console.log('Product created successfully with ID: ' + response.data.id);
        // Do something after product is successfully created
      })
      .catch(error => {
        console.error('Error creating product:', error);
      });
  }
</script>
<script>
  function confirmDelete(productId) {
    if (confirm("Are you sure you want to delete this product?")) {
      // ส่ง request ไปยังหน้า delete_product.php เพื่อลบสินค้า
      window.location.href = "../Back-End/delete_product.php?id=" + productId;
    }
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('.btn-edit').on('click', function() {
      var productId = $(this).data('product-id');
      var productName = $(this).data('product-name');
      var productPrice = $(this).data('product-price');
      var productDescription = $(this).data('product-description');
      var productImage = $(this).data('product-image');
      var inputImage = $(this).data('product-image');

      // เติมข้อมูลลงในช่อง input ใน Modal
      $('#editProductId').val(productId);
      $('#editProductName').val(productName);
      $('#editProductPrice').val(productPrice);
      $('#editProductDescription').val(productDescription);
      $('#editProductImagePreview').attr('src', productImage);
      $('#inputProductImagePreview').val(productImage);

      console.log('Product ID:', productId);
      console.log('Product Name:', productName);
      console.log('Product Price:', productPrice);
      console.log('Product Description:', productDescription);
      console.log('Product Image:', productImage);
      console.log('Product Image:', inputImage);

      // เพิ่ม event handler สำหรับปุ่ม Update
      $('#updateProductButton').on('click', function() {
        $('#updateProductButton').off('click');
      });
    });
  });
</script>
</body>

</html>