<?php
require_once dirname(__DIR__) . '/classes/Database.php';
require_once dirname(__DIR__) . '/classes/Empleado.php';
require_once dirname(__DIR__) . '/classes/Validador.php';

class EmpleadoController {
  private $modelo;

  public function __construct() {
    $this->modelo = new Empleado();
  }

  public function index() {
    return $this->modelo->obtenerTodos();
  }

  public function guardar($data) {
    try {
        $reglas = [
            'nombre'      => 'required|alpha',
            'email'       => 'required|email',
            'sexo'        => 'required|sexo',
            'area'        => 'required',
            'descripcion' => 'required',
            'roles'       => 'required|array'
        ];

        if (!Validador::validar($data, $reglas)) {
            $errores = Validador::errores();
            $erroresStr = urlencode(json_encode($errores));
            header("Location: /empleados/index.php?page=empleadosform&accion=crear&errores=$erroresStr");
            exit;
        }

        $this->modelo->beginTransaction();
        $empleado_id = $this->modelo->guardar($data);
        $this->modelo->asignarRoles($empleado_id, $data['roles']);
        $this->modelo->commit();

        header('Location: /empleados/index.php?page=empleados&msg=creado');
        exit;
    } catch (Exception $e) {
      $this->modelo->rollBack();
      $error = urlencode($e->getMessage());
      header("Location: /empleados/index.php?page=empleadosform&accion=crear&error=$error");
      exit;
    }
  }

  public function actualizar($data) {
    try {
        $reglas = [
            'id'         => 'required|numeric',
            'nombre'     => 'required|alpha',
            'email'      => 'required|email',
            'sexo'       => 'required|sexo',
            'area'       => 'required',
            'descripcion'=> 'required',
            'roles'      => 'required|array'
        ];

        if (!Validador::validar($data, $reglas)) {
            $errores = Validador::errores();
            $erroresStr = urlencode(json_encode($errores));
            header("Location: /empleados/index.php?page=empleadosform&accion=editar&id={$data['id']}&errores=$erroresStr");
            exit;
        }

        $this->modelo->beginTransaction();

        // Actualiza los datos del empleado
        $this->modelo->actualizar($data);

        // Limpia roles actuales y asigna los nuevos
        $this->modelo->eliminarRoles($data['id']);
        $this->modelo->asignarRoles($data['id'], $data['roles']);

        $this->modelo->commit();

        header('Location: /empleados/index.php?page=empleados&msg=actualizado');
        exit;
    } catch (Exception $e) {
        $this->modelo->rollBack();
        $error = urlencode($e->getMessage());
        header("Location: /empleados/index.php?page=empleadosform&accion=editar&id={$data['id']}&error=$error");
        exit;
    }
  }

  public function eliminar($data) {
  try {
    if (empty($data['id']) || !is_numeric($data['id'])) {
      throw new Exception("ID inválido.");
    }

    $this->modelo->eliminar($data['id']);

    header("Location: /empleados/index.php?page=empleados&msg=eliminado");
    exit;
  } catch (Exception $e) {
    $error = urlencode($e->getMessage());
    header("Location: /empleados/index.php?page=empleados&error=$error");
    exit;
  }
}

  public function buscarPorId($data) {
    return $this->modelo->showById($data);
  }

  public function obtenerRoles($data) {
    return $this->modelo->getRolesById($data);
  }
}

// Ejecutar según acción enviada
$controller = new EmpleadoController();

if (isset($_POST['guardar'])) {
  $controller->guardar($_POST);
}

if (isset($_POST['actualizar'])) {
  $controller->actualizar($_POST);
}

?>