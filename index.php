<?php
require __DIR__ . '/vendor/autoload.php';
require_once 'controllers/EmpleadoController.php';
require_once 'controllers/AreaController.php';
require_once 'controllers/RolController.php';

$pagina = $_GET['page'] ?? 'empleados';
$view = "views/$pagina.php";

include 'includes/layout.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_GET['accion'] ?? '';
    $page = $_GET['page'] ?? ''; // ej: empleadosform, areasform, rolesform.

    // Obtener el nombre del controlador a partir de "empleadosform" → EmpleadoController
    $controllerName = ucfirst(strtolower(preg_replace('/form$/', '', $page))) . 'Controller';

    if (class_exists($controllerName)) {
        $controller = new $controllerName();

        if (method_exists($controller, $accion)) {
            $controller->$accion($_POST);
        } else {
            die("Error: El método '$accion' no existe en $controllerName.");
        }
    } else {
        die("Error: El controlador '$controllerName' no está definido.");
    }
}

?>