<?php   // Vistas/Modulos/dashboard.php
$empleados = new EmpleadosC();
$result=$empleados->mostrarEmpleadosC();
?>

<h2>Panel de Reportes</h2>
<canvas id="empleadosChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch("index.php?ruta=dashboard")
    .then(response => response.json())
    .then(data => {
        const ctx = document.getElementById("empleadosChart").getContext("2d");
        new Chart(ctx, {
            type: "bar",
            data: {
                labels: data.labels,
                datasets: [{
                    label: "Cantidad de empleados",
                    data: data.values,
                    backgroundColor: "rgba(54, 162, 235, 0.5)",
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 1
                }]
            }
        });
    });
});
</script>
