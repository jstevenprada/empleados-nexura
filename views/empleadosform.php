<?php
  require_once dirname(__DIR__) . '/controllers/AreaController.php';
  require_once dirname(__DIR__) . '/controllers/RolController.php';
  require_once dirname(__DIR__) . '/controllers/EmpleadoController.php';
  $areascontroller = new AreaController();
  $rolcontroller = new RolController();
  $empleadoController = new EmpleadoController();

  $areas = $areascontroller->index();
  $roles = $rolcontroller->index();
  $empleado = [
      'id' => '',
      'nombre' => '',
      'email' => '',
      'sexo' => '',
      'area_id' => '',
      'boletin' => '',
      'descripcion' => '',
      'roles' => []
  ];
  $rolesSeleccionados = [];
  if (isset($_GET['id'])) {
    $empleado = $empleadoController->buscarPorId($_GET['id']);
    $empleado['roles'] = $empleadoController->obtenerRoles($_GET['id']);
    $rolesSeleccionados = array_column($empleado['roles'], 'rol_id');
  }

  $accion = $_GET['accion'];
  $titulo = ($accion === 'editar') ? 'Editar Empleado' : 'Crear Empleado';

?>
<script src="assets/js/validar-empleado.js"></script>
<h5><?= $titulo ?></h5>
<div class="alert alert-info mt-4" role="alert">
  Los campos con asteriscos (*) son obligatorios.
</div>
<?php if (isset($_GET['errores'])): ?>
  <?php $errores = json_decode($_GET['errores'], true); ?>
  <div class="alert alert-danger alert-dismissible">
    <ul>
      <?php foreach ($errores as $campo => $mensajes): ?>
        <?php foreach ($mensajes as $mensaje): ?>
          <li><?= htmlspecialchars($mensaje) ?></li>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </ul>
  </div>
<?php endif; ?>

<form id="formEmpleado" method="POST" action="index.php?page=empleadosform&accion=<?= $accion ?>">
  <?php if ($accion === 'editar'): ?>
    <input type="hidden" name="id" value="<?= $empleado['id'] ?>">
  <?php endif; ?>

  <div class="mb-3">
    <label for="nombre" class="form-label">Nombre Completo *</label>
    <input type="text" class="form-control" name="nombre" id="nombre"
      value="<?= $accion === 'editar' ? htmlspecialchars($empleado['nombre']) : '' ?>"
      placeholder="Nombre completo del empleado">
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Correo electrónico *</label>
    <input type="email" class="form-control" name="email" id="email"
      value="<?= $accion === 'editar' ? htmlspecialchars($empleado['email']) : '' ?>"
      placeholder="Correo electrónico">
  </div>
  <div class="mb-3">
    <label for="sexo" class="form-label">Sexo *</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="sexo" id="masculino" value="M"
            <?= ($accion === 'editar' && $empleado['sexo'] === 'M') ? 'checked' : '' ?>>
        <label class="form-check-label" for="masculino">
            Masculino
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="sexo" id="femenino" value="F"
            <?= ($accion === 'editar' && $empleado['sexo'] === 'F') ? 'checked' : '' ?>>
        <label class="form-check-label" for="femenino">
            Femenino
        </label>
    </div>
  </div>
  <div class="mb-3">
      <label for="select" class="form-label">Área *</label>
      <select name="area" class="form-control" required>
        <?php foreach ($areas as $area): ?>
          <option value="<?= $area['id'] ?>" <?= ($empleado['area_id'] == $area['id']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($area['nombre']) ?>
          </option>
        <?php endforeach; ?>
      </select>
  </div>
  <div class="mb-3">
    <label for="textarea" class="form-label">Descripción *</label>
    <textarea class="form-control" name="descripcion" id="textarea" rows="3"><?= $accion === 'editar' ? htmlspecialchars($empleado['descripcion']) : '' ?></textarea>
  </div>
  <div class="mb-3">
    <label for="boletin" class="form-label">Boletín</label>
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="boletin" name="boletin"
        <?= ($accion === 'editar' && $empleado['boletin']) ? 'checked' : '' ?>>
      <label class="form-check-label" for="boletin">
        Deseo recibir el boletín informativo
      </label>
    </div>
  </div>
  <div class="mb-3">
    <label for="roles" class="form-label">Roles *</label>
    <?php foreach ($roles as $rol): ?>
      <div class="form-check">
        <input class="form-check-input" 
              type="checkbox" 
              name="roles[]" 
              value="<?= $rol['id'] ?>" 
              <?= in_array($rol['id'], $rolesSeleccionados) ? 'checked' : '' ?>>
        <label class="form-check-label"><?= htmlspecialchars($rol['nombre']) ?></label>
      </div>
    <?php endforeach; ?>

  </div>
  <button type="submit" name="<?= $accion === 'editar' ? 'actualizar' : 'guardar' ?>" class="btn btn-success">
    <?= $accion === 'editar' ? 'Actualizar' : 'Guardar' ?>
  </button>
</form>