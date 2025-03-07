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

    public function enviarCorreoC() {
        if(isset($_POST['email'])){
            $destinatario=Sanitizar::limpiar($_POST['email']);
            
            if (!filter_var($destinatario, FILTER_VALIDATE_EMAIL)) {
                responderJSON(['status' => 'error', 'message' => 'Correo inválido']);
                exit;
            }
    
            $usuario = $this->correoM->verificarEmailM($destinatario);
            if (!$usuario) {
                responderJSON(['status' => 'error', 'message' => 'Correo no registrado']);
                exit;
            }
    
            $codigo = rand(100000, 999999);
            $guardar = $this->correoM->guardarCodigoM($destinatario,$codigo);
            
            if (!$guardar) {
                responderJSON(['status' => 'error', 'message' => 'Aún tienes un código activo o hubo un problema.']);
                exit;
            }
            

            $asunto="Restablecer contraseña";
            $cuerpo = "<h2>Hola,</h2><p>Tu código de recuperación es: <strong>$codigo</strong></p>";

    
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

    public function verificarCodigoC() {
        if(isset($_POST['codigo'])){
            $codigo = Sanitizar::limpiar($_POST['codigo']);
            $verificado=$this->correoM->verificarCodigoM($codigo);
            if ($verificado) {
                responderJSON(['status' => 'success']);
            } else {
                responderJSON(['status' => 'error', 'message' => 'Código incorrecto o expirado']);
            }
        }
    }

    public function obtenerTiempoExpiracionC() {
        if(isset($_POST['email'])){
            $email = $_POST['email'];
            $tiempoRestante = $this->correoM->obtenerTiempoExpiracionM($email);
    
            if ($tiempoRestante === null) {
                responderJSON(['status' => 'error', 'message' => 'No hay código activo']);
                exit;
            }
    
            responderJSON(['status' => 'success', 'tiempo_restante' => $tiempoRestante]);
        }
    }

    public function limpiarCodigosExpiradosC() {
        if (!isset($_POST['email'])) {
            responderJSON(['status' => 'error', 'message' => 'Correo no recibido']);
            exit;
        }

        $email = $_POST['email'];
        $eliminado = $this->correoM->limpiarCodigosExpiradosM($email);

        if ($eliminado) {
            responderJSON(['status' => 'success', 'message' => 'Código eliminado']);
        } else {
            responderJSON(['status' => 'error', 'message' => 'No se pudo eliminar']);
        }
    }
}
?>
