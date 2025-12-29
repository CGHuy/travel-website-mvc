<?php
// Lấy dữ liệu từ controller
$bookingDetail = $bookingDetail ?? [];

// Chuẩn hóa dữ liệu
if (!empty($bookingDetail)) {
    // Lấy thông tin tour từ TourDeparture
    require_once __DIR__ . '/../../models/TourDeparture.php';
    require_once __DIR__ . '/../../models/Tour.php';

    $tourDeparture = new TourDeparture();
    $tourModel = new Tour();

    $departure = $tourDeparture->getById($bookingDetail['departure_id'] ?? null);
    $tour = $tourModel->getById($departure['tour_id'] ?? null);

    $bookingDetail['tour_code'] = $tour['code'] ?? 'N/A';
    $bookingDetail['tour_name'] = $tour['name'] ?? 'N/A';
    $bookingDetail['departure_date'] = $departure['departure_date'] ?? $bookingDetail['created_at'] ?? '';
    $bookingDetail['departure_location'] = $departure['departure_location'] ?? 'N/A';
    $bookingDetail['booking_status'] = $bookingDetail['status'] ?? 'pending';
    $bookingDetail['payment_status'] = $bookingDetail['payment_status'] ?? 'unpaid';
}
?>

<div class="card-header d-flex justify-content-between align-items-center">
    <div>
        <h5 class="card-title">Chi Tiết Booking</h5>
        <p style="color: #636465ff;">Thông tin chi tiết về chuyến đi của bạn đã đặt</p>
    </div>
</div>
<div class="card-body">
    <div class="table-responsive">
        <table class="table align-middle detail-booking-table">
            <tbody>
                <?php if (empty($bookingDetail)): ?>
                    <tr>
                        <td colspan="2" class="text-center">Không tìm thấy booking</td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <th rowspan="4">
                            <h6 style="color: #1a75c4ff;">THÔNG TIN LIÊN LẠC</h6>
                        </th>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Họ và tên</td>
                        <td><?= htmlspecialchars($bookingDetail['contact_name'] ?? 'N/A') ?></td>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Email</td>
                        <td><?= htmlspecialchars($bookingDetail['contact_email'] ?? 'N/A') ?></td>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Số điện thoại</td>
                        <td><?= htmlspecialchars($bookingDetail['contact_phone'] ?? 'N/A') ?></td>
                    </tr>

                    <tr>
                        <th rowspan="8">
                            <h6 style="color: #1a75c4ff;">CHI TIẾT BOOKING</h6>
                        </th>
                    </tr>

                    <tr>
                        <td class="detail-booking-title">Mã Booking</td>
                        <td style="color: blue; font-weight: bold;">
                            <?= htmlspecialchars($bookingDetail['booking_code'] ?? 'BK' . str_pad($bookingDetail['id'], 5, '0', STR_PAD_LEFT)) ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Mã Tour</td>
                        <td style="color: blue; font-weight: bold;">
                            <?= htmlspecialchars($bookingDetail['tour_code']) ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Tên Tour</td>
                        <td><?= htmlspecialchars($bookingDetail['tour_name']) ?></td>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Ngày khởi hành</td>
                        <td><?= !empty($bookingDetail['departure_date']) ? date('d/m/Y', strtotime($bookingDetail['departure_date'])) : 'N/A' ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Số lượng</td>
                        <td><?= htmlspecialchars($bookingDetail['quantity'] ?? 'N/A') ?></td>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Địa điểm khởi hành</td>
                        <td><?= htmlspecialchars($bookingDetail['departure_location'] ?? 'N/A') ?></td>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Ghi chú</td>
                        <td><?= htmlspecialchars($bookingDetail['note'] ?? 'Không có') ?></td>
                    </tr>

                    <tr class="detail-payment-header">
                        <th rowspan="4">
                            <h6 style="color: #1a75c4ff;">THÔNG TIN THANH TOÁN</h6>
                        </th>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Tổng giá</td>
                        <td style="color: red; font-weight: bold;">
                            <?= number_format($bookingDetail['total_price'] ?? 0, 0, ',', '.') ?> đ
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Trạng thái</td>
                        <td>
                            <?php
                            $statusBadge = [
                                'pending' => '<span class="badge bg-warning">Chờ xác nhận</span>',
                                'confirmed' => '<span class="badge bg-success">Đã xác nhận</span>',
                                'cancelled' => '<span class="badge bg-danger">Đã hủy</span>'
                            ];
                            echo $statusBadge[$bookingDetail['booking_status']] ?? '<span class="badge bg-secondary">Không rõ</span>';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Trạng thái thanh toán</td>
                        <td>
                            <?php
                            $paymentBadge = [
                                'unpaid' => '<span class="badge bg-warning">Chưa thanh toán</span>',
                                'paid' => '<span class="badge bg-success">Đã thanh toán</span>',
                                'refunded' => '<span class="badge bg-danger">Đã hoàn tiền</span>'
                            ];
                            echo $paymentBadge[$bookingDetail['payment_status']] ?? '<span class="badge bg-secondary">Không rõ</span>';
                            ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>