<h2>Quản Lý Lịch Trình</h2>
<a href="#" class="btn btn-primary mb-3">Thêm Lịch Trình Mới</a>
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
                        <a href="#" class="btn btn-sm btn-warning">Sửa</a>
                        <a href="#" class="btn btn-sm btn-danger">Xóa</a>
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