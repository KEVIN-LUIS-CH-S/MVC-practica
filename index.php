<?php //index.php
ob_start();
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'Controladores/rutasC.php';
require_once 'Controladores/adminC.php';
require_once 'Controladores/empleadosC.php';

require_once 'Helpers/sanitizar.php';
require_once 'Helpers/responderJson.php';

require_once 'Modelos/rutasM.php';
require_once 'Modelos/adminM.php';
require_once 'Modelos/empleadosM.php';

$rutasC = new RutasC();

// Si la solicitud es para un modal, solo devolver el contenido sin la plantilla
if (isset($_GET['modal']) && $_GET['modal'] == 'true') {
    $modulo = $rutasC->procesaRutasC();
    include $modulo;
    exit; // Detener la ejecución para evitar que se cargue la plantilla completa
}

// Evitar cargar la plantilla si es una petición AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    exit;
}

include 'Vistas/plantilla.php';
ob_end_flush();
?>