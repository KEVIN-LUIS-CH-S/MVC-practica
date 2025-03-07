<?php   //Vistas/Modulos/actualizarContra.php
if (isset($_GET['action']) && $_GET['action'] == 'actualizar') {
    $recuperar = new recuperarCorreoC();
    $recuperar->actualizarContraC();
    exit();
}
?>

<p>Ingresa tu nueva contraseña:</p>

<form id="formActualizar">
    <input type="password" id="nuevaContra" name="nuevaContra" placeholder="Nueva contraseña" required minlength="6">
    <input type="password" id="confirmarContra" name="confirmarContra" placeholder="Confirmar contraseña" required minlength="6">
    <input type="submit" value="Actualizar Contraseña">
</form>

<script>
document.getElementById('formActualizar').addEventListener('submit', function(event) {
    event.preventDefault();
    const email = localStorage.getItem('email');
    const nuevaContra = document.getElementById('nuevaContra').value;
    const confirmarContra = document.getElementById('confirmarContra').value;

    if (nuevaContra !== confirmarContra) {
        Swal.fire('Error', 'Las contraseñas no coinciden', 'error');
        return;
    }

    const formData = new FormData();
    formData.append('email',email);

    fetch('index.php?ruta=actualizarContra&action=actualizar', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.status === 'success') {
            Swal.fire({
                title: 'Contraseña actualizada',
                text: 'Ahora puedes iniciar sesión con tu nueva contraseña.',
                icon: 'success'
            }).then(() => {
                localStorage.removeItem('email'); // Limpiar email almacenado
                window.location.href = 'index.php?ruta=ingresoAdmin';
            });
        } else {
            Swal.fire('Error', result.message, 'error');
        }
    })
    .catch(error => {
        Swal.fire('Error', 'Hubo un problema al actualizar la contraseña', 'error');
        console.error('Error:', error);
    });
});
</script>