<h2>Quản Lý Tour</h2>
<a href="#" class="btn btn-primary mb-3">Thêm Tour Mới</a>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Tên Tour</th>
            <th>Mô tả</th>
            <th>Giá</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($tours)): ?>
            <?php foreach ($tours as $tour): ?>
                <tr>
                    <td><?= htmlspecialchars($tour['id']) ?></td>
                    <td><?= htmlspecialchars($tour['name']) ?></td>
                    <td><?= htmlspecialchars($tour['description']) ?></td>
                    <td><?= number_format($tour['price_default']) ?> VNĐ</td>
                    <td>
                        <a href="#" class="btn btn-sm btn-warning">Sửa</a>
                        <a href="#" class="btn btn-sm btn-danger">Xóa</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">Không có tour nào.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>