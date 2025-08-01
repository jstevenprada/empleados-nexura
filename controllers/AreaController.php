<?php
require_once dirname(__DIR__) . '/classes/Database.php';
require_once dirname(__DIR__) . '/classes/Area.php';

class AreaController {
  private $modelo;

  public function __construct() {
    $this->modelo = new Area();
  }

  public function index() {
    return $this->modelo->obtenerTodos();
  }
}
?>