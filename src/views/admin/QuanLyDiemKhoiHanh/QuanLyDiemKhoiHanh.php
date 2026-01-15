<div class="card-header d-flex justify-content-between align-items-center p-0 px-4">
    <div>
        <h5 class="card-title">
            <i class="fa-solid fa-location-dot me-2"></i>Quản lý Điểm Khởi Hành
        </h5>
    </div>
    <div class="text-end mb-2">
        <span class="badge bg-info">Tổng: <?= $total ?> điểm khởi hành</span>
    </div>
</div>
<div class="card-body">
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-exclamation me-2"></i><?= htmlspecialchars($_SESSION['error_message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['error_message']); ?>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i><?= htmlspecialchars($_SESSION['success_message']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    
    <div class="input-group search-group mb-3">
        <span class="input-group-text search-icon">
            <i class="fa-solid fa-magnifying-glass fa-sm"></i>
        </span>
        <input class="form-control search-input" id="searchTourDeparture" placeholder="Tìm kiếm điểm khởi hành theo mã, tên tour, địa điểm..." value="" aria-label="Tìm kiếm" />
    </div>
    <a href="#" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addTourDepartureModal">Thêm Điểm Khởi Hành Mới</a>
    <div class="list-group">
        <?php if (!empty($departures)): ?>
            <?php foreach ($departures as $departure): ?>
                <div class="list-group-item mb-3 p-3 border rounded shadow-sm d-flex align-items-center tour-departure-item">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="mb-1 fw-bold find_name">
                                    <?= htmlspecialchars($departure['tour_name']) ?>
                                    <?php
                                    $status = $departure['status'];
                                    $badgeClass = '';
                                    $badgeText = '';
                                    if ($status == 'open') {
                                        $badgeClass = 'bg-success';
                                        $badgeText = 'Mở';
                                    } elseif ($status == 'closed') {
                                        $badgeClass = 'bg-danger';
                                        $badgeText = 'Đóng';
                                    } elseif ($status == 'full') {
                                        $badgeClass = 'bg-warning';
                                        $badgeText = 'Đầy';
                                    }
                                    ?>
                                    <span class="badge <?= $badgeClass ?> ms-2"><?= $badgeText ?></span>
                                </h5>
                                <small class="text-muted find_id">Mã: <?= htmlspecialchars($departure['departure_code']) ?></small>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="#" class="btn btn-sm btn-outline-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editTourDepartureModal"
                                    data-id="<?= $departure['id'] ?>">
                                    <i class="fa-solid fa-pen-to-square me-1"></i> Sửa
                                </a>
                                <a href="#" class="btn btn-sm btn-outline-danger"
                                    data-bs-toggle="modal"
                                    data-bs-target="#deleteTourDepartureModal"
                                    data-id="<?= $departure['id'] ?>"
                                    data-name="<?= htmlspecialchars($departure['tour_name']) ?>">
                                    <i class="fa-solid fa-trash me-1"></i> Xóa
                                </a>
                            </div>
                        </div>
                        <hr class="my-2">
                        <div class="d-flex justify-content-between text-muted small">
                            <span class="d-flex align-items-center">
                                <i class="fa-solid fa-plane-departure me-2"></i>
                                <strong class="me-1">Địa điểm:</strong>
                                <span class="find_location"><?= htmlspecialchars($departure['departure_location']) ?></span>
                            </span>
                            <span class="d-flex align-items-center">
                                <i class="fa-solid fa-calendar me-2"></i>
                                <strong class="me-1">Ngày:</strong>
                                <span><?= htmlspecialchars($departure['departure_date']) ?></span>
                            </span>
                            <span class="d-flex align-items-center">
                                <i class="fa-solid fa-tag me-2"></i>
                                <strong class="me-1">Giá:</strong>
                                <span><?= number_format($departure['price_moving']) ?> VNĐ</span>
                            </span>
                            <span class="d-flex align-items-center">
                                <i class="fa-solid fa-child me-2"></i>
                                <strong class="me-1">Giá trẻ em:</strong>
                                <span><?= number_format($departure['price_moving_child']) ?> VNĐ</span>
                            </span>
                             <span class="d-flex align-items-center">
                                <i class="fa-solid fa-users me-2"></i>
                                <strong class="me-1">Chỗ ngồi:</strong>
                                <span><?= htmlspecialchars($departure['seats_available']) ?>/<?= htmlspecialchars($departure['seats_total']) ?></span>
                            </span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <?php if ($totalPages > 1): ?>
                <nav aria-label="Page navigation" class="mt-3">
                    <ul class="pagination justify-content-center">
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a class="page-link" href="?controller=TourDeparture&action=index&page=<?= $page - 1 ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                <a class="page-link" href="?controller=TourDeparture&action=index&page=<?= $i ?>"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        <?php if ($page < $totalPages): ?>
                            <li class="page-item">
                                <a class="page-link" href="?controller=TourDeparture&action=index&page=<?= $page + 1 ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            <?php endif; ?>
        <?php else: ?>
            <p class="text-center">Không có điểm khởi hành nào.</p>
        <?php endif; ?>
    </div>
</div>

<!-- Modal thêm -->
<div class="modal fade" id="addTourDepartureModal" tabindex="-1" aria-labelledby="addTourDepartureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTourDepartureModalLabel">Thêm Điểm Khởi Hành</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-0 pt-0">
                <!-- Nội dung -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Đang tải form...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal sửa -->
<div class="modal fade" id="editTourDepartureModal" tabindex="-1" aria-labelledby="editTourDepartureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTourDepartureModalLabel">Sửa Điểm Khởi Hành</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-0 pt-0">
                <!-- Nội dung -->
                <div class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Đang tải form...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal xóa -->
<div class="modal fade" id="deleteTourDepartureModal" tabindex="-1" aria-labelledby="deleteTourDepartureModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="deleteTourDepartureModalLabel">Xác nhận xóa điểm khởi hành</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form method="post" action="<?= route('TourDeparture.delete') ?>">
                <input type="hidden" name="id" id="delete_id">

                <div class="modal-body">
                    <p class="m-0 p-2">Bạn có chắc chắn muốn xóa điểm khởi hành:</p>
                    <strong id="delete_name" class="p-2"></strong>
                    <p class="text-danger m-0 p-2"><strong>Hành động này không thể hoàn tác.</strong></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-danger">Xóa</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="/web_du_lich/public/js/admin/QuanLyTourDeparture.js"></script>