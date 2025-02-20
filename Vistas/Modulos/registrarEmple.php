<?php
$registrar = new EmpleadosC();
$registrar->registrarEmpleadosC();
?>
<br>  <!-- Vistas/Modulos/registrar.php -->
<h1>REGISTRAR UN EMPLEADO</h1>

<form method="post" action="" id="registrarEmple">
	<input type="text" placeholder="Nombre" name="nombreR" required>
	<input type="text" placeholder="Apellido" name="apellidoR" required>
	<input type="email" placeholder="Email" name="emailR" required>
	<input type="text" placeholder="Puesto" name="puestoR" required>
	<input type="text" placeholder="Salario" name="salarioR" required>
	<input type="submit" value="Registrar">
</form>

<script>
	document.getElementById("registrarEmple").addEventListener("submit", function(event) {
    event.preventDefault(); // Evita el comportamiento por defecto del formulario
    const formData = new FormData(this);

    fetch('index.php?ruta=registrarEmple', {
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
                //window.location.href = 'index.php?ruta=empleados';
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
</script>