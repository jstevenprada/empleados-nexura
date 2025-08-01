<?php
require_once __DIR__ . '/Database.php';
use Usuario\Empleados\Database;

class Empleado {
    private $conn;
    private $table = "empleado_rol";

    public function __construct() {
        $database = new Database();
        $this->db = $database->conn; 
    }
}
?>