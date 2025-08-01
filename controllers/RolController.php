<?php
require_once dirname(__DIR__) . '/classes/Database.php';
require_once dirname(__DIR__) . '/classes/Rol.php';

class RolController {
  private $modelo;

  public function __construct() {
    $this->modelo = new Rol();
  }

  public function index() {
    return $this->modelo->obtenerTodos();
  }
}
?>