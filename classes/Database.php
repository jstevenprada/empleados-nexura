<?php
namespace Usuario\Empleados;

use Dotenv\Dotenv;
use PDO;
use PDOException;

class Database {
    private $host;
    private $db;
    private $user;
    private $pass;
    public $conn;

    public function __construct() {
        if (!isset($_ENV['DB_HOST'])) {
            $dotenv = Dotenv::createImmutable(dirname(__DIR__));
            $dotenv->load();
        }

        $this->host = $_ENV['DB_HOST'];
        $this->db   = $_ENV['DB_NAME'];
        $this->user = $_ENV['DB_USER'];
        $this->pass = $_ENV['DB_PASS'];

        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db;charset=utf8", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Conexión fallida: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>