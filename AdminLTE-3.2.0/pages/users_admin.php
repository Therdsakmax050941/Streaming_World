<?php include_once('../pages/menu.php') ?>
<div class="content-wrapper" style="min-height: 2128.12px;">
    <div class=content>
    <div class="container">
            <h2 class="text-center">จัดการสมาชิก Admin</h2>
            <form action="../Back-End/save_user.php" method="post">
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <label class="sr-only" for="inlineFormInput">Username</label>
                        <input type="text" name="username" class="form-control mb-2" id="inlineFormInput" placeholder="Username">
                    </div>
                    <div class="col-auto">
                        <label class="sr-only" for="inlineFormInputGroup">Password</label>
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                            </div>
                            <input type="password" name="password" class="form-control" id="inlineFormInputGroup" placeholder="Password">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="far fa-eye" id="showPasswordIcon" onclick="togglePasswordVisibility()"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="input-group mb-2">
                            <div class="input-group-prepend">
                            </div>
                            <select class="form-control" name="status">
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary mb-2">สร้างสมาชิก</button>
                    </div>
                </div>
            </form>

            <div id="adminUsersTable">
                <?php include_once('../Back-End/function.php');
                echo displayAdminUsers(); ?>
                <!-- เพิ่มแบบฟอร์มสำหรับการแก้ไขข้อมูล -->
                <div id="editAdminUserModal" class="modal fade" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">แก้ไขข้อมูลผู้ใช้</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="editAdminUserForm">
                                    <div class="form-group">
                                        <label for="editUsername">Username</label>
                                        <input type="text" class="form-control" id="editUsername" name="username" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="editStatus">Status</label>
                                        <select class="form-control" id="editStatus" name="status">
                                            <option value="admin">Admin</option>
                                            <option value="user">User</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="editStatus2">Status2</label>
                                        <select class="form-control" id="editStatus2" name="status2">
                                            <option value="1">ใช้งานอยู่</option>
                                            <option value="0">ถูกปิดการใช้งาน</option>
                                        </select>
                                    </div>
                                    <input type="hidden" id="editUserId" name="userId">
                                    <button type="submit" class="btn btn-primary">บันทึก</button>
                                </form>
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
<!-- ./wrapper -->

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
<script>
    function editAdminUser(id, username, status, status2) {
        // กำหนดค่าให้กับแบบฟอร์มการแก้ไขข้อมูล
        document.getElementById('editUserId').value = id;
        document.getElementById('editUsername').value = username;
        document.getElementById('editStatus').value = status;
        document.getElementById('editStatus2').value = status2;

        // เปิด modal แบบฟอร์มการแก้ไขข้อมูล
        $('#editAdminUserModal').modal('show');
    }

    // ส่งค่าแบบฟอร์มการแก้ไขข้อมูลผู้ใช้
    document.getElementById('editAdminUserForm').addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(this);

        fetch('../Back-End/update_user.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // ใช้ Console Log เพื่อดูข้อมูลที่ได้รับจากการแก้ไข

                if (data.success) {
                    // ซ่อน modal แบบฟอร์มการแก้ไขข้อมูล
                    $('#editAdminUserModal').modal('hide');

                    // แสดง SweetAlert2 แสดงสถานะการแก้ไขสำเร็จ
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: 'แก้ไขข้อมูลผู้ใช้สำเร็จ',
                    }).then(() => {
                        // โหลดข้อมูลใหม่แสดงในตาราง
                        window.location.href = '../pages/users_admin.php?menu=2';
                        displayAdminUsers();
                    });
                } else {
                    // แสดง SweetAlert2 แสดงสถานะการแก้ไขไม่สำเร็จ
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'เกิดข้อผิดพลาดในการแก้ไขข้อมูล',
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>
<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('inlineFormInputGroup');
        const showPasswordIcon = document.getElementById('showPasswordIcon');

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            showPasswordIcon.classList.remove("far", "fa-eye");
            showPasswordIcon.classList.add("far", "fa-eye-slash");
        } else {
            passwordInput.type = "password";
            showPasswordIcon.classList.remove("far", "fa-eye-slash");
            showPasswordIcon.classList.add("far", "fa-eye");
        }
    }
</script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            icon: 'warning',
            title: 'ยืนยันการลบข้อมูล',
            text: 'คุณต้องการลบข้อมูลนี้ใช่หรือไม่?',
            showCancelButton: true,
            confirmButtonText: 'ลบ',
            cancelButtonText: 'ยกเลิก',
            confirmButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                // ส่งค่าไอดีของข้อมูลที่ต้องการลบไปยังหน้า PHP เพื่อดำเนินการลบข้อมูลในฐานข้อมูล
                deleteAdminUser(id);
            }
        });
    }

    function deleteAdminUser(id) {
        fetch('../Back-End/delete_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'userId=' + id,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // แสดง SweetAlert2 แสดงสถานะการลบสำเร็จ
                    Swal.fire({
                        icon: 'success',
                        title: 'สำเร็จ!',
                        text: 'ลบข้อมูลผู้ใช้สำเร็จ',
                    }).then(() => {
                        // โหลดข้อมูลใหม่แสดงในตาราง
                        window.location.href = '../pages/users_admin.php?menu=2';
                        displayAdminUsers();
                    });
                } else {
                    // แสดง SweetAlert2 แสดงสถานะการลบไม่สำเร็จ
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'เกิดข้อผิดพลาดในการลบข้อมูล',
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
    displayAdminUsers();
</script>
<script>
    // สร้างฟังก์ชันสำหรับรีเฟรชตารางแสดงข้อมูลผู้ใช้งาน
    function displayAdminUsers() {
        fetch('../Back-End/get_users.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const adminUsersTable = document.getElementById('adminUsersTable');
                    adminUsersTable.innerHTML = data.table;
                } else {
                    // ถ้าเกิดข้อผิดพลาดในการรับข้อมูลจากเซิร์ฟเวอร์
                    console.error('Error:', data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // รีเฟรชตารางเมื่อเวลาโหลดหน้าหรือเมื่อลบข้อมูลสำเร็จ
    displayAdminUsers();
</script>


</body>

</html>