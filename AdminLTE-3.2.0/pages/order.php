<?php include_once('../pages/menu.php');
require_once('../Back-End/function.php');

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper" style="min-height: 2128.12px;">


  <div class=content>
    <h2 class="text-center">การจัดการออเดอร์</h2>
    <div class="container mt-5">
      <?php include_once('../Back-End/order/get_order.php') ?>
    </div>
    <!-- Modal เพื่อแสดงข้อมูลลูกค้า -->
    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">รายละเอียดออร์เดอร์</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="orderDetails"></div>
          </div>
        </div>
      </div>
    </div>



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
<script>
  $(document).ready(function() {
    $('.btn-view').click(function() {
      var orderId = $(this).data('order-id');
      $.ajax({
        type: 'GET',
        url: '../Back-End/order/get_all_orders.php',
        data: {
          order_id: orderId
        },
        success: function(response) {
          $('#orderDetails').html(response);
          $('#viewModal').modal('show');
        },
        error: function() {
          alert('Error fetching orders.');
        }
      });
    });
  });
</script>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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