<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'Librerias/PHPMailer/src/PHPMailer.php';
require_once 'Librerias/PHPMailer/src/Exception.php';
require_once 'Librerias/PHPMailer/src/SMTP.php';

class CorreoC {
    public static function enviarCorreo($destinatario, $asunto, $cuerpo) {
        $mail = new PHPMailer(true);
        
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Servidor SMTP (depende del proveedor)
            $mail->SMTPAuth = true;
            $mail->Username = 'regacadd@gmail.com'; // Tu correo
            $mail->Password = 'grupociber2024'; // Tu contraseña o App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587; // Puerto SMTP (puede ser 465 o 587)

            // Configuración del correo
            $mail->setFrom('regacadd@gmail.com', 'MVC Practica');
            $mail->addAddress($destinatario);
            $mail->Subject = $asunto;
            $mail->isHTML(true);
            $mail->Body = $cuerpo;

            $mail->send();
            return ['status' => 'success', 'message' => 'Correo enviado exitosamente'];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => 'Error al enviar el correo: ' . $mail->ErrorInfo];
        }
    }
}
?>
