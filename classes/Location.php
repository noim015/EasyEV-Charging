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
}
?>
