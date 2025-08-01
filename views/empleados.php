<?php
  require_once dirname(__DIR__) . '/controllers/EmpleadoController.php';
  $controller = new EmpleadoController();
  $empleados = $controller->index();
?>
<h5>Gestión de empleados</h5>
<?php
$mensajes = [
    'creado' => '¡Empleado creado exitosamente!',
    'actualizado' => '¡Empleado actualizado correctamente!',
    'eliminado' => '¡Empleado eliminado exitosamente!',
];

if (isset($_GET['msg']) && array_key_exists($_GET['msg'], $mensajes)) : ?>
    <div class="alert alert-success alert-dismissible fade show mt-4" role="alert">
        <?= $mensajes[$_GET['msg']] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
    </div>
<?php endif; ?>
<div class="text-end mt-4">
  <a href="index.php?page=empleadosform&accion=crear" class="btn btn-success">
    <i class="fa-solid fa-user-plus"></i> Crear
  </a>
</div>
<table class="table table-hover table-no-vertical-borders align-middle mt-2">
  <thead class="table-light">
    <tr>
      <th><i class="fa-solid fa-user"></i> Nombre</th>
      <th><i class="fa-solid fa-envelope"></i> Email</th>
      <th><i class="fa-solid fa-venus-mars"></i> Sexo</th>
      <th><i class="fa-solid fa-building"></i> Área</th>
      <th><i class="fa-solid fa-bell"></i> Boletín</th>
      <th>Modificar</th>
      <th>Eliminar</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($empleados as $empleado): ?>
      <tr>
        <td><?= htmlspecialchars($empleado['nombre']) ?></td>
        <td><?= htmlspecialchars($empleado['email']) ?></td>
        <td><?= $empleado['sexo'] === 'M' ? 'Masculino' : 'Femenino' ?></td>
        <td><?= htmlspecialchars($empleado['area']) ?></td>
        <td><?= $empleado['boletin'] ? 'Sí' : 'No' ?></td>
        <td>
          <a href="index.php?page=empleadosform&accion=editar&id=<?= $empleado['id'] ?>" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-pen"></i>  
            Editar
          </a>
        </td>
        <td>
          <button 
            type="button" 
            class="btn btn-danger btn-sm" 
            data-bs-toggle="modal" 
            data-bs-target="#modalEliminar" 
            data-id="<?= $empleado['id'] ?>" 
            data-nombre="<?= $empleado['nombre'] ?>">
            <i class="fa-solid fa-trash"></i>  
            Eliminar
          </button>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<!-- Modal -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="/empleados/index.php?page=empleado&accion=eliminar">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEliminarLabel">Confirmar eliminación</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <p id="mensajeModal">¿Estás seguro de eliminar este empleado?</p>
          <input type="hidden" name="id" id="idEmpleadoEliminar">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger">Sí, eliminar</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  const modalEliminar = document.getElementById('modalEliminar');

  modalEliminar.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const id = button.getAttribute('data-id');
    const nombre = button.getAttribute('data-nombre');

    const inputId = modalEliminar.querySelector('#idEmpleadoEliminar');
    const mensaje = modalEliminar.querySelector('#mensajeModal');

    inputId.value = id;
    mensaje.textContent = `¿Estás seguro de eliminar al empleado "${nombre}"?`;
  });
</script>