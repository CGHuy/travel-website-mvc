<?php include __DIR__ . '/../partials/header.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý user</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/AppStyle.css">
    <link rel="stylesheet" href="css/SettingAccount.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
     <div class="container-fluid my-4">
          <div class="d-flex gap-4 px-5">
               <?php
                    $currentPage = 'user';
                    include __DIR__ . '/../partials/admin-menu.php';
               ?>

               <div class="card card_form" style="flex: 0 0 calc(80% - 1rem);">
                    <div class="card-body">
                         <div id="admin-content">
                         <h2>Quản Lý User</h2>
                         <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Thêm User Mới</button>
                         <table class="table table-striped">
                              <thead>
                                   <tr>
                                        <th>ID</th>
                                        <th>Tên</th>
                                        <th>Email</th>
                                        <th>Vai Trò</th>
                                        <th>Hành động</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php if (!empty($users)): ?>
                                        <?php foreach ($users as $user): ?>
                                             <tr>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td></td>
                                             <td>
                                                  <button class="btn btn-sm btn-warning" onclick="editUser(<?= $user['id'] ?>)">Sửa</button>
                                                  <button class="btn btn-sm btn-danger" onclick="deleteUser(<?= $user['id'] ?>)">Xóa</button>
                                             </td>
                                             </tr>
                                        <?php endforeach; ?>
                                   <?php else: ?>
                                        <tr>
                                             <td colspan="5">Không có user nào.</td>
                                        </tr>
                                   <?php endif; ?>
                              </tbody>
                         </table>
                         </div>

                         <!-- Modal Thêm User -->
                         <div class="modal fade" id="addUserModal" tabindex="-1">
                         <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                   <div class="modal-header">
                                        <h5 class="modal-title">Thêm User Mới</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                   </div>
                                   <form method="post" action="?controller=AdminController&action=storeUser">
                                        <div class="modal-body">
                                             <div class="row g-3">
                                             <div class="col-md-6">
                                                  <label class="form-label">Tên</label>
                                                  <input type="text" name="name" class="form-control" required>
                                             </div>
                                             <div class="col-md-6">
                                                  <label class="form-label">Email</label>
                                                  <input type="email" name="email" class="form-control" required>
                                             </div>
                                             <div class="col-md-6">
                                                  <label class="form-label">Mật Khẩu</label>
                                                  <input type="password" name="password" class="form-control" required>
                                             </div>
                                             <div class="col-md-6">
                                                  <label class="form-label">Vai Trò</label>
                                                  <select name="role" class="form-control" required>
                                                       <option value="user">User</option>
                                                       <option value="admin">Admin</option>
                                                  </select>
                                             </div>
                                             </div>
                                        </div>
                                        <div class="modal-footer">
                                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                             <button type="submit" class="btn btn-primary">Thêm</button>
                                        </div>
                                   </form>
                              </div>
                         </div>
                         </div>

                         <!-- Modal Sửa User -->
                         <div class="modal fade" id="editUserModal" tabindex="-1">
                         <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                   <div class="modal-header">
                                        <h5 class="modal-title">Sửa User</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                   </div>
                                   <form method="post" action="?controller=AdminController&action=updateUser">
                                        <input type="hidden" name="id" id="editUserId">
                                        <div class="modal-body">
                                             <div class="row g-3">
                                             <div class="col-md-6">
                                                  <label class="form-label">Tên</label>
                                                  <input type="text" name="name" id="editName" class="form-control" required>
                                             </div>
                                             <div class="col-md-6">
                                                  <label class="form-label">Email</label>
                                                  <input type="email" name="email" id="editEmail" class="form-control" required>
                                             </div>
                                             <div class="col-md-6">
                                                  <label class="form-label">Mật Khẩu (để trống nếu không đổi)</label>
                                                  <input type="password" name="password" class="form-control">
                                             </div>
                                             <div class="col-md-6">
                                                  <label class="form-label">Vai Trò</label>
                                                  <select name="role" id="editRole" class="form-control" required>
                                                       <option value="user">User</option>
                                                       <option value="admin">Admin</option>
                                                  </select>
                                             </div>
                                             </div>
                                        </div>
                                        <div class="modal-footer">
                                             <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                                             <button type="submit" class="btn btn-primary">Cập nhật</button>
                                        </div>
                                   </form>
                              </div>
                         </div>
                         </div>
                    </div>
               </div>
        </div>
    </div>

</body>

<?php include __DIR__ . '/../partials/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</html>
