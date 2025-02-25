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
    document.addEventListener("click", function(event) {
        let target = event.target;
    
        if (target.classList.contains("abrirModalEditar")) {
            let idEmpleado = target.getAttribute("data-id");
            console.log("Botón Editar clickeado con ID:", idEmpleado);
    
            cargarModal("index.php?ruta=editarEmple", "contenidoModal", "formEditarEmpleado", { id: idEmpleado });
            document.getElementById("modalGeneralLabel").innerText = "Editar Empleado";
    
            let modalElement = document.getElementById("modalGeneral");
            let modal = new bootstrap.Modal(modalElement);
    
            // 🛠️ Solución: Limpiar backdrops antes de mostrar el modal
            document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());
    
            modal.show();
    
            // 🛠️ Solución extra: Asegurar que solo quede un fondo al cerrar
            modalElement.addEventListener("hidden.bs.modal", function () {
                document.body.classList.remove("modal-open");
                document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());
            });
        }
    });
    

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
                fetch(`index.php?ruta=empleados&id=${idEmpleado}`, {
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: data.status === "success" ? "success" : "error",
                        title: data.message
                    }).then(() => {
                        if (data.status === "success") {
                            target.closest("tr").remove();
                            //window.location.reload(); // Recargar la página si se eliminó correctamente
                        }
                    });
                    /*if (data.success) {
                        target.closest("tr").remove(); // Elimina la fila de la tabla
                        Swal.fire("Eliminado", "El empleado ha sido eliminado", "success");
                    } else {
                        Swal.fire("Error", "No se pudo eliminar el empleado", "error");
                    }*/
                });
            }
        });
    }
});