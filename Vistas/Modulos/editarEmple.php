<?php	/* Vistas/Modulos/editarEmple.php */
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php?ruta=dashboard");
    exit();
}
$empleados = new EmpleadosC();
$resultado = $empleados->editarEmpleadoC();
$puestos = $empleados->obtenerPuestosC();
//$empleados->actualizarEmpleadoC(); es llamdo del index
?><br>
<div id="formEditarEmpleado">
    <h1>EDITAR EMPLEADO</h1>
    <form method="post" action="">
        <input type="hidden" value="<?= $resultado['id'] ?>" name="idE" required>
        <input type="text" placeholder="Nombre" name="nombreE" value="<?= $resultado['nombre'] ?>" required>
        <input type="text" placeholder="Apellido" name="apellidoE" value="<?= $resultado['apellido'] ?>" required>
        <input type="email" placeholder="Email" name="emailE" value="<?= $resultado['email'] ?>" required>
        <select name="puestoE" required>
            <option value="">Seleccione un puesto</option>
            <?php foreach ($puestos as $p): ?>
            <option value="<?= $p['id'] ?>" <?= ($p['id'] == $resultado['id_puesto']) ? 'selected' : '' ?>>
                <?= $p['nombre'] ?>
            </option>
            <?php endforeach; ?>
        </select>
        <input type="text" placeholder="Salario" name="salarioE" value="<?= $resultado['salario'] ?>" required>
        <input type="submit" value="Actualizar">
    </form>
</div>