<?php //index.php
//ob_start();
require_once 'Controladores/rutasC.php';
require_once 'Controladores/adminC.php';
require_once 'Controladores/empleadosC.php';

require_once 'Helpers/sanitizar.php';
require_once 'Helpers/responderJson.php';

require_once 'Modelos/rutasM.php';
require_once 'Modelos/adminM.php';
require_once 'Modelos/empleadosM.php';

// Evitar cargar la plantilla si es una petición AJAX
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
    exit;
}

include 'Vistas/plantilla.php';
//ob_end_flush();
?>