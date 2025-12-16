<!-- Đã chuyển CSS sang file ListTourStyle.css -->
<?php
include __DIR__ . '/../partials/menu.php';

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Web Du Lịch</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/AppStyle.css">
    <link rel="stylesheet" href="css/SettingAccount.css">
    <link rel="stylesheet" href="css/ListTourStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

</head>

<body>
    <main class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-1">
            <h1 class="text-slate-900 dark:text-slate-50 fw-bold mb-3" style="font-size:2rem;">Khám Phá Các Tour Du Lịch
            </h1>
            <div class="d-flex align-items-center gap-2 flex-nowrap">
                <label class="form-label mb-0 text-sm font-medium text-slate-600 dark:text-slate-300" for="sort">Sắp
                    xếp:</label>
                <select
                    class="form-select rounded-lg border-slate-300 bg-background-light dark:bg-slate-800 dark:border-slate-700 dark:text-slate-200 h-10 ps-3 pe-4 text-sm focus:border-primary focus:ring-primary"
                    id="sort">
                    <option>Tất cả</option>
                    <option>Giá: Thấp đến cao</option>
                    <option>Giá: Cao đến thấp</option>
                </select>
            </div>
        </div>

        <div class="main-body d-flex gap-4">
            <div class="card p-4" style="flex: 0 0 20%; min-height: 70vh; align-self: flex-start;">
                <h5>Bộ lọc</h5>
                <!-- Bộ lọc bên trái -->
                <form>
                    <div class="mb-4">
                        <label for="priceRange" class="form-label fw-bold">Giá</label>
                        <input type="range" class="form-range" min="500000" max="10000000" step="500000"
                            id="priceRange">
                        <div class="d-flex justify-content-between">
                            <span>500.000đ</span>
                            <span>10.000.000đ+</span>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="areaSelect" class="form-label fw-bold">Khu vực</label>
                        <select class="form-select" id="areaSelect">
                            <option>Tất cả</option>
                            <option>Miền Bắc</option>
                            <option>Miền Trung</option>
                            <option>Miền Nam</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold">Thời lượng</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="duration" id="duration1" autocomplete="off"
                                checked>
                            <label class="btn btn-outline-primary" for="duration1">1–3 ngày</label>
                            <input type="radio" class="btn-check" name="duration" id="duration2" autocomplete="off">
                            <label class="btn btn-outline-primary" for="duration2">4–7 ngày</label>
                            <input type="radio" class="btn-check" name="duration" id="duration3" autocomplete="off">
                            <label class="btn btn-outline-primary" for="duration3">7+ ngày</label>
                        </div>
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold">Dịch vụ</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="service1">
                            <label class="form-check-label" for="service1">
                                Bao gồm vé máy bay
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="service2" checked>
                            <label class="form-check-label" for="service2">
                                Khách sạn 5 sao
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="service3">
                            <label class="form-check-label" for="service3">
                                Có hướng dẫn viên
                            </label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="list-tour" style="flex: 0 0 calc(80% - 1rem);">
                <!-- Danh sách tour: 2 hàng 3 cột, Bootstrap, có phân trang -->
                <div class="container">
                    <div class="row g-3">
                        <?php if (!empty($tours)): ?>
                            <?php foreach ($tours as $tour): ?>
                                <div class="col-4">
                                    <div class="card h-100">
                                        <?php
                                        $finfo = new finfo(FILEINFO_MIME_TYPE);
                                        $mime = $finfo->buffer($tour['cover_image']);
                                        $imgData = base64_encode($tour['cover_image']);
                                        ?>
                                        <img src="data:<?php echo $mime; ?>;base64,<?php echo $imgData; ?>"
                                            class="card-img-top p-3" alt="<?php echo htmlspecialchars($tour['name']); ?>">
                                        <div class="card-body py-0 text-center">
                                            <div class="d-flex flex-column h-100">
                                                <div class="mb-2 d-flex justify-content-center gap-2">
                                                    <span class="badge bg-primary">
                                                        <?php echo htmlspecialchars($tour['duration']); ?> ngày
                                                    </span>
                                                    <span class="badge bg-primary">
                                                        <?php echo htmlspecialchars($tour['region']); ?>
                                                    </span>
                                                </div>
                                                <h5 class="card-title"><?php echo htmlspecialchars($tour['name']); ?></h5>
                                                <p class="card-text"><?php echo htmlspecialchars($tour['description']); ?></p>
                                                <div class="d-flex justify-content-between align-items-center mt-1">
                                                    <p class="fw-bold text-primary self-align-center mb-0"
                                                        style="font-size: 1.4rem;">
                                                        <?php echo number_format($tour['price_default'], 0, ',', '.') . 'đ'; ?>
                                                    </p>
                                                    <a href="#" class="btn btn-primary">Xem chi tiết</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <p>Không có tour nào để hiển thị.</p>
                            </div>
                        <?php endif; ?>

                        <!-- Pagination -->
                        <?php if (isset($totalPages) && $totalPages > 1): ?>
                            <nav aria-label="Page navigation" class="mt-4">
                                <ul class="pagination justify-content-center">
                                    <?php
                                    $currentPage = isset($page) ? $page : 1;
                                    $prevDisabled = $currentPage <= 1 ? 'disabled' : '';
                                    $nextDisabled = $currentPage >= $totalPages ? 'disabled' : '';
                                    $queryStr = $_GET;
                                    ?>
                                    <li class="page-item <?php echo $prevDisabled; ?>">
                                        <a class="page-link" href="?<?php $queryStr['page'] = $currentPage - 1;
                                        echo http_build_query($queryStr); ?>" tabindex="-1">Trước</a>
                                    </li>
                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
                                            <a class="page-link" href="?<?php $queryStr['page'] = $i;
                                            echo http_build_query($queryStr); ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?php echo $nextDisabled; ?>">
                                        <a class="page-link" href="?<?php $queryStr['page'] = $currentPage + 1;
                                        echo http_build_query($queryStr); ?>">Sau</a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
    </main>

</body>
<?php
include __DIR__ . '/../partials/footer.php';
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>