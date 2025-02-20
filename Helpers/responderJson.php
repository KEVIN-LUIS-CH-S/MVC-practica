<?php
function responderJSON($data) {
    if (ob_get_length()) {
        ob_clean(); // Limpia cualquier salida previa
    }
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
}
