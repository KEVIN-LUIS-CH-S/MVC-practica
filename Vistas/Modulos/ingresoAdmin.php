<br> <!-- Vistas/Modulos/ingreso.php -->
<h1>INGRESAR</h1>

<form method="post" action="" id="ingresoFormAdmin">
    <input type="text" placeholder="Usuario" name="usuarioI" required>
    <input type="password" placeholder="Contraseña" name="claveI" id="password" required>
    <label>
        <input type="checkbox" id="mostrarContrasena"> Mostrar contraseña
    </label>
    <input type="submit" value="Ingresar">
</form>

<a href="index.php?ruta=restablecerContra">¿Olvide mi contraseña?</a>

<?php
$ingreso = new AdminC();
$ingreso->ingresoC();
?>

<script>
    document.getElementById("ingresoFormAdmin").addEventListener("submit", function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        fetch('index.php?ruta=ingresoAdmin', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire({
                icon: data.status === 'success' ? 'success' : 'error',
                title: data.message
            }).then(() => {
                if (data.status === 'success') {
                    window.location.href = 'index.php?ruta=dashboard';
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
        const passwordInput = document.getElementById("password");
        passwordInput.type = this.checked ? "text" : "password";
    });
</script>