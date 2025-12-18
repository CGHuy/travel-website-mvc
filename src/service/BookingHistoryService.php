<?php
require_once __DIR__ . '/../../config/database.php';

class BookingHistoryService
{
    private $db;
    private $conn;

    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }

    /**
     * Lấy lịch sử đặt tour của một user
     * JOIN giữa bookings, tour_departures, tours
     */
    public function getByUserId($userId, $status = null) // Lấy tất cả booking của user, có thể lọc theo trạng thái
    {
        $query = "
            SELECT 
                b.id,
                b.booking_code,
                b.user_id,
                b.departure_id,
                b.quantity,
                b.total_price,
                b.payment_status,
                b.status as booking_status,
                b.contact_name,
                b.contact_phone,
                b.contact_email,
                b.note,
                b.created_at,
                b.updated_at,
                td.id as departure_id,
                td.departure_code,
                td.departure_location,
                td.departure_date,
                td.price_moving,
                td.seats_total,
                td.seats_available,
                td.status as departure_status,
                t.id as tour_id,
                t.tour_code,
                t.name as tour_name,
                t.slug,
                t.description,
                t.location,
                t.region,
                t.duration,
                t.price_default,
                t.cover_image
            FROM bookings b
            JOIN tour_departures td ON b.departure_id = td.id
            JOIN tours t ON td.tour_id = t.id
            WHERE b.user_id = ?
        ";

        $types = 'i'; // khai báo kiểu dữ liệu tham số truyền vào truy vấn Interger
        $params = [$userId];

        // Nếu $status có giá trị và nằm trong ds trạng thái hợp lệ thì thêm điều kiện lọc
        if ($status && in_array($status, ['pending', 'confirmed', 'cancelled'])) {
            $query .= " AND b.status = ?"; // thêm điều kiện lọc theo trạng thái
            $types .= 's'; // kiểu string cho tham số $status
            $params[] = $status; // thêm giá trị $status vào mảng tham số truyền vào truy vấn 
        }
        //Mục đích:
        // Giúp hàm getByUserId có thể lấy tất cả booking của user hoặc chỉ lấy booking theo trạng thái mong muốn (chờ xác nhận, đã xác nhận, đã hủy), 
        // tùy theo giá trị truyền vào từ controller.

        $query .= " ORDER BY b.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Lấy chi tiết một booking
     */
    public function getById($bookingId)
    {
        $query = "
            SELECT 
                b.id,
                b.booking_code,
                b.user_id,
                b.departure_id,
                b.quantity,
                b.total_price,
                b.payment_status,
                b.status as booking_status,
                b.contact_name,
                b.contact_phone,
                b.contact_email,
                b.note,
                b.created_at,
                b.updated_at,
                td.id as departure_id,
                td.departure_code,
                td.departure_location,
                td.departure_date,
                td.price_moving,
                td.seats_total,
                td.seats_available,
                td.status as departure_status,
                t.id as tour_id,
                t.tour_code,
                t.name as tour_name,
                t.slug,
                t.description,
                t.location,
                t.region,
                t.duration,
                t.price_default,
                t.cover_image
            FROM bookings b
            JOIN tour_departures td ON b.departure_id = td.id
            JOIN tours t ON td.tour_id = t.id
            WHERE b.id = ?
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $bookingId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    /**
     * Lấy tất cả bookings (có phân trang)
     */
    public function getAll($limit = 10, $offset = 0)
    {
        $query = "
            SELECT 
                b.id,
                b.booking_code,
                b.user_id,
                b.departure_id,
                b.quantity,
                b.total_price,
                b.payment_status,
                b.status as booking_status,
                b.contact_name,
                b.contact_phone,
                b.contact_email,
                b.note,
                b.created_at,
                b.updated_at,
                td.id as departure_id,
                td.departure_code,
                td.departure_location,
                td.departure_date,
                td.price_moving,
                td.seats_total,
                td.seats_available,
                td.status as departure_status,
                t.id as tour_id,
                t.tour_code,
                t.name as tour_name,
                t.slug,
                t.description,
                t.location,
                t.region,
                t.duration,
                t.price_default,
                t.cover_image
            FROM bookings b
            JOIN tour_departures td ON b.departure_id = td.id
            JOIN tours t ON td.tour_id = t.id
            ORDER BY b.created_at DESC
            LIMIT ? OFFSET ?
        ";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('ii', $limit, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Đếm tổng số bookings của user
     */
    public function countByUserId($userId)
    {
        $query = "SELECT COUNT(*) as total FROM bookings WHERE user_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['total'];
    }
    public function __destruct()
    {
        $this->db->close();
    }
}
