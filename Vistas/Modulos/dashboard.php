<?php
if (isset($_GET['action']) && $_GET['action'] == 'contarEmple') {
    $empleados = new EmpleadosC();
    $empleados->contarEmpleadosPorPuestoC();
    exit();
}
?>


<h2>Panel de Reportes</h2>
<canvas id="empleadosChart"></canvas>
<script src="Vistas/js/graficos.js"></script>
<script>
</script>
