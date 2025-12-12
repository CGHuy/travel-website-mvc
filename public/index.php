<?php
require_once __DIR__ . '/../config/helpers.php';
include __DIR__ . '/../src/views/partials/menu.php';

// Helper sinh breadcrumb động
function get_breadcrumbs()
{
    $controller = $_GET['controller'] ?? '';
    $action = $_GET['action'] ?? '';
    $map = [
        'user' => 'Người dùng',
        'destination' => 'Địa điểm',
        // Thêm các controller khác nếu cần
    ];
    $action_map = [
        'index' => 'Danh sách',
        'show' => 'Chi tiết',
        'create' => 'Thêm mới',
        'edit' => 'Chỉnh sửa',
        // Thêm các action khác nếu cần
    ];
    $breadcrumbs = [
        ['label' => 'Trang chủ', 'url' => '/'],
    ];
    if ($controller && isset($map[$controller])) {
        $breadcrumbs[] = ['label' => $map[$controller], 'url' => '?controller=' . $controller . '&action=index'];
    }
    if ($action && isset($action_map[$action]) && $action !== 'index') {
        $breadcrumbs[] = ['label' => $action_map[$action], 'url' => ''];
    }
    return $breadcrumbs;
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Du Lịch</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/AppStyle.css">
</head>

<body>

    <div class="container mt-4">
        <?php $breadcrumbs = get_breadcrumbs();
        include __DIR__ . '/../src/views/components/breadcrumb.php'; ?>
        <h2 class="mb-4">Danh sách địa điểm du lịch</h2>
        <div class="table-container">
            <div class="table-wrapper">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên người dùng</th>
                            <th>Email</th>
                            <th class="text-right">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Nguyen Ngoc Khanh</td>
                            <td>ngockhanh@gmail.com</td>
                            <td>
                                <div class="status-label status-default">Danger</div>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <button class=" btn btn-secondary">he</button>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1">
        </div>

        <div class="search-group">
            <div class="search-icon">
                <span class="material-symbols-outlined"><i class="fa-solid fa-magnifying-glass fa-sm"></i></span>
            </div>
            <input class="search-input" placeholder="Tìm kiếm tour theo tên, địa điểm..." value="" />
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Thông tin địa điểm</h2>
            </div>
            <div class="card-body card-grid">
                ...

            </div>
        </div>

        <?php
        require_once __DIR__ . '/../config/database.php';
        $db = new Database();
        $conn = $db->getConnection();
        $sql = "SELECT name, cover_image FROM tours WHERE id = 5";
        $res = $conn->query($sql);
        if ($res && $row = $res->fetch_assoc()) {
            $imgData = base64_encode($row['cover_image']);
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $finfo->buffer($row['cover_image']);
            echo "<pre>";
            echo "Mime-type: $mime\n";
            echo "Blob length: " . strlen($row['cover_image']) . "\n";
            echo "Base64 sample: " . substr($imgData, 0, 100) . "\n";
            echo "</pre>";
            echo '<img src="data:' . $mime . ';base64,' . $imgData . '" width="300" alt="' . htmlspecialchars($row['name']) . '">';
        } else {
            echo "Không tìm thấy ảnh.";
        }
        $db->close();
        ?>
    </div>
    <?php
    include __DIR__ . '/../src/views/partials/footer.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>