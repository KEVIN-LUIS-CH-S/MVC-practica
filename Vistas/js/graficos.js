// Vistas/js/graficos.js

document.addEventListener("DOMContentLoaded", function() {

    //grafico total empleados por puesto
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
        setTimeout(() => {
            cargarRegistrosRecientes();
        }, 850);
    })
    .catch(error => console.error("Error en la carga del gráfico:", error));

    //grafico recientemente agregados
    function cargarRegistrosRecientes() {
    fetch("index.php?ruta=dashboard&action=registrosRecientes")
    .then(response => response.json())
    .then(data => {
        if (data.status === "error") {
            console.error("Error:", data.message);
            return;
        }

        const nombres = data.data.map(item => `${item.nombre} ${item.apellido}`);
        const fechas = data.data.map(item => item.fecha_ingreso);
        const ctx = document.getElementById("registrosChart").getContext("2d");

        // 🔄 Verificar si el gráfico ya existe antes de destruirlo
        if (window.registrosChart instanceof Chart) {
            window.registrosChart.destroy();
        }

        // 🟢 Crear el nuevo gráfico
        window.registrosChart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: nombres, // 📌 Nombres de empleados en X
                datasets: [{
                    label: "Fecha de ingreso",
                    data: fechas.map(f => new Date(f)), // Convertir fecha en objeto Date
                    backgroundColor: "#36A2EB",
                    borderColor: "#1E88E5",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return `Fecha de ingreso: ${fechas[tooltipItem.dataIndex]}`;
                            }
                        }
                    }
                },
                scales: {
                    x: { title: { display: true, text: "Empleado" } },
                    y: { 
                        type: "time", // 📅 Ahora Chart.js interpretará las fechas correctamente
                        time: {
                            unit: "day",
                            tooltipFormat: "yyyy-MM-dd",
                            displayFormats: {
                                day: "yyyy-MM-dd"
                            }
                        },
                        title: { display: true, text: "Fecha de ingreso" }
                    }
                }
            }
        });
    })
    .catch(error => console.error("Error en la carga del gráfico:", error));
}
});
