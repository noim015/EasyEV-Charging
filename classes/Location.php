<?php
require_once 'config/db.php';

class Location {
    private $conn;

    public function __construct() {
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function addLocation($description, $numStations, $costPerHour) {
        $stmt = $this->conn->prepare("INSERT INTO charging_locations (description, num_stations, cost_per_hour) VALUES (?, ?, ?)");
        $stmt->bind_param("sid", $description, $numStations, $costPerHour);
        return $stmt->execute();
    }

    public function getAllLocations() {
        $result = $this->conn->query("SELECT * FROM charging_locations");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getLocationById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM charging_locations WHERE location_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function updateLocation($id, $description, $numStations, $costPerHour) {
        $stmt = $this->conn->prepare("UPDATE charging_locations SET description = ?, num_stations = ?, cost_per_hour = ? WHERE location_id = ?");
        $stmt->bind_param("sidi", $description, $numStations, $costPerHour, $id);
        return $stmt->execute();
    }

    public function getAvailableLocations() {
    $sql = "
        SELECT l.*, 
        (l.num_stations - COALESCE(used.count, 0)) AS available 
        FROM charging_locations l
        LEFT JOIN (
            SELECT location_id, COUNT(*) AS count 
            FROM checkins 
            WHERE checkout_time IS NULL 
            GROUP BY location_id
        ) used ON l.location_id = used.location_id
        HAVING available > 0
    ";
    $result = $this->conn->query($sql);
    return $result->fetch_all(MYSQLI_ASSOC);
}

}
?>
