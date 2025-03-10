<?php // index.php
ob_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'Controladores/rutasC.php';
require_once 'Controladores/adminC.php';
require_once 'Controladores/empleadosC.php';
require_once 'Controladores/recuperarCorreoC.php';


require_once 'Helpers/sanitizar.php';
require_once 'Helpers/responderJson.php';

require_once 'Modelos/rutasM.php';
require_once 'Modelos/adminM.php';
require_once 'Modelos/empleadosM.php';
require_once 'Modelos/recuperarCorreoM.php';

$rutasC = new RutasC();

if (isset($_GET['action']) && $_GET['action'] == 'exportarPdf') {
    require_once 'Controladores/exportarPDF.php';
    exit();
}

$ruta = isset($_GET["ruta"]) ? $_GET["ruta"] : "";

$paginasPermitidas = ["ingresoAdmin", "restablecerContra", "registroAdmin","verificarCodigo","actualizarContra"]; // Rutas que pueden entrar sin sesión

if (!isset($_SESSION["Ingreso"]) && !in_array($ruta, $paginasPermitidas)) { 
    header("Location: index.php?ruta=ingresoAdmin"); 
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Si la solicitud es un POST, llamar directamente al controlador correspondiente
    if ($ruta === "editarEmple") {
        $empleados = new EmpleadosC();
        $empleados->actualizarEmpleadoC();
        exit(); // Finalizar la ejecución para que no cargue la plantilla
    }
}


// Si la solicitud es para un modal, solo devolver el contenido sin la plantilla
if (isset($_GET['modal']) && $_GET['modal'] == 'true') {
    $modulo = $rutasC->procesaRutasC();
    include $modulo;
    exit; // Detener la ejecución para evitar que se cargue la plantilla completa
}

if (isset($_GET['action']) && $_GET['action'] == 'buscar' && isset($_GET['query'])) {
    $empleados = new EmpleadosC();
    $empleados->buscarEmpleadoC($_GET['query']);
    exit();
}

// Evitar cargar la plantilla si es una petición AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    exit;
}

include 'Vistas/plantilla.php';
ob_end_flush();
?>