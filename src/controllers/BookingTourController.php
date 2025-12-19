<?php
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../service/ListTourService.php';
require_once __DIR__ . '/../models/TourImage.php';
class BookingTourController
{
    private $tourModel;

    public function __construct()
    {
        $this->tourModel = new Tour();
    }

    public function index()
    {
        return include __DIR__ . '/../views/components/BookingTour.php';
    }
}