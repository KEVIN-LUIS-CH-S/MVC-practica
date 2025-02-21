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
        <?php foreach($pagina as $key => $value): ?>
            <tr>
                <td><?=$value['nombre']?></td>
                <td><?=$value['apellido']?></td>
                <td><?=$value['email']?></td>
                <td><?=$value['puesto']?></td>
                <td><?=$value['salario']?></td>
                <td>
                    <a href='index.php?ruta=editarEmple&id=<?=$value['id']?>'>
                        <button>Editar</button>
                    </a>
                </td>
                <td>
                    <a href='index.php?ruta=empleados&id=<?=$value['id']?>'>
                        <button>Borrar</button>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Botón para abrir el modal -->
<button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalRegistro" id="abrirModal">
    Registrar Nuevo Empleado
</button>

<!-- Modal de Bootstrap (inicialmente vacío) -->
<div class="modal fade" id="modalRegistro" tabindex="-1" aria-labelledby="modalRegistroLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalRegistroLabel">Registrar Nuevo Empleado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="contenidoModal">
        <!-- Aquí se cargará registrarEmple.php -->
      </div>
    </div>
  </div>
</div>

<script>

    document.getElementById("abrirModal").addEventListener("click", function() {
        cargarModal("index.php?ruta=registrarEmple", "contenidoModal", "registrarEmple");
    });

</script>

