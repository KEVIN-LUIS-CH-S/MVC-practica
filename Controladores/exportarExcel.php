<?php //Controladores/exportarExcel.php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Settings;

// Desactivar caché
Settings::setCache(null);

$empleadosM = new EmpleadosM();
$empleados = $empleadosM->mostrarEmpleadosM();

if (!$empleados) {
    die("No hay empleados para exportar.");
}

$spreadsheet = new Spreadsheet();   
$sheet = $spreadsheet->getActiveSheet();

$encabezados = ["ID", "Nombre", "Apellido", "Email", "Puesto", "Salario"];
$sheet->fromArray([$encabezados], NULL, 'A1');

$fila = 2;
foreach ($empleados as $empleado) {
    $sheet->fromArray([$empleado['id'], $empleado['nombre'], $empleado['apellido'], $empleado['email'], $empleado['puesto'], $empleado['salario']], NULL, "A$fila");
    $fila++;
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="empleados.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;

?>