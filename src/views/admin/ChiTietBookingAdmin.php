<?php $bookingDetail = $bookingDetail ?? [];
$currentPage = 'booking'; ?>


<link rel="stylesheet" href="css/ChiTietBookingAdmin.css">

<div class="card-header">
    <h2 class="card-title">CHI TIẾT BOOKING</h2>
    <p style="color: #636465ff;">Thông tin chi tiết về chuyến đi của bạn đã đặt</p>
</div>
<div class="table-responsive">
    <form method="post">
        <table class="table align-middle detail-booking-table">
            <tbody>
                <?php if (empty($bookingDetail)): ?>
                    <tr>
                        <td colspan="9" class="text-center">Không tìm thấy booking</td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <th rowspan="4">
                            <h6 style="color: #1a75c4ff;">THÔNG TIN LIÊN LẠC</h6>
                        </th>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Họ và tên</td>
                        <td><?= htmlspecialchars($bookingDetail['contact_name']) ?></td>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Email</td>
                        <td><?= htmlspecialchars($bookingDetail['contact_email']) ?></td>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Số điện thoại</td>
                        <td><?= htmlspecialchars($bookingDetail['contact_phone']) ?></td>
                    </tr>

                    <tr>
                        <th rowspan="8">
                            <h6 style="color: #1a75c4ff;">CHI TIẾT BOOKING </h6>
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
                        <td><?= date('d/m/Y', strtotime($bookingDetail['departure_date'])) ?></td>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Số lượng</td>
                        <td><?= htmlspecialchars($bookingDetail['quantity']) ?></td>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Địa điểm khởi hành</td>
                        <td><?= htmlspecialchars($bookingDetail['departure_location']) ?></td>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Ghi chú</td>
                        <td><?= htmlspecialchars($bookingDetail['note']) ?></td>
                    </tr>

                    <tr class="detail-payment-header">
                        <th rowspan="4">
                            <h6 style="color: #1a75c4ff;">THÔNG TIN THANH TOÁN</h6>
                        </th>
                    </tr>

                    </tr>
                    <tr>
                        <td class="detail-booking-title">Tổng giá</td>
                        <td style="color: red; font-weight: bold;">
                            <?= number_format($bookingDetail['total_price'], 0, ',', '.') ?> đ
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
                            echo $statusBadge[$bookingDetail['booking_status']] ?? $bookingDetail['booking_status'];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="detail-booking-title">Trạng thái thanh toán</td>
                        <td>
                            <?php
                            $statusBadge = [
                                'unpaid' => '<span class="badge bg-warning">Chưa thanh toán</span>',
                                'paid' => '<span class="badge bg-success">Đã thanh toán</span>',
                                'refunded' => '<span class="badge bg-danger">Đã hoàn tiền</span>'
                            ];
                            echo $statusBadge[$bookingDetail['payment_status']] ?? $bookingDetail['payment_status'];
                            ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
</div>