<?php 
require_once 'Librerias/TCPDF/tcpdf.php';

$empleadosM = new EmpleadosM();

// Si hay una búsqueda, filtra los empleados
$query = isset($_GET['query']) ? trim($_GET['query']) : null;
$empleados = $query ? $empleadosM->buscarEmpleadoM($query) : $empleadosM->mostrarEmpleadosM();

// 📌 Crear PDF
$pdf = new TCPDF();
$pdf->SetMargins(15, 10, 15); // Márgenes: Izquierda, Arriba, Derecha
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 10);

// 📌 **Definir encabezados**
$headers = ["Nombre", "Apellido", "Email", "Puesto", "Salario"];
$columnKeys = ['nombre', 'apellido', 'email', 'puesto', 'salario'];

// **Paso 1: Calcular anchos de columna**
$pageWidth = $pdf->GetPageWidth() - 30; // Resta los márgenes (15 izquierda + 15 derecha)
$columnWidths = array_fill(0, count($headers), 0);

// **Calcular el ancho requerido para cada columna**
foreach ($headers as $i => $header) {
    $columnWidths[$i] = max($columnWidths[$i], $pdf->GetStringWidth($header) + 6);
}
foreach ($empleados as $emp) {
    foreach ($columnKeys as $i => $key) {
        if (isset($emp[$key])) {
            $columnWidths[$i] = max($columnWidths[$i], $pdf->GetStringWidth($emp[$key]) + 6);
        }
    }
}

// **Ajustar anchos proporcionalmente al tamaño de la página**
$totalWidth = array_sum($columnWidths);
$scaleFactor = $pageWidth / $totalWidth; // Factor de escalado
foreach ($columnWidths as $i => $width) {
    $columnWidths[$i] = round($width * $scaleFactor, 2); // Escalar cada columna
}

// 📌 **Dibujar la tabla**
$pdf->SetFillColor(200, 200, 200);
$pdf->SetTextColor(0);
$pdf->SetFont('', 'B');

// **Encabezados**
foreach ($headers as $i => $header) {
    $pdf->Cell($columnWidths[$i], 10, $header, 1, 0, 'C', true);
}
$pdf->Ln();

// **Contenido**
$pdf->SetFont('');
$pdf->SetFillColor(240, 240, 240);
$fill = false;

foreach ($empleados as $emp) {
    foreach ($columnKeys as $i => $key) {
        $valor = isset($emp[$key]) ? $emp[$key] : ''; // Evita error si falta una clave
        $pdf->Cell($columnWidths[$i], 8, $valor, 1, 0, 'C', $fill);
    }
    $pdf->Ln();
    $fill = !$fill;
}

// 📌 **Salida del PDF**
$pdf->Output('empleados.pdf', 'D');
exit;
?>
