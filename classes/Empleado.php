<?php
require_once __DIR__ . '/Database.php';
use Usuario\Empleados\Database;

class Empleado {
    private $conn;
    private $table = "empleados";

    public function __construct() {
        $database = new Database();
        $this->db = $database->conn; 
    }

    public function obtenerTodos() {
        $stmt = $this->db->prepare("SELECT e.id, e.nombre, e.email, e.sexo, a.nombre AS area, e.boletin
                                    FROM empleados e
                                    JOIN areas a ON e.area_id = a.id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
    public function guardar($data) {
        $stmt = $this->db->prepare("INSERT INTO empleados (nombre, email, sexo, area_id, boletin, descripcion) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['nombre'],
            $data['email'],
            $data['sexo'],
            $data['area'],
            isset($data['boletin']) ? 1 : 0,
            $data['descripcion'],
        ]);
        return $this->db->lastInsertId();
    }

    public function actualizar($data) {
        $stmt = $this->db->prepare("UPDATE empleados SET nombre=?, email=?, sexo=?, area_id=?, boletin=?, descripcion=? WHERE id=?");
        $stmt->execute([
            $data['nombre'],
            $data['email'],
            $data['sexo'],
            $data['area'],
            isset($data['boletin']) ? 1 : 0,
            $data['descripcion'],
            $data['id']
        ]);
    }

    public function eliminar($empleado_id) {
        $stmt = $this->db->prepare("DELETE
                                    FROM empleados
                                    WHERE id = :eid");
        return $stmt->execute(['eid' => $empleado_id]);
    }

    public function asignarRoles($empleado_id, $roles) {
        foreach ($roles as $rol_id) {
            $stmt = $this->db->prepare("INSERT INTO empleado_rol (empleado_id, rol_id) VALUES (:eid, :rid)");
            $stmt->execute(['eid' => $empleado_id, 'rid' => $rol_id]);
        }
    }

    public function eliminarRoles($empleado_id) {
        $stmt = $this->db->prepare("DELETE
                                    FROM empleado_rol
                                    WHERE empleado_id = :eid");
        $stmt->execute(['eid' => $empleado_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function showById($empleado_id) {
        $stmt = $this->db->prepare("SELECT id,nombre,email,sexo,area_id,boletin,descripcion
                                    FROM empleados
                                    WHERE id = :eid");
        $stmt->execute(['eid' => $empleado_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRolesById($empleado_id) {
        $stmt = $this->db->prepare("SELECT rol_id
                                    FROM empleado_rol
                                    WHERE empleado_id = :eid");
        $stmt->execute(['eid' => $empleado_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function beginTransaction() {
        $this->db->beginTransaction();
    }

    public function commit() {
        $this->db->commit();
    }

    public function rollBack() {
        $this->db->rollBack();
    }
}
?>