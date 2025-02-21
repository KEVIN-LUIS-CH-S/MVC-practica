<?php  //Modelos/adminM.php
    require_once "conexionBD.php";

    class AdminM extends ConexionBD{
        public function ingresoM($datosC, $tablaBD = 'administradores'){
            try{
                $cbd = ConexionBD::cBD('pdo');
                $usuario = $datosC['usuario'];
                $clave_temp = $datosC['clave'];

                $stmt = $cbd->prepare("SELECT id, usuario, password FROM $tablaBD WHERE usuario = :usuario");
                $stmt->execute([':usuario' => $usuario]);
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row ?: null;
            } catch(Exception $e){
                return ['status' => 'error', 'message' => 'Error en el login, intente mas tarde'];
            }
            
        }

        public function registrarUsuarioM($datosC, $tablaBD = 'administradores'){
            try {
                $cbd=ConexionBD::cBD('pdo');
                $usuario=$datosC['usuario'];
                $email=$datosC['email'];
                $password=password_hash($datosC['password'], PASSWORD_DEFAULT);
                $stmt=$cbd->prepare("INSERT INTO $tablaBD (usuario, email, password, estado) VALUES (:usuario, :email, :password, 1)");
                $stmt->execute([':usuario'=>$usuario,
                                ':email'=>$email,
                                ':password'=>$password]);
                return ['status' => 'success', 'message' => '¡Te has registrado exitosamente!'];
            
            } catch (Exception $e) {
                return ['status' => 'error', 'message' => 'Error al registrar el usuario: '];
            }
            
        }

        public function verificarUsuarioM($datosC, $tablaBD = 'administradores') {
            try {
                $cbd = ConexionBD::cBD('pdo');
                $usuario = $datosC['usuario'];
        
                // Evitar inyecciones SQL
                $stmt = $cbd->prepare("SELECT COUNT(*) FROM $tablaBD WHERE usuario = :usuario");
                $stmt->execute([':usuario' => $usuario]);
                $row = $stmt->fetch(PDO::FETCH_NUM);
        
                // Si se encontró un registro
                if ($row && $row[0] > 0) {
                    return ['status' => 'error', 'message' => '¡El usuario/correo ya está registrado!'];
                }
                return false;
        
            } catch (Exception $e) {
                return ['status' => 'error', 'message' => '¡Error al verificar el usuario!'];
            }
        }
    }    
?>