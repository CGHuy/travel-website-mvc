<?php include __DIR__ . '/../partials/header.php'; ?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý booking</title>
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
                $currentPage = 'booking';
                include __DIR__ . '/../partials/admin-menu.php';
            ?>

            <div class="card card_form" style="flex: 0 0 calc(80% - 1rem);">
                <div class="card-body">
                    <div id="admin-content">
                        <h2>Quản Lý Booking</h2>
                        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addBookingModal">Thêm Booking Mới</button>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên Tour</th>
                                    <th>Tên Khách</th>
                                    <th>Ngày Đặt</th>
                                    <th>Trạng Thái</th>
                                    <th>Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($bookings)): ?>
                                    <?php foreach ($bookings as $booking): ?>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning" onclick="editBooking(<?= $booking['id'] ?>)">Sửa</button>
                                                <button class="btn btn-sm btn-danger" onclick="deleteBooking(<?= $booking['id'] ?>)">Xóa</button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6">Không có booking nào.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Modal Thêm Booking -->
                    <div class="modal fade" id="addBookingModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Thêm Booking Mới</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="post" action="?controller=AdminController&action=storeBooking">
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Tour ID</label>
                                                <input type="number" name="tour_id" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">User ID</label>
                                                <input type="number" name="user_id" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Ngày Đặt</label>
                                                <input type="date" name="booking_date" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Số Người</label>
                                                <input type="number" name="number_of_people" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Tổng Giá</label>
                                                <input type="number" name="total_price" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Trạng Thái</label>
                                                <select name="status" class="form-control" required>
                                                    <option value="pending">Pending</option>
                                                    <option value="confirmed">Confirmed</option>
                                                    <option value="cancelled">Cancelled</option>
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

                    <!-- Modal Sửa Booking -->
                    <div class="modal fade" id="editBookingModal" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Sửa Booking</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="post" action="?controller=AdminController&action=updateBooking">
                                    <input type="hidden" name="id" id="editBookingId">
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Tour ID</label>
                                                <input type="number" name="tour_id" id="editTourId" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">User ID</label>
                                                <input type="number" name="user_id" id="editUserId" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Ngày Đặt</label>
                                                <input type="date" name="booking_date" id="editBookingDate" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Số Người</label>
                                                <input type="number" name="number_of_people" id="editNumberOfPeople" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Tổng Giá</label>
                                                <input type="number" name="total_price" id="editTotalPrice" class="form-control" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Trạng Thái</label>
                                                <select name="status" id="editStatus" class="form-control" required>
                                                    <option value="pending">Pending</option>
                                                    <option value="confirmed">Confirmed</option>
                                                    <option value="cancelled">Cancelled</option>
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
