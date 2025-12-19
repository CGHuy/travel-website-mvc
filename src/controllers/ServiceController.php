<?php
require_once __DIR__ . '/../models/Service.php';

class ServiceController
{
    public function index()
    {
        $serviceModel = new Service();
        $services = $serviceModel->getAll();
        $currentPage = 'service';
        ob_start();
        include __DIR__ . '/../views/components/QuanLyService.php';
        $content = ob_get_clean();
        include __DIR__ . '/../views/partials/admin_layout.php';
    }
}