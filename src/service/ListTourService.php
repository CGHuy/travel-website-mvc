<?php
require_once __DIR__ . '/../models/Tour.php';

class ListTourService
{
    private $tourModel;
    public function __construct()
    {
        $this->tourModel = new Tour();
    }

    /**
     * Lọc tour theo region, duration, services (lọc đủ tất cả dịch vụ)
     * $services: mảng id dịch vụ (int)
     */
    public function filterTours($region = '', $durationRange = '', $services = [])
    {
        $params = [];
        $where = [];
        $join = '';
        $having = '';
        $group = '';
        if ($region !== '') {
            $where[] = 't.region = ?';
            $params[] = $region;
        }
        if (!empty($services)) {
            $count = count($services);
            $join .= ' INNER JOIN tour_services ts ON t.id = ts.tour_id ';
            $where[] = 'ts.service_id IN (' . implode(',', array_fill(0, $count, '?')) . ')';
            $params = array_merge($params, $services);
            $group = ' GROUP BY t.id ';
            $having = ' HAVING COUNT(DISTINCT ts.service_id) = ' . $count;
        }
        $sql = 'SELECT t.* FROM tours t ' . $join;
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $sql .= $group . $having;
        $db = new \Database();
        $conn = $db->getConnection();
        $stmt = $conn->prepare($sql);
        if ($params) {
            $types = str_repeat('s', count($params));
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        $tours = [];
        while ($row = $result->fetch_assoc()) {
            $tours[] = $row;
        }
        // Lọc tiếp theo duration nếu có
        if ($durationRange !== '') {
            $filtered = [];
            foreach ($tours as $tour) {
                $days = null;
                if (preg_match('/(\d+)\s*ngày/i', $tour['duration'], $matches)) {
                    $days = (int) $matches[1];
                } elseif (preg_match('/(\d+)/', $tour['duration'], $matches)) {
                    $days = (int) $matches[1];
                }
                if ($days !== null) {
                    if (
                        ($durationRange === '1-3' && $days >= 1 && $days <= 3) ||
                        ($durationRange === '4+' && $days >= 4)
                    ) {
                        $filtered[] = $tour;
                    }
                }
            }
            return $filtered;
        }
        return $tours;
    }

    /**
     * Lọc tour theo region và khoảng ngày thực tế (duration)
     * $durationRange: '1-3', '4-7', '8+'
     */
    public function getByRegionAndDuration($region, $durationRange)
    {
        $tours = $this->tourModel->getByRegion($region);
        if ($durationRange === '' || $durationRange === null) {
            return $tours;
        }
        $filtered = [];
        foreach ($tours as $tour) {
            // Ưu tiên lấy số ngày (trước từ "ngày"), ví dụ: "4 ngày 3 đêm" => 4
            $days = null;
            if (preg_match('/(\d+)\s*ngày/i', $tour['duration'], $matches)) {
                $days = (int) $matches[1];
            } elseif (preg_match('/(\d+)/', $tour['duration'], $matches)) {
                $days = (int) $matches[1];
            }
            if ($days !== null) {
                if (
                    ($durationRange === '1-3' && $days >= 1 && $days <= 3) ||
                    ($durationRange === '4+' && $days >= 4)
                ) {
                    $filtered[] = $tour;
                }
            }
        }
        return $filtered;
    }

    /**
     * Lọc tour theo khoảng ngày thực tế (duration), không phụ thuộc region
     * $durationRange: '1-3', '4-7', '8+'
     */
    public function getByDurationRange($durationRange)
    {
        $tours = $this->tourModel->getAll();
        if ($durationRange === '' || $durationRange === null) {
            return $tours;
        }
        $filtered = [];
        foreach ($tours as $tour) {
            // Ưu tiên lấy số ngày (trước từ "ngày"), ví dụ: "4 ngày 3 đêm" => 4
            $days = null;
            if (preg_match('/(\d+)\s*ngày/i', $tour['duration'], $matches)) {
                $days = (int) $matches[1];
            } elseif (preg_match('/(\d+)/', $tour['duration'], $matches)) {
                $days = (int) $matches[1];
            }
            if ($days !== null) {
                if (
                    ($durationRange === '1-3' && $days >= 1 && $days <= 3) ||
                    ($durationRange === '4+' && $days >= 4)
                ) {
                    $filtered[] = $tour;
                }
            }
        }
        return $filtered;
    }
}

