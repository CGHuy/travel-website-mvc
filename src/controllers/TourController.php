<?php
require_once __DIR__ . '/../models/Tour.php';
require_once __DIR__ . '/../models/TourDeparture.php';

class TourController {
    private $model;
    private $departureModel;

    public function __construct() {
        $this->model = new Tour();
        $this->departureModel = new TourDeparture();
    }

    public function index() {
        $page = $_GET['page'] ?? 1;
        $limit = 5;
        $offset = ($page - 1) * $limit;
        $tours = $this->model->getAllPaginated($offset, $limit);
        $total = $this->model->getTotal();
        $totalPages = ceil($total / $limit);
        $currentPage = 'Tour';
        ob_start();
        include __DIR__ . '/../views/admin/QuanLyTour/QuanLyTour.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/admin/admin_layout.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $name = $_POST['name'];
            $slug = $_POST['slug'];
            $description = $_POST['description'];
            $location = $_POST['location'];
            $region = $_POST['region'];
            $duration = $_POST['duration'];
            $price_default = $_POST['price_default'];
            $price_child = $_POST['price_child'];
            $cover_image = null;
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                $cover_image = file_get_contents($_FILES['cover_image']['tmp_name']);
            } else {
                // Đọc ảnh default nếu không có ảnh được chọn
                $default_image_path = __DIR__ . '/../../public/images/default.png';
                if (file_exists($default_image_path)) {
                    $cover_image = file_get_contents($default_image_path);
                }
            }
            $this->model->create($name, $slug, $description, $location, $region, $duration, $price_default, $price_child, $cover_image);
            $_SESSION['success_message'] = 'Tour đã được thêm thành công.';
            header('Location: ' . route('Tour.index'));
            exit;
        }
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $id = $_POST['id'];
            $name = $_POST['edit_name'];
            $slug = $_POST['edit_slug'];
            $description = $_POST['edit_description'];
            $location = $_POST['edit_location'];
            $region = $_POST['edit_region'];
            $duration = $_POST['edit_duration'];
            $price_default = $_POST['edit_price_default'];
            $price_child = $_POST['edit_price_child'];
            
            $cover_image = null;
            if (isset($_FILES['edit_cover_image']) && $_FILES['edit_cover_image']['error'] === UPLOAD_ERR_OK) {
                $cover_image = file_get_contents($_FILES['edit_cover_image']['tmp_name']);
            } else {
                // Đọc ảnh default nếu không có ảnh được chọn
                $default_image_path = __DIR__ . '/../../public/images/default.png';
                if (file_exists($default_image_path)) {
                    $cover_image = file_get_contents($default_image_path);
                }
            }

            $this->model->update($id, $name, $slug, $description, $location, $region, $duration, $price_default, $price_child, $cover_image);
            $_SESSION['success_message'] = 'Tour đã được cập nhật thành công.';
            header('Location: ' . route('Tour.index'));
            exit;
        }
    }

    public function delete() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $id = $_POST['id'];
        
        $departures = $this->departureModel->getByTourId($id);
        if (!empty($departures)) {
            $_SESSION['error_message'] = 'Không thể xóa tour vì tour này đã có lịch khởi hành. Vui lòng xóa các lịch khởi hành trước.';
            header('Location: ' . route('Tour.index'));
            exit;
        }
        
        $this->model->delete($id);
        $_SESSION['success_message'] = 'Tour đã được xóa thành công.';
        header('Location: ' . route('Tour.index'));
        exit;
    }

    public function getAddForm() {
        include __DIR__ . '/../views/admin/QuanLyTour/FormAddTour.php';
    }

    public function getEditForm() {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            echo "ID tour không hợp lệ.";
            return;
        }
        $tour = $this->model->getById($id);
        if (!$tour) {
            echo "Tour không tồn tại.";
            return;
        }
        include __DIR__ . '/../views/admin/QuanLyTour/FormEditTour.php';
    }

    public function exportExcel() {

        require_once __DIR__ . '/../../classes/PHPExcel.php';
        require_once __DIR__ . '/../../classes/PHPExcel/IOFactory.php';

        $objExcel = new PHPExcel();
        $objExcel->setActiveSheetIndex(0);
        $sheet = $objExcel->getActiveSheet()->setTitle('DSTour');
        $rowCount = 1;

        // Tiêu đề cột
        $sheet->setCellValue('A'.$rowCount,'Mã tour');
        $sheet->setCellValue('B'.$rowCount,'Tour code');
        $sheet->setCellValue('C'.$rowCount,'Tên tour');
        $sheet->setCellValue('D'.$rowCount,'Slug');
        $sheet->setCellValue('E'.$rowCount,'Mô tả');
        $sheet->setCellValue('F'.$rowCount,'Địa điểm');
        $sheet->setCellValue('G'.$rowCount,'Khu vực');
        $sheet->setCellValue('H'.$rowCount,'Giá');
        $sheet->setCellValue('I'.$rowCount,'Giá trẻ em');

        // Định dạng tiêu đề
        $headerStyle = array(
            'font' => array(
                    'bold' => true,
                    'color' => array('rgb' => 'FFFFFF')
            ),
            'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => '4F81BD')
            ),
            'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
            )
        );
        $sheet->getStyle('A1:I1')->applyFromArray($headerStyle);

        $data = $this->model->getAll();

        foreach ($data as $row) {
            $rowCount++;
            $sheet->setCellValue('A'.$rowCount, $row['id']);
            $sheet->setCellValue('B'.$rowCount, $row['tour_code']);
            $sheet->setCellValue('C'.$rowCount, $row['name']);
            $sheet->setCellValue('D'.$rowCount, $row['slug']);
            $sheet->setCellValue('E'.$rowCount, $row['description']);
            $sheet->setCellValue('F'.$rowCount, $row['location']);
            $sheet->setCellValue('G'.$rowCount, $row['region']);
            $sheet->setCellValue('H'.$rowCount, $row['price_default']);
            $sheet->setCellValue('I'.$rowCount, $row['price_child']);
        }

        // Tự động điều chỉnh độ rộng cột
        foreach(range('A','I') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Định dạng viền bảng
        $borderStyle = array(
            'borders' => array(
                    'allborders' => array(
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => array('rgb' => '000000')
                    )
            )
        );
        $sheet->getStyle('A1:I'.$rowCount)->applyFromArray($borderStyle);

        if (ob_get_length()) ob_end_clean();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="DSTour.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
        $writer->save('php://output');
        exit;
    }
}
