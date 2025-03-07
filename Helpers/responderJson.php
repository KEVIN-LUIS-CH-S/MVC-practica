<?php // Helpers/responderJson.php

function responderJSON($data) {
    if (ob_get_length()) {
        ob_clean(); // Limpia cualquier salida previa
    }
    header('Content-Type: application/json; charset=utf-8');
    if (headers_sent()) {
        die(json_encode(["status" => "error", "message" => "Se enviaron encabezados antes del JSON"]));
    }
    echo json_encode($data);
    exit;
}
?>
