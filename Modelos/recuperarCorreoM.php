<?php
require_once 'conexionBD.php';

class RecuperarcorreoM extends ConexionBD{
    public function verificarEmail($email, $tabla='administradores') {
        try {
            $cbd = ConexionBD::cBD('pdo');
            $stmt= $cbd->prepare("SELECT id FROM $tabla WHERE email = :email");
            $stmt->execute([':email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => '¡Error en la consulta verificarEmail'];
        }
        
    }

    public static function verificarCodigo($email, $codigo, $tabla='administradores') {
        try {
            $cbd = ConexionBD::cBD('pdo');
            $stmt=$cbd->prepare("SELECT id FROM $tabla WHERE email = :email AND codigo = :codigo");
            $stmt->execute([':email'=>$email,
                            ':codigo'=>$codigo]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => '¡Error en la consulta verificarCodigo'];
        }
        
    }
    
}

?>