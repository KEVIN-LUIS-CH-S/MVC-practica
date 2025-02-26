<?php
require_once 'Controladores/correo.php';

$destinatario = 'jaguar.kevin18@gmail.com';
$asunto = 'Prueba de correo';
$cuerpo = '<h2>Hola, este es un correo de prueba.</h2>';

$resultado = CorreoC::enviarCorreo($destinatario, $asunto, $cuerpo);

echo json_encode($resultado);
?>
