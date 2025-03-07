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

            // Verificar si ya hay un código válido
            $stmt = $cbd->prepare("SELECT codigo_expira FROM $tabla WHERE email = :email AND codigo_expira > NOW()");
            $stmt->execute([':email' => $destinatario]);
            $codigo_existente = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($codigo_existente) {
                return false;
            }

            $stmt=$cbd->prepare("UPDATE $tabla SET codigo = :codigo, codigo_expira = NOW() + INTERVAL 1 MINUTE WHERE email = :email");
            $stmt->execute([':codigo'=>$codigo,
                            ':email'=>$destinatario]);
            return true;
            } catch (Exception $e) {
                return false;
            }
    }
    
    public function verificarCodigoM($email, $codigo, $tabla='administradores') {
        try {
            $cbd = ConexionBD::cBD('pdo');
            $stmt = $cbd->prepare("SELECT * FROM administradores WHERE email = :email AND codigo = :codigo AND codigo_expira > NOW()");
            $stmt->execute([
                ':email' => $email,
                ':codigo' => $codigo
            ]);
            return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
        } catch (Exception $e) {
            return false;
        }
        
    }
    
    public function obtenerTiempoExpiracionM($email) {
        try {
            $cbd = ConexionBD::cBD('pdo');

            $stmt = $cbd->prepare("SELECT TIMESTAMPDIFF(SECOND, NOW(), codigo_expira) AS tiempo_restante FROM administradores WHERE email = :email AND codigo_expira > NOW()");
            $stmt->execute([':email' => $email]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            return $resultado ? $resultado['tiempo_restante'] : null;
        } catch (Exception $e) {
            return null;
        }
    }

    public function limpiarCodigosExpiradosM($email) {
        try {
            $cbd = ConexionBD::cBD('pdo');

            $stmt = $cbd->prepare("UPDATE administradores SET codigo = NULL, codigo_expira = NULL WHERE email = :email AND codigo_expira <= NOW()");
            $stmt->execute([':email' => $email]);

            return $stmt->rowCount() > 0;
        } catch (Exception $e) {
            return false;
        }
    }
}

?>