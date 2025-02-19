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

        public function verificarUsuarioM($datosC, $tablaBD = 'administradores'){
            try {
                $cbd = ConexionBD::cBD('pdo');
                $usuario = $datosC['usuario'];
                //var_dump($usuario); // Verifica que el valor sea el esperado
                $stmt = $cbd->prepare("SELECT COUNT(*) FROM $tablaBD WHERE usuario = :usuario");
                $stmt->execute([':usuario'=>$usuario]);
                $row = $stmt->fetch(PDO::FETCH_NUM); // Traemos el conteo de usuarios que coinciden
                // Verificamos si $row no es false antes de acceder a sus valores
                if ($row) {
                    $count = $row[0]; // Accedemos al conteo
                    return $count > 0; // Retornamos true si hay coincidencias
                } else {
                    return false; // Si no hay resultado, retornamos false
                }
                    return $count > 0; // Retornamos true si hay coincidencias
            } catch (Exception $e) {
                return ['status' => 'error', 'message' => '¡Error al verificar el usuario: ' . $e->getMessage()];
            }
        }        
    }
?>