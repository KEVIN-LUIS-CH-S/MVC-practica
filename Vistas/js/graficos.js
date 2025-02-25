document.addEventListener("DOMContentLoaded", function() {
    fetch("index.php?ruta=dashboard&action=contarEmple")
    .then(response => response.json())
    .then(data => {
        if (data.status === "error") {
            console.error("Error:", data.message);
            return;
        }

        const labels = data.labels;
        const values = data.values;
        const totalEmpleados = values.reduce((acc, num) => acc + num, 0); // Sumar total

        const ctx = document.getElementById("empleadosChart").getContext("2d");

        new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: [
                        "#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0", "#9966FF", "#FF9F40"
                    ],
                    borderColor: "#fff",
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { 
                        display: true,
                        position: "bottom" // Mueve la leyenda abajo
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return `${tooltipItem.label}: ${tooltipItem.raw} empleados`;
                            }
                        }
                    }
                }
            },
            plugins: [{
                afterDraw: function(chart) {
                    let ctx = chart.ctx;
                    let chartArea = chart.chartArea; // Obtiene solo el área del gráfico
                    let centerX = (chartArea.left + chartArea.right) / 2;
                    let centerY = (chartArea.top + chartArea.bottom) / 2;

                    ctx.save();
                    ctx.font = "bold " + (chart.height / 10).toFixed(2) + "px Arial";
                    ctx.fillStyle = "#000";
                    ctx.textAlign = "center";
                    ctx.textBaseline = "middle";

                    ctx.fillText(totalEmpleados, centerX, centerY);
                    ctx.restore();
                }
            }]
        });
    })
    .catch(error => console.error("Error en la carga del gráfico:", error));
});
