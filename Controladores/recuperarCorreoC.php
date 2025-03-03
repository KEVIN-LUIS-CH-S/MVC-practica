<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'Librerias/PHPMailer/src/PHPMailer.php';
require_once 'Librerias/PHPMailer/src/Exception.php';
require_once 'Librerias/PHPMailer/src/SMTP.php';

class recuperarCorreoC {

    function __construct(){
        $this->correoM = new recuperarCorreoM();
    }

    public function enviarCorreo($destinatario, $asunto, $cuerpo) {
        if(isset($_POST['email'])){
            $email=Sanitizar::limpiar($_POST['email']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                responderJSON(['status' => 'error', 'message' => 'Correo inválido']);
                exit;
            }
    
            $usuario = $this->$correoM->verificarEmail($email);
            if (!$usuario) {
                responderJSON(['status' => 'error', 'message' => 'Correo no registrado']);
                exit;
            }
    
            $codigo = rand(100000, 999999);
    
            $mail = new PHPMailer(true);
            
            try {
                // Configuración del servidor SMTP
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Servidor SMTP (depende del proveedor)
                $mail->SMTPAuth = true;
                $mail->Username = 'regacadd@gmail.com'; // Tu correo
                $mail->Password = 'lffesurqtdoiddsx'; // Tu contraseña o App Password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587; // Puerto SMTP (puede ser 465 o 587)
    
                // Configuración del correo
                $mail->setFrom('regacadd@gmail.com', 'MVC Practica');
                $mail->addAddress($destinatario);
                $mail->Subject = $asunto;
                $mail->isHTML(true);
                $mail->Body = $cuerpo;
    
                $mail->send();
                responderJSON(['status' => 'success', 'message' => 'Correo enviado exitosamente']);
            } catch (Exception $e) {
                responderJSON(['status' => 'error', 'message' => 'Error al enviar el correo: ' . $mail->ErrorInfo]);
            }
        }
    }

    /*$email = trim($_POST['email']);
    $codigo = trim($_POST['codigo']);

    $verificado = RecuperarM::verificarCodigo($email, $codigo);
    if ($verificado) {
        echo json_encode(['status' => 'success', 'message' => 'Código correcto']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Código incorrecto o expirado']);
    }*/

}
?>
