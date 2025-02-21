document.addEventListener("DOMContentLoaded", function() {
    // Registrar empleado - Modal
    document.getElementById("abrirModalRegistro").addEventListener("click", function() {
        cargarModal("index.php?ruta=registrarEmple", "contenidoModal", "formRegistrarEmpleado");
        document.getElementById("modalGeneralLabel").innerText = "Registrar Nuevo Empleado";
        new bootstrap.Modal(document.getElementById("modalGeneral")).show();
    });

    // Editar empleado - Modal
    document.querySelectorAll(".abrirModalEditar").forEach(btn => {
        btn.addEventListener("click", function() {
            let idEmpleado = this.getAttribute("data-id");
            cargarModal("index.php?ruta=editarEmple", "contenidoModal", "formEditarEmpleado", { id: idEmpleado });
            new bootstrap.Modal(document.getElementById("modalGeneral")).show();
        });
    });

    // Eliminar empleado con SweetAlert2
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
    });

    // Nueva funcionalidad aqui

});
