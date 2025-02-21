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


<script>

    /*document.getElementById("abrirModalRegistro").addEventListener("click", function() {
        cargarModal("index.php?ruta=registrarEmple", "contenidoModal", "formRegistrarEmpleado");
        document.getElementById("modalGeneralLabel").innerText = "Registrar Nuevo Empleado";
        new bootstrap.Modal(document.getElementById("modalGeneral")).show();
    });

    document.querySelectorAll(".abrirModalEditar").forEach(btn => {
        btn.addEventListener("click", function() {
            let idEmpleado = this.getAttribute("data-id");
            cargarModal("index.php?ruta=editarEmple", "contenidoModal", "formEditarEmpleado", { id: idEmpleado });
            new bootstrap.Modal(document.getElementById("modalGeneral")).show();
        });
    });

    // Funcionalidad de eliminación con SweetAlert2
    document.querySelectorAll(".btnEliminar").forEach(btn => {
        btn.addEventListener("click", function() {
            let idEmpleado = this.getAttribute("data-id");
            let nombre = this.getAttribute("data-nombre");
            let apellido = this.getAttribute("data-apellido");

            Swal.fire({
                title: `¿Estás seguro de eliminar a ${nombre} ${apellido}?`,
                text: "Esta acción no se puede deshacer",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Sí, eliminar",
                cancelButtonText: "Cancelar"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`index.php?ruta=empleados&id=${idEmpleado}`)
                    .then(response => response.json())
                    .then(data => {
                        Swal.fire({
                            icon: data.status === "success" ? "success" : "error",
                            title: data.message
                        }).then(() => {
                            if (data.status === "success") {
                                window.location.reload(); // Recargar la página si se eliminó correctamente
                            }
                        });
                    })
                    .catch(error => console.error("❌ Error en fetch:", error));
                }
            });
        });
    });*/
</script>

