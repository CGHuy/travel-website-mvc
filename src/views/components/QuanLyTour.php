<div class="card-header d-flex justify-content-between align-items-center">
    <div>
        <h5 class="card-title">Quản lý Tour</h5>
    </div>
    <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addTourModal">Thêm Tour Mới</a>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Tour</th>
                    <th>Mô tả</th>
                    <th>Giá</th>
                    <th>Trạng thái</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($tours)): ?>
                    <?php foreach ($tours as $tour): ?>
                        <tr>
                            <td><?= htmlspecialchars($tour['id']) ?></td>
                            <td><?= htmlspecialchars($tour['name']) ?></td>
                            <td><?= htmlspecialchars(substr($tour['description'], 0, 50)) ?>...</td>
                            <td><?= number_format($tour['price_default']) ?> VNĐ</td>
                            <td>
                                <span class="status-label status-success">Hoạt động</span>
                            </td>
                            <td>
                                <a href="#" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editTourModal" data-id="<?= $tour['id'] ?>">Sửa</a>
                                <a href="#" class="btn btn-sm btn-outline-danger" onclick="deleteTour(<?= $tour['id'] ?>)">Xóa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">Không có tour nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Thêm Tour -->
<div class="modal fade" id="addTourModal" tabindex="-1" aria-labelledby="addTourModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTourModalLabel">Thêm Tour Mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="<?= route('tour.create') ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Tên Tour</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="price_default" class="form-label">Giá</label>
                        <input type="number" class="form-control" id="price_default" name="price_default" required>
                    </div>
                    <!-- Thêm các field khác nếu cần -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Thêm</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Sửa Tour -->
<div class="modal fade" id="editTourModal" tabindex="-1" aria-labelledby="editTourModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTourModalLabel">Sửa Tour</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="<?= route('tour.update') ?>">
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Tên Tour</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_price_default" class="form-label">Giá</label>
                        <input type="number" class="form-control" id="edit_price_default" name="price_default" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deleteTour(id) {
    if (confirm('Bạn có chắc muốn xóa tour này?')) {
        // Gửi request xóa
        window.location.href = '?controller=tour&action=delete&id=' + id;
    }
}

// Điền dữ liệu vào modal sửa khi click
document.addEventListener('DOMContentLoaded', function() {
    var editModal = document.getElementById('editTourModal');
    editModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        // Giả sử lấy dữ liệu từ server, nhưng tạm thời để trống
        document.getElementById('edit_id').value = id;
        // Có thể dùng AJAX để lấy dữ liệu tour
    });
});
</script>