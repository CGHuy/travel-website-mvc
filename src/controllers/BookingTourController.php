<?php
require_once __DIR__ . '/../models/Tour.php';
require_once __DIR__ . '/../models/TourImage.php';
require_once __DIR__ . '/../models/TourDeparture.php';
require_once __DIR__ . '/../models/User.php';
class BookingTourController
{
    private $tourModel;
    private $tour_departureModel;

    private $userModel;

    public function __construct()
    {
        $this->tourModel = new Tour();
        $this->tour_departureModel = new TourDeparture();
        $this->userModel = new User();
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE)
            session_start();
        $tour = null;
        $departures = [];
        $userInfo = null;
        if (!empty($_SESSION['user_id'])) {
            $userInfo = $this->userModel->getById($_SESSION['user_id']);
        }
        if (isset($_GET['tour_id'])) {
            $tour = $this->tourModel->getById($_GET['tour_id']);
            if (!empty($tour['id'])) {
                $departures = $this->tour_departureModel->getByTourIdForBookingTour($tour['id']);
            }
        }
        // Truyền $userInfo sang view
        return include __DIR__ . '/../views/components/BookingTour.php';
    }
}