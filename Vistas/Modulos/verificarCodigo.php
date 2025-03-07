<form id="formCodigo">
    <input type="text" id="codigo" name="codigo" placeholder="Ingresa el código de 6 dígitos" required maxlength="6">
    <button type="submit">Verificar</button>
</form>

<p id="contador"></p>
<button id="reenviar" style="display: none;">Reenviar Código</button>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let email = localStorage.getItem('email'); // Guardar email en localStorage después de ingresarlo
    if (!email) {
        alert('No hay un correo asociado, vuelve a ingresar tu correo.');
        window.location.href = 'index.php?ruta=restablecerContra';
    }

    function obtenerTiempoExpiracion() {
        fetch('index.php?ruta=verificarCodigo&action=obtenerTiempo', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'email=' + encodeURIComponent(email)
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
        fetch('index.php?ruta=verificarCodigo&action=limpiarCodigo', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'email=' + encodeURIComponent(email)
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

    obtenerTiempoExpiracion();
});
</script>
