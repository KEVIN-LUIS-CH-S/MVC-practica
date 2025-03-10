<?php // Helpers/responderJson.php

function responderJSON($data) {
    // Si hay alguna salida, la limpiamos correctamente
    if (ob_get_contents()) {
        ob_end_clean(); // Usa ob_end_clean() en lugar de ob_clean() para evitar problemas
    }

    // Verifica si ya se enviaron encabezados
    if (!headers_sent()) {
        header('Content-Type: application/json; charset=utf-8');
    }

    // Envía la respuesta JSON
    echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}
?>
