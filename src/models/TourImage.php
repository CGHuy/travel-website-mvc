<?php
require_once __DIR__ . '/../../config/database.php';
class TourImage
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
        $sql = "SELECT * FROM tour_images";
        $result = $this->conn->query($sql);
        $images = [];
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $row['image'] = $this->convertToDataUri($row['image']);
                $images[] = $row;
            }
        }
        return $images;
    }
    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tour_images WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        if ($row && isset($row['image'])) {
            $row['image'] = $this->convertToDataUri($row['image']);
        }
        return $row;
    }
    public function create($tour_id, $image)
    {
        $stmt = $this->conn->prepare("INSERT INTO tour_images (tour_id, image) VALUES (?, ?)");
        $stmt->bind_param("is", $tour_id, $image);
        return $stmt->execute();
    }
    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM tour_images WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    public function __destruct()
    {
        $this->db->close();
    }
    /**
     * Convert binary image data to data URI for browser display
     * @param string|null $bin
     * @return string|null
     */
    private function convertToDataUri($bin)
    {
        if ($bin === null)
            return null;
        // Try to detect mime type by magic bytes (simple check)
        $mime = 'image/jpeg'; // default
        if (strlen($bin) > 2) {
            $bytes = substr($bin, 0, 4);
            if (strncmp($bytes, "\x89PNG", 4) === 0)
                $mime = 'image/png';
            elseif (strncmp($bytes, "\xFF\xD8", 2) === 0)
                $mime = 'image/jpeg';
            elseif (strncmp($bytes, "GIF8", 4) === 0)
                $mime = 'image/gif';
            elseif (strncmp($bytes, "RIFF", 4) === 0)
                $mime = 'image/webp';
        }
        return 'data:' . $mime . ';base64,' . base64_encode($bin);
    }

    public function getImagesByTourIdForListTour($tour_id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM tour_images WHERE tour_id = ?");
        $stmt->bind_param("i", $tour_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $images = [];
        while ($row = $result->fetch_assoc()) {
            $row['image'] = $this->convertToDataUri($row['image']);
            $images[] = $row;
        }
        return $images;
    }
}
