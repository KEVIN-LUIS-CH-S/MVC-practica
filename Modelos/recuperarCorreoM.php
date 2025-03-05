<?php
require_once 'conexionBD.php';

class RecuperarcorreoM extends ConexionBD{
    public function verificarEmailM($destinatario, $tabla='administradores') {
        try {
            $cbd = ConexionBD::cBD('pdo');
            $stmt= $cbd->prepare("SELECT id FROM $tabla WHERE email = :email");
            $stmt->execute([':email' => $destinatario]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
        
    }

    public function guardarCodigoM($destinatario, $codigo, $tabla='administradores') {
        try {
            $cbd= ConexionBD::cBD('pdo');
            $stmt=$cbd->prepare("UPDATE $tabla SET codigo = :codigo, codigo_expira = NOW() + INTERVAL 6 MINUTE WHERE email = :email");
            $stmt->execute([':codigo'=>$codigo,
                            ':email'=>$destinatario]);
            return true;
            } catch (Exception $e) {
                return false;
            }
    }

    public function limpiarCodigosExpiradosM() {
        try {
            $pdo = ConexionBD::cBD()->prepare("UPDATE usuarios SET codigo = NULL WHERE codigo_expira < NOW()");
            $pdo->execute();
            } catch (Exception $e) {
                return ['status' => 'error', 'message' => '¡Error en la consulta limpiarCodigo'];
            }
        }
    
    public function verificarCodigoM($email, $codigo, $tabla='administradores') {
        try {
            $cbd = ConexionBD::cBD('pdo');
            $stmt = $cbd->prepare("SELECT id FROM $tabla WHERE email = :email AND codigo = :codigo AND codigo_expira >= NOW()");
            $stmt->execute([':email'=>$email,
                            ':codigo'=>$codigo]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return false;
        }
        
    }
    
}

?>