<?php
require_once __DIR__ . '/../models/TourItinerary.php';

class ItineraryController {

    public function storeItinerary() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $itineraryModel = new TourItinerary();
            $name = $_POST['name'] ?? '';
            $tour_id = $_POST['tour_id'] ?? 0;
            $day_number = $_POST['day_number'] ?? 0;
            $description = $_POST['description'] ?? '';
            $itineraryModel->create($tour_id, $day_number, $description);
            header('Location: ?controller=AdminController&action=itinerary');
            exit;
        }
    }

    public function updateItinerary() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $itineraryModel = new TourItinerary();
            $id = $_POST['id'] ?? 0;
            $name = $_POST['name'] ?? '';
            $tour_id = $_POST['tour_id'] ?? 0;
            $day_number = $_POST['day_number'] ?? 0;
            $description = $_POST['description'] ?? '';
            $itineraryModel->update($id, $tour_id, $day_number, $description);
            header('Location: ?controller=AdminController&action=itinerary');
            exit;
        }
    }

    public function deleteItinerary() {
        $id = $_GET['id'] ?? 0;
        $itineraryModel = new TourItinerary();
        $itineraryModel->delete($id);
        header('Location: ?controller=AdminController&action=itinerary');
        exit;
    }

    public function getItinerary() {
        $id = $_GET['id'] ?? 0;
        $itineraryModel = new TourItinerary();
        $itinerary = $itineraryModel->getById($id);
        header('Content-Type: application/json');
        echo json_encode($itinerary);
        exit;
    }
}
?>