<?php // Controladores/exportarPdf.php
require_once 'Librerias/TCPDF/tcpdf.php';

$empleadosM = new EmpleadosM();

// Si hay una búsqueda, filtra los empleados
$query = isset($_GET['query']) ? trim($_GET['query']) : null;

if ($query) {
    $empleados = $empleadosM->buscarEmpleadoM($query); // Cuando hay búsqueda
} else {
    $empleados = $empleadosM->mostrarEmpleadosM(); // Cuando no hay búsqueda
}

$pdf = new TCPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 12);

$html = '<h1>Lista de Empleados</h1><table border="1"><tr><th>Nombre</th><th>Apellido</th><th>Email</th><th>Puesto</th><th>Salario</th></tr>';
foreach ($empleados as $emp) {
    $html .= "<tr><td>{$emp['nombre']}</td><td>{$emp['apellido']}</td><td>{$emp['email']}</td><td>{$emp['puesto']}</td><td>{$emp['salario']}</td></tr>";
}
$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('empleados.pdf', 'D');

exit;

?>
