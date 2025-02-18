<?php  //Modelos/adminM.php
    require_once "conexionBD.php";

    class AdminM extends ConexionBD{
        public function IngresoM($datosC, $tablaBD = 'administradores'){
            $cbd = ConexionBD::cBD();
            $usuario = $datosC['usuario'];
            $clave = $datosC['clave'];
            $query = "SELECT usuario, clave FROM $tablaBD 
                WHERE usuario='$usuario' AND clave='$clave'";
            $result = $cbd->query($query);
            return $result->fetch_array(MYSQLI_ASSOC);
        }

        public function registrarUsuarioM($datosC, $tablaBD = 'administradores'){
            try {
                $cbd=ConexionBD::cBD();
                $usuario=$datosC['usuario'];
                $correo=$datosC['correo'];
                $password=password_hash($datosC['password'], PASSWORD_DEFAULT);
                $stmt=$cbd->prepare("INSERT INTO $tablaBD (usuario, correo, password) VALUES (:usuario, :correo, :password, 1)");
                $stmt->execute([':usuario'=>$usuario,
                                ':correo'=>$correo,
                                ':password'=>$password]);
                return ['status' => 'success', 'message' => '¡Te has registrado exitosamente!'];
            
            } catch (Exception $e) {
                return ['status' => 'error', 'message' => 'Error al registrar el usuario: '];
            }
            
        }

        public function verificarUsuarioM($datosC, $tablaBD = 'administradores'){
            try {
                $cbd = ConexionBD::cBD();
                $usuario=$datosC['usuario'];
                $stmt = $cbd->prepare("SELECT COUNT(*) FROM $tablaBD WHERE usuario = :usuario");
                $stmt->execute([':usuario' => $usuario]);
                return $stmt->fetchColumn() > 0; // Devuelve true si el usuario existe 
            } catch (Exception $e) {
                return ['status' => 'error', 'message' => '!El usuario ya existe¡: '];
            }
            
        }
    }
?>