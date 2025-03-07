<?php   //Vistas/Modulos/restablecerContra.php
if (isset($_GET['action']) && $_GET['action'] == 'restablecer') {
    $recuperar = new recuperarCorreoC();
    $recuperar->enviarCorreoC();
    exit();
}
?>
<p>Se le enviara un codigo de recuperacion a su correo registrado:</p>

<form id="formCorreo">
    <input type="email" id="email" name="email" placeholder="Ingresa tu correo" required>
    <input type="submit">
</form>

<script>
document.getElementById('formCorreo').addEventListener('submit', function(event) {
    event.preventDefault();
    const formData = new FormData(this);

    Swal.fire({
        title: 'Enviando código...',
        text: 'Por favor, espera un momento',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch('index.php?ruta=restablecerContra&action=restablecer', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        if (result.status === 'success') {
            Swal.fire({
                title: 'Código enviado',
                text: 'Revisa tu correo electrónico',
                icon: 'success'
            }).then(() => {
                window.location.href = 'index.php?ruta=verificarCodigo';
            });
        } else {
            Swal.fire('Error', result.message, 'error');
        }
    })
    .catch(error => {
        Swal.fire('Error', 'Hubo un problema al enviar el código', 'error');
        console.error('Error:', error);
    });
});
</script>