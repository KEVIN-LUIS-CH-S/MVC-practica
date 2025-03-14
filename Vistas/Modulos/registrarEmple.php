<?php   //Vistas/Modulos/registrarEmple.php

if (!isset($_SERVER["HTTP_REFERER"])) {
    header("Location: index.php?ruta=dashboard");
    exit();
}

$registrar = new EmpleadosC();
$puestos = $registrar->obtenerPuestosC();
$registrar->registrarEmpleadosC();
?>
<br>  <!-- Vistas/Modulos/registrar.php -->
<h1>REGISTRAR UN EMPLEADO</h1>

<div id="formRegistrarEmpleado">
    <form method="post" action="">
        <input type="hidden" name="idAdmin" value="<?= $_SESSION['usuario_id']; ?>">
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" placeholder="Nombre" name="nombreR" id="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" placeholder="Apellido" name="apellidoR" id="apellido" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" placeholder="Email" name="emailR" id="email" class="form-control" required>
        </div>
        <div class="mb-3">
        <label for="puesto" class="form-label">Puesto</label>
            <select name="puestoR" id="puesto" class="form-control" required>
                <option value="">Seleccione un puesto</option>
                <?php
                foreach ($puestos as $puesto): ?>
                    <option value="<?= $puesto['id']; ?>"><?= $puesto['nombre']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="salario" class="form-label">Salario</label>
            <input type="text" placeholder="Salario" name="salarioR" id="salario" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Registrar</button>
    </form>
</div>