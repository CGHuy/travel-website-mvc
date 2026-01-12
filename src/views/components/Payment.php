<?php
if (session_status() === PHP_SESSION_NONE)
    session_start();
$currentUser = $_SESSION['user_id'] ?? null;
if (!$currentUser) {
    $redirectUrl = $_SERVER['REQUEST_URI'];
    header('Location: /web_du_lich/public/login.php?redirect=' . urlencode($redirectUrl));
    exit;
}
include __DIR__ . '/../partials/header.php';
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán - Web Du Lịch</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/AppStyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h2 class="card-title text-center text-white">THANH TOÁN ĐẶT TOUR</h2>
                    </div>
                    <div class="card-body p-5">
                        <!-- Thông tin tour -->
                        <div style="background-color:#f8f9fa;padding:20px;border-radius:8px;margin-bottom:30px;">
                            <h4 class="mb-3"><strong><?php echo htmlspecialchars($tour['name'] ?? 'Chưa chọn tour'); ?></strong></h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Mã Tour:</strong> <?php echo htmlspecialchars($tour['tour_code'] ?? ''); ?></p>
                                    <p><strong>Ngày khởi hành:</strong> <?php echo htmlspecialchars($departure['departure_date'] ?? ''); ?></p>
                                    <p><strong>Điểm khởi hành:</strong> <?php echo htmlspecialchars($departure['departure_location'] ?? ''); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Số lượng người:</strong> <span class="text-danger fw-bold"><?php echo $total_quantity ?? 0; ?></span></p>
                                    <p><strong>Số lượng người lớn:</strong> <?php echo $adults ?? 0; ?></p>
                                    <p><strong>Số lượng trẻ em:</strong> <?php echo $children ?? 0; ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Chi tiết giá -->
                        <div style="background-color:#e7f3ff;padding:20px;border-radius:8px;border-left:4px solid #0d6efd;margin-bottom:30px;">
                            <h5 class="mb-3"><strong>Chi Tiết Giá</strong></h5>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <p><strong>Chi phí người lớn:</strong></p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <p><?php echo number_format($adults_cost ?? 0, 0, ',', '.'); ?>đ</p>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <p><strong>Chi phí trẻ em:</strong></p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <p><?php echo number_format($children_cost ?? 0, 0, ',', '.'); ?>đ</p>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <p><strong>Phí di chuyển:</strong></p>
                                </div>
                                <div class="col-md-6 text-end">
                                    <p><?php echo number_format($moving_total ?? 0, 0, ',', '.'); ?>đ</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <h5><strong>TỔNG TIỀN:</strong></h5>
                                </div>
                                <div class="col-md-6 text-end">
                                    <h4 class="text-danger fw-bold"><?php echo number_format($total_price ?? 0, 0, ',', '.'); ?>đ</h4>
                                </div>
                            </div>
                        </div>

                        <!-- Mã QR -->
                        <div style="background-color:#fff3cd;padding:20px;border-radius:8px;border:2px dashed #ffc107;margin-bottom:30px;text-align:center;">
                            <p class="mb-3"><strong>Quét mã QR để thanh toán</strong></p>
                            <div style="background:white;padding:10px;border-radius:8px;display:inline-block;">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?php echo urlencode('Thanh toan tour - ' . ($total_price ?? 0) . ' VND'); ?>" alt="QR Code" style="width:200px;height:200px;">
                            </div>
                        </div>

                        <!-- Nút xác nhận -->
                        <div class="row g-2">
                            <div class="col-md-6">
                                <a href="javascript:history.back()" class="btn btn-secondary w-100 fw-bold">
                                    <i class="fa fa-arrow-left me-2"></i>Quay Lại
                                </a>
                            </div>
                            <div class="col-md-6">
                                <form method="post" action="<?= route('BookingTour.confirmPayment') ?>" style="display:inline;">
                                    <input type="hidden" name="departure_id" value="<?php echo htmlspecialchars($departure_id ?? ''); ?>">
                                    <input type="hidden" name="adults" value="<?php echo htmlspecialchars($adults ?? 0); ?>">
                                    <input type="hidden" name="children" value="<?php echo htmlspecialchars($children ?? 0); ?>">
                                    <input type="hidden" name="contact_name" value="<?php echo htmlspecialchars($contact_name ?? ''); ?>">
                                    <input type="hidden" name="contact_phone" value="<?php echo htmlspecialchars($contact_phone ?? ''); ?>">
                                    <input type="hidden" name="contact_email" value="<?php echo htmlspecialchars($contact_email ?? ''); ?>">
                                    <input type="hidden" name="note" value="<?php echo htmlspecialchars($note ?? ''); ?>">
                                    <input type="hidden" name="tour_id" value="<?php echo htmlspecialchars($tour_id ?? 0); ?>">
                                    <button type="submit" class="btn btn-success w-100 fw-bold">
                                        <i class="fa fa-check-circle me-2"></i>Xác Nhận Thanh Toán
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- Thông tin liên lạc -->
                        <hr class="my-4">
                        <div style="background-color:#e8f5e9;padding:20px;border-radius:8px;border-left:4px solid #28a745;">
                            <h5 class="mb-3"><strong>Thông Tin Liên Lạc</strong></h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Tên:</strong> <?php echo htmlspecialchars($contact_name ?? ''); ?></p>
                                    <p class="mb-2"><strong>Điện thoại:</strong> <?php echo htmlspecialchars($contact_phone ?? ''); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-2"><strong>Email:</strong> <?php echo htmlspecialchars($contact_email ?? ''); ?></p>
                                    <p class="mb-2"><strong>Ghi chú:</strong> <?php echo htmlspecialchars($note ?? 'Không có'); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
include __DIR__ . '/../partials/footer.php';
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>