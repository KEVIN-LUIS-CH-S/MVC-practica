<?php // Controladores/exportarPdf.php
require_once 'Librerias/TCPDF/tcpdf.php';

$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tu Empresa');
$pdf->SetTitle('Lista de Empleados');
$pdf->SetHeaderData('', 0, 'Lista de Empleados', 'Generado automáticamente');

// Establecer márgenes
$pdf->SetMargins(10, 20, 10);
$pdf->SetHeaderMargin(5);
$pdf->SetFooterMargin(10);
$pdf->SetAutoPageBreak(true, 15);

// Agregar página
$pdf->AddPage();

// Contenido del PDF
$html = '<h2>Lista de Empleados</h2>';
$html .= '<table border="1" cellpadding="5">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Email</th>
                <th>Puesto</th>
                <th>Salario</th>
            </tr>';

$empleadosM = new EmpleadosM();
$empleados = $empleadosM->mostrarEmpleadosM();

foreach ($empleados as $empleado) {
    $html .= '<tr>
                 <td>' . $empleado['id'] . '</td>
                 <td>' . $empleado['nombre'] . '</td>
                 <td>' . $empleado['apellido'] . '</td>
                 <td>' . $empleado['email'] . '</td>
                 <td>' . $empleado['puesto'] . '</td>
                 <td>' . $empleado['salario'] . '</td>
             </tr>';
}
$html .= '</table>';

// Escribir el contenido en el PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Salida del PDF
$pdf->Output('empleados.pdf', 'D');
exit;


?>
