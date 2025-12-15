<?php include __DIR__ . '/../partials/header.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Quản lý lịch trình</title>
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
                    $currentPage = 'itinerary';
                    include __DIR__ . '/../partials/admin-menu.php';
               ?>

               <div class="card card_form" style="flex: 0 0 calc(80% - 1rem);">
                    <div class="card-body">
                         <div id="admin-content">
                         <h2>Quản Lý Lịch Trình</h2>
                         <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addItineraryModal">Thêm Lịch Trình Mới</button>
                         <table class="table table-striped">
                              <thead>
                                   <tr>
                                        <th>ID</th>
                                        <th>Tên Lịch Trình</th>
                                        <th>Mô tả</th>
                                        <th>Hành động</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <?php if (!empty($itineraries)): ?>
                                        <?php foreach ($itineraries as $itinerary): ?>
                                             <tr>
                                             <td><?= htmlspecialchars($itinerary['id']) ?></td>
                                             <td><?= htmlspecialchars($itinerary['name'] ?? 'N/A') ?></td>
                                             <td><?= htmlspecialchars($itinerary['description']) ?></td>
                                             <td>
                                                  <button class="btn btn-sm btn-warning" onclick="editItinerary(<?= $itinerary['id'] ?>)">Sửa</button>
                                                  <button class="btn btn-sm btn-danger" onclick="deleteItinerary(<?= $itinerary['id'] ?>)">Xóa</button>
                                             </td>
                                             </tr>
                                        <?php endforeach; ?>
                                   <?php else: ?>
                                        <tr>
                                             <td colspan="4">Không có lịch trình nào.</td>
                                        </tr>
                                   <?php endif; ?>
                              </tbody>
                         </table>
                         </div>

                         <!-- Modal Thêm Lịch Trình -->
                         <div class="modal fade" id="addItineraryModal" tabindex="-1">
                         <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                   <div class="modal-header">
                                        <h5 class="modal-title">Thêm Lịch Trình Mới</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                   </div>
                                   <form method="post" action="?controller=ItineraryController&action=storeItinerary" enctype="multipart/form-data">
                                        <div class="modal-body">
                                             <div class="row g-3">
                                             <div class="col-md-6">
                                                  <label class="form-label">Tên Lịch Trình</label>
                                                  <input type="text" name="name" class="form-control" required>
                                             </div>
                                             <div class="col-md-6">
                                                  <label class="form-label">Tour ID</label>
                                                  <input type="number" name="tour_id" class="form-control" required>
                                             </div>
                                             <div class="col-md-6">
                                                  <label class="form-label">Ngày thứ</label>
                                                  <input type="number" name="day_number" class="form-control" required>
                                             </div>
                                             <div class="col-12">
                                                  <label class="form-label">Mô tả</label>
                                                  <textarea name="description" class="form-control" rows="3" required></textarea>
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

                         <!-- Modal Sửa Lịch Trình -->
                         <div class="modal fade" id="editItineraryModal" tabindex="-1">
                         <div class="modal-dialog modal-lg">
                              <div class="modal-content">
                                   <div class="modal-header">
                                        <h5 class="modal-title">Sửa Lịch Trình</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                   </div>
                                   <form method="post" action="?controller=ItineraryController&action=updateItinerary" enctype="multipart/form-data">
                                        <input type="hidden" name="id" id="editItineraryId">
                                        <div class="modal-body">
                                             <div class="row g-3">
                                             <div class="col-md-6">
                                                  <label class="form-label">Tên Lịch Trình</label>
                                                  <input type="text" name="name" id="editItineraryName" class="form-control" required>
                                             </div>
                                             <div class="col-md-6">
                                                  <label class="form-label">Tour ID</label>
                                                  <input type="number" name="tour_id" id="editTourId" class="form-control" required>
                                             </div>
                                             <div class="col-md-6">
                                                  <label class="form-label">Ngày thứ</label>
                                                  <input type="number" name="day_number" id="editDayNumber" class="form-control" required>
                                             </div>
                                             <div class="col-12">
                                                  <label class="form-label">Mô tả</label>
                                                  <textarea name="description" id="editItineraryDescription" class="form-control" rows="3" required></textarea>
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