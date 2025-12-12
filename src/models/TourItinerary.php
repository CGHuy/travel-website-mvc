<?php
require_once __DIR__ . '/../../config/database.php';
class TourItinerary
{
    private $db;
    private $conn;
    public function __construct()
    {
        $this->db = new Database();
        $this->conn = $this->db->getConnection();
    }
    public function getAll()
    {
        $sql = "SELECT * FROM tour_itineraries";
        $result = $this->conn->query($sql);
        $itineraries = [];
        if ($result)
            while ($row = $result->fetch_assoc())
                $itineraries[] = $row;
        return $itineraries;
    }
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tour_itineraries WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function create($tour_id, $day_number, $description)
    {
        $stmt = $this->conn->prepare("INSERT INTO tour_itineraries (tour_id, day_number, description) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $tour_id, $day_number, $description);
        return $stmt->execute();
    }
    public function update($id, $tour_id, $day_number, $description)
    {
        $stmt = $this->conn->prepare("UPDATE tour_itineraries SET tour_id = ?, day_number = ?, description = ? WHERE id = ?");
        $stmt->bind_param("iisi", $tour_id, $day_number, $description, $id);
        return $stmt->execute();
    }
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM tour_itineraries WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function __destruct()
    {
        $this->db->close();
    }
}
