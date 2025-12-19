<?php
require_once __DIR__ . '/../models/Tour.php';

class TourController
{
    public function index()
    {
        $tourModel = new Tour();
        $tours = $tourModel->getAll();
        $currentPage = 'tour';
        ob_start();
        include __DIR__ . '/../views/components/QuanLyTour.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/partials/admin_layout.php';

    }
    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price_default = $_POST['price_default'];
            // Thêm các field khác
            $this->tourModel->create($name, '', $description, '', '', '', $price_default, '');
            header('Location: ' . route('tour.index'));
        }
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $description = $_POST['description'];
            $price_default = $_POST['price_default'];
            $this->tourModel->update($id, $name, '', $description, '', '', '', $price_default, '');
            header('Location: ' . route('tour.index'));
        }
    }

    public function delete()
    {
        $id = $_GET['id'];
        $this->tourModel->delete($id);
        header('Location: ' . route('tour.index'));
    }
}