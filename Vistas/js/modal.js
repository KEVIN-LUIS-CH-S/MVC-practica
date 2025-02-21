/* Vistas/js/modal.js*/

function cargarModal(url, modalId, formId, data = {}) {
    let queryString = new URLSearchParams(data).toString();
    let fullUrl = queryString ? `${url}&${queryString}` : url;

    fetch(fullUrl)
        .then(response => response.text())
        .then(html => {
            document.getElementById(modalId).innerHTML = html;

            const form = document.getElementById(formId).querySelector("form");

            form.addEventListener("submit", function(event) {
                event.preventDefault();
                const formData = new FormData(form);

                fetch(url, {
                    method: "POST",
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    Swal.fire({
                        icon: data.status === "success" ? "success" : "error",
                        title: data.message
                    }).then(() => {
                        if (data.status === "success") {
                            window.location.reload();
                        }
                    });
                })
                .catch(error => {
                    console.error("❌ Error en fetch:", error);
                    Swal.fire({
                        icon: "error",
                        title: "¡Error inesperado!",
                        text: "Ocurrió un problema al procesar la solicitud."
                    });
                });
            });
        })
        .catch(error => console.error("❌ Error al cargar el formulario:", error));
}
