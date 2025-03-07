<?php   //Vistas/Modulos/verificarCodigo.php
if (isset($_GET['action']) && $_GET['action'] == 'obtenerTiempo') {
    $recuperar = new recuperarCorreoC();
    $recuperar->obtenerTiempoExpiracionC();
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'limpiarCodigo') {
    $recuperar = new recuperarCorreoC();
    $recuperar->limpiarCodigosExpiradosC();
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'verificarCod') { 
    $recuperar = new recuperarCorreoC();
    $recuperar->verificarCodigoC(); 
    exit();
}
?>

<p>Ingresa el código de 6 dígitos enviado a tu correo:</p>

<form id="formCodigo">
    <input type="text" id="codigo" name="codigo" placeholder="Código de verificación" required maxlength="6">
    <input type="submit" value="Verificar">
</form>

<p id="contador"></p>
<button id="reenviar" style="display: none;">Reenviar Código</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const email = localStorage.getItem('email');
    
    if (!email) {
        Swal.fire('Error', 'No hay un correo asociado, vuelve a ingresar tu correo.', 'error')
        .then(() => {
            window.location.href = 'index.php?ruta=restablecerContra';
        });
        return;
    }

    function obtenerTiempoExpiracion() {
        const formData = new FormData();
        formData.append('email', email);

        fetch('index.php?ruta=verificarCodigo&action=obtenerTiempo', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                iniciarContador(data.tiempo_restante);
            } else {
                Swal.fire('Error', data.message, 'error');
                document.getElementById('reenviar').style.display = 'block';
            }
        });
    }

    function iniciarContador(segundos) {
        let contador = document.getElementById('contador');
        let intervalo = setInterval(() => {
            segundos--;
            contador.textContent = `Tiempo restante: ${segundos} segundos`;
            if (segundos <= 0) {
                clearInterval(intervalo);
                limpiarCodigoExpirado();
            }
        }, 1000);
    }

    function limpiarCodigoExpirado() {
        const formData = new FormData();
        formData.append('email', email);

        fetch('index.php?ruta=verificarCodigo&action=limpiarCodigo', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            Swal.fire('Código expirado', 'Solicita un nuevo código', 'warning');
            document.getElementById('reenviar').style.display = 'block';
        });
    }

    document.getElementById('reenviar').addEventListener('click', function() {
        window.location.href = 'index.php?ruta=restablecerContra';
    });

    document.getElementById('formCodigo').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);
        formData.append('email', email); // Agregar el email al formulario

        fetch('index.php?ruta=verificarCodigo&action=verificarCod', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === 'success') {
                Swal.fire({
                    title: 'Código verificado',
                    text: 'Redirigiendo a la actualización de contraseña...',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'index.php?ruta=actualizarContra';
                });
            } else {
                Swal.fire('Error', result.message, 'error');
            }
        })
        .catch(error => {
            Swal.fire('Error', 'Hubo un problema al verificar el código', 'error');
            console.error('Error:', error);
        });
    });

    obtenerTiempoExpiracion();
});
</script>
