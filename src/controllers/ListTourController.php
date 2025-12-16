<?php
require_once __DIR__ . '/../models/Tour.php';

class ListTourController
{
    private $tourModel;

    public function __construct()
    {
        $this->tourModel = new Tour();
    }

    public function index()
    {
        $allTours = $this->tourModel->getAll();
        $perPage = 6;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0 ? (int) $_GET['page'] : 1;
        $totalTours = count($allTours);
        $totalPages = (int) ceil($totalTours / $perPage);
        $offset = ($page - 1) * $perPage;
        $tours = array_slice($allTours, $offset, $perPage);
        return include __DIR__ . '/../views/components/ListTour.php';
    }
}