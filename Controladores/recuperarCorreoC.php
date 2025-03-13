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

    private function getEnvValue($key) {
        $lines = file(__DIR__ . "/../.env", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES); // Ajusta la ruta según la ubicación del archivo
        foreach ($lines as $line) {
            list($envKey, $envValue) = explode("=", $line, 2);
            if (trim($envKey) == $key) {
                return trim($envValue);
            }
        }
        return null;
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
                $mail->Host = $this->getEnvValue('EMAIL_HOST'); // Servidor SMTP (depende del proveedor)
                $mail->SMTPAuth = true;
                $mail->Username = $this->getEnvValue('EMAIL_USERNAME'); // Tu correo
                $mail->Password = $this->getEnvValue('EMAIL_PASSWORD'); // Tu contraseña o App Password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = $this->getEnvValue('EMAIL_PORT'); // Puerto SMTP (puede ser 465 o 587)
    
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
        if (isset($_POST['codigo']) && isset($_POST['email'])) {
            $codigo = Sanitizar::limpiar($_POST['codigo']);
            $email = Sanitizar::limpiar($_POST['email']); // Obtener el email
    
            $verificado = $this->correoM->verificarCodigoM($email, $codigo); // Pasar el email
    
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

    public function actualizarContraC() {
        if (isset($_POST['nuevaContra'])) {
            $email = Sanitizar::limpiar($_POST['email']);
            $nuevaContra = Sanitizar::limpiar($_POST['nuevaContra']);
            $actualizado = $this->correoM->actualizarContraM($email, $nuevaContra);
        
            if ($actualizado) {
                responderJSON(['status' => 'success']);
            } else {
                responderJSON(['status' => 'error', 'message' => 'No se pudo actualizar la contraseña']);
            }
        }
    }
    
}
?>
