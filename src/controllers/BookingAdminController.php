<?php
require_once __DIR__ . '/../service/BookingAdminService.php';

class BookingAdminController
{
    private $bookingService;

    public function __construct()
    {
        $this->bookingService = new BookingAdminService();
    }

    public function index()
    {
        // Lấy trạng thái lọc nếu có
        $status = $_REQUEST['sort'] ?? '';
        $page = isset($_REQUEST['page']) ? max(1, (int) $_REQUEST['page']) : 1;
        $perPage = 5;

        // Lấy bookings từ service
        $bookings = $this->bookingService->getAllWithPagination($status, $page, $perPage);
        $totalPages = $this->bookingService->getTotalPages($status, $perPage);

        // Render view qua layout admin
        $currentPage = 'booking';
        ob_start();
        include __DIR__ . '/../views/admin/QuanLyBooking.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }

    public function detail()
    {
        $id = $_REQUEST['id'] ?? null;
        if (!$id) {
            header('Location: ' . route('BookingAdmin.index'));
            exit;
        }

        $bookingDetail = $this->bookingService->getDetail($id);

        // Chuẩn hóa dữ liệu (moved from view)
        if (!empty($bookingDetail)) {
            require_once __DIR__ . '/../models/TourDeparture.php';
            require_once __DIR__ . '/../models/Tour.php';

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

        ob_start();
        include __DIR__ . '/../views/admin/ChiTietBookingAdmin.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }
}