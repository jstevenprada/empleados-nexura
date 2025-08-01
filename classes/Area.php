<?php
require_once __DIR__ . '/Database.php';
use Usuario\Empleados\Database;

class Area {
    private $conn;
    private $table = "areas";

    public function __construct() {
        $database = new Database();
        $this->db = $database->conn; 
    }

    public function obtenerTodos() {
        $stmt = $this->db->prepare("SELECT id,nombre FROM areas");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>