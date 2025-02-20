<?php
$empleados = new EmpleadosC();
$pagina = $empleados->mostrarEmpleadosC();
$empleados->borrarEmpleadoC();
?><br>  <!-- Vistas/Modulos/empleados.php -->
<!-- Botón para abrir el modal -->
<h1>Empleados</h1>

<!-- Botón para abrir el modal con SweetAlert2 -->
<button id="abrirModal">Registrar Nuevo Empleado</button>

<table id="t1" border="1">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Email</th>
            <th>Puesto</th>
            <th>Salario</th>
            <th></th>
            <th></th>
        </tr>
    </thead>

    <tbody>
        <?php foreach($pagina as $key => $value): ?>
            <tr>
                <td><?=$value['nombre']?></td>
                <td><?=$value['apellido']?></td>
                <td><?=$value['email']?></td>
                <td><?=$value['puesto']?></td>
                <td><?=$value['salario']?></td>
                <td>
                    <a href='index.php?ruta=editar&id=<?=$value['id']?>'>
                        <button>Editar</button>
                    </a>
                </td>
                <td>
                    <a href='index.php?ruta=empleados&id=<?=$value['id']?>'>
                        <button>Borrar</button>
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    document.getElementById("abrirModal").addEventListener("click", () => {
        Swal.fire({
            title: 'Registrar un Empleado',
            html: `
                <input type="text" id="nombre" class="swal2-input" placeholder="Nombre" required>
                <input type="text" id="apellido" class="swal2-input" placeholder="Apellido" required>
                <input type="email" id="email" class="swal2-input" placeholder="Email" required>
                <input type="text" id="puesto" class="swal2-input" placeholder="Puesto" required>
                <input type="text" id="salario" class="swal2-input" placeholder="Salario" required>
            `,
            confirmButtonText: 'Registrar',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            preConfirm: () => {
                // Obtener valores del formulario
                const nombre = document.getElementById('nombre').value.trim();
                const apellido = document.getElementById('apellido').value.trim();
                const email = document.getElementById('email').value.trim();
                const puesto = document.getElementById('puesto').value.trim();
                const salario = document.getElementById('salario').value.trim();

                // Validar campos vacíos
                if (!nombre || !apellido || !email || !puesto || !salario) {
                    Swal.showValidationMessage('Todos los campos son obligatorios');
                    return false;
                }

                // Retornar los datos
                return { nombre, apellido, email, puesto, salario };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Llamar a la función para registrar
                registrarEmpleado(result.value);
            }
        });
    });

    // Función para enviar los datos con fetch()
    function registrarEmpleado(datos) {
        const formData = new FormData();
        formData.append('nombreR', datos.nombre);
        formData.append('apellidoR', datos.apellido);
        formData.append('emailR', datos.email);
        formData.append('puestoR', datos.puesto);
        formData.append('salarioR', datos.salario);

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
                // Actualizar la vista si el registro fue exitoso
                if (data.status === 'success') {
                    window.location.reload();
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
    }
</script>


