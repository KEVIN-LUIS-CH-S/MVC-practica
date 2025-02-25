<?php
$registrar = new AdminC();
$registrar->registrarUsuarioC();
?>
<br>  <!-- Vistas/Modulos/registroAdmin.php -->
<h1>REGISTRAR UN ADMINISTRADOR</h1>

<form method="post" action="" id="registroFormAdmin">
    <input type="text" placeholder="Usuario" name="usuarioR" required>
    <input type="email" placeholder="Email" name="emailR" required>
    <input type="password" placeholder="Contraseña" name="passwordR" id="password" required>
    <input type="password" placeholder="Confirmar Contraseña" name="confirmPasswordR" id="confirmPassword" required>
    <label>
        <input type="checkbox" id="mostrarContrasena"> Mostrar Contraseña
    </label>
    <input type="submit" value="Registrar">
</form>

<script>
    document.getElementById("registroFormAdmin").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita el comportamiento por defecto del formulario
    const formData = new FormData(this);

    const password = document.getElementById("password").value;
    const confirmPassword = document.getElementById("confirmPassword").value;

        if (password !== confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: 'Las contraseñas no coinciden.'
            });
            return;
        }
    
    fetch('index.php?ruta=registroAdmin', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        Swal.fire({
            icon: data.status === 'success' ? 'success' : 'error',
            title: data.message
        }).then(() => {
            // Redirigir solo si el registro fue exitoso
            if (data.status === 'success') {
                window.location.href = 'index.php?ruta=ingresoAdmin';
            }
        });
    })
    .catch(error => {
        console.error('Error en la petición:', error);
        Swal.fire({
            icon: 'error',
            title: '¡Error inesperado!',
            text: 'Ocurrió un problema al procesar la solicitud.'
        });
    });
});

document.getElementById("mostrarContrasena").addEventListener("change", function() {
        const passwordField = document.getElementById("password");
        const confirmPasswordField = document.getElementById("confirmPassword");
        const type = this.checked ? "text" : "password";
        passwordField.type = type;
        confirmPasswordField.type = type;
    });
</script>