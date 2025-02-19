<?php
$registrar = new AdminC();
$registrar->registrarUsuarioC();
?>
<br>  <!-- Vistas/Modulos/registroAdmin.php -->
<h1>REGISTRAR UN ADMINISTRADOR</h1>

<form method="post" action="" id="registroFormAdmin">
    <input type="text" placeholder="Usuario" name="usuarioR" required>
    <input type="email" placeholder="Email" name="emailR" required>
    <input type="password" placeholder="Contraseña" name="passwordR" required>
    <input type="submit" value="Registrar">
</form>

<script>
    document.getElementById("registroForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita el comportamiento por defecto del formulario

    const formData = new FormData(this);

    fetch('/MVC/Controladores/adminC.php', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        console.log("Respuesta recibida: ", response);
        response.json();}) // Asumimos que el backend devuelve JSON
    .then(data => {
        console.log("Respuesta del servidor: ", data);
        if (data.status === 'success') {
            // Si el registro es exitoso, mostramos una alerta con SweetAlert2
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: data.message // Muestra el mensaje del backend
            });

        } else {
            // Si hubo algún error, mostramos la alerta de error
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: data.message // Muestra el mensaje del backend
            });
        }
    })
    .catch(error => {
        // Si ocurre un error durante la petición
        Swal.fire({
            icon: 'error',
            title: '¡Error!',
            text: 'Hubo un problema con la solicitud. Intenta nuevamente.'
        });
    });
});
</script>