// Vistas/funcionalidades.js

document.addEventListener("DOMContentLoaded", function() {
    const btnAbrirModal = document.getElementById("abrirModalRegistro");

    if (btnAbrirModal !== null) {  // Solo ejecuta si el botón existe
        // Registrar empleado - Modal
        btnAbrirModal.addEventListener("click", function() {
            cargarModal("index.php?ruta=registrarEmple", "contenidoModal", "formRegistrarEmpleado");
            document.getElementById("modalGeneralLabel").innerText = "Registrar Nuevo Empleado";
            new bootstrap.Modal(document.getElementById("modalGeneral")).show();
        });
    }

    // Editar empleado - Modal
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
