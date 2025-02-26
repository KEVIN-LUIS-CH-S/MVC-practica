<?php // Vistas/Modulos/dashboard.php
if (isset($_GET['action']) && $_GET['action'] == 'contarEmple') {
    $empleados = new EmpleadosC();
    $empleados->contarEmpleadosPorPuestoC();
    exit();
}

if (isset($_GET['action']) && $_GET['action'] == 'registrosRecientes') {
    $empleados = new EmpleadosC();
    $empleados->registrosRecientesC();
    exit();
}

?>


<h2>Panel de Reportes</h2>
<canvas id="empleadosChart"></canvas>

<h2>Registros Recientes</h2>
<canvas id="registrosChart"></canvas>

<script src="Vistas/js/graficos.js"></script>