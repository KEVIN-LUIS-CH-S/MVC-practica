// Vistas/js/funcionalidades.js

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
            modal.show();
    
            // 🛠️ Solución extra: Asegurar que solo quede un fondo al cerrar
            modalElement.addEventListener("hidden.bs.modal", function () {
                document.body.classList.remove("modal-open");
                document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());
            });
        }
    }); 

    // Nueva funcionalidad aqui

});
