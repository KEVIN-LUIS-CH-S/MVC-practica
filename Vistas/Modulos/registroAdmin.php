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
    document.getElementById("registroFormAdmin").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita el comportamiento por defecto del formulario

    const formData = new FormData(this);

    fetch('index.php?ruta=registroAdmin', {
        method: 'POST',
        body: new FormData(document.getElementById('registroFormAdmin'))

    })
    .then(response => response.text())  // ✅ Primero mostramos el texto crudo
.then(text => {
    console.log('Texto recibido del servidor:', text);  // Revisa qué está llegando exactamente
    return JSON.parse(text); // Convierte manualmente a JSON
})
.then(data => {
    console.log('Respuesta del servidor en JSON:', data);
    Swal.fire({
        icon: data.status === 'success' ? 'success' : 'error',
        title: data.message
    });
})
.catch(error => {
    console.error('Error en la petición: ', error);
});
});
</script>