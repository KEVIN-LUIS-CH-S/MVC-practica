<?php
$empleados = new EmpleadosC();
$pagina = $empleados->mostrarEmpleadosC();
$empleados->borrarEmpleadoC();
?><br>  <!-- Vistas/Modulos/empleados.php -->

<h1>Empleados</h1>

<!-- Campo de búsqueda -->
<input type="text" id="busqueda" placeholder="Buscar empleado...">

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

    <tbody id="tablaEmpleados">
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
    document.getElementById('busqueda').addEventListener('input', function() {
    let query = this.value.trim();
    fetch('index.php?ruta=empleados&action=buscar&query=' + encodeURIComponent(query))
        .then(response => response.json())
        .then(data => {
            console.log("Resultados recibidos:", data); // 📌 Verifica los datos en consola
            
            let tbody = document.getElementById('tablaEmpleados');
            tbody.innerHTML = ''; // Borra la tabla

            data.forEach(emp => {
                let tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${emp.nombre}</td>
                    <td>${emp.apellido}</td>
                    <td>${emp.email}</td>
                    <td>${emp.puesto}</td>
                    <td>${emp.salario}</td>
                    <td><button class='btn btn-warning abrirModalEditar' data-id='${emp.id}'>Editar</button></td>
                    <td><button class='btn btn-danger btnEliminar' data-id='${emp.id}' data-nombre='${emp.nombre}' data-apellido='${emp.apellido}'>Borrar</button></td>
                `;
                tbody.appendChild(tr);
            });

            // 📌 Verificamos si los botones existen después de actualizar la tabla
            console.log("Botones después de actualizar la tabla:", document.querySelectorAll(".abrirModalEditar").length);
        });
});

// 📌 Delegación de eventos para los botones
document.getElementById('tablaEmpleados').addEventListener('click', function(event) {
    let target = event.target;

    // 📌 Si el clic fue en un botón de editar
    if (target.classList.contains('abrirModalEditar')) {
        let idEmpleado = target.getAttribute("data-id");
        console.log("Botón Editar clickeado con ID:", idEmpleado); // 📌 Depuración
        cargarModal("index.php?ruta=editarEmple", "contenidoModal", "formEditarEmpleado", { id: idEmpleado });
        document.getElementById("modalGeneralLabel").innerText = "Editar Empleado";
        new bootstrap.Modal(document.getElementById("modalGeneral")).show();
    }

    // 📌 Si el clic fue en un botón de eliminar
    if (target.classList.contains('btnEliminar')) {
        let idEmpleado = target.getAttribute("data-id");
        let nombre = target.getAttribute("data-nombre");
        let apellido = target.getAttribute("data-apellido");

        console.log("Botón Eliminar clickeado con ID:", idEmpleado); // 📌 Depuración

        Swal.fire({
            title: `¿Estás seguro de eliminar a ${nombre} ${apellido}?`,
            text: "Esta acción no se puede deshacer",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('index.php?ruta=empleados&action=eliminar', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: idEmpleado })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        target.closest("tr").remove(); // Elimina la fila de la tabla
                        Swal.fire("Eliminado", "El empleado ha sido eliminado", "success");
                    } else {
                        Swal.fire("Error", "No se pudo eliminar el empleado", "error");
                    }
                });
            }
        });
    }
});
</script>