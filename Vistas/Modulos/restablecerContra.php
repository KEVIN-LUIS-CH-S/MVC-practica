<?php   //Vistas/Modulos/restablecerContra.php
if (isset($_GET['action']) && $_GET['action'] == 'restablecer') {
    $recuperar = new recuperarCorreoC();
    $recuperar->enviarCorreoC();
    exit();
}
?>

<form id="formCorreo">
    <input type="email" id="email" name="email" placeholder="Ingresa tu correo" required>
    <button type="submit">Enviar código</button>
</form>

<script>
document.getElementById('formCorreo').addEventListener('submit', function(event) {
    event.preventDefault();
    
    let email = document.getElementById('email').value.trim();
    if (!email) {
        Swal.fire('Error', 'Por favor, ingresa tu correo', 'error');
        return;
    }

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
        /*headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'email=' + encodeURIComponent(email)*/
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