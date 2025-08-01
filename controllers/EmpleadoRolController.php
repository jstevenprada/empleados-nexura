<?php
require_once dirname(__DIR__) . '/classes/EmpleadoRol.php';

class EmpleadoRolController {
  private $modelo;

  public function __construct() {
    $this->modelo = new EmpleadoRol();
  }
}
?>