<?php
$empleados = new EmpleadosC();
$pagina = $empleados->mostrarEmpleadosC();
$empleados->borrarEmpleadoC();
?><br>  <!-- Vistas/Modulos/empleados.php -->

<h1>Empleados</h1>

<table id="t1" border="1">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Puesto</th>
            <th>Salario</th>
            <th></th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($pagina as $value): ?>
            <tr>
                <td><?= $value['nombre'] ?></td>
                <td><?= $value['apellido'] ?></td>
                <td><?= $value['email'] ?></td>
                <td><?= $value['puesto'] ?></td>
                <td><?= $value['salario'] ?></td>
                <td>
                    <button class="btn btn-warning abrirModalEditar" data-id="<?= $value['id'] ?>">
                        Editar
                    </button>
                </td>
                <td>
                    <button class="btn btn-danger btnEliminar" 
                        data-id="<?= $value['id'] ?>" 
                        data-nombre="<?= $value['nombre'] ?>" 
                        data-apellido="<?= $value['apellido'] ?>">
                        Borrar
                    </button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Botón para abrir el modal de Registro -->
<button class="btn btn-primary" id="abrirModalRegistro">
    Registrar Nuevo Empleado
</button>

<!-- Modal de Bootstrap -->
<div class="modal fade" id="modalGeneral" tabindex="-1" aria-labelledby="modalGeneralLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalGeneralLabel">Editar Empleado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="contenidoModal">
        <!-- Aquí se cargará `editarEmple.php` -->
      </div>
    </div>
  </div>
</div>