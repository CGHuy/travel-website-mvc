<?php
require_once __DIR__ . '/../../config/database.php';
class TourService
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
        $sql = "SELECT * FROM tour_services";
        $result = $this->conn->query($sql);
        $services = [];
        if ($result)
            while ($row = $result->fetch_assoc())
                $services[] = $row;
        return $services;
    }
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tour_services WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }
    public function create($tour_id, $service_id)
    {
        $stmt = $this->conn->prepare("INSERT INTO tour_services (tour_id, service_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $tour_id, $service_id);
        return $stmt->execute();
    }
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM tour_services WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function __destruct()
    {
        $this->db->close();
    }
}
